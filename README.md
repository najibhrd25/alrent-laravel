# 🎯 PANDUAN DEMO RPLibrary Backend API

Panduan ini sudah diverifikasi langsung dari source code dan di-fix dari error-error yang pernah terjadi sebelumnya. Ikuti secara berurutan dari Step 1 sampai selesai.

---

## STEP 1: Nyalakan Database (DBngin)

1. Buka aplikasi **DBngin** di Mac.
2. Cari server yang bernama **`rpl-db`** (PostgreSQL 17.0).
3. Pastikan port-nya **`5433`** (sesuai yang di file `.env` kamu).
4. Klik **Start** sampai indikatornya berubah **hijau**.

> [!IMPORTANT]
> Kalau server tidak mau nyala karena port bentrok, coba ganti port ke `5434` atau `5432`. **TAPI** kalau ganti port, kamu juga **WAJIB** update file `.env` di bagian `DATABASE_URL`:
> ```
> DATABASE_URL="postgresql://postgres@localhost:PORT_BARU/rpllibrary?schema=public"
> ```

---

## STEP 2: Pastikan Database Ada di TablePlus

1. Buka **TablePlus**.
2. Buat koneksi baru atau buka koneksi yang sudah ada ke `rpl-db` dengan setting:
   - **Host**: `127.0.0.1`
   - **Port**: `5433`
   - **User**: `postgres`
   - **Password**: *(kosongkan)*
   - **Database**: `rpllibrary`
3. Klik **Test** → pastikan muncul tulisan hijau "connected".
4. Klik **Connect**.

> [!WARNING]
> Kalau database `rpllibrary` belum ada (error "database does not exist"), sambungkan dulu ke database `postgres` (default), lalu jalankan SQL berikut:
> ```sql
> CREATE DATABASE rpllibrary;
> ```
> Setelah itu, disconnect dan reconnect ke database `rpllibrary`.

---

## STEP 3: Install Dependencies (Kalau Belum)

Buka Terminal, masuk ke folder proyek:
```bash
cd ~/Documents/ADMIN\ RPL
```

Lalu jalankan:
```bash
npm install
```

> Tunggu sampai selesai. Kalau sudah pernah install dan folder `node_modules` sudah ada, step ini bisa dilewati.

---

## STEP 4: Sinkronkan Database dengan Prisma

Masih di Terminal yang sama, jalankan:
```bash
npx prisma db push
```

**Hasil yang diharapkan:**
```
🚀 Your database is now in sync with your Prisma schema. Done in XXms
```

> Ini akan membuat 4 tabel di database: **User**, **Book**, **Category**, **Transaction**.
> Kamu bisa verifikasi di **TablePlus** dengan klik refresh (Cmd+R) — tabel-tabel akan muncul di panel kiri.

---

## STEP 5: Jalankan Server

```bash
npm run dev
```

**Hasil yang diharapkan:**
```
[SERVER] 🚀 RPLibrary API is running perfectly on http://localhost:3000
```

> [!CAUTION]
> Kalau muncul error `EADDRINUSE`, artinya port 3000 sudah dipakai. Kill proses lama dulu:
> ```bash
> lsof -ti:3000 | xargs kill -9
> ```
> Lalu jalankan `npm run dev` lagi.

**🟢 SERVER SUDAH JALAN! Sekarang buka Postman untuk testing API.**

---

## STEP 6: Import Postman Collection

1. Buka **Postman**.
2. Klik **Import** → pilih file `RPLibrary.postman_collection.json` yang ada di root folder proyek.
3. Collection **RPLibrary API - Admin Lab Selection** akan muncul di sidebar kiri.

---

## STEP 7: Register Akun Baru

**Request:** `POST /api/auth/register`

1. Di Postman, buka folder **1. Authentication** → klik **Register Member**.
2. Masuk ke tab **Body** → pilih **raw** → pilih **JSON**.
3. Isi body:
```json
{
  "name": "Najib Demo",
  "email": "najib@demo.com",
  "password": "password123"
}
```
4. Klik **Send**.

**Hasil yang diharapkan:** `201 Created`
```json
{
  "status": "success",
  "message": "Account created successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "Najib Demo",
      "email": "najib@demo.com",
      "role": "MEMBER"
    }
  }
}
```

> [!NOTE]
> **Validasi penting:**
> - `name` minimal 3 karakter
> - `email` harus format email valid
> - `password` minimal 6 karakter
> 
> Kalau email sudah terdaftar, akan muncul error `"Email is already registered."`. Ganti aja email-nya.

