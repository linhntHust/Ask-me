<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-03-26
 * Time: 14:56
 */
use Faker\Generator as Faker;

$factory->define(App\Models\Question::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(15),
        'question_poll' => $faker->boolean,
        'details' => $faker->sentence(100),
        'user_id' => App\Models\User::all()->random()->id,
        'approve_status' => $faker->randomElement([0,1,2]),
        'category_id' => App\Models\Category::all()->random()->id,
        'filename' => $faker->boolean(50) ? $faker->image($dir='public/upload/questions', $width=800, $height=480,null, false) : null,
        'is_solved' => $faker->boolean,
        'reports' => $faker->numberBetween(0,20),
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
    ];
});
