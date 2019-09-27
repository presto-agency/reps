<?php

use App\Models\Footer;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Footer::query()->firstOrNew(['title' => 'Disclaimer']);
        if (!$data->exists) {
            $data->fill([
                'title' => 'Disclaimer',
                'text' => 'text',
            ])->save();
        }
    }
}
