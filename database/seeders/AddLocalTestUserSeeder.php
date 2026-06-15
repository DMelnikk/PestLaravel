<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddLocalTestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(app()->environment() === 'local') {
            User::create([
                'email' => 'test@test.com',
                'name' => 'Dmitri',
                'password' => bcrypt('password'),
            ]);
        }

    }
}
