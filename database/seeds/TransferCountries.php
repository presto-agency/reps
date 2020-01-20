<?php

use Carbon\Carbon;
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
        Schema::table('countries', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
        });
        /**
         * Clear table
         */
        DB::table('countries')->delete();
        /**
         * Get and Insert data
         */
        DB::connection("mysql2")->table("countries")
            ->chunkById(100, function ($repsCountries) {
                try {
                    $insertItems = [];
                    foreach ($repsCountries as $item) {
                        $flag          = '/storage/images/countries/flags/'
                            .mb_strtolower($item->code).'.png';

                        $insertItems[] = [
                            'id'         => $item->id,
                            'name'       => ! empty($item->name) === true
                                ? $item->name : '',
                            'code'       => ! empty($item->code) === true
                                ? $item->code : '',
                            'flag'       => ! empty($item->code) === true
                                ? $flag : null,
                            'created_at' => Carbon::now(),
                        ];
                    }
                    DB::table("countries")->insert($insertItems);
                } catch (\Exception $e) {
                    dd($e, $item);
                }
            });
        /**
         * Enable forKeys
         */
        Schema::table('countries', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();
        });
    }

}
