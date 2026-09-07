# TODO - Implementasi Halaman PPK Ormawa Catur Cerdas UMS

> Referensi: `PRD-Halaman-PPKO-Catur-Cerdas.md`
> Catatan untuk agent: project Laravel + SQLite sudah ada, termasuk sistem auth/admin. Cek dulu struktur project existing (routes, models, middleware, layout) sebelum menambah kode baru — sesuaikan konvensi yang sudah dipakai.

## 0. Investigasi Awal (wajib sebelum coding)
- [x] Cek struktur project: `routes/web.php`, folder `app/Models`, `app/Http/Controllers`, `resources/views`
- [x] Cek sistem auth/admin existing: guard, middleware, role/permission yang dipakai
- [x] Cek layout/blade utama (master layout, komponen navbar/footer) yang harus dipakai untuk konsistensi desain
- [x] Cek konfigurasi storage (`config/filesystems.php`) dan pastikan `storage:link` sudah ada
- [x] Konfirmasi ke user: nama role/menu existing untuk mapping akses Panitia & Admin Pemdes

## 1. Database & Model
- [x] Buat migration tabel `pojoks` (id, nama, deskripsi_singkat)
- [x] Buat seeder `PojokSeeder` untuk 5 data tetap: Harmoni, Ceria, UMKM Go Digital, Budaya, Tani (sesuai deskripsi di transkrip)
- [x] Buat migration tabel `kegiatans` (id, pojok_id FK, judul, deskripsi, tanggal_kegiatan, thumbnail nullable, created_by FK users, timestamps)
- [x] Buat migration tabel `galeri_fotos` (id, kegiatan_id FK, file_path, caption nullable, uploaded_by FK users, timestamps)
- [x] Buat model `Pojok` dengan relasi `hasMany(Kegiatan)`
- [x] Buat model `Kegiatan` dengan relasi `belongsTo(Pojok)`, `hasMany(GaleriFoto)`, `belongsTo(User, 'created_by')`
- [x] Buat model `GaleriFoto` dengan relasi `belongsTo(Kegiatan)`, `belongsTo(User, 'uploaded_by')`
- [x] Jalankan migration & seeder, pastikan tidak konflik dengan skema existing

## 2. Backend - Modul Kegiatan (Admin)
- [x] Buat `KegiatanController` (index, create, store, edit, update, destroy)
- [x] Buat Form Request validasi (`StoreKegiatanRequest`, `UpdateKegiatanRequest`): judul required, deskripsi required, tanggal_kegiatan required date, pojok_id required exists, thumbnail nullable image max size
- [x] Terapkan middleware auth existing pada route CRUD kegiatan (akses untuk role Panitia & Admin Pemdes)
- [x] Simpan `created_by` otomatis dari user yang login
- [x] Tambahkan route resource `kegiatans` di grup route admin/protected

## 3. Backend - Modul Galeri Foto (Admin)
- [x] Buat `GaleriFotoController` (store, destroy; index bisa nested di halaman detail kegiatan)
- [x] Validasi upload: tipe file jpg/png/webp, ukuran maksimum (tentukan default misal 2MB, catat sebagai asumsi)
- [x] Simpan file ke `storage/app/public/galeri` menggunakan `Storage::disk('public')`
- [x] Simpan `uploaded_by` otomatis dari user yang login
- [x] Tambahkan fitur hapus foto (soft delete file dari storage saat record dihapus)
- [x] Tambahkan route nested `kegiatans/{kegiatan}/galeri`

## 4. Backend - Data untuk Landing Page (Publik)
- [x] Buat/perbarui controller halaman utama (misal `HomeController@index` atau sesuai struktur existing) untuk mengambil:
  - [x] Data 5 Pojok (dari tabel `pojoks`)
  - [x] Daftar kegiatan terbaru (urut tanggal desc), dengan opsi filter `?pojok=` via query string
  - [x] Galeri foto per kegiatan (eager load untuk hindari N+1 query)
- [x] Tambahkan pagination pada daftar kegiatan (misal 6-9 per halaman/load more)
- [x] Eager-load kurikulum dan kegiatan per-Pojok untuk section mandiri masing-masing Pojok
- [x] Tambahkan route & method `downloadKurikulum` publik yang aman

