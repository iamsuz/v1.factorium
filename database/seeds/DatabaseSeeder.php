<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RolesTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        // $user = ['first_name' => 'Greg','last_name'=>'Rips', 'email' => 'gregrips@gmail.com','password' => bcrypt('gregor75'), 'phone_number'=>'435891944', 'active'=>1];
        // $db = DB::table('users')->insert($user);
        Model::reguard();
    }
}
