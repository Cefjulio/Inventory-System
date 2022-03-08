<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
        User::create([
            'name' => 'Julio Auyon',
            'phone' => '30504456',
            'email' => 'juliorecinos30@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('abcd1234')
        ]);
        User::create([
            'name' => 'Julio2 Auyon2',
            'phone' => '30504456',
            'email' => 'julio2@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('abcd')
        ]);



    }
}
