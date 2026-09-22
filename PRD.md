# PRD — Perubahan Layanan "Cetak Surat Mandiri" → "Pengajuan Surat"
**Project:** Pemdescatur (Website Pemerintah Desa Catur, Kec. Sambi, Kab. Boyolali)
**Stack:** Laravel 11 (PHP), Blade + TailwindCSS + AlpineJS, MySQL/SQLite
**Disusun:** Berdasarkan audit langsung terhadap kode di repository `rizkyaz-git/Pemdescatur` (branch default saat clone)
**Status dokumen:** Draft untuk direview sebelum implementasi. **Belum ada kode yang diubah.**

---

## 0. Ringkasan Temuan Audit (Executive Summary)

Audit menemukan sesuatu yang penting dan mengubah kerangka berpikir permintaan awal:

> **Fitur "Pengajuan Surat" (form isian + tiket + status) SUDAH ADA dan sudah berfungsi secara backend**, lengkap dengan controller, route, model, migration, dan bahkan tampilan (`create.blade.php`, `show.blade.php`). Yang **belum ada adalah tautan navigasinya** — halaman ini tidak terhubung dari navbar, footer, homepage, maupun halaman katalog surat manapun. Secara UX, fitur ini saat ini "yatim" (orphaned page), hanya bisa diakses lewat URL langsung `/layanan/surat/buat`.
>
> Sebaliknya, yang saat ini menjadi **halaman utama** dan terhubung ke seluruh navigasi situs (navbar, footer, homepage shortcut) adalah **katalog & unduh template surat siap cetak** (`/layanan/cetak-surat-mandiri` → `LetterRequestController@index`), yang sudah sangat matang secara UI (slider panel, search, modal alur, dsb).

Dengan kata lain, pekerjaan ini **bukan membangun fitur pengajuan surat dari nol**, melainkan:
1. **Menukar posisi** — menjadikan halaman "Pengajuan Surat" (form) sebagai pintu masuk utama di `/layanan/cetak-surat-mandiri`, dan memindahkan katalog/unduh template menjadi akses sekunder.
2. **Melengkapi kekurangan struktural** yang ditemukan (lihat §2) — terutama: field "Nama Lengkap" belum ada di form, kolom WhatsApp tidak mudah dicari/ditampilkan di sisi admin, dan halaman admin "Permohonan Surat" tidak memiliki menu di sidebar sama sekali.
3. **Menyelaraskan gaya visual** form pengajuan (saat ini bergaya generik abu-abu) dengan visual language situs yang sebenarnya (warna `forest.deep #0A3D29`, font `Merriweather`/`Inter`, pola card/form yang sudah baku — dicontohkan sempurna oleh fitur **Pengaduan Warga** yang baru dan sudah konsisten).

---

## 1. Project Context

Pemdescatur adalah website resmi Pemerintah Desa Catur berbasis Laravel 11 dengan:
- **Routing:** `routes/web.php` — route publik terpisah dari grup `admin` (middleware `auth`, `role:...`).
- **Autentikasi & Role:** Guard `web`, kolom `role` pada tabel `users`. Role dikenali: `super_admin`, `admin_pemdes`, `ppk_ormawa` (dengan alias legacy `admin_modul`, `admin_ppp_ormawa`). Middleware `CheckRole` (`app/Http/Middleware/CheckRole.php`) mengatur hak akses granular per modul lewat method seperti `canAccessPublicServices()` di `App\Models\User`.
- **Styling:** TailwindCSS dengan token kustom di `tailwind.config.js`:
  - Publik: warna `forest.deep = #0A3D29` (brand hijau tua utama), `forest.mist/soft/pale` untuk latar lembut, font `font-serif` (Merriweather) untuk judul, `font-sans` (Inter) untuk body.
  - Admin: warna `civic.primary = #0F4C3A`, border `#E2E8F0`, radius besar (`rounded-[20px]`), font `font-jakarta` (Plus Jakarta Sans). **[NEEDS VERIFICATION]** — Ditemukan juga admin module yang lebih baru (`admin/complaints/*`) memakai token sedikit berbeda (`#0B6B52`, border `#DDE5E1`, `rounded-[12px]`), menunjukkan evolusi desain admin yang belum seragam di seluruh modul. Untuk fitur ini, PRD merekomendasikan mengikuti pola **terbaru** (`admin/complaints`) karena paling representatif sebagai standar saat ini.
- **Komponen Blade reusable:** `x-breadcrumbs`, `x-file-picker`, `x-primary-button`, `x-text-input`, `x-input-error`, `x-toast`, serta skeleton loader (`x-skeleton.surat-item` sudah tersedia khusus untuk katalog surat).
- **Layout:** `layouts.public` (situs publik) dan `layouts.admin` (panel admin, sidebar tetap di `resources/views/layouts/admin.blade.php`).

---

## 2. Existing Feature Analysis (Temuan Audit Detail)

### 2.1 Routing saat ini (`routes/web.php`)

```
Route::redirect('/layanan', '/layanan/cetak-surat-mandiri');
...
Route::redirect('/layanan/surat', '/layanan/cetak-surat-mandiri');
Route::get('/layanan/cetak-surat-mandiri', [PublicControllers\LetterRequestController::class, 'index'])->name('warga.letter.index');
Route::get('/layanan/surat/template/{letterTemplate}/download', [...], 'downloadTemplate')->name('warga.letter.download');
Route::get('/layanan/surat/buat', [...], 'create')->name('warga.letter.create');
Route::post('/layanan/surat', [...], 'store')->middleware('throttle:5,1')->name('warga.letter.store');
Route::get('/layanan/surat/{letterRequest}', [...], 'show')->name('warga.letter.show');
```

