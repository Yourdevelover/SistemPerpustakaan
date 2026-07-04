<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporans';

    protected $fillable = [
        'generated_by', 'jenis_laporan', 
        'periode_mulai', 'periode_akhir', 'file_path'
    ];

    // Relasi ke User (Many-to-One)
    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}