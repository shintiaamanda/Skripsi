<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id_register
 * @property string $nama
 * @property string $name
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $role
 */
class Register extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'register';
    protected $primaryKey = 'id_register';

    protected $fillable = [
        'nama',
        'email',
        'username',
        'password',
        'role',
        'nip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['name'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute(): string
    {
        return $this->nama;
    }

    public function getAuthIdentifierName(): string
    {
        return 'id_register';
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function login(): HasOne
    {
        return $this->hasOne(Login::class, 'username', 'username');
    }

    public function siswa(): HasOne
    {
        return $this->hasOne(InputDataSiswa::class, 'nama', 'nama');
    }
}
