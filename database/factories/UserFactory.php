<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
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

$factory->define(User::class, function (Faker $faker) {
   $departments= App\Models\Department::pluck('idDepartment')->toArray();
   $roles = App\Models\Role::pluck('idRole')->toArray();
    return [
        'name' => $faker->firstName,
        //'lastname' => $faker->lastName,
        'username' => $faker->unique()->word,
        'email' => $faker->unique()->safeEmail,
        //'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'extension' => $faker->phoneNumber,
        'status' => $faker->boolean,
        'remember_token' => Str::random(20),
        'idRole' => $faker->randomElement($roles),
        'idDepartment' => $faker->randomElement($departments),
    ];
});
