<?php

use App\Post;
use App\User;
use App\Course;
use App\Comment;
use App\Profile;
use App\Favorite;
use App\Semester;


/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Semester::class, function (Faker\Generator $faker) {
    
    return [
        'semester' => $faker->word,
    ];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::verified_user, User::not_verified_user]),
        'verification_token' => $verified == User::verified_user ? null : User::generateToken(),
        'is_admin' => $faker->randomElement([User::admin_user, User::regular_user]),
        'semester_id' => Semester::all()->random()->id,
    ];
});

$factory->define(Course::class, function (Faker\Generator $faker) {
    
    return [
        'course_name' => $faker->word,
        'description' => $faker->paragraph(1),
        'semester_id' => Semester::all()->random()->id,
    ];
});

$factory->define(Profile::class, function (Faker\Generator $faker) {
    
    return [
        'birth_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'email' => $faker->unique()->safeEmail,
        'photo' => $faker->randomElement(['1.icon_user.png','2.icon_user.png']),
        'user_id' => User::all()->random()->id,
    ];
});

$factory->define(Post::class, function (Faker\Generator $faker) {
    
    return [
        'title' => $faker->word,
        'content' => $faker->paragraph(1),
        'created_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'edited_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'viewed' => $faker->randomDigit,
        'user_id' => User::all()->random()->id,
        'course_id' => Course::all()->random()->id,
    ];
});

$factory->define(Comment::class, function (Faker\Generator $faker) {
    
    return [
        'content' => $faker->paragraph(1),
        'date' => $faker->date($format = 'd-m-Y', $max = 'now'),
        'post_id' => Post::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];
});

$factory->define(Favorite::class, function (Faker\Generator $faker) {
    
    return [
        'added_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'post_id' => Post::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];
});