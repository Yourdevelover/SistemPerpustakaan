<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBuku::withCount('bukus')->latest()->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_bukus,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ]);
        KategoriBuku::create($request->only('nama_kategori', 'deskripsi'));
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriBuku $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_bukus,nama_kategori,' . $kategori->id,
            'deskripsi'     => 'nullable|string',
        ]);
        $kategori->update($request->only('nama_kategori', 'deskripsi'));
        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriBuku $kategori)
    {
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}