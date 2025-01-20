<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Tala Chikhali',
            'email' => 'tala@gmail.com',
            'password' => Hash::make('password'),
            'image' => 'none'
        ]);

        $admin->assignRole('admin');
    }
}
