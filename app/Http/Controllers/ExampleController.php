<?php

namespace App\Http\Controllers;

// Import namespace class Request
use Illuminate\Http\Request;


class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /* Param "only" adalah opsi jika hanya ingin method tertentu saja yg harus 
            melewati middleware */
        // $this->middleware('age', ['only' => ['getSettingsPhoto']]);

        /* Param "except" adalah opsi jika seluruh method pada controller ingin diterapkan 
            middleware kecuali method yg di-except tersebut*/
        // $this->middleware('age', ['except' => ['getSettings']]);
    }

    public function getSettings() {
        return '<a href="'.route('settings.photo').'"> Go to Photo Settings </a>';
    }

    public function getSettingsPhoto() {
        return "
            <h1>Photo Setting</h1>
            <br>
            <a href='".route('settings')."'> Back to Settings </a>
        ";
    }

    // Type hint class Request
    public function fooBar(Request $request) {
        return "
            Menampilkan path: ".$request->path()."
            <br>
            Request method: ".$request->method()."
        ";
    }

    public function userProfile(Request $request) {
        // $user['name'] = $request->name;
        // $user['username'] = $request->username;
        // $user['email'] = $request->email;
        // $user['password'] = $request->password;

        // return $user;

        // Mengembalikan langsung semua request
        // return $request->all();

        // Memberikan default value jika request input kosong
        $user['name'] = $request->input('name', 'Nama Lengkap');
        $user['username'] = $request->input('username', 'Username');
        $user['email'] = $request->input('email', 'e-email');
        $user['password'] = $request->input('password', 'Password');

        return $user;

        // Untuk mengecek apakah pada request terdapat key name & email
        // if($request->has(['name', 'email'])) {
        //     return "Success";
        // }else{
        //     return "Failed";
        // }
    }
}
