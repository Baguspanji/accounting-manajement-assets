# PRD: Aplikasi Akuntansi Manajemen Aset (Aset Tetap)

**Versi:** 2.0

## 1. Ringkasan
Aplikasi web untuk pengelolaan dan pencatatan akuntansi aset tetap / manajemen aset (fixed asset management accounting).
Fokus utama aplikasi adalah pencatatan transaksi aset dan akuntansi otomatis: perolehan, penyusutan, hingga pelepasan, dilengkapi dokumentasi pemakaian untuk pengguna.

**Target pengguna:**
- Administrator

## 2. Tujuan Sistem
Sistem harus mampu:
- Mencatat transaksi manajemen aset (perolehan, penyusutan, pelepasan)
- Menghasilkan jurnal otomatis setiap transaksi
- Menghitung penyusutan dengan beberapa metode (garis lurus, saldo menurun, jumlah angka tahun, unit produksi)
- Menghasilkan laporan keuangan terkait aset (kartu aset, daftar penyusutan, nilai buku, laba/rugi pelepasan)
- Menyediakan dokumentasi pemakaian aplikasi tanpa mekanisme latihan dan simulasi
- Menampilkan perubahan nilai buku aset secara realtime

## 3. Role

### Administrator
Satu-satunya peran pengguna dalam aplikasi. Mengelola seluruh sistem.
Hak akses:
- Dashboard
- COA
- Kategori Aset
- Metode Penyusutan
- Data Aset
- Transaksi (Perolehan, Penyusutan, Pelepasan)
- Jurnal, Buku Besar, Neraca Saldo
- Laporan
- Dokumentasi Pemakaian

## 4. Modul

### Dashboard
**Widget:**
- Total Aset (Register)
- Nilai Perolehan Total
- Nilai Buku Total
- Akumulasi Penyusutan
- Grafik Penyusutan per Kategori
- Aktivitas Terakhir

### Master Kategori Aset
**Operasi:** CRUD
**Field:**
- Kode
- Nama Kategori (Tanah, Bangunan, Kendaraan, Mesin, Peralatan, Komputer)
- Akun Aset (default)
- Akun Beban Penyusutan (default)
- Akun Akumulasi Penyusutan (default)
- Umur Manfaat Default
- Nilai Residu Default

### Master Aset (Kartu/Register Aset)
**Operasi:** CRUD
**Field:**
- Nomor Aset
- Nama Aset
- Kategori
- Nomor Seri
- Lokasi
- Penanggung Jawab
- Pemasok/Supplier
- Tanggal Perolehan
- Harga Perolehan
- Nilai Residu
- Umur Manfaat
- Metode Penyusutan
- Status

### Master Metode Penyusutan
**Operasi:** CRUD
**Contoh:**
- Garis Lurus (Straight Line)
- Saldo Menurun (Double Declining Balance)
- Jumlah Angka Tahun (Sum of Year Digits)
- Unit Produksi

Setiap metode memiliki:
- Kode
- Deskripsi / formula
- Parameter (umur manfaat, nilai residu, kapasitas produksi)

### Transaksi Perolehan Aset
**Input:**
- Aset
- Tanggal
- Nilai Perolehan
- Sumber Dana (Kas / Utang)

**Output:**
- Kartu aset terisi
- Jurnal: Debit Aset Tetap / Kredit Kas atau Utang
- Update nilai aset

### Penyusutan
**Input:**
- Periode (bulan/tahun)
- Eksekusi batch (run depreciation)

**Output:**
- Jadwal penyusutan per aset per periode
- Jurnal: Debit Beban Penyusutan / Kredit Akumulasi Penyusutan
- Update nilai buku aset

### Pelepasan Aset
**Jenis:**
- Penjualan
- Penghapusan (rusak/hilang)
- Transfer

**Input:**
- Tanggal
- Jenis
- Harga Jual (jika penjualan)

**Output:**
- Jurnal pelepasan (akumulasi penyusutan dihapus, aset dikeluarkan, laba/rugi diakui)
- Update status aset

### Jurnal
**Menampilkan:**
- Tanggal
- Akun
- Debit
- Kredit
- Referensi

**Status:** Readonly (Tidak boleh diubah manual).

### Buku Besar
Menampilkan mutasi akun (Aset Tetap, Akumulasi Penyusutan, Beban Penyusutan, Kas, dsb).

