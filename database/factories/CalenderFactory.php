<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Calender::class, function (Faker $faker) {
    $intStart = time() + (mt_rand(-21, 24) * 3600);
    static $arrColor = [
        'rgb(72, 176, 247)',
        'rgb(57, 204, 204)',
        'rgb(243, 156, 18)',
        'rgb(255, 133, 27)',
        'rgb(16, 207, 189)',
        'rgb(1, 255, 112)',
        'rgb(245, 87, 83)',
        'rgb(96, 92, 168)',
        'rgb(240, 18, 190)',
        'rgb(119, 119, 119)',
        'rgb(0, 31, 63)',
    ];

    $color = array_random($arrColor, 1);

    return [
        'title' => $faker->name,
        'desc' => mt_rand(10000, 99999).str_shuffle(implode('', range('A', 'Z'))),
        'status' => mt_rand(0, 5),
        'time_status' => mt_rand(1, 5),
        'admin_id' => mt_rand(1, 9999),
        'start' => date('Y-m-d H:i:s', $intStart),
        'end' =>  date('Y-m-d H:i:s',$intStart + (mt_rand(1, 31) * 24 * 3600)),
        'style' => json_encode([
            'backgroundColor' => $color[0],
            'borderColor' => $color[0],
        ], 320),
        'created_id' => 1,
        'updated_id' => 1,
    ];
});
