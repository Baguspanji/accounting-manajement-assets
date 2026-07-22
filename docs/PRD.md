# PRD: Aplikasi Pembelajaran Akuntansi Simpan Pinjam Syariah

**Versi:** 1.0

## 1. Ringkasan
Aplikasi web yang digunakan sebagai media pembelajaran transaksi koperasi simpan pinjam syariah.
Fokus utama aplikasi adalah simulasi transaksi dan pencatatan akuntansi otomatis.

**Target pengguna:**
- Guru
- Mahasiswa
- Siswa
- Admin

## 2. Tujuan Sistem
Sistem harus mampu:
- Melakukan simulasi transaksi koperasi syariah
- Menghasilkan jurnal otomatis
- Menghasilkan laporan keuangan
- Memberikan studi kasus pembelajaran
- Menampilkan perubahan saldo akun secara realtime

## 3. Role

### Admin
Mengelola seluruh sistem.
Hak akses:
- User
- COA
- Jenis Akad
- Tahun Ajaran
- Backup

### Guru
- Membuat kelas
- Membuat studi kasus
- Melihat nilai
- Melihat transaksi siswa

### Siswa
- Login
- Mengerjakan studi kasus
- Input transaksi
- Melihat jurnal
- Melihat laporan

## 4. Modul

### Dashboard
**Widget:**
- Total Anggota
- Total Simpanan
- Total Pembiayaan
- Total Kas
- Grafik Transaksi
- Aktivitas Terakhir

### Master Anggota
**Operasi:** CRUD
**Field:**
- Nomor Anggota
- Nama
- Alamat
- No HP
- Status

### Master COA
**Operasi:** CRUD
**Field:**
- Kode
- Nama Akun
- Kategori
- Normal Balance
- Parent

### Master Akad
**Operasi:** CRUD
**Contoh:**
- Wadiah
- Mudharabah
- Musyarakah
- Murabahah
- Ijarah
- Qardh

Setiap akad memiliki:
- Deskripsi
- Jurnal default
- Akun debit
- Akun kredit

### Simpanan
**Jenis:**
- Pokok
- Wajib
- Sukarela

**Transaksi:**
- Setor
- Tarik

**Output:**
- Jurnal
- Saldo anggota
- Saldo kas

### Pembiayaan
**Jenis:**
- Murabahah
- Mudharabah
- Musyarakah
- Ijarah
- Qardh

**Field:**
- Anggota
- Akad
- Nominal
- Margin
- Tenor
- Tanggal

**Output:**
- Jadwal angsuran
- Jurnal otomatis

### Pembayaran
**Input:**
- Tanggal
- Nominal
- Metode

**Output:**
- Jurnal
- Update sisa pembiayaan

### Jurnal
**Menampilkan:**
- Tanggal
- Akun
- Debit
- Kredit
- Referensi

**Status:** Readonly (Tidak boleh diubah manual).

### Buku Besar
Menampilkan mutasi akun.

### Neraca Saldo
Generate otomatis.

### Laporan
- Simpanan
- Pembiayaan
- Kas
- SHU
- Neraca
- Arus Kas

## 5. Alur Sistem

`Login` ➔ `Dashboard` ➔ `Pilih Studi Kasus` ➔ `Input Transaksi` ➔ `Validasi` ➔ `Generate Jurnal` ➔ `Update Saldo` ➔ `Generate Laporan` ➔ `Selesai`

## 6. Business Rules

### Simpanan
**Saat setor:**
- Kas bertambah
- Simpanan bertambah

**Saat tarik:**
- Kas berkurang
- Simpanan berkurang

### Murabahah
**Saat akad:**
- Pembiayaan Murabahah bertambah
- Kas berkurang

**Saat angsuran:**
- Kas bertambah
- Piutang berkurang
- Margin diakui sesuai jadwal

### Mudharabah
**Input:** Modal
**Output:** Nisbah, Pembagian hasil

### Musyarakah
**Input:** Modal koperasi, Modal anggota
**Output:** Pembagian keuntungan

### Ijarah
**Input:** Nilai sewa, Lama sewa
**Output:** Pendapatan sewa

### Qardh
- Tidak ada margin
- Hanya pokok

## 7. Studi Kasus
Minimal terdapat:
- **Case 1:** Simpanan Pokok
- **Case 2:** Simpanan Wajib
- **Case 3:** Murabahah Motor
- **Case 4:** Murabahah Laptop
- **Case 5:** Mudharabah Warung
- **Case 6:** Musyarakah Usaha
- **Case 7:** Ijarah Kendaraan
- **Case 8:** Qardh

## 8. Struktur Menu
- **Dashboard**
- **Master**
  - Anggota
  - COA
  - Akad
- **Transaksi**
  - Simpanan
  - Pembiayaan
  - Pembayaran
- **Akuntansi**
  - Jurnal
  - Buku Besar
  - Neraca Saldo
- **Laporan**
  - Neraca
  - SHU
  - Kas
- **Pembelajaran**
  - Materi
  - Studi Kasus
  - Latihan
- **Pengaturan**

## 9. Database (High Level)
Tabel utama:
- `users`
- `classes`
- `students`
- `members`
- `accounts`
- `account_groups`
- `journals`
- `journal_details`
- `saving_products`
- `saving_transactions`
- `financing_products`
- `financing_transactions`
- `installments`
- `profit_sharing`
- `study_cases`
- `materials`
- `quizzes`

## 10. Routes & View

### Master
- `GET /members` - Daftar anggota
- `GET /members/create` - Form tambah anggota
- `POST /members` - Simpan anggota baru
- `GET /members/{id}/edit` - Form edit anggota
- `PUT /members/{id}` - Update anggota
- `DELETE /members/{id}` - Hapus anggota

