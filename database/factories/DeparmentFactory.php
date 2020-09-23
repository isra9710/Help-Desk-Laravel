<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Department;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        //
        'departmentName' => 'Informática',
    ];
});
