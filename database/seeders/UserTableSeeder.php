<?php

namespace Database\Seeders;

use App\Models\User;
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
        //
        User::insert([
            [
                'name'=>'Mr.Admin',
                'email'=>'admin@admin.com',
                'password'=>bcrypt('password'),
                'created_at'      => date("Y-m-d H:i:s"),
                'updated_at'      => date("Y-m-d H:i:s"),
            ],
            [
                'name'=>'Mr.Editor',
                'email'=>'editor@editor.com',
                'password'=>bcrypt('password'),
                'created_at'      => date("Y-m-d H:i:s"),
                'updated_at'      => date("Y-m-d H:i:s"),
            ],
            [
                'name'=>'Mr.Manager',
                'email'=>'manager@manager.com',
                'password'=>bcrypt('password'),
                'created_at'      => date("Y-m-d H:i:s"),
                'updated_at'      => date("Y-m-d H:i:s"),
            ],
            [
                'name'=>'Mr.Driver',
                'email'=>'driver@driver.com',
                'password'=>bcrypt('password'),
                'created_at'      => date("Y-m-d H:i:s"),
                'updated_at'      => date("Y-m-d H:i:s"),
            ]


        ]);
    }
}
