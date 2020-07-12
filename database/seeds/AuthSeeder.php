<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $default_admin = [
            'user_id' => '1',
            'name' => 'Nishal',
            'email' => 'nishal.sehan@gmail.com',
            'password' => Hash::make('sha256','password'),
            'contact' => '+94779906450',
        ];

        $user = User::create($default_admin);

        $this->command->info("You have been Define Super Admin \n email - nishal.sehan@gmail.com \n Password - password");

    }
}
