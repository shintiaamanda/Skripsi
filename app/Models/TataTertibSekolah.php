<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_tertib
 * @property string $tata_tertib
 * @property string $tanggal_konseling
 */
class TataTertibSekolah extends Model
{
    use HasFactory;

    protected $table = 'tata_tertib_sekolah';
    protected $primaryKey = 'id_tertib';

    protected $fillable = [
        'tata_tertib',
        'tanggal_konseling',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_konseling' => 'date:Y-m-d',
        ];
    }
}
