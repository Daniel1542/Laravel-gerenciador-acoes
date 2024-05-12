<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admim@gmail.com',
            'password' => 'aaaa1111',
        ]);

        User::create([
            'email' => 'backup@gmail.com',
            'password' => 'aaaa1111',
        ]);

        User::factory()->create();
    }
}
