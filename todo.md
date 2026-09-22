# TODO — Implementasi "Pengajuan Surat" sebagai Layanan Utama
Acuan: `PRD.md` (wajib dibaca penuh sebelum mengerjakan apapun di bawah ini)
Aturan umum eksekusi ada di `EXECUTION_PROMPT.md` — task list ini HANYA berisi checklist, bukan instruksi cara kerja.

Urutan pengerjaan bersifat sekuensial per Fase. Jangan lompat ke fase berikutnya sebelum fase sebelumnya selesai & diverifikasi.

---

## FASE 0 — Persiapan & Verifikasi Asumsi
- [ ] Baca ulang `PRD.md` secara penuh.
- [ ] Jalankan `php artisan route:list --name=warga.letter,admin.letter` untuk mengonfirmasi nama route aktual saat ini sebelum diubah.
- [ ] Buka & baca isi lengkap `resources/views/admin/letter-requests/edit.blade.php` dan `show.blade.php` — konfirmasi bagaimana `form_data` ditampilkan saat ini (iterasi dinamis atau hardcode key), untuk menjawab [NEEDS VERIFICATION] di PRD §14 poin 4.
- [ ] Cek `tests/Feature` — cari test yang sudah ada terkait `letter` (mis. `LetterRequestTest.php` atau sejenis) agar tidak merusak test existing.
- [ ] Putuskan (atau tandai sebagai keputusan default bila tidak ada arahan tambahan dari user) untuk item [NEEDS VERIFICATION] di PRD:
  - §17: apakah `warga.letter.create` (`/layanan/surat/buat`) di-redirect permanen ke `warga.letter.index` yang baru, atau dipertahankan sebagai alias. **Default bila tidak ada arahan lain: redirect permanen ke `warga.letter.index`.**
  - §16: gunakan Opsi A (tanpa migration baru, field `nama` masuk ke `form_data`) untuk rilis ini. Opsi B tidak dikerjakan kecuali diminta eksplisit.
- [ ] Buat branch kerja baru (jangan langsung commit ke branch utama), penamaan bebas asal deskriptif, mis. `feature/pengajuan-surat-utama`.

## FASE 1 — Routing (`routes/web.php`)
- [ ] Ubah route `GET /layanan/cetak-surat-mandiri` (`warga.letter.index`) agar memanggil method yang menampilkan **form pengajuan** (logika `create()` saat ini).
- [ ] Tambahkan route baru untuk halaman katalog/template yang dipindah, contoh: `GET /layanan/surat/template` → nama route `warga.letter.templates`, memanggil logika `index()` saat ini (katalog).
- [ ] Tangani route `warga.letter.create` (`/layanan/surat/buat`) sesuai keputusan Fase 0 (redirect atau alias).
- [ ] Tinjau ulang `Route::redirect('/layanan/surat', '/layanan/cetak-surat-mandiri')` — pastikan perilakunya sudah sesuai ekspektasi baru (mengarah ke form, bukan katalog), sesuaikan bila perlu.
- [ ] Pastikan route `warga.letter.download`, `warga.letter.store`, `warga.letter.show` **tidak diubah**.
- [ ] Jalankan `php artisan route:list` dan pastikan tidak ada nama route yang bentrok/duplikat.

## FASE 2 — Controller Publik (`LetterRequestController`)
- [ ] Sesuaikan method `index()` dan `create()` di `App\Http\Controllers\Public\LetterRequestController` agar masing-masing me-return view yang tepat sesuai peran barunya (form vs katalog) — rename internal variabel/nama view bila perlu agar tidak membingungkan, TANPA mengubah nama method secara publik kecuali benar-benar diperlukan.
- [ ] Buat `App\Http\Requests\StoreLetterRequestRequest` baru mengikuti pola persis `App\Http\Requests\StoreLaporanRequest`:
  - [ ] Rule: `template_id` required, exists.
  - [ ] Rule: `form_data.nama` required, string, max:255.
  - [ ] Rule: `form_data.nik` required, string, regex 16 digit angka.
  - [ ] Rule: `form_data.telepon` required, regex nomor WA Indonesia (samakan persis dengan regex di `StoreLaporanRequest`).
  - [ ] Rule: `form_data.keperluan` required, string, min:10, max:1000.
  - [ ] Method `prepareForValidation()` untuk normalisasi nomor WA ke format `62xxxxxxxxxx` (adaptasi dari `StoreLaporanRequest`, sesuaikan path array `form_data.telepon`).
  - [ ] Pesan error Bahasa Indonesia untuk semua rule (pola sama seperti `StoreLaporanRequest`).