## 5. Frontend - Landing Page (Blade)
- [x] Buat/perbarui view halaman utama sesuai struktur section PRD (4.1):
  - [x] Hero Section (hanya gambar cover PPKO di paling atas, latar menyatu dengan warna dasar halaman)
  - [x] Section Latar Belakang & Potensi Desa (konten statis dari transkrip)
  - [x] Restrukturisasi 5 Section Mandiri per-Pojok (Harmoni, Ceria, UMKM Go Digital, Budaya, Tani)
  - [x] Integrasi dokumentasi kegiatan langsung ke dalam setiap section Pojok terkait
  - [x] Tambahkan kartu unduhan Kurikulum / Modul materi di setiap section Pojok
  - [x] Section Galeri Foto Lapangan (dinamis) dengan lightbox/modal saat foto diklik
  - [x] Section Dukungan & Mitra (statis: Pemdes Catur, UMS, dosen pendamping, mitra/komunitas)
  - [x] Section Penutup/Call to Action
- [x] Tambahkan empty state jika data kegiatan atau kurikulum kosong
- [x] Pastikan responsif (mobile-first, cek breakpoint tablet & desktop)
- [x] Tambahkan alt text pada semua gambar (aksesibilitas)

## 6. Frontend - Panel Admin (Kegiatan, Galeri & Kurikulum)
- [x] Buat view daftar kegiatan (list + tombol tambah/edit/hapus)
- [x] Buat form tambah/edit kegiatan (pilih Pojok via dropdown, input tanggal, upload thumbnail opsional)
- [x] Buat halaman detail kegiatan yang menampilkan galeri foto terkait + form upload foto baru
- [x] Buat modul Admin Pojok & Kurikulum (`Admin\PojokController` + views `index`, `edit`) untuk upload silabus/modul (PDF, DOCX, dll.)
- [x] Tambahkan konfirmasi sebelum hapus (kegiatan, foto & kurikulum)
- [x] Tambahkan menu "Pojok & Kurikulum" di sidebar layout admin
- [x] Sesuaikan tampilan admin dengan layout/theme admin existing di project

## 7. Validasi & Keamanan
- [ ] Pastikan hanya user login (Panitia/Admin Pemdes) yang bisa akses route CRUD
- [ ] Validasi ukuran & tipe file upload di sisi server
- [ ] Sanitasi input teks (judul, deskripsi, caption) untuk cegah XSS di Blade (gunakan `{{ }}` bukan `{!! !!}` kecuali perlu)
- [ ] Uji akses lintas role (Panitia vs Admin Pemdes) memastikan keduanya setara sesuai F-08

## 8. SEO & Meta (opsional, tunggu konfirmasi user)
- [ ] Tambahkan title & meta description khusus halaman ini jika dikonfirmasi dibutuhkan

## 9. Testing
- [ ] Test manual: tambah/edit/hapus kegiatan berhasil dan tampil di landing page
- [ ] Test manual: upload & hapus foto galeri berhasil, file benar-benar tersimpan/terhapus di storage
- [ ] Test filter kegiatan per Pojok berfungsi benar
- [ ] Test tampilan responsif di beberapa ukuran layar (mobile, tablet, desktop)
- [ ] Test empty state saat data kosong
- [ ] (Jika ada) tulis feature test Laravel untuk CRUD kegiatan & upload galeri

## 10. Finalisasi
- [ ] Review ulang seluruh konten statis vs transkrip asli (pastikan tidak ada typo/perubahan makna)
- [ ] Jalankan `php artisan storage:link` di environment deployment
- [ ] Cek performa halaman saat galeri foto banyak (lazy load/pagination bekerja)
- [ ] Konfirmasi ke user (stakeholder) untuk poin-poin di PRD bagian 9 (Pertanyaan Terbuka) sebelum dianggap selesai total:
  - [ ] Approval/moderasi kegiatan dari Panitia sebelum publish?
  - [ ] Batasan jumlah foto per kegiatan?
  - [ ] Kebutuhan SEO meta khusus?
