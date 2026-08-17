<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_info
 * @property string $informasi
 * @property string $tanggal_informasi
 */
class InformasiBk extends Model
{
    use HasFactory;

    protected $table = 'informasi_bk';
    protected $primaryKey = 'id_info';

    protected $fillable = [
        'informasi',
        'tanggal_informasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_informasi' => 'date:Y-m-d',
        ];
    }
}
