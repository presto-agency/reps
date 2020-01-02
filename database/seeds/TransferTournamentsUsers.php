<?php

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
                        $checkUser = DB::table('users')->where('name', $item->login)
                            ->orWhere('email', $item->login)->exists();

                        if ( ! $checkUser) {
                            $insert_user = [
                                'name'     => trim($item->login),
                                'email'    => trim($item->login),
                                'password' => Hash::make('password'),
                                'role_id'  => \App\Models\Role::where('name', 'user')->value('id'),
                            ];
                            \App\User::query()->insert($insert_user);
                        }
                    }
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
    }

}
