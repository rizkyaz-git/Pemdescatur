<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BmkgWeatherService
{
    public const LOCATION_NAME = 'Desa Catur';
    public const LOCATION_DISTRICT = 'Sambi';
    public const LOCATION_REGENCY = 'Boyolali';
    public const LOCATION_PROVINCE = 'Jawa Tengah';
    public const LOCATION_DETAIL = 'Sambi, Boyolali';
    public const ADM4 = '3309102006';
    public const ADM4_DOTTED = '33.09.10.2006';
    public const CACHE_KEY = 'bmkg_weather_catur_v2';
    public const CACHE_TTL_SECONDS = 1800; // 30 menit

    /**
     * Ambil data cuaca lengkap Desa Catur dari BMKG dengan caching.
     */
    public function getCurrentWeather(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () {
            return $this->fetchFromBmkg();
        });
    }

    /**
     * Request ke API resmi BMKG dengan auto-fallback.
     */
    protected function fetchFromBmkg(): array
    {
        $fallback = [
            'available' => false,
            'location' => self::LOCATION_NAME,
            'sub_location' => self::LOCATION_DETAIL,
            'full_location' => self::LOCATION_NAME . ', ' . self::LOCATION_DETAIL . ', ' . self::LOCATION_PROVINCE,
            'temperature' => null,
            'condition' => null,
            'feels_like' => null,
            'humidity' => null,
            'wind_speed' => null,
            'precipitation' => null,
            'icon' => null,
            'current' => null,
            'forecast' => [],
            'metrics' => [
                'humidity' => null,
                'wind_speed' => null,
                'precipitation' => null,
            ],
            'theme' => [
                'type' => 'cerah',
                'gradient' => 'from-[#0B2545] via-[#134074] to-[#1D4E89]',
            ],
            'updated_at' => null,
            'message' => 'Informasi cuaca sementara tidak tersedia.',
            'source' => 'BMKG',
            'source_url' => 'https://data.bmkg.go.id/prakiraan-cuaca/',
        ];

        try {
            // Request menggunakan parameter resmi adm4=3309102006
            $response = Http::timeout(4)
                ->acceptJson()
                ->get('https://api.bmkg.go.id/publik/prakiraan-cuaca', [
                    'adm4' => self::ADM4,
                ]);

            // Jika format tanpa titik merespons 404 pada API BMKG, fallback ke 33.09.10.2006
            if (!$response->successful()) {
                $response = Http::timeout(4)
                    ->acceptJson()
                    ->get('https://api.bmkg.go.id/publik/prakiraan-cuaca', [
                        'adm4' => self::ADM4_DOTTED,
                    ]);
            }

            if (!$response->successful()) {
                Log::warning('BMKG Weather API non-success response: ' . $response->status());
                return $fallback;
            }

            $json = $response->json();
            $data = $json['data'][0] ?? null;

            if (!$data || empty($data['cuaca'])) {
                return $fallback;
            }

            return $this->transformWeatherData($data);
        } catch (\Throwable $e) {
            Log::error('BMKG Weather fetch error: ' . $e->getMessage());
            return $fallback;
        }
    }

    /**
     * Transformasi data JSON BMKG menjadi struktur yang informatif, rapi, dan siap saji.
     */
    protected function transformWeatherData(array $data): array
    {
        $cuacaBlocks = $data['cuaca'] ?? [];
        $allEntries = [];

        foreach ($cuacaBlocks as $block) {
            if (is_array($block)) {
                foreach ($block as $entry) {
                    if (is_array($entry) && isset($entry['local_datetime'])) {
                        $allEntries[] = $entry;
                    }
                }
            }
        }

        if (empty($allEntries)) {
            return [
                'available' => false,
                'location' => self::LOCATION_NAME,
                'sub_location' => self::LOCATION_DETAIL,
                'message' => 'Data prakiraan cuaca tidak ditemukan.',
                'source' => 'BMKG',
                'source_url' => 'https://data.bmkg.go.id/prakiraan-cuaca/',
            ];
        }

        // Tentukan entri cuaca yang paling dekat dengan waktu saat ini (WIB)
        $now = Carbon::now('Asia/Jakarta');
        $currentEntry = null;
        $minDiff = PHP_INT_MAX;
        $currentIndex = 0;

        foreach ($allEntries as $idx => $entry) {
            $entryTime = Carbon::parse($entry['local_datetime'], 'Asia/Jakarta');
            $diff = abs($now->diffInMinutes($entryTime, false));

            if ($diff < $minDiff) {
                $minDiff = $diff;
                $currentEntry = $entry;
                $currentIndex = $idx;
            }
        }

        if (!$currentEntry) {
            $currentEntry = $allEntries[0];
            $currentIndex = 0;
        }

        // Ekstraksi prakiraan 5-6 time slots harian yang relevan
        $forecastSlots = [];
        // Ambil mulai dari slot terdekat atau slot hari ini
        $startIndex = max(0, $currentIndex);
        $slice = array_slice($allEntries, $startIndex, 6);

        // Jika slot setelah sekarang kurang dari 5, ambil mundur sedikit dari hari yang sama
        if (count($slice) < 5 && $startIndex > 0) {
            $needed = 5 - count($slice);
            $backStart = max(0, $startIndex - $needed);
            $slice = array_slice($allEntries, $backStart, 6);
        }

        foreach ($slice as $entry) {
            $slotTime = Carbon::parse($entry['local_datetime'], 'Asia/Jakarta');
            $isCurrent = ($entry['local_datetime'] === $currentEntry['local_datetime']);

            $forecastSlots[] = [
                'time' => $slotTime->format('H:i'),
                'hour' => $slotTime->format('H'),
                'temperature' => isset($entry['t']) ? round($entry['t']) : 0,
                'condition' => $entry['weather_desc'] ?? 'Cerah',
                'icon' => $entry['image'] ?? null,
                'is_current' => $isCurrent,
                'precipitation' => isset($entry['tp']) ? $entry['tp'] : 0,
                'humidity' => $entry['hu'] ?? null,
            ];
        }

        $temperature = isset($currentEntry['t']) ? round($currentEntry['t']) : null;
        $humidity = $currentEntry['hu'] ?? null;
        $windSpeed = isset($currentEntry['ws']) ? round($currentEntry['ws'], 1) : null;
        $precipitation = isset($currentEntry['tp']) ? round($currentEntry['tp'], 1) : 0;
        $condition = $currentEntry['weather_desc'] ?? 'Cerah';

        // Hitung Feels-Like Temperature (Apparent Temperature formula standar meteorologi)
        $feelsLike = $this->calculateFeelsLike($temperature, $humidity, $windSpeed);

        // Tentukan tema visual gradien berdasarkan kondisi cuaca & waktu (siang/malam)
        $theme = $this->resolveWeatherTheme($condition, $currentEntry['local_datetime'] ?? null);

        return [
            'available' => true,
            'location' => self::LOCATION_NAME,
            'sub_location' => self::LOCATION_DETAIL,
            'full_location' => self::LOCATION_NAME . ', ' . self::LOCATION_DETAIL . ', ' . self::LOCATION_PROVINCE,
            'temperature' => $temperature,
            'condition' => $condition,
            'feels_like' => $feelsLike,
            'humidity' => $humidity,
            'wind_speed' => $windSpeed,
            'precipitation' => $precipitation,
            'icon' => $currentEntry['image'] ?? null,
            'current' => [
                'temperature' => $temperature,
                'condition' => $condition,
                'feels_like' => $feelsLike,
                'icon' => $currentEntry['image'] ?? null,
                'time' => Carbon::parse($currentEntry['local_datetime'], 'Asia/Jakarta')->format('H:i'),
            ],
            'forecast' => $forecastSlots,
            'metrics' => [
                'humidity' => $humidity,
                'wind_speed' => $windSpeed,
                'precipitation' => $precipitation,
            ],
            'theme' => $theme,
            'updated_at' => Carbon::parse($currentEntry['local_datetime'], 'Asia/Jakarta')->format('H:i') . ' WIB',
            'message' => null,
            'source' => 'BMKG',
            'source_url' => 'https://data.bmkg.go.id/prakiraan-cuaca/',
        ];
    }

    /**
     * Hitung suhu semu (Feels-Like) menggunakan Australian Apparent Temperature Formula.
     */
    protected function calculateFeelsLike(?float $temp, ?int $humidity, ?float $windSpeed): ?int
    {
        if ($temp === null || $humidity === null) {
            return $temp ? round($temp) : null;
        }

        $ws = $windSpeed ?? 0;
        // Vapor pressure in hPa
        $e = ($humidity / 100) * 6.105 * exp((17.27 * $temp) / (237.7 + $temp));
        $at = $temp + (0.33 * $e) - (0.70 * ($ws / 3.6)) - 4.00;

        return (int) round($at);
    }

    /**
     * Resolusi tema warna latar belakang kartu berdasarkan kondisi cuaca dan waktu siang/malam.
     */
    protected function resolveWeatherTheme(string $condition, ?string $timeStr = null): array
    {
        $hour = (int) Carbon::now('Asia/Jakarta')->format('H');
        if ($timeStr) {
            try {
                $hour = (int) Carbon::parse($timeStr, 'Asia/Jakarta')->format('H');
            } catch (\Throwable $e) {
                // fallback to current hour
            }
        }

        $isDay = ($hour >= 6 && $hour < 18);
        $lower = strtolower($condition);

        // 1. Kondisi Petir (Siang / Malam)
        if (str_contains($lower, 'petir')) {
            return [
                'type' => 'petir',
                'is_day' => $isDay,
                'gradient' => 'from-[#1E1B4B] via-[#141233] to-[#0A091A]',
                'accent' => 'text-purple-300',
                'border' => 'border-purple-400/20',
                'glow' => 'bg-purple-400/25',
            ];
        }

        // 2. Kondisi Hujan / Badai / Gerimis
        if (str_contains($lower, 'hujan') || str_contains($lower, 'gerimis') || str_contains($lower, 'badai')) {
            return [
                'type' => 'hujan',
                'is_day' => $isDay,
                'gradient' => $isDay 
                    ? 'from-[#1E3A5F] via-[#142943] to-[#0A1624]' 
                    : 'from-[#0A1118] via-[#060B10] to-[#020406]',
                'accent' => 'text-cyan-300',
                'border' => 'border-cyan-400/20',
                'glow' => 'bg-cyan-400/20',
            ];
        }

        // 3. Kondisi Berawan / Kabut / Mendung
        if (str_contains($lower, 'berawan') || str_contains($lower, 'kabut') || str_contains($lower, 'mendung')) {
            return [
                'type' => 'berawan',
                'is_day' => $isDay,
                'gradient' => $isDay 
                    ? 'from-[#334E68] via-[#243B53] to-[#102A43]' 
                    : 'from-[#0B1320] via-[#080E17] to-[#03060B]',
                'accent' => $isDay ? 'text-sky-200' : 'text-slate-300',
                'border' => 'border-sky-300/20',
                'glow' => $isDay ? 'bg-sky-300/20' : 'bg-slate-300/15',
            ];
        }

        // 4. Default: Cerah / Cerah Berawan (Siang vs Malam)
        return [
            'type' => 'cerah',
            'is_day' => $isDay,
            'gradient' => $isDay 
                ? 'from-[#2563EB] via-[#1E40AF] to-[#172554]'  // Biru cerah dinamis khas langit siang
                : 'from-[#0F172A] via-[#0B1120] to-[#020617]', // Midnight slate premium malam bertabur bintang
            'accent' => $isDay ? 'text-amber-300' : 'text-indigo-200',
            'border' => $isDay ? 'border-amber-300/20' : 'border-indigo-300/20',
            'glow' => $isDay ? 'bg-sky-400/25' : 'bg-indigo-400/20',
        ];
    }
}
