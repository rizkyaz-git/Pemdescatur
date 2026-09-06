<?php

namespace App\Services;

use App\Models\LetterRequest;

class LetterGeneratorService
{
    /**
     * Generate surat text by replacing placeholders
     * Placeholder format: {{field_name}}
     */
    public function generateLetterText(LetterRequest $letterRequest): string
    {
        $template = $letterRequest->template->template_text;
        $data = $letterRequest->form_data;

        // Replace placeholders with data
        $filledTemplate = $template;
        foreach ($data as $key => $value) {
            $filledTemplate = str_replace("{{$key}}", $value, $filledTemplate);
        }

        return $filledTemplate;
    }

    /**
     * Generate HTML untuk PDF
     */
    public function generateHtmlForPdf(LetterRequest $letterRequest): string
    {
        $letterText = $this->generateLetterText($letterRequest);

        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Surat - {$letterRequest->ticket_number}</title>
            <style>
                body {
                    font-family: 'Courier New', monospace;
                    margin: 40px;
                    line-height: 1.6;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                }
                .content {
                    margin: 20px 0;
                }
                .footer {
                    margin-top: 40px;
                }
                .signature {
                    margin-top: 60px;
                }
            </style>
        </head>
        <body>
            <div class="content">
                {$letterText}
            </div>
            <div class="footer">
                <p><small>Nomor Tiket: {$letterRequest->ticket_number}</small></p>
                <p><small>Tanggal Diproses: {$letterRequest->processed_at?->format('d-m-Y H:i:s') ?? '-'}</small></p>
            </div>
        </body>
        </html>
        HTML;
    }
}
