<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_konseling
 * @property int $id_siswa
 * @property int|null $id_jadwal
 * @property string $tanggal_konseling
 * @property string $keluhan
 */
class AjukanKonseling extends Model
{
    use HasFactory;

    protected $table = 'ajukan_konseling';
    protected $primaryKey = 'id_konseling';

    protected $fillable = [
        'id_siswa',
        'id_jadwal',
        'tanggal_konseling',
        'keluhan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_konseling' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(InputDataSiswa::class, 'id_siswa');
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalLayananBk::class, 'id_jadwal');
    }

    public function scopeForGuruBk(Builder $query, string $guruBkNama): Builder
    {
        return $query->where(function (Builder $q) use ($guruBkNama) {
            $q->whereNull('id_jadwal')
                ->orWhereHas('jadwal', function (Builder $j) use ($guruBkNama) {
                    $j->where('guru', $guruBkNama);
                });
        });
    }

    public function isExpired(): bool
    {
        if (! $this->tanggal_konseling) {
            return false;
        }

        $dateStr = $this->tanggal_konseling instanceof \DateTimeInterface
            ? $this->tanggal_konseling->format('Y-m-d')
            : substr((string) $this->tanggal_konseling, 0, 10);

        $targetDate = \Carbon\Carbon::parse($dateStr)->startOfDay();
        $today = now()->startOfDay();

        // 1. Jika tanggal konseling sudah lewat sebelum hari ini
        if ($targetDate->lt($today)) {
            return true;
        }

        // 2. Jika tanggal konseling hari ini, periksa rentang jam
        if ($targetDate->eq($today) && $this->jadwal && ! empty($this->jadwal->jam)) {
            if (preg_match_all('/(\d{1,2}:\d{2})/', $this->jadwal->jam, $matches) && ! empty($matches[1])) {
                // Mengambil jam selesai (misal dari "08:00 - 09:30" diambil "09:30")
                $targetJam = end($matches[1]);
                if (strlen($targetJam) === 4) {
                    $targetJam = '0' . $targetJam;
                }
                $timeToday = now()->format('H:i');

                if ($timeToday > $targetJam) {
                    return true;
                }
            }
        }

        return false;
    }
}
