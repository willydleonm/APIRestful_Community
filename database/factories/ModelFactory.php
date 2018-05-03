<?php

use App\User;


/** @var \Illuminate\Database\Eloquent\Factory $factory */
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
    ];
});


$factory->define(Course::class, function (Faker\Generator $faker) {
    
    return [
        'course_name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(Profile::class, function (Faker\Generator $faker) {
    
    return [
        'birth_date' => $faker->date($format = 'd-m-Y', $max = 'now'),
        'email' => $faker->unique()->safeEmail,
        'photo' => $faker->randomElement(['1.icon_user.png','2.icon_user.png']),
    ];
});