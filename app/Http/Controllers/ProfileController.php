<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;

class ProfileController extends Controller
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
     * Get all data from category
     */
    /* public function index(Request $request)
    {
        $category = new CategoryAds;

        $res['success'] = true;
        $res['result'] = $category->all();

        return response($res);
    } */

    /**
     * Get one data CategoryAds by id
     * Url : /category/{id}
     */
    public function read(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($user !== null) {
            $res['success'] = true;
            
            // user has one profile
            $res['data'] = [
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->profile->phone,
                'address' => $user->profile->address
            ];
            
            return response($res);
        }else{
            $res['success'] = false;
            $res['message'] = 'User not found!';
            
            return response($res);
        }
    }

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
     * Insert database for CategoryAds
     * Url : /category
     */
    public function create(Request $request)
    {
        $user = User::find($request->input('user_id'));
        if($user){
            // CARA 1
            /* $profile = new Profile;
            $profile->fill([
                'user_id' => $request->input('user_id'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address')
            ]);

            if($profile->save()){
                $res['success'] = true;
                $res['message'] = 'Success add new profile user!';
                
                return response($res);
            } else {
                $res['success'] = false;
                $res['message'] = 'Failed add new profile user!';
                
                return response($res);
            } */

            // CARA 2
            $profile = new Profile([
                'phone' => $request->input('phone'),
                'address' => $request->input('address')
            ]);

            if($user->profile()->save($profile)){
                $res['success'] = true;
                $res['message'] = 'Success add new profile user!';
                
                return response($res);
            }else{
                $res['success'] = false;
                $res['message'] = 'Failed add new profile user!';
                
                return response($res);
            }
        }else{
            $res['success'] = false;
            $res['message'] = 'User ID not found!';
            
            return response($res);
        }   
    }

    /**
     * Update data CategoryAds by id
     */
    /* public function update(Request $request, $id)
    {
        if ($request->has('name')) {
            $category = CategoryAds::find($id);
            $category->name = $request->input('name');
            if ($category->save()) {
                $res['success'] = true;
                $res['result'] = 'Success update '.$request->input('name');

                return response($res);
            }
        }else{
            $res['success'] = false;
            $res['result'] = 'Please fill name category!';

            return response($res);
        }
    } */

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