---

## STEP 8: Login dan Dapatkan Token

**Request:** `POST /api/auth/login`

1. Buka folder **1. Authentication** → klik **Login User**.
2. Tab **Body** → **raw** → **JSON**:
```json
{
  "email": "najib@demo.com",
  "password": "password123"
}
```
3. Klik **Send**.

**Hasil yang diharapkan:** `200 OK`
```json
{
  "status": "success",
  "message": "Logged in successfully",
  "data": {
    "token": "eyJhbGciOi...(token panjang)...",
    "user": {
      "id": 1,
      "name": "Najib Demo",
      "email": "najib@demo.com",
      "role": "MEMBER"
    }
  }
}
```

4. **⚠️ COPY token tersebut!** (teks panjang yang dimulai dengan `eyJ...`)

---

## STEP 9: Setup Token di Postman (PENTING!)

Ini adalah step yang **paling sering bikin error** kemarin. Ikuti dengan teliti:

1. Di sidebar kiri Postman, **klik kanan** nama collection **RPLibrary API** → pilih **Edit**.
2. Masuk ke tab **Authorization**.
3. Pilih Type: **Bearer Token**.
4. Di kolom **Token**, **paste** token JWT yang tadi di-copy dari step 8.
5. Klik **Save** (tombol orange di kanan atas).

> [!CAUTION]
> **JEBAKAN PALING BERBAHAYA:**
> Untuk setiap request setelah ini, pastikan tab **Authorization** di masing-masing request disetel ke **"Inherit auth from parent"** — **BUKAN** "No Auth" atau "Bearer Token" manual.
> 
> Kalau kamu set manual Bearer Token di level request, bisa bikin **"Invalid Token"** error karena token di-override!

---

## STEP 10: Buktikan RBAC — Akses Ditolak untuk MEMBER

**Request:** `POST /api/categories`

1. Buka folder **Categories** → klik **Create Category**.
2. Tab **Body** → **raw** → **JSON**:
```json
{
  "name": "Programming"
}
```
3. Pastikan tab **Authorization** disetel ke **Inherit auth from parent**.
4. Klik **Send**.

**Hasil yang diharapkan:** `403 Forbidden`
```json
{
  "status": "error",
  "message": "Access denied: Admin only."
}
```

> Ini **benar dan diharapkan!** Kamu sedang membuktikan bahwa Role-Based Access Control (RBAC) berfungsi. MEMBER tidak bisa membuat kategori — hanya ADMIN yang bisa.

---

## STEP 11: Switch Role ke ADMIN via TablePlus

1. Buka **TablePlus** (yang sudah terkoneksi ke `rpllibrary`).
2. Klik tabel **User** di panel kiri.
3. Cari user kamu (kolom **name** = "Najib Demo").
4. **Double-klik** tepat pada kolom **role** yang bertuliskan `MEMBER`.
5. Ganti menjadi `ADMIN` (huruf besar semua).
6. Tekan **Cmd + S** untuk menyimpan.

> [!IMPORTANT]
> **WAJIB LOGIN ULANG!** Setelah mengubah role, token lama masih menyimpan role `MEMBER`. Kamu **HARUS** kembali ke **Step 8** (Login lagi) untuk mendapatkan token baru yang berisi role `ADMIN`, lalu update token di Collection Authorization (**Step 9**).

---

## STEP 12: Login Ulang sebagai ADMIN

Ulangi **Step 8** (Login) dengan email dan password yang sama.

Kali ini, response akan menunjukkan:
```json
"role": "ADMIN"
```

**Lalu ulangi Step 9** — paste token baru ini ke Collection Authorization.

---

## STEP 13: Admin Membuat Kategori

**Request:** `POST /api/categories`

1. Buka lagi **Create Category**.
2. Body tetap sama:
```json
{
  "name": "Programming"
}
```
3. Klik **Send**.

**Hasil yang diharapkan:** `201 Created`
```json
{
  "status": "success",
  "message": "Category created successfully",
  "data": {
    "category": {
      "id": 1,
      "name": "Programming"
    }
  }
}
```

> Sekarang berhasil karena token kamu sudah berisi role ADMIN!

---

## STEP 14: Admin Membuat Buku (Tanpa Gambar)

**Request:** `POST /api/books`

1. Buka folder **2. Books** → klik **Create Book (Admin)**.
2. Masuk ke tab **Body** → pilih **form-data** (bukan raw!).
3. Isi field-field berikut (semua tipe **Text**):

