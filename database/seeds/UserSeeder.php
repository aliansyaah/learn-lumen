<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UserTableSeeder');
        DB::table('users')->delete();

        // User 1
        $item = app()->make('App\User');
        $hasher = app()->make('hash');
        $password = $hasher->make('password');  // bikin password dgn kata "password"
        
        $api_token = sha1(time());
        $item->fill([
            'username' => 'Aliansyah',
            'email' => 'aliansyah@gmail.com',
            'password' => $password,
            'api_token' => $api_token
        ]);
        $item->save();
        
        // User 2
        $item = app()->make('App\User');
        $hasher = app()->make('hash');
        $password = $hasher->make('password');  // bikin password dgn kata "password"
        
        $api_token = sha1(time());
        $item->fill([
            'username' => 'Ahmad Rosid',
            'email' => 'ocittwo@gmail.com',
            'password' => $password,
            'api_token' => $api_token
        ]);
        $item->save();
    }
}
