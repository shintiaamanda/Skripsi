<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_login
 * @property string $username
 * @property string $password
 */
class Login extends Model
{
    use HasFactory;

    protected $table = 'login';
    protected $primaryKey = 'id_login';

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function register(): BelongsTo
    {
        return $this->belongsTo(Register::class, 'username', 'username');
    }
}
