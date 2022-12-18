<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        [
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'first_name' => 'Admin',
            'last_name' => 'System',
            'phone' => '090 2440 048',
            'role_id' => 1,
            'active' => 1,
            'created_at' => now()
        ],
        [
            'email' => 'user01@example.com',
            'password' => Hash::make('12345'),
            'first_name' => 'Anh',
            'last_name' => 'Duy',
            'phone' => '090 2440 048',
            'role_id' => 2,
            'active' => 1,
            'created_at' => now()
        ]
        ]   );
    }
}
