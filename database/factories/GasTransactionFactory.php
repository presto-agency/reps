<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GasTransaction;
use Faker\Generator as Faker;

$factory->define(GasTransaction::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'initializable_id' => 1,
        'initializable_type' => 'App\User',
        'incoming' => 25,
        'description' => 'Списание газов администратором'
    ];
});
