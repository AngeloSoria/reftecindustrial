<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $username = env('SA_ACCOUNT_USERNAME', 'user1');
        $pass = env('SA_ACCOUNT_PASSWORD', 'user1@12345');

        User::updateOrCreate(['username' => $username], [
            'username' => $username,
            'password' => Hash::make($pass),

            'name' => 'Reftec User',
            'role' => 'Super Admin'
        ]);
    }
}
