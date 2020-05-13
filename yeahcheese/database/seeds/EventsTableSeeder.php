<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            [
                'title' => 'テストイベント１',
                'release_date' => '2020-05-12',
                'end_date' => '2020-05-30',
                'auth_key' => '12345678',
                'user_id' => 1,
            ],
            [
                'title' => 'テストイベント2',
                'release_date' => '2020-05-12',
                'end_date' => '2020-05-30',
                'auth_key' => '22222222',
                'user_id' => 1,
            ],
            [
                'title' => 'テストイベント3',
                'release_date' => '2020-05-12',
                'end_date' => '2020-05-30',
                'auth_key' => '33333333',
                'user_id' => 2,
            ],
        ]);
    }
}
