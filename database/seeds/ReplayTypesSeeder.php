<?php

use App\Models\ReplayType;
use Illuminate\Database\Seeder;

class ReplayTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $replayType = ReplayType::query()->firstOrNew(['title' => 'Gosu']);
        if (!$replayType->exists) {
            $replayType->fill([
                'title' => 'Gosu',
            ])->save();
        }
        $replayType = ReplayType::query()->firstOrNew(['title' => 'Пользовательский']);
        if (!$replayType->exists) {
            $replayType->fill([
                'title' => 'Пользовательский',
            ])->save();
        }
    }
}
