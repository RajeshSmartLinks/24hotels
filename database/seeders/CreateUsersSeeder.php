<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Super Admin',
               'email'=>'rajesh@smartlinks.com',
                'back_end_user'=>1,
               'password'=> bcrypt('Rajesh@123'),
            ],
            [
                'name'=>'Rajesh Vuppala frontEnd',
                'email'=>'vuppalaRajesh961@gmail.com',
                 'back_end_user'=>0,
                'password'=> bcrypt('Rajesh@123'),
             ],
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
