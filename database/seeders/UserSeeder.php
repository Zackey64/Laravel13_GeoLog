<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(
            [
                'name' => 'Zackey(admin)',
                'email' => 'ishizaki0826@gmail.com',
                'password' => bcrypt('password'),
            ]
        );
    }
}
