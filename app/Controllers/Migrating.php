<?php

namespace App\Controllers;

use App\Database\Seeds;

class Migrating extends BaseController
{
    public function index() {
        $migrate = \Config\Services::migrations();
        $seeder = \Config\Database::seeder();

        try
        {
          if($migrate->latest())
          {
            $seeder->call('PermissionSeeder');
            $seeder->call('RoleSeeder');
            $seeder->call('UserSeeder');
            die('success');
          }
        }
        catch (\Exception $e)
        {
          die("error in migrations");
        }
    }
}