<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->password = 'A1234567';
        $user->name = 'Test User Login';
        $user->email = 'user@laravel6baseproject.com';
        $user->save();
    }
}
