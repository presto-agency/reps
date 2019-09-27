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
        $role = ReplayType::query()->firstOrNew(['title' => 'Gosu']);
        if (!$role->exists) {
            $role->fill([
                'title' => 'Gosu',
            ])->save();
        }
        $role = ReplayType::query()->firstOrNew(['title' => 'Пользовательский']);
        if (!$role->exists) {
            $role->fill([
                'title' => 'Пользовательский',
            ])->save();
        }
    }
}
