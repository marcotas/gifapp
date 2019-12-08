<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        create(User::class, [
            'name'     => 'Marco Túlio',
            'password' => bcrypt('123456'),
            'email'    => 'marco@mail.com',
        ]);
    }
}
