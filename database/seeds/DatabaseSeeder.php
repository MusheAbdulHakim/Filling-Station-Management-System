<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(\Backpack\Settings\database\seeds\SettingsTableSeeder::class);

        $this->call(PermissionManagerTablesSeeder::class);
        $this->call(UsersTableSeeder::class);

        
    }
}
