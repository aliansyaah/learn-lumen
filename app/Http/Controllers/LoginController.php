<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /**
     * Index login controller
     * 
     * Dengan controller ini kita akan memberikan token kepada user yang akan digunakan
     * sebagai permission untuk mengakses seluruh aktifitas di dalam API ini.
     * When user success login will retrive callback as api_token
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $hasher = app()->make('hash');

        $email = $request->input('email');
        $password = $request->input('password');

        // Cek email
        $login = User::where('email', $email)->first();
        if (!$login) {
            $res['success'] = false;
            // $res['message'] = 'Your email or password incorrect!';
            $res['message'] = 'Your email is not found!';

            return response($res);
        }else{
            // Compare password dgn password di DB
            if ($hasher->check($password, $login->password)) {
                $api_token = sha1(time());      // bikin token

                // token di-update ke tabel user
                $create_token = User::where('id', $login->id)->update(['api_token' => $api_token]);
                if ($create_token) {
                    $res['success'] = true;
                    $res['api_token'] = $api_token;
                    $res['message'] = $login;

                    return response($res);
                }
            }else{
                $res['success'] = false;
                $res['message'] = 'Your email or password incorrect!';

                return response($res);
            }
        }
    }
    
}