Route admin:
```
Route::resource('letter-templates', Admin\LetterTemplateController::class)->except(['show']);
Route::resource('letter-requests', Admin\LetterRequestController::class)->only(['index','show','edit','update']);
```

### 2.2 Controller Publik — `App\Http\Controllers\Public\LetterRequestController`
Satu controller menangani **dua fungsi berbeda** yang saat ini digabung:
| Method | Fungsi saat ini | Menjadi |
|---|---|---|
| `index()` | Menampilkan **katalog template** (search, list, detail panel) → view `public.layanan.surat.index` | Akan **dipindah** perannya menjadi halaman sekunder "Template & Format Surat" |
| `downloadTemplate()` | Unduh file template siap-cetak dari storage | **Tidak berubah** |
| `create()` | Form pengajuan surat → view `public.layanan.surat.create` | Akan **menjadi halaman utama** di `/layanan/cetak-surat-mandiri` |
| `store()` | Simpan `LetterRequest` baru, generate nomor tiket, redirect ke `show` | **Diperluas validasinya** (lihat §10–12) |
| `show()` | Detail status tiket + proteksi IDOR (guest vs user login) | **Tidak berubah secara struktural** |

### 2.3 Model & Data
**`App\Models\LetterTemplate`** (tabel `letter_templates`):
```
id, name, code (nullable), file_path (nullable), description (nullable),
requirements (nullable, text — daftar syarat dipisah baris baru),
template_text (nullable, longtext — sisa dari desain lama placeholder {{}}),
timestamps
```
Field `code` sempat wajib-unik, lalu dibuat nullable oleh migration `2026_09_09_151500`. Field `template_text` awalnya wajib (untuk template HTML dengan placeholder), tapi sekarang **sudah tidak dipakai aktif** — model sudah bergeser ke pola "upload file siap cetak" (`file_path` + accessor `has_file`, `file_url`, `file_extension`, `file_size_formatted`).

**`App\Models\LetterRequest`** (tabel `letter_requests`):
```
id, user_id (nullable, FK users, cascade), template_id (FK letter_templates, cascade),
ticket_number (unique, auto-generate format TKT-YYYYMM-00001),
form_data (JSON, cast ke array — BEBAS/DINAMIS, isi field ditentukan oleh form),
status (enum: pending|approved|rejected, default pending),
result_file_path (nullable — path PDF hasil surat jadi),
admin_notes (nullable),
submitted_at, processed_at (nullable timestamps),
timestamps
index: ticket_number, user_id, status
```
**Temuan penting:** `user_id` sudah dibuat `nullable` oleh migration terpisah `2026_09_03_000001_make_user_id_nullable_in_services_tables.php` — artinya **guest submission (tanpa akun) sudah didukung skema database**, konsisten dengan pola yang sama diterapkan pada fitur Pengaduan.

**Field NIK, Nama, dan Nomor WhatsApp SAAT INI tidak punya kolom sendiri** — semuanya disimpan di dalam `form_data` (JSON bebas), dengan key yang **ditentukan oleh nama input HTML di form** (`form_data[nik]`, `form_data[telepon]`, `form_data[keperluan]`). **Tidak ada key standar untuk "nama pemohon"** di form saat ini — field Nama Lengkap **belum ada sama sekali** di form pengajuan yang sudah ada.

### 2.4 Pola Referensi yang Sudah Terbukti (Fitur Pengaduan Warga)
Fitur **Pengaduan Warga** (`Laporan` model, tabel `laporans`, hasil refactor migration `2026_09_15_000002_refactor_complaints_to_laporans.php`) adalah **cetak biru desain yang paling relevan** untuk fitur ini, karena:
- Guest-only (tanpa akun), identifikasi lewat `nama` + `no_whatsapp` sebagai **kolom eksplisit**, bukan JSON.
- Validasi nomor WhatsApp memakai `FormRequest` khusus (`App\Http\Requests\StoreLaporanRequest`) dengan regex `^(?:\+62|62|0)8[1-9][0-9]{6,10}$` dan normalisasi otomatis ke format `62xxxxxxxxxx` lewat `prepareForValidation()`.
- Tampilan form (`resources/views/public/layanan/pengaduan/create.blade.php`) memakai visual language situs yang benar: card putih `rounded-xl border-slate-200/90 shadow-xs`, warna aksen `#0A3D29`, label `text-[13px] font-semibold text-slate-800`, dropdown kategori custom Alpine (mobile: native `<select>`, desktop: dropdown custom), komponen `<x-file-picker>` untuk lampiran.
- Pesan sukses menyebutkan eksplisit nomor WA yang akan dihubungi admin.

**Rekomendasi kuat:** Form "Pengajuan Surat" versi baru sebaiknya **meniru pola form Pengaduan** ini persis (bukan pola `create.blade.php` surat yang lama, yang stylingnya generik abu-abu dan belum konsisten).

### 2.5 Gap Kritis di Sisi Admin (Temuan Audit)
1. **Sidebar admin (`layouts/admin.blade.php`) hanya punya menu "Template Surat"** (`admin.letter-templates.*`). **Tidak ada menu "Permohonan Surat"** (`admin.letter-requests.*`) sama sekali di sidebar — meskipun controller, route, dan view admin-nya sudah lengkap (`index`, `show`, `edit`, `update`). Saat ini halaman ini hanya bisa diakses admin lewat mengetik URL manual.
2. **Tabel admin daftar permohonan** (`admin/letter-requests/index.blade.php`) menampilkan kolom "Pemohon" dari `$req->user->name` — untuk pengajuan **guest** (tanpa akun, `user_id = null`), kolom ini akan tampil **strip (`-`)**, tidak menampilkan nama maupun nomor WA sama sekali padahal data itu ada di `form_data`.
3. **Fitur pencarian admin** (`search` di `Admin\LetterRequestController@index`) mencari lewat `ticket_number` dan `whereHas('user', name like ...)` — untuk pengajuan guest, pencarian by nama **tidak akan menemukan hasil** karena tidak ada relasi `user`.
4. **Dashboard admin** (`Admin\DashboardController`) menampilkan `letter_templates_count`, tapi **tidak menampilkan jumlah permohonan surat** (`letter_requests_count`) atau jumlah yang berstatus pending — padahal ini akan menjadi indikator kerja admin paling penting setelah perubahan ini.

