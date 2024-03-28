<?php

namespace App\Services\Payment;

class QrCodeService
{
    private string $baseUrl = 'https://quickchart.io/chart';
    private string $text = '';
    private int $width = 350;
    private int $height = 350;
    private string $base64 = '';

    private function __construct()
    {
    }

    public static function make(): QrCodeService
    {
        return new self();
    }

    public static function generate(string $text, int $width = 350, int $height = 350): string
    {
        return self::make()->text($text)->width($width)->height($height)->convertBase64()->getBase64();
    }

    public function convertBase64(): QrCodeService
    {
        $query = http_build_query([
            'chs' => $this->width . 'x' . $this->height,
            'cht' => 'qr',
            'chl' => $this->text,
        ]);

        $url = $this->baseUrl . '?' . $query;
        $data = file_get_contents($url);
        $this->base64 = 'data:image/png;base64,' . base64_encode($data);

        return $this;
    }

    public function text(string $text): QrCodeService
    {
        $this->text = $text;
        return $this;
    }

    public function width(int $width): QrCodeService
    {
        $this->width = $width;
        return $this;
    }

    public function height(int $height): QrCodeService
    {
        $this->height = $height;
        return $this;
    }

    public function getBase64(): string
    {
        return $this->base64;
    }
}
