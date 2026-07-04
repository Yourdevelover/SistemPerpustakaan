<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->paginate(10);
        return view('admin.buku.index', compact('bukus'));

        $bukus = Buku::with('kategori')
            ->when(
                $request->search,
                fn($q) =>
                $q->where('judul', 'like', "%{$request->search}%")
                    ->orWhere('penulis', 'like', "%{$request->search}%")
                    ->orWhere('isbn', 'like', "%{$request->search}%")
            )
            ->when(
                $request->kategori,
                fn($q) =>
                $q->where('kategori_id', $request->kategori)
            )
            ->latest()->paginate(10)->withQueryString();

        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        $kategoris = KategoriBuku::orderBy('nama_kategori')->get();
        return view('admin.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn'           => 'required|string|unique:bukus,isbn',
            'judul'          => 'required|string|max:255',
            'penulis'        => 'required|string|max:255',
            'penerbit'       => 'required|string|max:255',
            'tahun_terbit'   => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah_total'   => 'required|integer|min:1',
            'lokasi_rak'     => 'nullable|string|max:50',
            'kategori_id'    => 'required|exists:kategori_bukus,id',
            'cover'          => 'nullable|image|max:2048',
        ]);

        $validated['jumlah_tersedia'] = $validated['jumlah_total'];

        if ($request->hasFile('cover')) {
            $validated['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($validated);
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $kategoris = KategoriBuku::orderBy('nama_kategori')->get();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'isbn'         => 'required|string|unique:bukus,isbn,' . $buku->id,
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah_total' => 'required|integer|min:1',
            'lokasi_rak'   => 'nullable|string|max:50',
            'kategori_id'  => 'required|exists:kategori_bukus,id',
            'cover'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($buku->cover_path) Storage::disk('public')->delete($buku->cover_path);
            $validated['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($validated);
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover_path) Storage::disk('public')->delete($buku->cover_path);
        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
