<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@kreatx.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$hXwDtM09I1XfK/RnXYQWBuRdC8mYzNP0y5F35J1AZkNe4BfBGEyB.', // 12345678
            'remember_token' => Str::random(10),
            'isAdmin' => '1',
        ]);

        $this->call(DepartmentTableSeeder::class);
    }
}