- [ ] Ganti validasi inline di method `store()` agar memakai `StoreLetterRequestRequest` yang baru dibuat.
- [ ] Update pesan flash sukses di `store()` agar menyebutkan nomor WA yang akan dihubungi admin (pola sama seperti `ComplaintController@store`).
- [ ] Tambahkan handling empty state: jika `LetterTemplate::all()` kosong, kirim flag/variabel ke view agar dropdown menampilkan state kosong yang jelas (lihat PRD §23).

## FASE 3 — View Publik: Form "Pengajuan Surat" (halaman utama baru)
- [ ] Buka `resources/views/public/layanan/surat/create.blade.php` sebagai basis.
- [ ] Restyle total mengikuti pola visual `resources/views/public/layanan/pengaduan/create.blade.php` (WAJIB dijadikan acuan 1:1 untuk: struktur card, label, input, error style, tombol submit) — lihat PRD §19.
- [ ] Update judul, breadcrumb, dan `@section('title')`/`@section('meta_description')` agar mencerminkan "Pengajuan Surat" sebagai layanan utama.
- [ ] Tambahkan field **Nama Lengkap** (`form_data[nama]`) — field baru, belum ada sebelumnya.
- [ ] Pertahankan field NIK (`form_data[nik]`) dan No. WhatsApp (`form_data[telepon]`) dengan key yang sama seperti sekarang (backward compatible), tapi restyle sesuai pola baru.
- [ ] Hapus/ganti referensi `auth()->user()->nik` (bug lama, kolom tidak ada) — jangan disalin ke form baru; gunakan `old('form_data.nik')` saja sebagai default value.
- [ ] Pertahankan field Jenis Surat (`template_id`) dan Keperluan (`form_data[keperluan]`), restyle sesuai pola baru.
- [ ] Tambahkan tautan sekunder kecil/understated menuju halaman "Template & Format Surat" (route baru dari Fase 1), diposisikan dekat header halaman, TIDAK berupa tombol besar/mencolok — lihat PRD §19.
- [ ] Tangani empty state dropdown Jenis Surat (opsi disabled dengan pesan jelas) sesuai PRD §23.
- [ ] Pastikan responsive sesuai pola `max-w-3xl mx-auto px-4 sm:px-6 lg:px-8`.

## FASE 4 — View Publik: Halaman Sekunder "Template & Format Surat"
- [ ] Pastikan `resources/views/public/layanan/surat/index.blade.php` (katalog, TIDAK dihapus) sekarang dirender oleh route baru dari Fase 1.
- [ ] Update `@section('title')` dari "Layanan Cetak Surat Mandiri" menjadi "Template & Format Surat" (atau judul sejenis yang mencerminkan peran sekundernya).
- [ ] Update breadcrumb agar konsisten dengan hierarki baru (mis. Beranda / Cetak Surat Mandiri / Template & Format Surat, atau sejenisnya — selaraskan dengan struktur breadcrumb halaman form di Fase 3).
- [ ] Pastikan seluruh fungsi yang sudah ada (search, slider mobile/desktop, modal "Alur Pengurusan", download template) **tetap berjalan tanpa regresi**.
- [ ] Jangan hapus/ubah style `.surat-slider-*` dan logika Alpine.js yang sudah ada kecuali untuk penyesuaian teks/judul.