### 2.6 Bug Kecil Ditemukan (Tidak dalam scope perbaikan, sekadar dicatat)
- Form `create.blade.php` lama memanggil `auth()->user()->nik`, padahal **tidak ada kolom `nik` di tabel `users`** (kolom `nik` sebelumnya ada di tabel `residents` yang sudah di-drop oleh migration `2026_09_09_000005_drop_residents_and_families_tables.php`). Ini tidak menimbulkan error fatal (Eloquent mengembalikan `null` untuk atribut tak dikenal), namun logikanya dead code. **[NEEDS VERIFICATION]** — tidak wajib diperbaiki dalam fitur ini, tapi disebutkan agar tidak disalin ke form baru.
- Beberapa view memakai `$tpl->title ?? $tpl->name` — kolom `title` **tidak pernah ada** di `letter_templates`, jadi selalu fallback ke `name`. Referensi mati, aman diabaikan/dibersihkan opsional saat menyentuh file terkait.

---

## 3. Problem Statement

Desa belum memiliki template surat resmi final, sehingga fitur unduh-template-siap-cetak yang saat ini menjadi halaman utama layanan surat berisiko membingungkan warga (template belum resmi/final) dan tidak menjadi jalur layanan yang efektif. Sementara itu, kapabilitas **pengajuan surat via form** sudah ada di backend namun tidak dapat diakses warga karena tidak ditautkan di manapun, dan belum lengkap (tanpa field nama, admin tidak bisa melihat data pemohon guest dengan baik).

## 4. Goals
1. Menjadikan **"Pengajuan Surat"** (form isian) sebagai halaman utama & jalur layanan resmi di `/layanan/cetak-surat-mandiri`.
2. Memastikan admin desa menerima data pemohon yang lengkap: nama, NIK, WhatsApp aktif, jenis surat, keperluan — agar dapat menindaklanjuti via WhatsApp.
3. Mempertahankan seluruh fitur & data template surat yang sudah ada (tidak dihapus), dipindah menjadi akses sekunder yang rapi.
4. Menutup gap admin (§2.5) agar permohonan benar-benar bisa dikelola, bukan sekadar tersimpan di database.
5. Menjaga konsistensi visual penuh dengan desain situs yang sudah ada (meniru pola Pengaduan Warga sebagai acuan gaya).

## 5. Non-Goals
- **Tidak** membangun sistem pembuatan surat otomatis dari `template_text` (placeholder engine) — field ini tetap didiamkan, tidak dihidupkan kembali.
- **Tidak** mengubah alur/desain fitur Pengaduan Warga, Berita, Galeri, PPKO, atau modul lain di luar layanan surat.
- **Tidak** mengganti sistem desain global (warna, font, komponen) — hanya menggunakan yang sudah ada.
- **Tidak** membangun sistem akun wajib untuk warga — pengajuan tetap bisa dilakukan sebagai guest (tanpa login), sama seperti pengaduan.
- **Tidak** mengubah struktur role/permission admin yang sudah ada.
- **Tidak** membuat generator PDF surat otomatis — `result_file_path` tetap diisi manual oleh admin (sudah ada, lihat §2.2/Admin Workflow).

## 6. User Roles
| Role | Hak akses terhadap fitur ini |
|---|---|
| **Warga (guest, tanpa akun)** | Mengisi & mengirim form Pengajuan Surat; melihat status via nomor tiket/link; melihat & mengunduh Template Surat (akses sekunder). |
| **Warga (login, punya akun)** | Sama seperti guest, plus histori dapat dikaitkan ke `user_id` jika login saat submit. |
| **admin_pemdes** / **super_admin** | Akses penuh CRUD Template Surat + kelola Permohonan Surat (lihat status, ubah status, upload hasil PDF, catatan admin). Ditentukan oleh `canAccessPublicServices()` di model `User`. |
| **ppk_ormawa** | Tidak punya akses ke modul ini (sudah dibatasi middleware `role:super_admin,admin_pemdes` di route group). |

## 7. User Flow

### 7.1 Flow Warga (Alur Utama Baru)
```
1. Warga membuka menu "Cetak Surat Mandiri" dari navbar/footer/homepage
   → mendarat di /layanan/cetak-surat-mandiri (SEKARANG: halaman "Pengajuan Surat")
2. Warga mengisi form: Nama Lengkap, NIK, No. WhatsApp, Jenis Surat, Keperluan
   (+ data tambahan jika jenis surat tsb membutuhkan — lihat §10)
3. Submit → sistem membuat LetterRequest baru, generate No. Tiket otomatis
4. Warga diarahkan ke halaman konfirmasi (sudah ada: warga.letter.show)
   → menampilkan No. Tiket, status "Menunggu Verifikasi", info bahwa admin
     akan menghubungi via WhatsApp yang diinput
5. (Opsional) Warga dapat mengakses "Template & Format Surat" dari tautan
   sekunder untuk melihat contoh format/syarat sebelum mengisi form
```

### 7.2 Flow Admin
```
1. Admin login → sidebar sekarang punya menu "Permohonan Surat" (baru ditambahkan)
2. Admin membuka daftar permohonan → melihat Nama, No. WA, Jenis Surat, Status
   (termasuk untuk pemohon guest — lihat §14 perbaikan tampilan)
3. Admin klik salah satu tiket → melihat detail lengkap form_data pemohon
4. Admin menghubungi pemohon via WhatsApp (manual, di luar sistem)
5. Admin ubah status: Approved/Rejected + catatan + (opsional) upload PDF hasil
6. Warga dapat mengecek status via halaman show / link tiket
```

