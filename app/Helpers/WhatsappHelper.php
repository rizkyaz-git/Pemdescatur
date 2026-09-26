<?php

namespace App\Helpers;

/**
 * Pembuatan tautan WhatsApp yang konsisten untuk seluruh panel admin.
 *
 * Satu-satunya sumber normalisasi nomor WhatsApp pada aplikasi ini:
 * - membuang spasi, tanda "+", tanda "-" dan karakter non-digit lain;
 * - mengubah format lokal "08xxxxxxxxxx" menjadi internasional "628xxxxxxxxxx";
 * - tidak menambahkan prefiks "62" dua kali bila nomor sudah internasional.
 */
class WhatsappHelper
{
    /**
     * Kode negara Indonesia untuk format internasional wa.me.
     */
    public const COUNTRY_CODE = '62';

    /**
     * URL resmi wa.me: membuka WhatsApp Web di desktop dan aplikasi WhatsApp di mobile.
     */
    public const BASE_URL = 'https://wa.me/';

    /**
     * Normalisasi nomor WhatsApp menjadi format internasional tanpa karakter lain.
     * Mengembalikan null bila tidak ada nomor yang bisa dipakai.
     */
    public static function normalize(mixed $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = self::COUNTRY_CODE.substr($digits, 1);
        }

        return $digits;
    }

    /**
     * Bangun URL wa.me dari nomor asli. Mengembalikan null bila nomor tidak valid.
     */
    public static function link(mixed $phone): ?string
    {
        $number = self::normalize($phone);

        return $number === null ? null : self::BASE_URL.$number;
    }
}