## FASE 5 — Navigasi Situs Publik (Link ke halaman baru)
- [ ] `resources/views/public/home/sections/shortcuts.blade.php`: cek 2 titik referensi `warga.letter.index` — pastikan konteks copy (mis. "Surat Mandiri") masih relevan untuk halaman form; sesuaikan teks kecil bila perlu, tanpa mengubah struktur kartu.
- [ ] `resources/views/layouts/partials/public-footer.blade.php`: cek 7 titik referensi `warga.letter.index` — khususnya baris yang mem-passing parameter `search` ke `warga.letter.index` (mengasumsikan tujuan adalah katalog) — arahkan referensi tersebut ke route baru "Template & Format Surat" (Fase 1), BUKAN ke `warga.letter.index` yang sekarang jadi form.
- [ ] `resources/views/layouts/partials/public-header.blade.php`: cek 2 titik referensi `warga.letter.index` — pastikan label menu masih sesuai ("Cetak Surat Mandiri" mengarah ke halaman form).
- [ ] Setelah semua diaudit, buat daftar singkat titik mana yang tetap mengarah ke `warga.letter.index` (form) vs yang diarahkan ulang ke route katalog baru — sertakan di ringkasan pekerjaan akhir.

## FASE 6 — View Publik: Halaman Status Tiket (Penyelarasan Visual)
- [ ] `resources/views/public/layanan/surat/show.blade.php`: selaraskan warna aksen ke `#0A3D29` (forest.deep) secara konsisten — saat ini beberapa elemen memakai `emerald-600`/`emerald-800`/`gray-*` generik.
- [ ] Selaraskan style card/border mengikuti pola situs (`rounded-xl border-slate-200/90 shadow-xs` dsb) jika ditemukan penggunaan `gray-*` yang tidak konsisten dengan `slate-*` yang dipakai di halaman lain.
- [ ] Jangan ubah logika progress tracker (3 langkah) — hanya styling.

## FASE 7 — Admin: Navigasi Sidebar
- [ ] Buka `resources/views/layouts/admin.blade.php`, cari section "LAYANAN PUBLIK" (sekitar baris 164–199, dalam blok `@if(Auth::user()->canAccessPublicServices())`).
- [ ] Tambahkan item navigasi baru "Permohonan Surat" mengarah ke `route('admin.letter-requests.index')`, ditempatkan berdampingan dengan "Template Surat" dan "Pengaduan Warga" yang sudah ada.
- [ ] Gunakan pola markup identik (svg icon, class `group flex items-center justify-between ...`, active-state indicator `request()->routeIs('admin.letter-requests.*')`) seperti item nav lain di section yang sama.
- [ ] Pilih ikon svg yang relevan secara semantik (mis. ikon dokumen/tiket) dan berbeda dari ikon "Template Surat" agar mudah dibedakan.
- [ ] (Opsional, sesuai PRD §14 poin 5) Tambahkan badge jumlah permohonan berstatus `pending` di sebelah label menu, hanya jika PRD §29 diminta dikerjakan sekarang — jika tidak ada arahan eksplisit dari user, LEWATI dulu poin ini dan cukup catat sebagai potensi future work.

## FASE 8 — Admin: Tabel & Pencarian Permohonan Surat
- [ ] `App\Http\Controllers\Admin\LetterRequestController@index`: perluas kondisi `search` agar juga mencocokkan `form_data->nama` dan `form_data->telepon` (gunakan `where('form_data->nama', 'like', "%{$search}%")` / `orWhere('form_data->telepon', 'like', ...)`, sesuai dukungan JSON path query Laravel/MySQL).
- [ ] `resources/views/admin/letter-requests/index.blade.php`:
  - [ ] Ganti kolom "Pemohon" agar fallback ke `data_get($req->form_data, 'nama', '-')` ketika `$req->user` null.
  - [ ] Tambahkan kolom baru "No. WhatsApp" mengambil dari `data_get($req->form_data, 'telepon')`, tampilkan `-` jika kosong.
  - [ ] Pastikan `overflow-x-auto` yang sudah ada tetap menangani lebar tabel dengan kolom tambahan ini.
- [ ] Verifikasi (buka & baca, JANGAN asumsi) `resources/views/admin/letter-requests/show.blade.php` dan `edit.blade.php` — pastikan field `nama` baru ikut tampil di detail (baik lewat iterasi dinamis `form_data` atau perlu ditambah eksplisit); tambahkan bila belum tampil.