### Neraca Saldo
Generate otomatis.

### Laporan
- Kartu Aset (per aset)
- Daftar Aset per Kategori
- Jadwal Penyusutan
- Nilai Buku per Kategori
- Laba/Rugi Pelepasan Aset
- Neraca
- SHU / Laba Rugi
- Arus Kas

## 5. Alur Sistem

`Login` ➔ `Dashboard` ➔ `Input Transaksi Aset` ➔ `Validasi` ➔ `Generate Jurnal` ➔ `Update Nilai Buku` ➔ `Generate Laporan` ➔ `Selesai`

## 6. Business Rules

### Perolehan Aset
- Harga perolehan = harga beli + biaya langsung (transport, instalasi) hingga aset siap digunakan
- **Saat perolehan tunai:** Debit Aset Tetap / Kredit Kas
- **Saat perolehan kredit:** Debit Aset Tetap / Kredit Utang Usaha

### Penyusutan
Faktor: harga perolehan, nilai residu, umur manfaat, metode.
- **Saat penyusutan:** Debit Beban Penyusutan / Kredit Akumulasi Penyusutan
- Akumulasi penyusutan bertambah, nilai buku berkurang
- Tanah tidak disusutkan

#### Metode Garis Lurus
Beban sama tiap periode: `(HP − NR) / n`

#### Metode Saldo Menurun (DDB)
Tarif = 2 × (1/n); beban = tarif × nilai buku awal periode. Nilai residu tidak diperhitungkan dalam tarif.

#### Metode Jumlah Angka Tahun (SOYD)
Penyebut = `n(n+1)/2`; beban = (sisa umur / penyebut) × (HP − NR)

#### Metode Unit Produksi
Beban = (HP − NR) × (produksi periode / kapasitas total)

### Pelepasan Aset
**Saat dijual:**
- Akumulasi Penyusutan dihapus (Debit)
- Aset Tetap dikeluarkan (Kredit)
- Kas/Piutang dicatat (Debit) sebesar harga jual
- Selisih nilai buku vs harga jual → Laba (Kredit) atau Rugi (Debit)

**Saat dihapus (rusak/hilang):**
- Akumulasi Penyusutan dihapus (Debit)
- Aset Tetap dikeluarkan (Kredit)
- Nilai buku tersisa → Rugi Penghapusan (Debit)

## 7. Dokumentasi Pemakaian
Aplikasi menyediakan dokumentasi pemakaian (tanpa latihan dan simulasi) yang mencakup:
- **Mulai Cepat:** alur kerja utama aplikasi
- **Chart of Account:** cara menyiapkan daftar akun
- **Kategori Aset:** pengelompokan aset dan pemetaan akun
- **Metode Penyusutan:** pilihan metode dan contoh perhitungan
- **Perolehan Aset:** prosedur pencatatan aset baru
- **Penyusutan:** prosedur pencatatan beban penyusutan
- **Pelepasan Aset:** prosedur pencatatan penjualan/penghapusan
- **Dashboard & Pelaporan:** cara membaca ringkasan dan laporan

## 8. Design System (Tailwind)

| Elemen UI | Fungsi | Warna | Kode Hex |
|---|---|---|---|
| Primary | Header, Tombol Utama, Ikon Aktif | Biru Kelasi | `#2563EB` |
| Background | Latar belakang aplikasi | Abu-abu Sangat Muda | `#F8FAFC` |
| Surface | Latar kartu barang, Form input | Putih Bersih | `#FFFFFF` |
| Text Primary | Judul, Nama Aset, Angka | Abu-abu Gelap | `#1E293B` |
| Text Secondary | Deskripsi, Kategori, Tanggal | Abu-abu Medium | `#64748B` |

Token Tailwind: `primary`, `primary-light`, `primary-dark`, `background`, `surface`, `text-primary`, `text-secondary`.

## 9. Struktur Menu
- **Dashboard**
- **Master**
  - Kategori Aset
  - Aset (Register/Kartu)
  - Metode Penyusutan
  - COA
- **Transaksi**
  - Perolehan Aset
  - Penyusutan
  - Pelepasan Aset
- **Akuntansi**
  - Jurnal
  - Buku Besar
  - Neraca Saldo
- **Laporan**
  - Kartu Aset
  - Jadwal Penyusutan
  - Nilai Buku
  - Laba/Rugi Pelepasan
