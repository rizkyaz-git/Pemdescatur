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

        // Simpan cache purifier di storage
        $config->set('Cache.SerializerPath', storage_path('app/htmlpurifier'));

        $purifier = new HTMLPurifier($config);

        return $purifier->purify($html);
    }

    /**
     * Versi ringan: hanya strip semua tag HTML (untuk excerpt/deskripsi singkat).
     */
    public static function strip(?string $html): string
    {
        return strip_tags($html ?? '');
    }
}
