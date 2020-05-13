<?php

use Illuminate\Database\Seeder;

class PicturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pictures')->insert([
            [
                'event_id' => 1,
                'path' => 'neko_magazine04.jpg',
            ],
            [
                'event_id' => 2,
                'path' => 'neko_magazine04.jpg',
            ],
            [
                'event_id' => 3,
                'path' => 'neko_magazine04.jpg',
            ],
        ]);
    }
}
