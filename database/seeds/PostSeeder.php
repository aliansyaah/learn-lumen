<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UserTableSeeder');
        DB::table('posts')->delete();
        $post = app()->make('App\Post');
        $post->fill(['user_id' => 1, 'title' => 'Holiday in Bali', 'body' => 'This is body']);
        $post->save();
    }
}
