<?php
use App\Models\Users;
use Faker\Generator as Faker;

$factory->define(Users::class, function (Faker $faker) {
    return [
        'username'=>$faker->username,
        'truename'=>$faker->name(),
        'password'=>bcrypt('123456'),
        'email'=>$faker->email,
        'mobile'=>$faker->phoneNumber,
        'gender'=>['先生','女士'][rand(0,1)],
    ];
});
