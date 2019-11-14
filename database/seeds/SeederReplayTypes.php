<?php

use App\Models\ReplayType;
use Illuminate\Database\Seeder;

class SeederReplayTypes extends Seeder
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
                'name'  => 'duel',
                'title' => 'Gosu',
            ])->save();
        }
        $replayType = ReplayType::query()->firstOrNew(['title' => 'Пользовательский']);
        if (!$replayType->exists) {
            $replayType->fill([
                'name'  => 'pack',
                'title' => 'Пользовательский',
            ])->save();
        }
        /*Mod Types*/
        $replayType = ReplayType::query()->firstOrNew(['title' => 'Gosu']);
        if ($replayType->exists) {
            $replayType->fill([
                'name'  => 'duel',
                'title' => '1x1',
            ])->save();
        }
        $replayType = ReplayType::query()->firstOrNew(['title' => 'Пользовательский']);
        if ($replayType->exists) {
            $replayType->fill([
                'name'  => 'pack',
                'title' => 'Park / Archive',
            ])->save();
        }
        $replayType = ReplayType::query()->firstOrNew(['title' => 'Game of the Week']);
        if (!$replayType->exists) {
            $replayType->fill([
                'name'  => 'gotw',
                'title' => 'Game of the Week',
            ])->save();
        }
        $replayType = ReplayType::query()->firstOrNew(['title' => '2x2, 3x3, 4x4']);
        if (!$replayType->exists) {
            $replayType->fill([
                'name'  => 'team',
                'title' => '2x2, 3x3, 4x4',
            ])->save();
        }
    }
}