- **Dokumentasi**
  - Panduan Pemakaian
- **Pengaturan**

## 10. Database (High Level)
Tabel utama:
- `users`
- `asset_categories`
- `assets`
- `depreciation_methods`
- `asset_acquisitions`
- `depreciations`
- `asset_disposals`
- `accounts`
- `journals`
- `journal_details`
- `users`

## 11. Routes & View

### Master
- `GET /assets` - Daftar aset
- `GET /assets/create` - Form tambah aset
- `POST /assets` - Simpan aset baru
- `GET /assets/{id}/edit` - Form edit aset
- `PUT /assets/{id}` - Update aset
- `DELETE /assets/{id}` - Hapus aset

- `GET /asset-categories` - Daftar kategori aset
- `GET /asset-categories/create` - Form tambah kategori
- `POST /asset-categories` - Simpan kategori baru
- `GET /asset-categories/{id}/edit` - Form edit kategori
- `PUT /asset-categories/{id}` - Update kategori
- `DELETE /asset-categories/{id}` - Hapus kategori

- `GET /depreciation-methods` - Daftar metode penyusutan
- `GET /depreciation-methods/create` - Form tambah metode
- `POST /depreciation-methods` - Simpan metode baru
- `GET /depreciation-methods/{id}/edit` - Form edit metode
- `PUT /depreciation-methods/{id}` - Update metode
- `DELETE /depreciation-methods/{id}` - Hapus metode

- `GET /accounts` - Daftar COA
- `GET /accounts/create` - Form tambah akun
- `POST /accounts` - Simpan akun baru
- `GET /accounts/{id}/edit` - Form edit akun
- `PUT /accounts/{id}` - Update akun
- `DELETE /accounts/{id}` - Hapus akun

### Transaksi
- `GET /acquisitions` - Daftar perolehan aset
- `GET /acquisitions/create` - Form perolehan aset
- `POST /acquisitions` - Proses perolehan + jurnal otomatis

- `GET /depreciations` - Daftar jadwal penyusutan
- `POST /depreciations/run` - Eksekusi penyusutan periodik + jurnal otomatis

- `GET /disposals` - Daftar pelepasan aset
- `GET /disposals/create` - Form pelepasan aset
- `POST /disposals` - Proses pelepasan + jurnal otomatis

### Akuntansi
- `GET /journals` - Daftar jurnal
- `GET /ledgers` - Buku besar
- `GET /trial-balance` - Neraca saldo

### Laporan
- `GET /reports/assets` - Daftar/kartu aset
- `GET /reports/depreciation-schedule` - Jadwal penyusutan
- `GET /reports/book-value` - Nilai buku per kategori
- `GET /reports/disposals` - Laba/rugi pelepasan
- `GET /reports/balance-sheet` - Neraca
- `GET /reports/profit-loss` - Laba rugi
- `GET /reports/cashflow` - Arus kas

## 12. Teknologi
**Backend & Frontend:**
- Laravel 13
- Laravel Blade (template engine)
- TailwindCSS
- Alpine.js (untuk interaktivitas ringan di browser)

**Database:**
- MySQL (development: SQLite)

**Authentication:**
- Laravel Sanctum / Session

**Export:**
- Excel
- PDF

**Catatan:** Aplikasi tidak menggunakan TypeScript dan tidak memerlukan build tool frontend modern. Semua tampilan dirender server-side via Blade, dengan sedikit JavaScript native atau Alpine.js untuk elemen interaktif.

## 13. Target MVP
**Sprint 1:**
- [x] Login
- [x] Dashboard
- [x] Master Kategori Aset
- [x] Master Aset (Register)
- [x] COA

**Sprint 2:**
- [x] Perolehan Aset
- [x] Penyusutan (metode dasar)
- [ ] Jurnal (list jurnal global)

**Sprint 3:**
- [ ] Buku Besar

**Sprint 4:**
- [x] Pelepasan Aset
- [ ] Laporan

---

## Rekomendasi Arsitektur
Menggunakan pendekatan **Domain-Driven Design (DDD)** ringan agar modul akuntansi aset terstruktur dan mudah dikembangkan.

