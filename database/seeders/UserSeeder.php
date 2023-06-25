<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    protected $emails = ['admin@mailinator.com', 'admin2@mailinator.com', 'admin3@mailinator.com'];
    public function run(): void
    {
//        User::query()->create([
//            'name' => 'Admin1',
//            'email' => 'admin@mailinator.com',
//            'email_verified_at' => now(),
//            'password' => bcrypt('12345678'),
//            'role' => 'admin'
//        ]);
        foreach ($this->emails as $email) {
            User::factory()->state(function (array $attributes) use ($email) {
                return [
                    'email' => $email,
                ];
            })->create();
        }
    }
}
