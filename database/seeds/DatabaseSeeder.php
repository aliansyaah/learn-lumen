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
        // $this->call('UserTableSeeder');
        $this->call('UserSeeder');
        $this->call('CategoryAdsSeeder');
        $this->call('ItemAdsSeeder');
        $this->call('PostSeeder');
    }
}
