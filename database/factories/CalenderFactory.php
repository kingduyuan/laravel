<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Models\Calendar::class, function (Faker $faker) {
    // 初始化定义
    $intStart = time() + (mt_rand(-21, 24) * 3600);
    $color = array_random(App\Models\Calendar::$arrColor, 1);

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
