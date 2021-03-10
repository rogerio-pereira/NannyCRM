<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Rogerio Pereira',
            'email' => 'rogerio@colmeiatecnologia.com.br',
            'password' => '$2y$10$mpA12rJ7jFSmv3h0CkFAHuW3xDEDXS1KyKQmLvRZJQeISWDt8qYYi'
        ]);
    }
}
