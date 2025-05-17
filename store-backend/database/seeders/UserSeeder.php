<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'test@mail.com',
            'password' => bcrypt('test'),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        echo "\nUser token:\n".$token."\n";
    }
}
