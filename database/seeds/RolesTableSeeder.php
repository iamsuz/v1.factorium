<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['role'=>'admin', 'description'=>'Administrator']);
        Role::create(['role'=>'developer', 'description'=>'Person who has project']);
        Role::create(['role'=>'investor', 'description'=>'Almost Every user is investor']);
        Role::create(['role'=>'superadmin', 'description'=>'Superadmin for wensite Configuration']);        
    }
}
