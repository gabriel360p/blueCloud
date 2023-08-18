<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
class userSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>"Gabriel Costa da Silva",
            'nickname'=>"huliJonas",
            'password'=>Hash::make('123123123'),
            'email'=>"gabrielmark210@gmail.com"
        ]);
    }
}
    