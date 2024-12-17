<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('password123'), 'role' => 'admin'],
            ['name' => 'John Doe', 'email' => 'johndoe@example.com', 'password' => Hash::make('password123'), 'role' => 'applicant'],
            ['name' => 'Jane Doe', 'email' => 'janedoe@example.com', 'password' => Hash::make('password123'), 'role' => 'applicant'],
            ['name' => 'Emily Smith', 'email' => 'emily@example.com', 'password' => Hash::make('password123'), 'role' => 'applicant'],
            ['name' => 'Michael Brown', 'email' => 'michael@example.com', 'password' => Hash::make('password123'), 'role' => 'applicant'],
            ['name' => 'Chris Green', 'email' => 'chris@example.com', 'password' => Hash::make('password123'), 'role' => 'admin'],
            ['name' => 'Sarah White', 'email' => 'sarah@example.com', 'password' => Hash::make('password123'), 'role' => 'applicant'],
            ['name' => 'David Black', 'email' => 'david@example.com', 'password' => Hash::make('password123'), 'role' => 'applicant'],
            ['name' => 'Olivia Blue', 'email' => 'olivia@example.com', 'password' => Hash::make('password123'), 'role' => 'admin'],
            ['name' => 'Sophia Grey', 'email' => 'sophia@example.com', 'password' => Hash::make('password123'), 'role' => 'applicant'],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