## 8. Proposed UX

**Halaman `/layanan/cetak-surat-mandiri` (utama, BARU):**
- Judul halaman: **"Pengajuan Surat"** (breadcrumb & `<title>` disesuaikan).
- Struktur: 1 card form bersih, mengikuti pola persis `pengaduan/create.blade.php` (card putih `rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8`, label `text-[13px] font-semibold text-slate-800`, input `bg-slate-50/40`, aksen warna `#0A3D29`).
- Di atas atau dekat form: **tautan sekunder kecil** menuju "Lihat Template & Format Surat" (bukan tombol besar/mencolok) — mengarah ke halaman katalog lama yang dipindah ke path baru (lihat §17).
- Field dinamis: bila jenis surat yang dipilih memiliki `requirements` (syarat berkas), tampilkan sebagai info non-mengganggu (collapsible/keterangan kecil), bukan sebagai form terpisah wajib diisi.
- Setelah submit sukses: tetap gunakan `warga.letter.show` yang sudah ada, dengan penyesuaian gaya visual agar selaras (tracker status sudah bagus, hanya perlu penyesuaian warna aksen agar konsisten dengan `#0A3D29`).

**Halaman sekunder "Template & Format Surat" (BARU dari perpindahan index lama):**
- UI slider/katalog yang sudah ada (`public.layanan.surat.index`) **dipertahankan utuh**, hanya dipindah path dan diberi framing baru: fokus sebagai referensi format/syarat, bukan sebagai layanan utama. Judul diubah dari "Layanan Cetak Surat Mandiri" menjadi misalnya **"Template & Format Surat"**.
- Diakses dari: (a) tautan sekunder di halaman Pengajuan Surat, (b) footer, (c) opsional dari menu "Alur Pengurusan" bila relevan.

## 9. Functional Requirements
1. Route `warga.letter.index` (`/layanan/cetak-surat-mandiri`) harus menampilkan **form pengajuan** (logika `create()` saat ini), bukan lagi katalog template.
2. Logika katalog template (logika `index()` saat ini) harus tetap ada dan dapat diakses di path baru (lihat §17), dengan nama route baru agar tidak membingungkan (mis. `warga.letter.templates`).
3. Form pengajuan wajib menyertakan field **Nama Lengkap** (belum ada saat ini — field baru).
4. Field NIK dan No. WhatsApp yang sudah ada di form dipertahankan namanya (`form_data[nik]`, `form_data[telepon]`) agar backward compatible dengan data lama, ditambah validasi format yang lebih ketat (lihat §11–12).
5. Sidebar admin wajib punya entri navigasi baru ke `admin.letter-requests.index` (gap kritis §2.5.1).
6. Tabel admin daftar permohonan wajib menampilkan Nama & No. WhatsApp dari `form_data` sebagai fallback ketika `user_id` null (gap kritis §2.5.2).
7. Pencarian admin wajib bisa mencari berdasarkan nama/WA di dalam `form_data`, bukan hanya relasi `user` (gap kritis §2.5.3).
8. Template surat lama tidak boleh dihapus/dipindah secara struktural dari database maupun storage — hanya perubahan pada layer presentasi (routing & UI).

## 10. Form Requirements
Field minimum pada form Pengajuan Surat:
| Field | Key `form_data` | Wajib | Catatan |
|---|---|---|---|
| Nama Lengkap | `nama` | Ya | **Field baru**, belum ada di form saat ini |
| NIK | `nik` | Ya | Sudah ada, pertahankan key `nik` |
| No. WhatsApp Aktif | `telepon` | Ya | Sudah ada; direkomendasikan disamakan validasi & normalisasinya dengan pola `no_whatsapp` di `StoreLaporanRequest` (lihat §12) |
| Jenis Surat | `template_id` (kolom asli, bukan dalam `form_data`) | Ya | Sudah ada — `<select>` dari `LetterTemplate::all()` |
| Keperluan/Keterangan | `keperluan` | Ya | Sudah ada |
| Data tambahan per-jenis-surat | dinamis, `form_data[...]` | Kondisional | Lihat catatan di bawah |

**Catatan data tambahan dinamis:** Struktur database saat ini (`LetterTemplate`) **tidak memiliki kolom skema-form-per-jenis-surat** (mis. field JSON berisi definisi field tambahan seperti "Nama Almarhum" untuk Surat Kematian). Menambahkan field dinamis per jenis surat berarti field baru di tabel `letter_templates` (lihat §16 opsi B) — **[NEEDS VERIFICATION]** apakah dibutuhkan sekarang atau cukup field umum (nama, NIK, WA, keperluan) untuk semua jenis surat pada tahap ini, mengingat prioritas utama adalah menyalurkan kontak WA ke admin, bukan menggantikan proses administratif penuh.

**Rekomendasi tahap ini:** Gunakan field umum saja dulu (5 field di atas) tanpa skema dinamis per template, karena field `requirements` (syarat berkas) yang sudah ada di `LetterTemplate` sudah cukup untuk memberi tahu warga syarat fisik yang perlu dibawa saat legalisasi — selaras dengan Non-Goals §5 (tidak membangun generator surat penuh).

