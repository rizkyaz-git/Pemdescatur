# Product Requirements Document (PRD)
## Halaman PPK Ormawa Catur Cerdas UMS

| | |
|---|---|
| **Dokumen** | PRD - Halaman PPK Ormawa Catur Cerdas |
| **Versi** | 1.0 |
| **Tanggal** | 7 September 2026 |
| **Stakeholder** | Website Pemdes Catur |
| **Tech Stack** | Laravel + SQLite |

---

## 1. Latar Belakang

Website Pemdes Catur membutuhkan halaman khusus untuk menampilkan dan mendokumentasikan Program Penguatan Kapasitas Ormawa (PPK Ormawa) "Catur Cerdas" yang diselenggarakan oleh IMM Al-Ghazali, Fakultas Psikologi, Universitas Muhammadiyah Surakarta, di Desa Catur, Kecamatan Sambi, Kabupaten Boyolali, tahun 2026.

Halaman ini berfungsi sebagai **etalase informasi** (profil program & 5 Pojok Pemberdayaan) sekaligus **arsip dokumentasi** kegiatan yang terus diperbarui selama program berjalan.

## 2. Tujuan

1. Menyajikan profil, latar belakang, dan tujuan Program Catur Cerdas kepada publik.
2. Memperkenalkan 5 Pojok Pemberdayaan beserta sasaran dan bentuk kegiatannya.
3. Mendokumentasikan kegiatan/update program secara berkala (jenis konten dinamis).
4. Menampilkan galeri foto dokumentasi tiap kegiatan.
5. Memungkinkan pengelolaan konten dinamis oleh dua pihak: **Panitia PPK Ormawa** dan **Admin Website Pemdes Catur**.

## 3. Target Pengguna

| Peran | Deskripsi |
|---|---|
| **Pengunjung publik** | Warga desa, mahasiswa, dosen pembimbing, pihak DIKTI/Belmawa, masyarakat umum yang ingin melihat profil & dokumentasi program |
| **Admin Panitia PPK Ormawa** | Anggota IMM Al-Ghazali yang menginput kegiatan & galeri foto |
| **Admin Website Pemdes Catur** | Pengelola website desa, memiliki akses yang sama untuk mengelola/moderasi konten |

> Catatan: Sistem auth/admin **sudah tersedia di project existing** — implementasi mengikuti sistem role & auth yang sudah ada, PRD ini hanya mendefinisikan role akses baru (jika diperlukan) untuk mengelola modul kegiatan & galeri.

## 4. Lingkup (Scope)

### 4.1 Struktur Halaman
Halaman berbentuk **single page (landing page)** dengan struktur scroll berikut:

1. **Hero Section** — Judul program, tagline, ilustrasi/foto utama
2. **Latar Belakang & Potensi Desa** — Narasi kondisi Desa Catur dan tantangan yang dihadapi
3. **5 Pojok Pemberdayaan** (statis, konten dari transkrip):
   - Pojok Harmoni
   - Pojok Ceria
   - Pojok UMKM Go Digital
   - Pojok Budaya
   - Pojok Tani
4. **Dokumentasi Kegiatan** (dinamis) — Daftar/timeline kegiatan per Pojok, dapat difilter per Pojok
5. **Galeri Foto** (dinamis) — Galeri foto kegiatan, dikelompokkan per kegiatan/Pojok
6. **Dukungan & Mitra** (statis) — Pemdes Catur, UMS, dosen pendamping, mitra/komunitas
7. **Penutup/Call to Action** — Ajakan dukung gerakan pemberdayaan & PPKO Ormawa Indonesia

### 4.2 Konten Statis (hardcode)
- Narasi latar belakang program
- Deskripsi 5 Pojok Pemberdayaan (nama, sasaran, bentuk kegiatan) — sesuai transkrip
- Narasi dukungan mitra & penutup

### 4.3 Konten Dinamis (dikelola via admin panel)
- **Modul Kegiatan/Update per Pojok**: CRUD kegiatan (judul, deskripsi, tanggal, Pojok terkait, status)
- **Modul Galeri Foto**: upload foto terkait tiap kegiatan, disimpan di local storage (`storage/app/public`)

### 4.4 Di Luar Lingkup (Out of Scope)
- Sistem auth/role baru dari nol (menggunakan yang sudah ada di project)
- Cloud storage (S3, dll) — hanya local disk
- Sub-halaman detail per Pojok atau halaman berita terpisah (di luar landing page)
- Fitur komentar, like, atau interaksi sosial publik
- Multi-bahasa

