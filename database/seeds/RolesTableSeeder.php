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
        Role::updateOrCreate(['role'=>'admin'],['role'=>'admin', 'description'=>'Administrator']);
        Role::updateOrCreate(['role'=>'developer'],['role'=>'developer', 'description'=>'Person who has project']);
        Role::updateOrCreate(['role'=>'investor'],['role'=>'investor', 'description'=>'Almost Every user is investor']);
        Role::updateOrCreate(['role'=>'superadmin'],['role'=>'superadmin', 'description'=>'Superadmin for wensite Configuration']);        
        Role::updateOrCreate(['role'=>'master'],['role'=>'master', 'description'=>'This user will be admin for all the sub domains']);
    }
}
