<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_jadwal
 * @property string $hari
 * @property string $tanggal_layanan
 * @property string $jam
 * @property string $guru
 */
class JadwalLayananBk extends Model
{
    use HasFactory;

    protected $table = 'jadwal_layanan_bk';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'hari',
        'tanggal_layanan',
        'jam',
        'guru',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_layanan' => 'date:Y-m-d',
        ];
    }
}
