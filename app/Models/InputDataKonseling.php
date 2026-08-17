<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_data_konseling
 * @property int $id_siswa
 * @property string $tanggal
 * @property string $masalah
 * @property string $solusi
 * @property string $guru_bk
 */
class InputDataKonseling extends Model
{
    use HasFactory;

    protected $table = 'input_data_konseling';
    protected $primaryKey = 'id_data_konseling';

    protected $fillable = [
        'id_siswa',
        'tanggal',
        'masalah',
        'solusi',
        'guru_bk',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(InputDataSiswa::class, 'id_siswa');
    }

    public function scopeForGuruBk(Builder $query, string $guruBkNama): Builder
    {
        return $query->where('guru_bk', $guruBkNama);
    }
}
