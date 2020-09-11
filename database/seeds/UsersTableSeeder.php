<?php

use Illuminate\Database\Seeder;
use App\Entities\Admin\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //User::truncate();


        factory(User::class, 100)->create();
    }
}
/**
 'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'username' => $faker->word,
        'email' => $faker->unique()->safeEmail,
        //'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
 **/
