<?php

namespace App\Actions\Fortify;

use App\Models\InputDataSiswa;
use App\Models\Register;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): Register
    {
        Validator::make($input, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(Register::class)],
            'role' => ['required', 'string', 'in:siswa,orang_tua'],
            'password' => $this->passwordRules(),
            'nisn' => ['nullable', 'required_if:role,siswa', 'string', 'max:20'],
            'kelas' => ['nullable', 'required_if:role,siswa', 'string', 'max:50'],
            'jenis_kelamin' => ['nullable', 'required_if:role,siswa', 'string', 'in:Laki-laki,Perempuan'],
            'no_hp' => ['nullable', 'required_if:role,siswa', 'string', 'max:15'],
            'alamat' => ['nullable', 'required_if:role,siswa', 'string'],
        ])->validate();

        $user = Register::create([
            'nama' => $input['nama'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => $input['password'],
            'role' => $input['role'],
        ]);

        if ($input['role'] === 'siswa' && ! empty($input['nisn'])) {
            InputDataSiswa::create([
                'nisn' => $input['nisn'],
                'nama' => $input['nama'],
                'jenis_kelamin' => $input['jenis_kelamin'] ?? 'Laki-laki',
                'kelas' => $input['kelas'] ?? '-',
                'alamat' => $input['alamat'] ?? '-',
                'no_hp' => $input['no_hp'] ?? '-',
            ]);
        }

        return $user;
    }
}
