<?php

use App\Models\{Country, Race, Role};
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Disable forKeys
         */
        Schema::table('users', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        User::query()->delete();
        /**
         * Remove autoIncr
         */
//        Schema::table('users', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', false)->change();
//        });
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("users")
            ->chunkById(100, function ($repsUsers) {
                try {
                    $insertItems = [];
                    foreach ($repsUsers as $item) {
                        $avatar = DB::connection("mysql2")->table("files")->where('id', $item->file_id)->value('link');
                        $roleId = Role::where('id', $item->user_role_id)->value('id');
                        $raceId = Race::where('code', $item->race)->value('id');
                        $countryId = Country::where('id', $item->country_id)->value('id');
                        $insertItems[] = [
                            'id'                => $item->id,
                            'avatar'            => $avatar,
                            'role_id'           => !empty($roleId) === true ? $roleId : 4,
                            'name'              => $item->name,
                            'email'             => $item->email,
                            'country_id'        => !empty($countryId) === true ? $countryId : 1,
                            'race_id'           => !empty($raceId) === true ? $raceId : 1,
                            'rating'            => $item->rating,
                            'email_verified_at' => $item->email_verified_at,
                            'ban'               => $item->is_ban,
                            'activity_at'       => $item->activity_at,
                            'birthday'          => $item->birthday,
                            'count_negative'    => $item->negative_count,
                            'count_positive'    => $item->positive_count,
                            'password'          => $item->password,
                            'remember_token'    => $item->remember_token,
                            'homepage'          => $item->homepage,
                            'isq'               => $item->isq,
                            'skype'             => $item->skype,
                            'vk_link'           => $item->vk_link,
                            'fb_link'           => $item->fb_link,
                            'last_ip'           => $item->last_ip,
                            'view_avatars'      => $item->view_avatars,
                            'created_at'        => $item->created_at,
                            'updated_at'        => $item->updated_at,

                        ];
                    }
                    DB::table("users")->insertOrIgnore($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Add autoIncr
         */
//        Schema::table('users', function (Blueprint $table) {
//            $table->unsignedBigInteger('id', true)->change();
//        });
        /**
         * Enable forKeys
         */
        Schema::table('users', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }
}
