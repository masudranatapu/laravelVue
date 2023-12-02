<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::insert([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now(),
        ]);
    }
}
