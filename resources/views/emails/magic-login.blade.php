@if($status)<p>Ada pembaruan pada laporan Anda. Status terbaru: {{ str($status)->replace('_', ' ')->title() }}.</p>@endif
@if($excerpt)<p>Ringkasan tanggapan: {{ $excerpt }}</p>@endif
<p><a href="{{ route('pelapor.verify', ['token' => $token]) }}">Lihat laporan saya</a></p>
<p>Tautan ini hanya berlaku sementara dan hanya dapat digunakan sekali.</p>
