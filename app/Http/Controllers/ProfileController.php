<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * Get one data User & Profile by id
     * Url : /read-user-profile/{id}
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
     * Insert database for Profile user
     * Url : /create-user-profile
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
            // Perbedaan dgn update adalah variabel $profile diisi instance dari model Profile
            $profile = new Profile([
                'phone' => $request->input('phone'),
                'address' => $request->input('address')
            ]);
            
            // Method save() must be instace of model Profile
            if($user->profile()->save($profile)){
                $res['success'] = true;
                $res['message'] = 'Success add new profile user!';
                
                return response($res, 201);
            }else{
                $res['success'] = false;
                $res['message'] = 'Failed add new profile user!';
                
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

    public function updateWTransStatus(Request $request, $id)
    {
        echo '<pre>';
        print_r($id);die;
        DB::transaction(function () {
            // Table 1
            DB::table('users')
                ->where('id', '2')
                ->update(['username' => 'edit username']);

            // Table 2
            DB::table('profiles')
                ->where('user_id', '2')
                ->update(['address' => 'jalan jalan']);
        });
        /* Jika transaksi gagal pada table 2, transaksi pada table 1 akan di-rollback
        */
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