## 11. Validation Requirements
Direkomendasikan membuat `FormRequest` baru (`StoreLetterRequestRequest`), mengikuti pola `StoreLaporanRequest`:
```
template_id : required, exists:letter_templates,id
form_data.nama    : required, string, max:255
form_data.nik     : required, string, regex:/^\d{16}$/   (16 digit angka)
form_data.telepon : required, string, regex sama seperti no_whatsapp di StoreLaporanRequest
form_data.keperluan : required, string, min:10, max:1000
```
`prepareForValidation()` menormalisasi nomor WhatsApp ke format `62xxxxxxxxxx`, identik dengan pola yang sudah terbukti di `StoreLaporanRequest`.

## 12. WhatsApp Number Requirements
- Format input diterima: `08xxxxxxxxxx`, `+62xxxxxxxxxx`, `62xxxxxxxxxx`.
- Disarankan disimpan **ternormalisasi** ke format `62xxxxxxxxxx` di dalam `form_data['telepon']`, agar konsisten dan siap dipakai untuk tautan `wa.me/` di sisi admin (peningkatan UX admin: tombol "Chat WhatsApp" langsung dari halaman detail permohonan — opsional, lihat §29 Future Extension).
- Wajib ditampilkan dengan jelas di:
  - Halaman konfirmasi warga (`show.blade.php`) — sudah tersirat lewat pesan, bisa dipertegas.
  - Tabel & detail admin (`admin/letter-requests/index.blade.php`, `show.blade.php`) — **saat ini tidak ditampilkan sama sekali** untuk guest, wajib diperbaiki.

## 13. Submission Status
Tidak ada perubahan pada enum status (`pending`, `approved`, `rejected`) — sudah sesuai kebutuhan "status pengajuan yang jelas". `getStatusLabelAttribute()` di model `LetterRequest` sudah menerjemahkan ke Bahasa Indonesia dengan baik.

## 14. Admin Workflow
1. **Sidebar:** tambah item navigasi "Permohonan Surat" mengarah ke `admin.letter-requests.index`, ditempatkan di section "Layanan Publik" (sejajar dengan "Template Surat" dan "Pengaduan Warga" yang sudah ada di `layouts/admin.blade.php` baris ~164–199). Disarankan menambahkan badge jumlah pending (pola badge status `w-1.5 h-3.5 rounded-full bg-[#22C55E]` sudah ada sebagai active-indicator, dapat direplikasi/dimodifikasi untuk pending-count).
2. **Tabel index admin:** ganti kolom "Pemohon" agar mengambil dari `form_data['nama']` sebagai fallback ketika `user` null:
   ```php
   $req->user->name ?? data_get($req->form_data, 'nama', '-')
   ```
   Tambahkan kolom baru "No. WhatsApp" mengambil dari `data_get($req->form_data, 'telepon')`.
3. **Pencarian:** perluas query `search` di `Admin\LetterRequestController@index` agar juga mencocokkan `form_data->nama` dan `form_data->telepon` (JSON search, MySQL: `JSON_EXTRACT` atau `whereJsonContains`/`where('form_data->nama', 'like', ...)` yang didukung Laravel).
4. **Halaman detail & edit admin** (`show.blade.php`, `edit.blade.php`) sudah memuat `form_data` — perlu dipastikan field baru `nama` ikut tampil (kemungkinan sudah otomatis tampil bila view melakukan iterasi `form_data`, **[NEEDS VERIFICATION]** — perlu dicek langsung isi `edit.blade.php`/`show.blade.php` saat implementasi untuk memastikan tidak hardcode key lama saja).
5. **Dashboard admin (opsional, rekomendasi):** tambahkan `letter_requests_pending_count` di `Admin\DashboardController` agar admin langsung tahu ada permohonan baru — konsisten dengan `letter_templates_count` yang sudah ada.

## 15. Existing Template Preservation Strategy
- **Tidak ada perubahan** pada model `LetterTemplate`, migration terkait, `Admin\LetterTemplateController`, maupun view `admin/letter-templates/*`. Seluruh CRUD template surat oleh admin **tetap berjalan seperti sekarang**.
- View `public.layanan.surat.index` (katalog + unduh) **tidak dihapus**, hanya:
  1. Dipindah agar diakses lewat route/path baru (bukan lagi `warga.letter.index`).
  2. Teks judul & meta description disesuaikan agar mencerminkan peran barunya sebagai halaman referensi, bukan layanan utama.
- Ketika desa sudah memiliki template resmi final, transisi ke depan cukup: (a) unggah file template resmi lewat admin (fitur sudah ada, tidak perlu dibangun ulang), (b) opsional promosikan kembali tautan "Template & Format Surat" menjadi lebih menonjol di halaman Pengajuan Surat — perubahan presentasi murni, tanpa perlu perubahan struktur data.

## 16. Database Changes

**Prinsip: tidak membuat tabel baru.** Tabel `letter_requests` dan `letter_templates` yang sudah ada **cukup untuk kebutuhan minimum** (§10) tanpa perubahan skema, karena `form_data` bersifat JSON bebas — field baru "Nama Lengkap" cukup ditambahkan sebagai key baru (`form_data['nama']`) tanpa migration.

**Opsi A (Direkomendasikan untuk tahap ini): Tanpa migration baru.**
- Field `nama` disimpan sebagai key baru di `form_data` (JSON), sama seperti `nik` dan `telepon` saat ini.
- Kelemahan: pencarian/filter by nama & WA di admin sedikit lebih kompleks secara query (JSON path query), tapi Laravel/MySQL sudah cukup mendukung ini di skala data desa.