| Key | Value |
|-----|-------|
| `title` | `Clean Code` |
| `author` | `Robert C. Martin` |
| `stock` | `5` |
| `categoryId` | `1` |

4. Klik **Send**.

**Hasil yang diharapkan:** `201 Created` dengan `coverImage: null`.

---

## STEP 15: Admin Membuat Buku dengan Upload Cover Image

**Request:** `POST /api/books` (buat buku kedua)

1. Masih di **Create Book (Admin)**, ubah field-field menjadi:

| Key | Type | Value |
|-----|------|-------|
| `title` | Text | `The Pragmatic Programmer` |
| `author` | Text | `Andy Hunt` |
| `stock` | Text | `3` |
| `categoryId` | Text | `1` |
| `coverImage` | **File** | *(pilih gambar dari komputer)* |

2. **PERHATIKAN**: Untuk field `coverImage`:
   - Ketik `coverImage` di kolom Key (huruf **I besar**, bukan `coverimage`!)
   - Arahkan mouse ke **sebelah kanan** field tersebut, klik dropdown **Text** → ganti jadi **File**
   - Setelah berubah ke File, klik **Select Files** → pilih gambar `.png` atau `.jpg`

3. Klik **Send**.

**Hasil yang diharapkan:** `201 Created` dengan `coverImage: "/uploads/covers/xxxxx.png"`

> [!WARNING]
> Kalau muncul error `"Unexpected field"`, itu artinya nama Key kamu **salah ketik**. Pastikan persis **`coverImage`** (huruf I besar!). Ini pernah terjadi sebelumnya dan ini fix-nya.

---

## STEP 16: Lihat Semua Buku (Public)

**Request:** `GET /api/books`

1. Buka folder **2. Books** → klik **Get All Books**.
2. Klik **Send** (tidak perlu body apapun).

**Hasil yang diharapkan:** `200 OK` — daftar semua buku yang sudah dibuat.

> **Bonus Filter:** Coba tambahkan query parameter di URL:
> - `{{base_url}}/api/books?title=Clean` → filter berdasarkan judul
> - `{{base_url}}/api/books?categoryId=1` → filter berdasarkan kategori

---

## STEP 17: Member Meminjam Buku (Borrow)

> ⚠️ **Pinjam buku hanya bisa dilakukan oleh MEMBER, bukan ADMIN.**

**Opsi A — Buat akun Member baru:**
Register akun baru (Step 7) dengan email berbeda, login, lalu paste token ke Collection.

**Opsi B — Ubah role kembali ke MEMBER:**
Di TablePlus, ubah role dari `ADMIN` ke `MEMBER`, simpan, lalu login ulang.

Setelah kamu login sebagai **MEMBER**:

**Request:** `POST /api/transactions/borrow`

1. Buka folder **3. Transactions** → klik **Borrow Book (Member)**.
2. Tab **Body** → **raw** → **JSON**:
```json
{
  "bookId": 1
}
```
3. Klik **Send**.

**Hasil yang diharapkan:** `201 Created`
```json
{
  "status": "success",
  "message": "You successfully borrowed 'Clean Code'",
  "data": {
    "transaction": {
      "id": 1,
      "userId": 1,
      "bookId": 1,
      "status": "BORROWED"
    }
  }
}
```

> Cek di TablePlus: stock buku "Clean Code" akan **berkurang dari 5 menjadi 4**.

---

## STEP 18: Admin Mengonfirmasi Pengembalian Buku (Return)

> ⚠️ Return hanya bisa dilakukan oleh **ADMIN**. Ubah role kembali ke ADMIN di TablePlus, login ulang, dan update token.

**Request:** `PUT /api/transactions/1/return`

1. Buka folder **3. Transactions** → klik **Return Book (Admin)**.
2. Di URL, pastikan angka `1` sesuai dengan ID transaksi yang ingin dikembalikan.
3. Tidak perlu body. Klik **Send**.

**Hasil yang diharapkan:** `200 OK`
```json
{
  "status": "success",
  "message": "Book return has been confirmed successfully.",
  "data": {
    "transaction": {
      "status": "RETURNED",
      "returnDate": "2026-04-18T..."
    }
  }
}
```

> Cek di TablePlus: stock buku akan **bertambah kembali dari 4 menjadi 5**.

---

## STEP 19: Lihat Riwayat Transaksi

**Request:** `GET /api/transactions`

