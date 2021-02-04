<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\User;

class PostController extends Controller
{

    /**
     * Create a new auth instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Get list post by user id
     * Url : /read-post/{id}
     */
    public function read(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        // echo '<pre>';
        // print_r($user->posts()->get());die;
        // dd($user->posts());     // dd means dump and die

        if ($user !== null) {
            // Get user data with their posts
            // $posts = User::where('id', $id)->with('posts')->get()->toArray();

            // Raw / manual query methods
            // $posts = DB::select("
            //     select posts.id, posts.user_id, posts.title, posts.body, posts.created_at, 
            //     posts.updated_at, users.username, users.email
            //     from posts
            //     left join users on users.id = posts.user_id
            //     where posts.user_id = ?
            // ", [$id]);

            $posts = $user->posts()->get();     // get all user's post
            // $posts = $user->posts()->get()->toArray();     // get all user's post to array
            // echo '<pre>';
            // print_r($posts);die;

            // If result post is not empty
            if(!$posts->isEmpty()){
            // if($posts){                  // check array is empty or not
                $res['success'] = true;
                $res['data'] = $posts;

                return response($res);
            }else{
                $res['success'] = false;
                $res['message'] = 'Post not found!';
                
                return response($res);
            }                
        }else{
            $res['success'] = false;
            $res['message'] = 'User not found!';
            
            return response($res);
        }
    }

    /**
     * Get one data Profile by phone number
     * Url : /read-profile/{phone}
     */
    public function readProfile(Request $request, $phone)
    {
        $profile = Profile::where('phone', $phone)->first();
        // echo '<pre>';
        // print_r($profile);die;
        if ($profile !== null) {
            $res['success'] = true;

            // profile belongs to user
            $res['data'] = [
                'username' => $profile->user->username,
                'email' => $profile->user->email,
                'phone' => $profile->phone,
                'address' => $profile->address
            ];
            
            return response($res);
        }else{
            $res['success'] = false;
            $res['message'] = 'Phone not found!';
            
            return response($res);
        }
    }

    /**
     * Insert database for post
     * Url : /create-post
     */
    public function create(Request $request)
    {
        // findOrFail akan melakukan pengecekan sekaligus jika user_id salah
        $user = User::findOrFail($request->input('user_id'));
        if($user){
            // Perbedaan dgn update adalah variabel $profile diisi instance dari model Profile
            $post = new Post([
                'title' => $request->input('title'),
                'body' => $request->input('body')
            ]);
            
            // Method save() must be instace of model Post
            if($user->posts()->save($post)){
                $res['success'] = true;
                $res['message'] = 'Success add new post!';
                
                return response($res, 201);
            }else{
                $res['success'] = false;
                $res['message'] = 'Failed add new post!';
                
                return response($res, 500);
            }
        }else{
            $res['success'] = false;
            $res['message'] = 'User ID not found!';
            
            return response($res, 404);
        }   
    }

    /**
     * Update data Profile by id
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            // echo '<pre>';
            // print_r($user);
            // print_r($request);die;

            // Perbedaan dgn create adalah variabel $profile diisi array dari request
            $profile = [
                'phone' => $request->input('phone'),
                'address' => $request->input('address')
            ];

            // Method update() must be the type of array, not object.
            if($user->profile()->update($profile)){
                $res['success'] = true;
                $res['message'] = 'Success update profile user';

                return response($res);
            }else{
                $res['success'] = false;
                $res['message'] = 'Failed update profile user';

                return response($res);
            }
        }else{
            $res['success'] = false;
            $res['result'] = 'User ID not found!';

            return response($res);
        }
    }

    /**
     * Delete data CategoryAds by id
     */
    /* public function delete(Request $request, $id)
    {
        $category = CategoryAds::find($id);
        if ($category->delete($id)) {
            $res['success'] = true;
            $res['result'] = 'Success delete category!';

            return response($res);
        }
    } */

}