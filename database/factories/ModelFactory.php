<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => $faker->slug,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->email,
        'gender' => rand(0, 1) ? 'male' : 'female',
        'date_of_birth' => $faker->dateTimeBetween('-18 years', '+3 years'),
        'password' => bcrypt('qwerty'),
        'active' => 1,
        'activated_on' => $faker->dateTimeBetween('-3 months', '+3 months'),
    ];
});
