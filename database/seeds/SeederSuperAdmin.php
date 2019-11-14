<?php


use App\User;
use Illuminate\Database\Seeder;

class SeederSuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'role_id'  => 1,
            'name'     => 'super-admin',
            'email'    => 'super-admin@reps.com',
            'password' => \Hash::make('12345678')
        ]);
    }
}
