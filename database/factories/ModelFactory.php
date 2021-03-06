<?php

use App\Post;
use App\User;
use App\Photo;
use App\Course;
use App\Comment;
use App\Favorite;
use App\Semester;


/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Semester::class, function (Faker\Generator $faker) {
    
    return [
        'semester' => $faker->word,
    ];
});

$factory->define(Course::class, function (Faker\Generator $faker) {
    
    return [
        'course_name' => $faker->word,
        'code' => $faker->word,
        'credits' => $faker->numberBetween(4,6),
        'description' => $faker->paragraph(1),
        'required_course' => $faker->numberBetween(1,50),
        'required_credits' =>$faker->numberBetween(70,175),
        'semester_id' => Semester::all()->random()->id,
    ];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birth_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'email' => $faker->unique()->safeEmail,
        'photo' => $faker->randomElement(['1.icon_user.png','2.icon_user.png']),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::verified_user, User::not_verified_user]),
        'verification_token' => $verified == User::verified_user ? null : User::generateToken(),
        'is_admin' => $faker->randomElement([User::admin_user, User::regular_user]),
        'semester_id' => Semester::all()->random()->id,
    ];
});

$factory->define(Post::class, function (Faker\Generator $faker) {
    
    return [
        'title' => $faker->word,
        'content' => $faker->paragraph(1),
        'viewed' => $faker->randomDigit,
        'user_id' => User::all()->random()->id,
        'course_id' => Course::all()->random()->id,
    ];
});

$factory->define(Comment::class, function (Faker\Generator $faker) {
    
    return [
        'content' => $faker->paragraph(1),
        'post_id' => Post::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];
});

$factory->define(Favorite::class, function (Faker\Generator $faker) {
    
    return [
        'post_id' => Post::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];
});

$factory->define(Photo::class, function (Faker\Generator $faker) {
    
    return [
        'url_photo' => $faker->randomElement(['1.post.png','2.post.png']),
        'post_id' => Post::all()->random()->id,
    ];
});