<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_monitoring
 * @property int $id_siswa
 * @property string $tanggal_monitoring
 * @property string $perkembangan
 */
class InputDataMonitoring extends Model
{
    use HasFactory;

    protected $table = 'input_data_monitoring';
    protected $primaryKey = 'id_monitoring';

    protected $fillable = [
        'id_siswa',
        'tanggal_monitoring',
        'perkembangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_monitoring' => 'date:Y-m-d',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(InputDataSiswa::class, 'id_siswa');
    }
}
