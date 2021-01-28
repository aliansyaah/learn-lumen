<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoryAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UserTableSeeder');
        DB::table('category_ads')->delete();
        $category = app()->make('App\CategoryAds');
        $category->fill(['name' => 'Komputer & Gadget']);
        $category->save();
        
        $category = app()->make('App\CategoryAds');
        $category->fill(['name' => 'Kesehatan']);
        $category->save();
    }
}
