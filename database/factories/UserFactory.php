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
/*
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedTinyInteger('idTypeU')->nullable();
            $table->unsignedBigInteger('idDepartment')->nullable();
*/
$factory->define(User::class, function (Faker $faker) {
   $departments= App\Models\Department::pluck('idDepartment')->toArray();
   $typeusers = App\Models\Typesu::pluck('idTypeU')->toArray();
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'username' => $faker->word,
        'email' => $faker->unique()->safeEmail,
        //'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(20),
        'idTypeU' => $faker->randomElement($typeusers),
        'idDepartment' => $faker->randomElement($departments),
    ];
});
