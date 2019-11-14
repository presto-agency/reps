<?php

use App\Models\Country;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;

class TransferCountries extends Seeder
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
        Schema::table('replays', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        Schema::table('users', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        Schema::table('streams', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Drop forKeys
         */
        Schema::table('users', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('users');
            in_array('users_country_id_foreign', $foreignKeys) === true ? $table->dropForeign('users_country_id_foreign') : null;
            in_array('users_race_id_foreign', $foreignKeys) === true ? $table->dropForeign('users_race_id_foreign') : null;
            in_array('users_role_id_foreign', $foreignKeys) === true ? $table->dropForeign('users_role_id_foreign') : null;
        });
        Schema::table('streams', function (Blueprint $table) {
            $foreignKeys = $this->listTableForeignKeys('streams');
            in_array('streams_country_id_foreign', $foreignKeys) === true ? $table->dropForeign('streams_country_id_foreign') : null;
        });
        /**
         * Clear table
         */
        Country::query()->whereNotNull('id')->delete();
        /**
         * Remove autoIncr
         */
        Schema::table('countries', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->change();
        });
        /**
         * Get and Insert data
         */
        $repsCountries = DB::connection("mysql2")->table("countries")->get();
        foreach ($repsCountries as $item) {
            $flag = DB::connection("mysql2")->table("files")->where('id', $item->flag_file_id)->value('link');

            try {
                $insertItem = [
                    'id'         => $item->id,
                    'name'       => !empty($item->name) === true ? $item->name : '',
                    'code'       => !empty($item->code) === true ? $item->code : '',
                    'flag'       => !empty($flag) === true ? $flag : null,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
                DB::table("countries")->insert($insertItem);
            } catch (\Exception $e) {
                dd($e, $item);
            }
        }

        /**
         * Add autoIncr
         */
        Schema::table('countries', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->change();
        });
        /**
         * Add NewForKeys and columns
         */
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->unsignedBigInteger('race_id')->nullable()->change();
            $table->unsignedBigInteger('role_id')->nullable()->change();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL');
            $table->foreign('race_id')->references('id')->on('races')->onDelete('SET NULL');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('SET NULL');
        });
        Schema::table('streams', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable()->change();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL');
        });
        /**
         * Enable forKeys
         */
        Schema::table('replays', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('users', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('streams', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * @param $table
     * @return array
     */
    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
}
