<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class SeederRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::query()->firstOrNew(['name' => 'super-admin']);
        if (!$role->exists) {
            $role->fill([
                'title' => 'Супер-админ',
            ])->save();
        }
        $role = Role::query()->firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'title' => 'Админ',
            ])->save();
        }
        $role = Role::query()->firstOrNew(['name' => 'moderator']);
        if (!$role->exists) {
            $role->fill([
                'title' => 'Модератор',
            ])->save();
        }
        $role = Role::query()->firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                'title' => 'Зарегистрированный пользователь',
            ])->save();
        }
    }
}
