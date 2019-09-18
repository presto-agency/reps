<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MainAdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'role_id' => 1,
            'name' => 'MainAdmin',
            'email' => 'mainadmin@reps.com',
            'password' => Hash::make('Reps!18092019!'),
        ]);
    }
}