**Opsi B (Opsional, jika ke depan dibutuhkan pencarian/reporting lebih berat atau field dinamis per-jenis-surat):**
Jika di kemudian hari performa pencarian atau kebutuhan reporting meningkat, dapat dipertimbangkan migration tambahan (bukan tabel baru, melainkan kolom baru di tabel yang sudah ada):
```
Table: letter_requests (ALTER, tambah kolom)
- nama         : string, nullable, after user_id   -- duplikasi ter-index dari form_data.nama untuk performa search
- no_whatsapp  : string, nullable, after nama       -- duplikasi ter-index dari form_data.telepon
Index tambahan: index('nama'), index('no_whatsapp')
Alasan: mempercepat query admin (search & filter) tanpa JSON path lookup, konsisten dengan pola kolom eksplisit yang dipakai tabel `laporans`.
Status: nullable (agar backward compatible dengan data lama yang hanya punya form_data)
Relasi: tidak ada relasi baru
Timestamps: tidak berubah (sudah ada created_at/updated_at)
```
**[NEEDS VERIFICATION]** — Opsi B tidak wajib untuk rilis awal fitur ini; direkomendasikan mulai dari Opsi A, dan hanya naik ke Opsi B bila volume permohonan surat terbukti besar atau admin mengeluhkan pencarian lambat.

Untuk `letter_templates`: **tidak ada perubahan skema** diperlukan.

## 17. Route Changes
| Route lama | Perubahan |
|---|---|
| `GET /layanan/cetak-surat-mandiri` → `warga.letter.index` (saat ini: katalog) | **Diubah perannya** menjadi form pengajuan (memakai logika `create()` saat ini) |
| `GET /layanan/surat/buat` → `warga.letter.create` | **Dipertimbangkan redirect** ke `warga.letter.index` yang baru (karena keduanya sekarang sama), atau dipertahankan sebagai alias — **[NEEDS VERIFICATION]** keputusan tim: apakah salah satu jadi redirect permanen demi menghindari duplikasi URL untuk halaman yang identik |
| — | **Route baru** dibutuhkan untuk katalog template yang dipindah, misal: `GET /layanan/surat/template` → `warga.letter.templates` (nama disesuaikan tim), memakai logika `index()` saat ini |
| `GET /layanan/surat/template/{letterTemplate}/download` → `warga.letter.download` | **Tidak berubah** |
| `POST /layanan/surat` → `warga.letter.store` | **Tidak berubah struktur**, hanya validasi diperluas (§11) |
| `GET /layanan/surat/{letterRequest}` → `warga.letter.show` | **Tidak berubah** |
| `Route::redirect('/layanan/surat', '/layanan/cetak-surat-mandiri')` | Perlu ditinjau ulang — saat ini redirect ke katalog, ke depan otomatis akan redirect ke form pengajuan (perilaku baru mengikuti perubahan `warga.letter.index`), **perlu dicek apakah ini sudah sesuai ekspektasi atau perlu redirect terpisah ke halaman katalog baru** |
| Route admin (`admin.letter-templates.*`, `admin.letter-requests.*`) | **Tidak berubah** |

## 18. Controller/Service Changes
- `App\Http\Controllers\Public\LetterRequestController`:
  - Method `index()` dan `create()` **bertukar tanggung jawab** secara route-mapping (bukan berarti kode method harus ditulis ulang total — cukup pemetaan ulang di `routes/web.php`, dengan penyesuaian nama view yang dipanggil masing-masing method agar konsisten dengan path/breadcrumb baru).
  - Method `store()`: validasi diganti memakai `FormRequest` baru `StoreLetterRequestRequest` (§11) alih-alih inline `$request->validate()` saat ini, mengikuti pola `StoreLaporanRequest` yang sudah established di codebase.
- `App\Http\Controllers\Admin\LetterRequestController`:
  - Method `index()`: perluas kondisi `search` agar mencakup `form_data` (§14 poin 3).
  - Tidak ada perubahan pada `edit()`, `update()`, `show()` secara struktural — hanya perlu memastikan view menampilkan field baru (`nama`) dengan benar.
- `App\Http\Controllers\Admin\LetterTemplateController`: **tidak berubah sama sekali.**

## 19. UI/UX Requirements
- Semua halaman baru/diubah **wajib** memakai:
  - Warna aksen `#0A3D29` (forest.deep) untuk elemen aksi primer di sisi publik — bukan warna baru.
  - `font-serif` (Merriweather) untuk judul (`h1`), `font-sans`/default untuk body.
  - Card pattern: `bg-white rounded-xl border border-slate-200/90 shadow-xs p-6 sm:p-8`.
  - Komponen form: label `text-[13px] font-semibold text-slate-800 mb-1.5`, input `px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0A3D29]/20 focus:border-[#0A3D29] text-sm bg-slate-50/40`.
  - `<x-breadcrumbs>` untuk navigasi jejak, `<x-file-picker>` bila ada upload (tidak dibutuhkan di form ini kecuali admin mengunggah hasil surat).
- **Dilarang** menambahkan gradient, ikon dekoratif berlebihan, atau pola "SaaS dashboard generik" — form harus terasa formal dan resmi, sejalan dengan instruksi awal.
- Tautan sekunder ke "Template & Format Surat" ditampilkan **kecil/understated** — contoh pola: link teks dengan ikon minor, bukan tombol/card besar, ditempatkan dekat header halaman (mirip posisi tombol "Alur Pengurusan" saat ini, namun secara bobot visual dikurangi).

## 20. Responsive Requirements
- Mengikuti pola sudah baku di seluruh situs: `max-w-3xl mx-auto px-4 sm:px-6 lg:px-8` untuk halaman form single-column (sudah dipakai `create.blade.php` & `pengaduan/create.blade.php`).
- Dropdown "Jenis Surat" mengikuti pola dual-mode yang sudah terbukti di form Pengaduan: `<select>` native di mobile (`sm:hidden`), dropdown custom Alpine di desktop (`hidden sm:block`) — **opsional**, boleh tetap pakai `<select>` native biasa di semua breakpoint bila tim ingin menyederhanakan (kedua pola sudah ada presedennya di codebase, `create.blade.php` surat lama memakai `<select>` native saja).
- Tabel admin permohonan: pastikan kolom baru (No. WhatsApp) tidak merusak `overflow-x-auto` yang sudah ada di `admin/letter-requests/index.blade.php`.

