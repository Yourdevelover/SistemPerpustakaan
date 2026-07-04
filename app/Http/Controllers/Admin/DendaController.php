<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $dendas = Denda::with(['peminjaman.anggota.user'])->latest()->paginate(10);
        return view('admin.denda.index', compact('dendas'));
    }

    public function edit(Denda $denda)
    {
        $denda->load('peminjaman.anggota.user');
        return view('admin.denda.edit', compact('denda'));
    }

    public function update(Request $request, Denda $denda)
    {
        $request->validate([
            'status_bayar'  => 'required|in:belum_bayar,lunas',
            'tanggal_bayar' => 'nullable|date',
        ]);
        $denda->update([
            'status_bayar'  => $request->status_bayar,
            'tanggal_bayar' => $request->status_bayar === 'lunas' ? now()->toDateString() : null,
        ]);
        return redirect()->route('admin.denda.index')->with('success', 'Status denda diperbarui.');
    }
}