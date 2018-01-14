<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create();
        User::create([
            'name' => 'iksz',
            'email' => 'iksz@mail.com',
            'password' => app('hash')->make('12345'),
            'role' => 'admin',
            'active' => 1,
        ]);
    }
}
