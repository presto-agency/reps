<?php

use Illuminate\Database\Seeder;

class HelpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('helps')->insert([
            'display_name' => 'Подсказки для чата',
            'key' => 'helps_for_chat',
            'value' => 'Текст подсказки',
            'description' => 'Список подсказок для чата',
        ]);
    }
}