## FASE 9 — Admin: Dashboard (Opsional — hanya jika diminta eksplisit)
- [ ] LEWATI fase ini kecuali ada instruksi eksplisit dari user untuk mengerjakannya. Jika diminta:
  - [ ] Tambahkan `letter_requests_pending_count` di `Admin\DashboardController`, memakai `LetterRequest::where('status','pending')->count()`.
  - [ ] Tampilkan di view dashboard admin dengan pola card statistik yang sudah ada (samakan dengan card `letter_templates_count`).

## FASE 10 — QA / Verifikasi Non-Regresi
- [ ] Jalankan `php artisan route:list` — pastikan semua nama route lama yang dipakai di 11 titik referensi (footer, header, shortcuts) masih valid dan tidak error.
- [ ] Jalankan test suite yang ada: `php artisan test` (atau `./vendor/bin/phpunit`) — pastikan tidak ada test existing yang gagal akibat perubahan ini.
- [ ] Uji manual alur end-to-end sebagai guest (tanpa login):
  - [ ] Buka `/layanan/cetak-surat-mandiri` → harus tampil form Pengajuan Surat.
  - [ ] Isi form lengkap (termasuk Nama Lengkap) → submit → harus dapat nomor tiket & redirect ke halaman status.
  - [ ] Buka tautan sekunder "Template & Format Surat" → katalog lama harus tampil utuh, search & download template masih berfungsi.
- [ ] Uji manual sebagai admin (`admin_pemdes` / `super_admin`):
  - [ ] Login → sidebar harus menampilkan menu "Permohonan Surat".
  - [ ] Buka menu tsb → permohonan yang baru saja dibuat (guest) harus tampil dengan Nama & No. WhatsApp terisi benar (bukan `-`).
  - [ ] Coba fitur search admin dengan nama pemohon guest tsb → harus ditemukan.
  - [ ] Buka detail/edit permohonan → ubah status ke `approved`, isi catatan, submit → pastikan berhasil tanpa error (fungsi existing, pastikan tidak regresi).
  - [ ] Pastikan CRUD "Template Surat" (create/edit/delete) di admin masih berfungsi normal tanpa perubahan (regresi check).
- [ ] Cek tidak ada file/data template surat yang hilang dari storage (`storage/app/public/letter_templates/`) dibanding sebelum perubahan.
- [ ] Review visual manual: bandingkan form baru dengan `pengaduan/create.blade.php` — pastikan konsisten (warna, font, spacing, tidak ada gradient/ikon dekoratif berlebihan).
- [ ] Cek console browser (devtools) di halaman form & katalog untuk memastikan tidak ada error JS (Alpine.js) akibat perubahan struktur.

## FASE 11 — Ringkasan & Serah Terima
- [ ] Tulis ringkasan perubahan: file apa saja yang diubah/ditambah, keputusan yang diambil untuk setiap item `[NEEDS VERIFICATION]` di PRD, dan bagian mana (jika ada) yang sengaja dilewati/tidak dikerjakan beserta alasannya.
- [ ] Cantumkan link/nama route baru yang ditambahkan (untuk halaman "Template & Format Surat") agar mudah direferensikan di masa depan.
- [ ] Jangan melakukan merge/push ke branch utama — serahkan hasil dalam bentuk diff/PR untuk direview oleh pemilik project.

---

## Batasan Keras (Jangan Dilanggar)
- Jangan menghapus tabel, kolom, file storage, atau view `letter_templates`/`letter-templates` manapun.
- Jangan mengubah fitur Pengaduan Warga, Berita, Galeri, PPKO, Profil Desa, atau modul admin lain di luar scope PRD.
- Jangan mengganti design token global (`tailwind.config.js`) atau membuat skema warna baru.
- Jangan membuat tabel database baru (ikuti Opsi A di PRD §16, kecuali diinstruksikan lain secara eksplisit).
- Jangan mengerjakan Fase 9 (dashboard) atau fitur di PRD §29 (Future Extension) kecuali diminta eksplisit.
- Jika menemukan fakta di kode yang bertentangan dengan asumsi PRD, STOP, jangan menebak — laporkan temuan dan tunggu arahan sebelum melanjutkan.
