<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
  public function run()
  {
    $role_employee = new Role();
    $role_employee->name = 'Operator';
    $role_employee->description = 'Call center operator';
    $role_employee->save();
    $role_manager = new Role();
    $role_manager->name = 'manager';
    $role_manager->description = 'Call center manager';
    $role_manager->save();
    $role_manager = new Role();
    $role_admin->name = 'admin';
    $role_admin->description = 'admin';
    $role_admin->save();
  }
}