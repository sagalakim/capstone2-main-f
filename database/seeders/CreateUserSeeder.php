<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //RUN: php artisan db:seed --class=CreateUserSeeder

    //CREATE Area of Assignment Data first
    public function run()
    {
        $users = [
            [
                'firstname' => 'Sales',
                'lastname' => 'Agent',
                'phone' => '09090090009',
                'email' => 'salesagent@test.com',
                'password' => bcrypt('salesagent'),
                'role' => 0,
                'area_id' => 1,
            ],
            [
                'firstname' => 'regional',
                'lastname' => 'salesmanager',
                'phone' => '09090090009',
                'email' => 'regional@test.com',
                'password' => bcrypt('regionalm'),
                'role' => 1,
                'area_id' => 1,
            ],
            [
                'firstname' => 'area',
                'lastname' => 'salesmanager',
                'phone' => '09090090009',
                'email' => 'area@test.com',
                'password' => bcrypt('aream'),
                'role' => 2,
                'area_id' => 1,
            ],
            [
                'firstname' => 'national',
                'lastname' => 'salesmanagerNonlife',
                'phone' => '09090090009',
                'email' => 'nationalnonlife@test.com',
                'password' => bcrypt('nationalnl'),
                'role' => 3,
                'area_id' => 1,
            ],
            [
                'firstname' => 'national',
                'lastname' => 'salesmanagerForlife',
                'phone' => '09090090009',
                'email' => 'nationallife@test.com',
                'password' => bcrypt('nationalfl'),
                'role' => 4,
                'area_id' => 1,
            ],
            [
                'firstname' => 'executive',
                'lastname' => 'assistant',
                'phone' => '09090090009',
                'email' => 'executiveassistant@test.com',
                'password' => bcrypt('executiveassistant'),
                'role' => 5,
                'area_id' => 1,
            ],
            [
                'firstname' => 'general',
                'lastname' => 'admin',
                'phone' => '09090090009',
                'email' => 'generaladmin@test.com',
                'password' => bcrypt('generaladmin'),
                'role' => 6,
                'area_id' => 1,
            ],
        ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
