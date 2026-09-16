<?php

namespace App\Helpers;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlPurifierHelper
{
    /**
     * Membersihkan HTML dari tag/atribut berbahaya (XSS prevention).
     * Digunakan untuk konten yang berasal dari rich text editor (Quill, dll).
     *
     * Tag yang diizinkan: h1–h6, p, ul, ol, li, blockquote, a, strong, em,
     *   u, s, br, img, table, thead, tbody, tr, td, th, hr, code, pre, span, div.
     * Atribut berbahaya (on*, javascript:) diblokir otomatis.
     */
    public static function clean(?string $html): string
    {
        if (is_null($html) || trim($html) === '') {
            return '';
        }

        // Graceful fallback jika package ezyang/htmlpurifier belum terpasang di vendor (misal di server hosting belum composer install)
        if (!class_exists(\HTMLPurifier_Config::class) || !class_exists(\HTMLPurifier::class)) {
            return self::fallbackClean($html);
        }

        try {
            $config = HTMLPurifier_Config::createDefault();

            // Izinkan elemen HTML yang umum dipakai oleh Quill editor
            $config->set('HTML.Allowed',
                'h1,h2,h3,h4,h5,h6,p[style],ul,ol,li,blockquote,'
                . 'a[href|target|rel],strong,b,em,i,u,s,del,br,'
                . 'img[src|alt|width|height|class|style],'
                . 'table,thead,tbody,tr,td[colspan|rowspan|style],th[colspan|rowspan|style],'
                . 'hr,code,pre,span[class|style],div[class|style]'
            );

            // Izinkan style terbatas (Quill sering memakai inline style)
            $config->set('CSS.AllowedProperties', [
                'text-align', 'color', 'background-color', 'font-size',
                'font-weight', 'font-style', 'text-decoration',
                'margin', 'margin-top', 'margin-bottom', 'margin-left', 'margin-right',
                'padding', 'padding-top', 'padding-bottom', 'padding-left', 'padding-right',
                'border', 'border-radius', 'width', 'max-width', 'height',
                'float', 'display', 'list-style-type', 'line-height',
            ]);

            // Paksa rel="noopener noreferrer" pada link agar aman
            $config->set('HTML.TargetBlank', true);
            $config->set('HTML.TargetNoreferrer', true);

            // Pastikan direktori cache serializer ada dan bisa ditulisi
            $cachePath = storage_path('app/htmlpurifier');
            if (!is_dir($cachePath)) {
                @mkdir($cachePath, 0775, true);
            }
            if (is_dir($cachePath) && is_writable($cachePath)) {
                $config->set('Cache.SerializerPath', $cachePath);
            } else {
                $config->set('Cache.DefinitionImpl', null);
            }

            $purifier = new HTMLPurifier($config);

            return $purifier->purify($html);
        } catch (\Throwable $e) {
            report($e);
            return self::fallbackClean($html);
        }
    }

    /**
     * Pembersihan darurat (fallback) jika HTMLPurifier belum diinstal via composer pada hosting/server.
     */
    private static function fallbackClean(string $html): string
    {
        $allowedTags = '<p><h1><h2><h3><h4><h5><h6><ul><ol><li><a><strong><b><em><i><u><s><del><br><img><table><thead><tbody><tr><td><th><hr><code><pre><span><div>';
        $cleaned = strip_tags($html, $allowedTags);

        // Hapus event handler JavaScript (onclick, onerror, onload, onmouseover, dll)
        $cleaned = preg_replace('/\s+on[a-zA-Z]+\s*=\s*(["\'][^"\']*["\']|[^\s>]+)/i', '', $cleaned);

        // Netralkan link javascript:
        $cleaned = preg_replace('/href\s*=\s*["\']\s*javascript:[^"\']*["\']/i', 'href="#"', $cleaned);
        $cleaned = preg_replace('/src\s*=\s*["\']\s*javascript:[^"\']*["\']/i', '', $cleaned);

        return $cleaned;
    }

    /**
     * Versi ringan: hanya strip semua tag HTML (untuk excerpt/deskripsi singkat).
     */
    public static function strip(?string $html): string
    {
        return strip_tags($html ?? '');
    }
}