## 21. Security & Privacy Considerations
- **Rate limiting** sudah ada (`throttle:5,1` pada route `store`) — dipertahankan, cukup memadai untuk mencegah spam form.
- **IDOR protection** pada `show()` sudah ada (cek `user_id` milik sendiri untuk user login) — dipertahankan; untuk pemohon guest, akses tetap terbuka lewat URL/tiket (perilaku sudah ada, tidak diubah — **[NEEDS VERIFICATION]** apakah ini risiko yang dapat diterima, karena siapapun yang tahu URL/ID request guest bisa melihat status; ini adalah desain existing yang sudah ada di sistem Pengaduan juga, bukan regresi baru dari fitur ini).
- NIK adalah data pribadi sensitif — sudah tersimpan sebagaimana adanya di `form_data` (tidak terenkripsi khusus di level kolom, konsisten dengan penanganan `nik` yang sudah ada saat ini). **[NEEDS VERIFICATION]** — tidak dalam scope PRD ini untuk menambah enkripsi kolom, karena bukan bagian dari permintaan awal, namun dicatat sebagai potensi hardening masa depan.
- CSRF protection: sudah otomatis via `@csrf` di semua form Blade Laravel — tidak perlu perubahan.

## 22. Error Handling
- Validasi gagal: pola sudah baku di seluruh situs — pesan error per-field memakai `@error('field')` dengan style `text-xs text-rose-600 font-medium mt-1`, mengikuti pola `pengaduan/create.blade.php` (bukan pola lama `text-red-600` di `create.blade.php` surat — **selaraskan ke pola rose yang lebih baru**).
- Kegagalan submit (mis. `template_id` tidak valid): sudah tertangani oleh validasi `exists:letter_templates,id`.
- Halaman detail tiket untuk ID yang tidak ditemukan: Laravel route-model-binding otomatis mengembalikan 404 (perilaku default, tidak perlu perubahan).

## 23. Empty State
- Bila `LetterTemplate::all()` kosong (belum ada jenis surat terdaftar sama sekali), dropdown "Jenis Surat" di form pengajuan akan kosong — perlu ditambahkan state kosong yang jelas, misal opsi disabled "Belum ada jenis surat tersedia, hubungi admin desa" agar warga tidak submit form kosong/error. **(Belum ditangani di kode saat ini — perlu ditambahkan.)**
- Halaman "Template & Format Surat" sudah punya empty state untuk hasil pencarian kosong (`@if(count($templates) === 0)` di `index.blade.php` baris 311–323) — dipertahankan.

## 24. Success State
- Sudah ada: pesan flash sukses di `store()` menyebutkan nomor tiket, redirect ke halaman `show` dengan progress tracker 3 langkah (Diajukan → Verifikasi Admin → Selesai/Terbit) — dipertahankan, hanya disarankan menambahkan penegasan "Admin akan menghubungi Anda ke nomor WhatsApp [no_wa]" pada pesan flash, meniru pola pesan sukses di `ComplaintController@store`.

## 25. Backward Compatibility
- Data `LetterRequest` lama (bila ada, dari sebelum field `nama` ditambahkan) akan memiliki `form_data` **tanpa key `nama`** — tampilan admin harus menangani ini secara graceful (`data_get($form_data, 'nama', '-')`, bukan asumsi key selalu ada).
- Redirect lama (`/layanan/surat` → `/layanan/cetak-surat-mandiri`) tetap harus berfungsi, hanya tujuan akhirnya kini menampilkan konten berbeda (form, bukan katalog) — ini **perubahan perilaku yang disengaja**, bukan bug, namun perlu dikomunikasikan sebagai bagian dari rilis.
- Semua link eksternal/internal yang sudah menunjuk ke `warga.letter.index` (ditemukan di: `shortcuts.blade.php` 2×, `public-footer.blade.php` 7×, `public-header.blade.php` 2×) **otomatis mengarah ke halaman baru** tanpa perlu diubah satu-satu, karena tetap memakai nama route yang sama — **kecuali** bila tim memilih mengganti nama route `warga.letter.index` itu sendiri, yang dalam kasus itu **seluruh 11 titik referensi ini wajib diperbarui**.

## 26. Technical Constraints
- Laravel route-model binding dipakai konsisten (`{letterTemplate}`, `{letterRequest}`) — pertahankan pola ini untuk konsistensi kode.
- `form_data` adalah kolom `json` cast `array` — pencarian/filter berbasis isinya bergantung pada dukungan JSON query driver database (MySQL mendukung penuh; **[NEEDS VERIFICATION]** perilaku sama di SQLite yang dipakai untuk testing, lihat `phpunit.xml`/`tests/Feature`).
- Tidak ada job queue/notifikasi WhatsApp otomatis di codebase saat ini (`config/queue.php` ada tapi tidak ditemukan integrasi WhatsApp API) — kontak ke pemohon **sepenuhnya manual oleh admin**, sesuai kondisi saat ini, tidak dalam scope untuk diotomasi di PRD ini.

