<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use setasign\Fpdi\Fpdi;

class PdfPreviewGenerator
{
    public function generate(string $sourceDisk, string $sourcePath, int $pages, string $targetDisk = 'public', string $targetDir = 'assets/book-previews'): string
    {
        if (! class_exists(Fpdi::class)) {
            throw new RuntimeException('FPDI belum terpasang. Jalankan composer require setasign/fpdi setasign/fpdf.');
        }

        if ($pages < 1) {
            throw new RuntimeException('Jumlah halaman preview harus minimal 1.');
        }

        $sourceFullPath = Storage::disk($sourceDisk)->path($sourcePath);
        if (! is_file($sourceFullPath)) {
            throw new RuntimeException('File sumber preview tidak ditemukan.');
        }

        $filename = 'preview_' . now()->format('Ymd_His') . '_' . Str::random(8) . '.pdf';
        $targetDir = trim($targetDir, '/');
        Storage::disk($targetDisk)->makeDirectory($targetDir);
        $targetPath = $targetDir . '/' . $filename;
        $targetFullPath = Storage::disk($targetDisk)->path($targetPath);

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($sourceFullPath);
        $total = min($pages, $pageCount);

        for ($pageNumber = 1; $pageNumber <= $total; $pageNumber += 1) {
            $templateId = $pdf->importPage($pageNumber);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
        }

        $pdf->Output('F', $targetFullPath);

        return $targetPath;
    }
}