## 5. Kebutuhan Fungsional

| ID | Kebutuhan | Prioritas |
|---|---|---|
| F-01 | Sistem menampilkan landing page dengan seluruh section sesuai struktur di 4.1 | Must |
| F-02 | Admin (Panitia/Pemdes) dapat login menggunakan sistem auth existing | Must |
| F-03 | Admin dapat membuat, mengedit, menghapus data **Kegiatan** (judul, deskripsi, tanggal, Pojok, thumbnail opsional) | Must |
| F-04 | Admin dapat mengunggah satu atau beberapa **foto** untuk tiap kegiatan (galeri) | Must |
| F-05 | Pengunjung dapat melihat daftar kegiatan terbaru pada landing page, dengan opsi filter berdasarkan Pojok | Should |
| F-06 | Pengunjung dapat melihat galeri foto (lightbox/modal) per kegiatan | Should |
| F-07 | Data kegiatan & galeri disimpan dalam database SQLite | Must |
| F-08 | Kedua role (Panitia & Admin Pemdes) memiliki hak akses yang setara terhadap modul Kegiatan & Galeri | Must |
| F-09 | Sistem menampilkan pesan/empty state jika belum ada kegiatan yang diinput | Could |
| F-10 | Responsif di perangkat mobile & desktop | Must |

## 6. Kebutuhan Non-Fungsional

- **Performa**: Halaman utama harus tetap ringan meski galeri foto bertambah banyak (gunakan lazy-load/pagination pada galeri).
- **Kompatibilitas**: Mengikuti tech stack existing project Laravel + SQLite, tanpa mengubah struktur auth yang sudah berjalan.
- **Keamanan**: Upload foto divalidasi tipe file (jpg/png/webp) dan ukuran maksimum; hanya user terautentikasi yang bisa akses CRUD.
- **Maintainability**: Konten statis tetap mudah diedit oleh developer (Blade/view), konten dinamis dikelola non-developer via panel admin.
- **Aksesibilitas**: Alt text pada gambar galeri, kontras warna layak baca.

## 7. Struktur Data (Draft)

### Tabel `pojok` (referensi statis/seed, opsional sebagai enum atau tabel master)
- id
- nama (Harmoni, Ceria, UMKM Go Digital, Budaya, Tani)
- deskripsi_singkat

### Tabel `kegiatan`
- id
- pojok_id (FK)
- judul
- deskripsi
- tanggal_kegiatan
- thumbnail (nullable)
- created_by (FK user)
- created_at / updated_at

### Tabel `galeri_foto`
- id
- kegiatan_id (FK)
- file_path
- caption (nullable)
- uploaded_by (FK user)
- created_at

## 8. Alur Pengguna (User Flow)

**Pengunjung:**
1. Membuka halaman → melihat hero, latar belakang, 5 Pojok
2. Scroll ke bagian Dokumentasi Kegiatan → filter per Pojok (opsional)
3. Klik kegiatan → melihat galeri foto terkait (modal/lightbox)

**Admin (Panitia/Pemdes):**
1. Login menggunakan sistem auth existing
2. Masuk ke menu Kegiatan → tambah/edit/hapus kegiatan
3. Pilih kegiatan → upload foto ke galeri kegiatan tersebut
4. Perubahan otomatis tampil di landing page publik

## 9. Pertanyaan Terbuka / Perlu Konfirmasi Lanjutan

- [ ] Nama-nama menu/role di sistem auth existing (perlu dicek langsung di project untuk penyesuaian middleware/permission)
- [ ] Apakah perlu approval/moderasi sebelum kegiatan dari Panitia tampil publik, atau langsung publish?
- [ ] Apakah ada batasan jumlah foto per kegiatan?
- [ ] Apakah dibutuhkan SEO meta (title/description) khusus untuk halaman ini?

## 10. Kriteria Selesai (Definition of Done)

- Semua section statis tampil sesuai transkrip yang diberikan
- Modul Kegiatan & Galeri Foto berfungsi penuh (CRUD + upload) dan terintegrasi dengan sistem auth existing
- Kedua role admin dapat mengelola konten dinamis tanpa error
- Halaman responsif di mobile & desktop
- Data tersimpan konsisten di SQLite