## 27. Acceptance Criteria
1. Mengakses `/layanan/cetak-surat-mandiri` menampilkan **form Pengajuan Surat** (bukan lagi katalog), dengan field: Nama Lengkap, NIK, No. WhatsApp, Jenis Surat, Keperluan.
2. Submit form yang valid menghasilkan `LetterRequest` baru dengan `form_data` memuat kelima field di atas, nomor tiket ter-generate, dan warga diarahkan ke halaman status.
3. Ada tautan sekunder yang jelas namun tidak mencolok menuju halaman "Template & Format Surat" yang menampilkan seluruh template yang sudah ada, tanpa ada data/file yang hilang.
4. Admin dapat mengakses menu "Permohonan Surat" langsung dari sidebar tanpa mengetik URL manual.
5. Tabel admin permohonan surat menampilkan Nama & No. WhatsApp untuk **semua** entri, termasuk pengajuan tanpa akun (guest).
6. Pencarian admin oleh nama/WA berhasil menemukan hasil untuk entri guest.
7. Seluruh data & file template surat (`letter_templates`, storage `letter_templates/`) tetap utuh dan dapat dikelola CRUD-nya oleh admin seperti sebelumnya.
8. Tidak ada fitur lain (Pengaduan, Berita, Galeri, PPKO, dsb) yang mengalami perubahan perilaku.
9. Seluruh halaman baru lolos pemeriksaan visual: konsisten dengan warna, font, dan pola card/form yang sudah ada di situs (dibandingkan terhadap `pengaduan/create.blade.php` sebagai acuan).

## 28. Risks
| Risiko | Dampak | Mitigasi |
|---|---|---|
| Mengganti isi route `warga.letter.index` mengejutkan warga yang sudah terbiasa dengan tampilan katalog lama | Sedang | Komunikasikan perubahan di halaman (banner sementara/pengumuman), pastikan tautan "Template & Format Surat" mudah ditemukan |
| Pencarian admin berbasis JSON (`form_data`) lebih lambat dibanding kolom biasa pada skala data besar | Rendah (skala desa) | Pantau; migrasi ke Opsi B (§16) bila diperlukan di masa depan |
| Duplikasi URL antara `warga.letter.index` (baru) dan `warga.letter.create` (lama) yang kini identik fungsinya | Rendah | Putuskan salah satu jadi redirect permanen (lihat §17 [NEEDS VERIFICATION]) |
| Admin belum terbiasa dengan menu baru "Permohonan Surat" di sidebar | Rendah | Cukup jelas secara label & ikon, konsisten dengan pola menu lain |
| Field NIK sensitif tersimpan di JSON tanpa enkripsi khusus | Rendah–Sedang (kepatuhan data) | Sudah merupakan pola existing (bukan regresi baru); dicatat sebagai potensi hardening masa depan, di luar scope PRD ini |

## 29. Future Extension
- Ketika template resmi final sudah tersedia: cukup unggah ulang file via `Admin\LetterTemplateController` yang sudah ada (tanpa perlu membangun ulang), lalu opsional naikkan visibilitas tautan "Template & Format Surat" menjadi lebih menonjol di halaman Pengajuan Surat, atau bahkan mengembalikan katalog sebagai bagian dari flow utama (mis. pilih template dulu → auto-attach ke form pengajuan).
- Tombol "Chat WhatsApp Langsung" (`https://wa.me/62xxxxxxxxxx`) di halaman detail admin, memanfaatkan nomor yang sudah dinormalisasi (§12) — peningkatan kecil yang berdampak besar bagi kecepatan tindak lanjut admin.
- Dashboard admin menampilkan jumlah permohonan pending sebagai notifikasi (§14 poin 5).
- Jika ke depan dibutuhkan field berbeda per jenis surat (mis. field khusus untuk Surat Kematian vs Surat Usaha), pertimbangkan menambah kolom `extra_fields_schema` (JSON) di `letter_templates` untuk mendefinisikan field dinamis per template — bukan kebutuhan saat ini (lihat §10 catatan).

---

## Lampiran: Daftar File Relevan yang Ditemukan (Referensi Implementasi)

**Routing:** `routes/web.php`

**Controller Publik:**
- `app/Http/Controllers/Public/LetterRequestController.php`
- `app/Http/Controllers/Public/ComplaintController.php` (pola acuan)

**Controller Admin:**
- `app/Http/Controllers/Admin/LetterRequestController.php`
- `app/Http/Controllers/Admin/LetterTemplateController.php`

**Model:** `app/Models/LetterRequest.php`, `app/Models/LetterTemplate.php`, `app/Models/Laporan.php` (pola acuan), `app/Models/User.php`

**Form Request (pola acuan):** `app/Http/Requests/StoreLaporanRequest.php`

**Migration:**
- `database/migrations/2026_09_02_000003_create_letter_templates_table.php`
- `database/migrations/2026_09_02_000004_create_letter_requests_table.php`
- `database/migrations/2026_09_03_000001_make_user_id_nullable_in_services_tables.php`
- `database/migrations/2026_09_09_144215_add_file_and_requirements_to_letter_templates_table.php`
- `database/migrations/2026_09_09_151500_make_code_nullable_in_letter_templates_table.php`
- `database/migrations/2026_09_15_000002_refactor_complaints_to_laporans.php` (pola acuan)

**View Publik:**
- `resources/views/public/layanan/surat/index.blade.php` (katalog — dipindah)
- `resources/views/public/layanan/surat/create.blade.php` (form — dipromosikan)
- `resources/views/public/layanan/surat/show.blade.php` (status tiket)
- `resources/views/public/layanan/pengaduan/create.blade.php` (pola acuan gaya)

**View Admin:**
- `resources/views/admin/letter-requests/index.blade.php`, `edit.blade.php`, `show.blade.php`
- `resources/views/admin/letter-templates/index.blade.php`, `create.blade.php`, `edit.blade.php`
- `resources/views/admin/complaints/index.blade.php` (pola acuan gaya admin terbaru)

**Layout & Komponen:**
- `resources/views/layouts/public.blade.php`, `resources/views/layouts/admin.blade.php`
- `resources/views/layouts/partials/public-header.blade.php`, `public-footer.blade.php`
- `resources/views/public/home/sections/shortcuts.blade.php`
- `resources/views/components/breadcrumbs.blade.php`, `file-picker.blade.php`

**Design Tokens:** `tailwind.config.js`
