<?php
use App\Models\Role;

/**
 * Class RolesTableSeeder
 *
 * @package \\${NAMESPACE}
 */
class RolesTableSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'referent']);
        Role::create(['name' => 'enrollment_service']);
        Role::create(['name' => 'student']);
    }
}
