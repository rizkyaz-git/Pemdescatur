Kamu adalah AI coding agent yang bekerja di dalam repository Laravel "Pemdescatur" (website Pemerintah Desa Catur).

Tugasmu adalah mengimplementasikan perubahan pada fitur "Layanan Cetak Surat Mandiri" menjadi "Pengajuan Surat", dengan mengikuti **DUA dokumen berikut sebagai satu-satunya sumber kebenaran**:

1. `PRD.md` — dokumen requirement lengkap hasil audit project. Berisi konteks, keputusan desain, dan alasan di balik setiap perubahan. WAJIB dibaca penuh sebelum menulis kode apapun.
2. `todo.md` — daftar task konkret, berurutan per fase, yang menerjemahkan PRD.md menjadi langkah eksekusi.

## Cara Kerja

1. **Baca `PRD.md` secara utuh terlebih dahulu.** Jangan mulai dari `todo.md` saja — banyak keputusan di todo.md hanya masuk akal jika kamu memahami konteks dan alasannya dari PRD (misalnya kenapa fitur pengajuan surat dianggap "sudah ada tapi orphaned", atau kenapa pola form Pengaduan Warga dijadikan acuan gaya).
2. **Kerjakan `todo.md` secara berurutan, fase demi fase (Fase 0 → Fase 11).** Jangan melompat ke fase berikutnya sebelum fase sebelumnya selesai dan item checklist-nya tercentang secara nyata (bukan diasumsikan selesai).
3. **Setiap kali sebuah checklist item mengharuskanmu membaca/mengecek file terlebih dahulu ("buka & baca", "verifikasi", "cek isi"), benar-benar buka file tersebut dan baca isinya — jangan berasumsi berdasarkan nama file atau isi PRD saja.** PRD ditulis berdasarkan audit pada satu titik waktu; kode di repository adalah kebenaran final.
4. **Ikuti pola/style yang sudah ada di codebase, bukan membuat pola baru.** Di beberapa langkah, PRD & todo secara eksplisit menunjuk file tertentu sebagai "pola acuan" (contoh: `resources/views/public/layanan/pengaduan/create.blade.php` dan `app/Http/Requests/StoreLaporanRequest.php`). Buka file acuan tersebut, pahami strukturnya, lalu adaptasi — jangan menulis dari nol dengan gaya berbeda.
5. **Patuhi bagian "Batasan Keras" di akhir `todo.md` secara mutlak.** Ini bukan saran, melainkan batas yang tidak boleh dilanggar apapun alasannya.
6. **Untuk setiap item yang ditandai `[NEEDS VERIFICATION]` di PRD atau opsional di todo.md**, gunakan keputusan default yang sudah ditetapkan di Fase 0 todo.md. Jangan berhenti untuk bertanya kecuali kamu menemukan kondisi di kode yang benar-benar bertentangan dengan asumsi PRD (lihat poin 7).
7. **Jika kamu menemukan fakta di kode yang bertentangan dengan asumsi/temuan di PRD** (misalnya nama route berbeda, struktur field berbeda, file tidak ditemukan di path yang disebutkan) — **STOP, jangan menebak atau memperbaiki sendiri secara diam-diam.** Laporkan temuan tersebut secara eksplisit ke pengguna sebelum melanjutkan ke langkah yang bergantung pada asumsi tersebut.
8. **Jangan melakukan perubahan di luar scope yang disebutkan**, walau kamu melihat "kesempatan" untuk memperbaiki hal lain (contoh: bug `$tpl->title ?? $tpl->name` yang sudah dicatat di PRD sebagai referensi mati — biarkan, jangan diperbaiki kecuali file yang sama memang sedang kamu sentuh untuk alasan lain dan perbaikannya trivial serta tidak berisiko).
9. **Setelah menyelesaikan seluruh fase**, kerjakan Fase 11 (Ringkasan & Serah Terima) secara tertulis — jangan hanya diam setelah kode selesai. Tulis ringkasan singkat yang mencakup: file yang diubah/ditambah, keputusan yang diambil untuk tiap `[NEEDS VERIFICATION]`, dan bagian yang sengaja dilewati (Fase 9 / dashboard, kecuali diminta eksplisit).
10. **Jangan commit langsung ke branch utama/production dan jangan push ke remote tanpa diminta.** Kerjakan di branch terpisah (lihat Fase 0), dan serahkan hasil akhir sebagai diff/pull request untuk direview manusia.

## Definisi "Selesai"

Sebuah fase dianggap selesai hanya jika:
- Semua checklist item di fase tersebut sudah dikerjakan (atau secara eksplisit dilewati dengan alasan yang dicatat, sesuai instruksi di item tersebut).
- Tidak ada regresi pada fitur lain — jika ragu, jalankan langkah verifikasi terkait di Fase 10 sesegera mungkin, jangan tunggu sampai akhir.
- Perubahan visual (jika ada) sudah dibandingkan langsung dengan file acuan gaya yang disebutkan di PRD/todo, bukan hanya "terlihat mirip" menurut ingatan.

Jika kamu tidak yakin apakah suatu langkah sudah benar-benar selesai, verifikasi ulang dengan membaca file yang relevan sebelum melanjutkan — jangan mengandalkan asumsi dari langkah sebelumnya.

Mulai dengan membaca `PRD.md`, lalu `todo.md`, lalu mulai eksekusi dari Fase 0.
