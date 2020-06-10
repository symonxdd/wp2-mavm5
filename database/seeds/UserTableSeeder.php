<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            'email' => 'test@user.com',
            'password' => 'test'
        ]);
        $user->save();
    }
}

/*
 * source: https://laravel.com/docs/7.x/seeding#running-seeders
 *
 * Wanneer er een nieuwe Seeder wordt gemaakt is dit nodig om uitgevoerd te worden:
 *
 * composer dump-autoload
 *
 * */
