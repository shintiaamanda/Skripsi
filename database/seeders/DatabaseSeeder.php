<?php

namespace Database\Seeders;

use App\Models\InputDataSiswa;
use App\Models\Register;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Register::create([
            'nama' => 'Shintia Amanda',
            'email' => 'adit@smkn3padang.sch.id',
            'username' => 'A002',
            'password' => 'password',
            'role' => 'guru_bk',
        ]);
        Register::create([
            'nama' => 'Zery',
            'email' => 'dino@smkn3padang.sch.id',
            'username' => 'A003',
            'password' => 'password',
            'role' => 'guru_bk',
        ]);

        Register::create([
            'nama' => 'Lili Sumeri, S.Pd',
            'email' => 'kepalasekolah@smkn3padang.sch.id',
            'username' => 'A001',
            'password' => 'password',
            'role' => 'kepala_sekolah',
            'nip' => '197203081997022001',
        ]);

        Register::create([
            'nama' => 'Ahmad Rizki',
            'email' => 'ahmad@smkn3padang.sch.id',
            'username' => 'siswa',
            'password' => 'password',
            'role' => 'siswa',
        ]);

        InputDataSiswa::create([
            'nisn' => '0012345678',
            'nama' => 'Ahmad Rizki',
            'jenis_kelamin' => 'Laki-laki',
            'kelas' => 'XII RPL 1',
            'alamat' => 'Jl. Pendidikan No. 10, Padang',
            'no_hp' => '081234567890',
        ]);

        Register::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@smkn3padang.sch.id',
            'username' => 'orangtua',
            'password' => 'password',
            'role' => 'orang_tua',
        ]);

        InputDataSiswa::create([
            'nisn' => '0012345679',
            'nama' => 'Siti Nurhaliza',
            'jenis_kelamin' => 'Perempuan',
            'kelas' => 'XII TKJ 2',
            'alamat' => 'Jl. Pendidikan No. 15, Padang',
            'no_hp' => '081234567891',
        ]);
    }
}