- `GET /accounts` - Daftar COA
- `GET /accounts/create` - Form tambah akun
- `POST /accounts` - Simpan akun baru
- `GET /accounts/{id}/edit` - Form edit akun
- `PUT /accounts/{id}` - Update akun
- `DELETE /accounts/{id}` - Hapus akun

- `GET /contracts` - Daftar akad
- `GET /contracts/create` - Form tambah akad
- `POST /contracts` - Simpan akad baru
- `GET /contracts/{id}/edit` - Form edit akad
- `PUT /contracts/{id}` - Update akad
- `DELETE /contracts/{id}` - Hapus akad

### Transaksi
- `GET /savings` - Daftar transaksi simpanan
- `GET /savings/create` - Form input simpanan
- `POST /savings` - Proses simpanan (setor/tarik)

- `GET /financings` - Daftar pembiayaan
- `GET /financings/create` - Form input pembiayaan
- `POST /financings` - Proses pembiayaan

- `GET /installments` - Daftar pembayaran
- `GET /installments/create` - Form input pembayaran
- `POST /installments` - Proses pembayaran

### Akuntansi
- `GET /journals` - Daftar jurnal
- `GET /ledgers` - Buku besar
- `GET /trial-balance` - Neraca saldo

### Laporan
- `GET /reports/savings` - Laporan simpanan
- `GET /reports/financings` - Laporan pembiayaan
- `GET /reports/cash` - Laporan kas
- `GET /reports/balance-sheet` - Neraca
- `GET /reports/profit-loss` - SHU
- `GET /reports/cashflow` - Arus kas

## 11. Teknologi
**Backend & Frontend:**
- Laravel 12
- Laravel Blade (template engine)
- TailwindCSS
- Alpine.js (untuk interaktivitas ringan di browser)

**Database:**
- MySQL

**Authentication:**
- Laravel Sanctum

**Export:**
- Excel
- PDF

**Catatan:** Aplikasi tidak menggunakan TypeScript dan tidak memerlukan build tool frontend modern. Semua tampian dirender server-side via Blade, dengan sedikit JavaScript native atau Alpine.js untuk elemen interaktif.

## 12. Target MVP
**Sprint 1:**
- Login
- Dashboard
- Master Anggota
- COA

**Sprint 2:**
- Simpanan
- Pembiayaan

**Sprint 3:**
- Jurnal
- Buku Besar

**Sprint 4:**
- Neraca
- SHU
- Studi Kasus

---

## Rekomendasi Arsitektur
Menggunakan pendekatan **Domain-Driven Design (DDD)** ringan agar modul akuntansi tidak tercampur dengan modul pembelajaran.

Struktur aplikasi Laravel yang disarankan:
```text
app/
 ├── Http/
 │    ├── Controllers/
 │    │    ├── MemberController.php
 │    │    ├── AccountController.php
 │    │    ├── ContractController.php
 │    │    ├── SavingController.php
 │    │    ├── FinancingController.php
 │    │    ├── InstallmentController.php
 │    │    ├── JournalController.php
 │    │    ├── LedgerController.php
 │    │    └── ReportController.php
 │    └── Requests/ (Form validation)
 ├── Models/
 │    ├── User.php
 │    ├── Member.php
 │    ├── Account.php
 │    ├── Contract.php
 │    ├── Saving.php
 │    ├── Financing.php
 │    ├── Installment.php
 │    ├── Journal.php
 │    ├── JournalDetail.php
 │    └── StudyCase.php
 ├── Services/
 │    ├── SavingService.php (logic setor/tarik)
 │    ├── FinancingService.php (logic pembiayaan)
 │    ├── JournalService.php (generate jurnal otomatis)
 │    ├── InstallmentService.php (logic pembayaran)
 │    └── ReportService.php (generate laporan)
 ├── Repositories/ (database queries)
 │    ├── MemberRepository.php
 │    ├── AccountRepository.php
 │    ├── JournalRepository.php
 │    └── ReportRepository.php
 ├── Events/ (untuk trigger lanjutan)
 │    ├── SavingCreated.php
 │    ├── FinancingCreated.php
 │    └── InstallmentPaid.php
 └── Listeners/ (untuk auto-journal)
      ├── GenerateJournalOnSaving.php
      ├── GenerateJournalOnFinancing.php
      └── GenerateJournalOnInstallment.php

resources/
 └── views/
      ├── layouts/
      │    ├── app.blade.php (master layout)
      │    └── sidebar.blade.php
      ├── members/
      │    ├── index.blade.php
      │    ├── create.blade.php
      │    └── edit.blade.php
      ├── accounts/
      ├── contracts/
      ├── savings/
      ├── financings/
      ├── installments/
      ├── journals/
      ├── reports/
      └── dashboard.blade.php

database/
 └── migrations/
      ├── create_users_table.php
      ├── create_members_table.php
      ├── create_accounts_table.php
      ├── create_contracts_table.php
      ├── create_savings_table.php
      ├── create_financings_table.php
      ├── create_installments_table.php
      ├── create_journals_table.php
      └── create_journal_details_table.php
```

**Keuntungan pendekatan ini:**
- Semua rendering dilakukan di server via Blade
- Tidak perlu build tool atau TypeScript
- Database MySQL lebih mudah dikonfigurasi di shared hosting
- Logic bisnis terpusat di Services layer
- Event-Listener untuk auto-generate jurnal
- Mudah untuk maintenance dan scaling ke fitur koperasi konvensional atau BMT di masa depan
