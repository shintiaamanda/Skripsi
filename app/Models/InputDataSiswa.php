<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_siswa
 * @property string $nisn
 * @property string $nama
 * @property string $jenis_kelamin
 * @property string $kelas
 * @property string $alamat
 * @property string $no_hp
 */
class InputDataSiswa extends Model
{
    use HasFactory;

    protected $table = 'input_data_siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nisn',
        'nama',
        'jenis_kelamin',
        'kelas',
        'alamat',
        'no_hp',
    ];

    public function konseling(): HasMany
    {
        return $this->hasMany(InputDataKonseling::class, 'id_siswa');
    }

    public function monitoring(): HasMany
    {
        return $this->hasMany(InputDataMonitoring::class, 'id_siswa');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(InputDataPelanggaran::class, 'id_siswa');
    }

    public function ajukanKonseling(): HasMany
    {
        return $this->hasMany(AjukanKonseling::class, 'id_siswa');
    }

    public function getPoinBonusMonitoringAttribute(): int
    {
        $bonus = 0;
        foreach ($this->monitoring as $m) {
            $textLower = strtolower($m->perkembangan ?? '');
            $isBuruk = \Illuminate\Support\Str::contains($textLower, ['buruk', 'kurang', 'nakal', 'bolos', 'langgar', 'lambat', 'penurunan', 'masalah', 'tidak', 'jelek', 'parah']);
            if (! $isBuruk && ! empty($textLower)) {
                $bonus += 10;
            }
        }

        return $bonus;
    }

    public function getSisaPoinAttribute(): int
    {
        $potongan = (int) $this->pelanggaran()->sum('poin');
        $bonus = $this->poin_bonus_monitoring;

        return 100 - $potongan + $bonus;
    }
}
