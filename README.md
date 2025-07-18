
# 📦 Forwader Import Management System

Sistem ini digunakan untuk mencatat dan mengelola transaksi impor barang dari supplier dan forwarder. Aplikasi ini dilengkapi dengan fitur input data, upload dokumen, cetak laporan dalam format PDF, dan pelaporan transaksi.

---

## 🔧 Teknologi yang Digunakan

- **Backend**: PHP OOP (Native)
- **Frontend**: JavaScript (jQuery, FullCalendar)
- **Database**: Microsoft SQL Server (terhubung menggunakan ODBC)
- **PDF Generator**: FPDF
- **Server**: Apache (XAMPP)

---

## 🚀 Fitur Utama

- Manajemen transaksi import barang
- Input data supplier & forwarder
- Upload dokumen pendukung (contoh: invoice, packing list)
- Cetak laporan transaksi dalam bentuk PDF
- Penyimpanan file terpusat di direktori khusus
- Tampilan dinamis menggunakan jQuery & FullCalendar

---

## ⚙️ Konfigurasi Sistem

### 📁 Konfigurasi Upload File

1. **Edit file konfigurasi Apache**

   Buka file berikut di XAMPP:

   ```
   F:\xampp\apache\conf\extra\httpd-xampp.conf
   ```

2. **Tambahkan konfigurasi berikut di akhir file:**

   ```apache
   Alias /UploadFilesForwader "C:/UploadFilesForwader"

   <Directory "C:/UploadFilesForwader">
       Options Indexes FollowSymLinks
       AllowOverride All
       Require all granted
   </Directory>
   ```

3. **Buat folder upload jika belum ada**

   Buat folder berikut di sistem:

   ```
   C:\UploadFilesForwader
   ```

4. **Restart Apache**

   Setelah konfigurasi disimpan, lakukan restart melalui **XAMPP Control Panel** agar perubahan berlaku.

---

## 🗃️ Koneksi Database SQL Server via ODBC

1. **Install ODBC Driver for SQL Server**

   Unduh dan instal driver dari:
   [https://learn.microsoft.com/en-us/sql/connect/odbc/download-odbc-driver-for-sql-server](https://learn.microsoft.com/en-us/sql/connect/odbc/download-odbc-driver-for-sql-server)

2. **Buat System DSN**

   - Buka: `Control Panel → Administrative Tools → ODBC Data Sources`
   - Masuk ke tab **System DSN**
   - Klik **Add**
   - Pilih: **ODBC Driver for SQL Server**
   - Masukkan:
     - **Name**: ForwarderDB
     - **Server**: `localhost\SQLEXPRESS` atau nama SQL Server kamu
     - Login sesuai konfigurasi (Windows/SQL Server Authentication)
     - Pilih database `bambi-bmi`

3. **Aktifkan ekstensi ODBC di PHP**

   Pastikan baris berikut aktif di `php.ini`:

   ```ini
   extension=php_odbc.dll
   ```

4. **Contoh kode koneksi PHP ke SQL Server via ODBC**

   ```php
   $dsn = "ForwarderDB"; // Nama DSN dari konfigurasi ODBC
   $user = "sa";         // Username SQL Server
   $pass = "password";   // Password SQL Server

   $conn = odbc_connect($dsn, $user, $pass);
   if (!$conn) {
       die("Koneksi gagal: " . odbc_errormsg());
   }
   ```

---

## 🛠️ Pembuatan Database dan Tabel

### 📌 1. Buat Database SQL Server

Masuk ke SQL Server Management Studio (SSMS) lalu jalankan perintah berikut:

```sql
CREATE DATABASE [bambi-bmi];
GO
```

---

### 📂 2. Import Table dan Stored Procedure

Semua skrip SQL ada di folder:

```
sp,fun&table/
```

**Langkah:**

1. Buka SQL Server Management Studio.
2. Hubungkan ke database `bambi-bmi`.
3. Jalankan file SQL berikut satu per satu:

   - `table_forwarder_transactions.sql` — untuk struktur tabel
   - `USP_CetakPrintForwaderImport [bambi-bmi].sql` — stored procedure cetak laporan
   - `USP_TamplilListForwaderImport [bambi-bmi].sql` — stored procedure tampilkan list data

> Pastikan semua skrip berjalan tanpa error, dan database siap digunakan oleh aplikasi.

---

## 🗂️ Struktur Folder

```
project-root/
│
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
│
├── public/
│   └── src/
│       └── forwaderimport/
│           ├── Simpdatdata.js
│           └── main.js
│
├── sp,fun&table/
│   ├── USP_CetakPrintForwaderImport [bambi-bmi].sql
│   ├── USP_TamplilListForwaderImport [bambi-bmi].sql
│   └── table_forwarder_transactions.sql
│
├── C:/UploadFilesForwader/
│   └── (folder untuk dokumen hasil upload)
│
└── README.md
```

---

## 🧪 Cara Menjalankan Proyek

1. Clone repository ini:
   ```bash
   git clone https://github.com/wardi17/forwader_bmi.git
   ```

2. Pastikan Apache, PHP, SQL Server, dan ODBC driver aktif.

3. Buat folder `C:/UploadFilesForwader` dan atur hak aksesnya.

4. Buat database `bambi-bmi` dan jalankan seluruh file SQL di `sp,fun&table/`.

5. Ubah konfigurasi koneksi database di file koneksi PHP jika perlu.

6. Akses aplikasi melalui browser:
   ```
   http://localhost/forwader_bmi/
   ```

---

## 📝 Catatan Tambahan

- Pastikan ukuran file upload tidak melebihi `upload_max_filesize` di `php.ini`
- Pastikan `extension=php_odbc.dll` aktif
- Gunakan browser modern seperti Chrome atau Edge

---

## 👨‍💻 Pengembang

**Nama**: Wardi Wardi  
**GitHub**: [https://github.com/wardi17](https://github.com/wardi17)

---

## 📄 Lisensi

Proyek ini bersifat internal. Dilarang menyebarluaskan tanpa izin tertulis.
