<?php

namespace App\Console\Commands;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDefaultUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-default {--name=Admin : Nama user} {--email=admin@example.com : Email user} {--password=password : Password user} {--pin=123456 : PIN user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat user default dengan PIN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');
        $pin = $this->option('pin');

        // Validasi panjang PIN
        if (strlen($pin) !== 6 || !is_numeric($pin)) {
            $this->error('PIN harus berupa 6 digit angka.');
            return Command::FAILURE;
        }

        // Cek apakah user sudah ada
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $this->error("User dengan email {$email} sudah ada.");
            return Command::FAILURE;
        }

        // Buat user baru
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'pin' => Hash::make($pin),
            'role' => 'pasien',
        ]);

        // Buat data pasien jika role adalah pasien
        if ($user->role === 'pasien') {
            Pasien::create([
                'user_id' => $user->id,
                'email' => $email,
                'no_rm' => 'RM-' . str_pad(Pasien::count(), 3, '0', STR_PAD_LEFT),
                'nik' => '1234567890' . rand(1000, 9999),
                'nama' => $name,
                'tanggal_lahir' => now()->subYears(25)->format('Y-m-d'),
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Alamat default',
                'no_telepon' => '08123456789' . rand(10, 99),
            ]);
        }

        $this->info("User {$name} berhasil dibuat dengan PIN.");
        $this->line("Email: {$email}");
        $this->line("Password: {$password}");
        $this->line("PIN: {$pin}");

        return Command::SUCCESS;
    }
}
