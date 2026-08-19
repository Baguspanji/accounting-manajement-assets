<?php

namespace App\Http\Controllers;

class DocumentationController extends Controller
{
    public function index()
    {
        $documents = $this->getDocumentsData();

        return view('documentation.index', compact('documents'));
    }

    public function show(int $id)
    {
        $documents = $this->getDocumentsData();
        $document = collect($documents)->firstWhere('id', $id);

        if (! $document) {
            abort(404, 'Dokumentasi tidak ditemukan');
        }

        return view('documentation.show', compact('document'));
    }

    private function getDocumentsData()
    {
        $path = public_path('assets/documents.json');

        if (! is_file($path)) {
            abort(500, 'File dokumentasi tidak ditemukan.');
        }

        $documents = json_decode(file_get_contents($path), true);

        if (! is_array($documents)) {
            abort(500, 'Format file dokumentasi tidak valid.');
        }

        return $documents;
    }
}
