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
            'role_id'           => 1,
            'name'              => config('auth.admin.name'),
            'email'             => config('auth.admin.email'),
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => \Hash::make(config('auth.admin.password'))
        ]);
    }
}
