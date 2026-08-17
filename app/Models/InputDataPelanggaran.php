<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_pelanggaran
 * @property int $id_siswa
 * @property string $tanggal_pelanggaran
 * @property int $poin
 * @property string $tindakan
 */
class InputDataPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'input_data_pelanggaran';
    protected $primaryKey = 'id_pelanggaran';

    protected $fillable = [
        'id_siswa',
        'tanggal_pelanggaran',
        'poin',
        'tindakan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pelanggaran' => 'date:Y-m-d',
            'poin' => 'integer',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(InputDataSiswa::class, 'id_siswa');
    }
}
