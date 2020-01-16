<?php

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

class TransferTournamentsUsers extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get and Insert data
         */
        DB::connection('mysql3')->table('user as u')
            ->join("lis_tourney_player as li", 'li.id_user', '=', 'u.id')
            ->select('u.login', 'li.id_user')
            ->groupBy('li.id_user')
            ->orderBy('li.id_user')
            ->chunk(50, function ($users) {
                try {
                    foreach ($users as $item) {
                        $checkUser = DB::table('users')->where('name', trim($item->login))
                            ->where('email', trim($item->login))->exists();

                        if ( ! $checkUser) {
                            $insert_user = [
                                'name'     => trim($item->login),
                                'email'    => trim($item->login),
                                'password' => Hash::make('password'),
                                'role_id'  => Role::query()->where('name', 'user')->value('id'),
                            ];
                            User::query()->insert($insert_user);
                        }
                    }
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
    }

}
