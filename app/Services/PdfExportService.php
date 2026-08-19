<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfExportService
{
    public function fromView(string $view, array $data = [], array $options = []): BinaryFileResponse
    {
        $html = view('layouts.print', [
            'title' => $options['title'] ?? 'Laporan',
            'subtitle' => $options['subtitle'] ?? '',
            'content' => view($view, $data)->render(),
        ])->render();

        $path = tempnam(sys_get_temp_dir(), 'laporan-').'.pdf';

        $margins = $options['margins'] ?? [10, 12, 12, 12];

        Browsershot::html($html)
            ->setNodeModulePath(config('services.browsershot.node_module_path'))
            ->setChromePath(config('services.browsershot.chrome_path'))
            ->format($options['format'] ?? 'A4')
            ->margins((float) $margins[0], (float) $margins[1], (float) $margins[2], (float) $margins[3], 'mm')
            ->waitUntilNetworkIdle(false)
            ->save($path);

        $filename = $options['filename'] ?? 'laporan.pdf';

        return response()
            ->download($path, $filename, ['Content-Type' => 'application/pdf'])
            ->deleteFileAfterSend(true);
    }

    public function inlineCss(): string
    {
        $manifestPath = public_path('build/manifest.json');

        if (! is_file($manifestPath)) {
            return '';
        }

        $manifest = json_decode((string) file_get_contents($manifestPath), true);
        $entry = $manifest['resources/css/app.css']['css'] ?? [];

        $css = '';

        foreach ((array) $entry as $file) {
            $path = public_path(ltrim($file, '/'));

            if (is_file($path)) {
                $css .= (string) file_get_contents($path);
            }
        }

        return $css;
    }
}
