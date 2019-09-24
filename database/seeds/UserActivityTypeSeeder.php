<?php

use App\Models\UserActivityType;
use Illuminate\Database\Seeder;

class UserActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = UserActivityType::query()->firstOrNew(['name' => 'Login']);
        if (!$type->exists) {
            $type->fill([
                'name' => 'Login',
            ])->save();
        }
        $type = UserActivityType::query()->firstOrNew(['name' => 'Logout']);
        if (!$type->exists) {
            $type->fill([
                'name' => 'Logout',
            ])->save();
        }
        $type = UserActivityType::query()->firstOrNew(['name' => 'Like']);
        if (!$type->exists) {
            $type->fill([
                'name' => 'Like',
            ])->save();
        }
        $type = UserActivityType::query()->firstOrNew(['name' => 'Register']);
        if (!$type->exists) {
            $type->fill([
                'name' => 'Register',
            ])->save();
        }
        $type = UserActivityType::query()->firstOrNew(['name' => 'Comment']);
        if (!$type->exists) {
            $type->fill([
                'name' => 'Comment',
            ])->save();
        }
        $type = UserActivityType::query()->firstOrNew(['name' => 'Create Post']);
        if (!$type->exists) {
            $type->fill([
                'name' => 'Create Post',
            ])->save();
        }
        $type = UserActivityType::query()->firstOrNew(['name' => 'Upload Replay']);
        if (!$type->exists) {
            $type->fill([
                'name' => 'Upload Replay',
            ])->save();
        }
        $type = UserActivityType::query()->firstOrNew(['name' => 'Upload Image']);
        if (!$type->exists) {
            $type->fill([
                'name' => 'Upload Image',
            ])->save();
        }
    }
}