1. Buka folder **3. Transactions** → klik **Get Transactions**.
2. Klik **Send**.

**Hasil yang diharapkan:**
- Kalau login sebagai **ADMIN**: melihat **semua** transaksi dari semua user.
- Kalau login sebagai **MEMBER**: hanya melihat transaksi **milik sendiri**.

---

## STEP 20: Lihat Profil Sendiri

**Request:** `GET /api/users/me`

1. Buka folder **User Profile** → klik **Get My Profile**.
2. Klik **Send**.

**Hasil yang diharapkan:** `200 OK`
```json
{
  "status": "success",
  "data": {
    "user": {
      "id": 1,
      "name": "Najib Demo",
      "email": "najib@demo.com",
      "role": "ADMIN",
      "profilePicture": null
    }
  }
}
```

---

## STEP 21: Upload Foto Profil

**Request:** `PUT /api/users/profile-picture`

1. Buka folder **User Profile** → klik **Upload Profile Picture**.
2. Tab **Body** → pilih **form-data**.
3. Isi:

| Key | Type | Value |
|-----|------|-------|
| `profilePicture` | **File** | *(pilih gambar dari komputer)* |

4. Sama seperti coverImage, ubah tipe dari **Text** ke **File** di dropdown.
5. Klik **Send**.

**Hasil yang diharapkan:** `200 OK`
```json
{
  "status": "success",
  "message": "Profile picture uploaded successfully.",
  "data": {
    "user": {
      "id": 1,
      "name": "Najib Demo",
      "profilePicture": "uploads/covers/xxxxx.png"
    }
  }
}
```

---

## ✅ CHECKLIST REKAP DEMO

| # | Fitur | Role | Status |
|---|-------|------|--------|
| 1 | Register akun baru | Public | ⬜ |
| 2 | Login & dapat JWT Token | Public | ⬜ |
| 3 | Setup token di Postman | - | ⬜ |
| 4 | RBAC: Member ditolak Create Category | MEMBER | ⬜ |
| 5 | Switch role ke ADMIN via TablePlus | - | ⬜ |
| 6 | Login ulang sebagai ADMIN | Public | ⬜ |
| 7 | Admin buat Kategori | ADMIN | ⬜ |
| 8 | Admin buat Buku (tanpa gambar) | ADMIN | ⬜ |
| 9 | Admin buat Buku (dengan upload cover) | ADMIN | ⬜ |
| 10 | Lihat semua buku + filter | Public | ⬜ |
| 11 | Member pinjam buku (Borrow) | MEMBER | ⬜ |
| 12 | Admin konfirmasi pengembalian (Return) | ADMIN | ⬜ |
| 13 | Lihat riwayat transaksi | ADMIN/MEMBER | ⬜ |
| 14 | Lihat profil sendiri | Any logged in | ⬜ |
| 15 | Upload foto profil | Any logged in | ⬜ |

---

## 🚨 TROUBLESHOOTING (Kalau Error)

### Error: `"Invalid Token"`
- **Penyebab**: Token expired atau Authorization di request-level bukan "Inherit auth from parent".
- **Solusi**: Login ulang, copy token baru, paste di Collection Authorization, pastikan setiap request pakai **Inherit auth from parent**.

### Error: `"Unexpected field"`
- **Penyebab**: Nama field upload salah ketik.
- **Solusi**: Pastikan field name persis `coverImage` (huruf I besar) untuk buku, dan `profilePicture` untuk profil.

### Error: `500 Internal Server Error` saat buat buku
- **Penyebab**: `categoryId` yang dimasukkan belum ada di database.
- **Solusi**: Pastikan kamu sudah membuat Category dulu (Step 13) sebelum membuat buku.

### Error: `ECONNREFUSED` atau `Could not connect`
- **Penyebab**: Database DBngin belum nyala atau port salah.
- **Solusi**: Buka DBngin, pastikan server hijau. Cek port di DBngin cocok dengan `.env`.

### Error: `"Access denied: Admin only."`
- **Penyebab**: Token yang dipakai masih token dari akun MEMBER.
- **Solusi**: Pastikan sudah switch role di TablePlus, **LOGIN ULANG** untuk dapat token baru, lalu update token di Collection.

### Error: `"Book is currently out of stock"`
- **Penyebab**: Stok buku sudah 0, tidak bisa dipinjam lagi.
- **Solusi**: Pilih buku lain, atau Admin kembalikan buku dulu (Return) agar stok bertambah.
