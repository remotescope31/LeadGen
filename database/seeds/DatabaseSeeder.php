<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
/////
         $sql = file_get_contents(database_path() . '/seeds/laravel_users_truncate.sql');
         DB::statement($sql);
         
         $sql = file_get_contents(database_path() . '/seeds/laravel_users.sql');
    	 DB::statement($sql);
//////
         $sql = file_get_contents(database_path() . '/seeds/laravel_regions_truncate.sql');
         DB::statement($sql);
         
         $sql = file_get_contents(database_path() . '/seeds/laravel_regions.sql');
         DB::statement($sql);
////
         $sql = file_get_contents(database_path() . '/seeds/laravel_city_truncate.sql');
         DB::statement($sql);

         $sql = file_get_contents(database_path() . '/seeds/laravel_city.sql');
         DB::statement($sql);


    }
}
