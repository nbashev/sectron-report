<?php

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
        factory(App\User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@zkta.com',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);
        factory(App\User::class)->create([
            'name' => 'Јосип Режак',
            'email' => 'support@sectron.mk',
            'username' => 'josip',
            'password' => bcrypt('support'),
            'remember_token' => str_random(10),
        ]);
        factory(App\User::class, 4)->create();
    }
}
