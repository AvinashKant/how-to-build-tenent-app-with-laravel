<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(Post::class, function (Faker $faker) {
	return [
		'user_name' => "1 database" . $faker->name,
		'user_post' => Str::random(10) . " -" . Str::random(20),
	];
});
