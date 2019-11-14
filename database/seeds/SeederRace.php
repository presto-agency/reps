<?php

use App\Models\Race;
use Illuminate\Database\Seeder;

class SeederRace extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $race = Race::query()->firstOrNew(['title' => 'All']);
        if (!$race->exists) {
            $race->fill([
                'title' => 'All',
                'code'  => 'All',
            ])->save();
        }
        $race = Race::query()->firstOrNew(['title' => 'Zerg']);
        if (!$race->exists) {
            $race->fill([
                'title' => 'Zerg',
                'code'  => 'Z',
            ])->save();
        }
        $race = Race::query()->firstOrNew(['title' => 'Protoss']);
        if (!$race->exists) {
            $race->fill([
                'title' => 'Protoss',
                'code'  => 'P',
            ])->save();
        }
        $race = Race::query()->firstOrNew(['title' => 'Terran']);
        if (!$race->exists) {
            $race->fill([
                'title' => 'Terran',
                'code'  => 'T',
            ])->save();
        }
    }
}