Struktur aplikasi Laravel yang disarankan:
```text
app/
 ├── Http/
 │    ├── Controllers/
 │    │    ├── AssetController.php
 │    │    ├── AssetCategoryController.php
 │    │    ├── DepreciationMethodController.php
 │    │    ├── AccountController.php
 │    │    ├── AcquisitionController.php
 │    │    ├── DepreciationController.php
 │    │    ├── DisposalController.php
 │    │    ├── JournalController.php
 │    │    ├── LedgerController.php
 │    │    └── ReportController.php
 │    └── Requests/ (Form validation)
 ├── Models/
 │    ├── User.php
 │    ├── Asset.php
 │    ├── AssetCategory.php
 │    ├── DepreciationMethod.php
 │    ├── Acquisition.php
 │    ├── Depreciation.php
 │    ├── Disposal.php
 │    ├── Account.php
 │    ├── Journal.php
 │    └── JournalDetail.php
 ├── Services/
 │    ├── AcquisitionService.php (logic perolehan + jurnal)
 │    ├── DepreciationService.php (kalkulasi penyusutan per metode)
 │    ├── DisposalService.php (logic pelepasan + jurnal)
 │    ├── JournalService.php (generate jurnal otomatis)
 │    └── ReportService.php (generate laporan)
 ├── Repositories/ (database queries)
 │    ├── AssetRepository.php
 │    ├── AccountRepository.php
 │    ├── JournalRepository.php
 │    └── ReportRepository.php
 ├── Events/ (untuk trigger lanjutan)
 │    ├── AssetAcquired.php
 │    ├── DepreciationPosted.php
 │    └── AssetDisposed.php
 └── Listeners/ (untuk auto-journal)
      ├── GenerateJournalOnAcquisition.php
      ├── GenerateJournalOnDepreciation.php
      └── GenerateJournalOnDisposal.php

resources/
 └── views/
      ├── layouts/
      │    ├── app.blade.php (master layout)
      │    └── sidebar.blade.php
      ├── assets/
      │    ├── index.blade.php
      │    ├── create.blade.php
      │    └── edit.blade.php
      ├── asset_categories/
      ├── depreciation_methods/
      ├── acquisitions/
      ├── depreciations/
      ├── disposals/
      ├── accounts/
      ├── journals/
      ├── reports/
      └── dashboard.blade.php

database/
 └── migrations/
      ├── create_users_table.php
      ├── create_asset_categories_table.php
      ├── create_depreciation_methods_table.php
      ├── create_assets_table.php
      ├── create_depreciations_table.php
      ├── create_asset_disposals_table.php
      ├── create_accounts_table.php
      ├── create_journals_table.php
      └── create_journal_details_table.php
```

**Keuntungan pendekatan ini:**
- Semua rendering dilakukan di server via Blade
- Tidak perlu build tool atau TypeScript
- Logic bisnis terpusat di Services layer (terutama kalkulasi penyusutan)
- Event-Listener untuk auto-generate jurnal
- Mudah untuk maintenance dan scaling ke fitur aset tidak berwujud (amortisasi), leasing, atau revaluasi di masa depan

---

## Lampiran A: Migrasi Schema (dari Koperasi Simpan Pinjam Syariah)

Berikut peta migrasi tabel dari aplikasi lama (SP Syariah) ke aplikasi baru (Manajemen Aset):

| Tabel Lama (SP Syariah) | Tabel Baru (Manajemen Aset) | Keterangan |
|--------------------------|------------------------------|-------------|
| `members`                | `assets` + `asset_categories` | Register anggota → register aset |
| `contracts` (akad)       | `depreciation_methods`        | Jenis akad → metode penyusutan |
| `savings`                | dihapus                       | Digantikan `asset_acquisitions` |
| `financings`             | dihapus                       | Digantikan `depreciations` |
| `installments`           | `asset_disposals`             | Angsuran → pelepasan aset |
| `accounts`               | `accounts` (diperbarui COA)   | COA umum dipertahankan |
| `journals` / `journal_details` | tetap                        | Jurnal otomatis tetap dipakai |

Perubahan kunci:
1. `accounts` tetap, tetapi seeder COA disesuaikan ke akun aset tetap (Aset Tetap, Akumulasi Penyusutan, Beban Penyusutan, Laba/Rugi Pelepasan).
2. Tabel operasional lama (`members`, `contracts`, `savings`, `financings`, `installments`) di-drop dan diganti tabel baru.
3. `journals` dan `journal_details` dipertahankan untuk pencatatan jurnal otomatis (menggunakan morph relasi `journalable`).