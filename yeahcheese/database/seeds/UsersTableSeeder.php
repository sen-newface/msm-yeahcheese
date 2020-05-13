<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                'name' => '若林',
                'email' => 'aaa@aaa',
                'password' => '00000000',
            ],
            [
                'name' => '春日',
                'email' => 'iii@iii',
                'password' => '11111111',
            ],
        ]);
    }
}
