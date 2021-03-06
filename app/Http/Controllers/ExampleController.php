<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    // Import namespace class Request
use Illuminate\Http\Response;
use Validator;

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

    public function response(){
        $data['status'] = 'Success';

        // Cara 1, dgn memanggil class Response
        return (new Response($data, 201))
            ->header('Content-Type', 'application/json');

        // Cara 2, dgn memakai helper response
        // return response($data, 201);
        /* Helper response mempunyai 3 parameter
            1. Content
            2. HTTP status
            3. Array headers
         */
        
        // Cara 3, langsung menentukan response type json
        // return response()->json([
        //     'message' => 'Failed! Not found!',
        //     'status' => false
        // ], 404);
    }

    public function responsePost(Request $request){
        // Normal validation
        // $this->validate($request, [
        //     'name' => 'required|max:10',
        //     'email' => 'required|email'
        // ]);

        // Custom response validation
        $validasi = Validator::make($request->all(), [
            'name' => 'required|max:10',
            'email' => 'required|email'
        ]);

        if($validasi->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validasi->errors()
            ], 401);
        }

        $name = $request->input('name');
        $email = $request->input('email');

        $data['status'] = 'success';
        $data['data'] = [
            'name' => $name,
            'email' => $email
        ];
        return response($data, 200);
    }

    // Custom validation messages
    public function responsePost2(Request $request){
        // Define validation messages
        $messages = [
            'required' => 'Kolom tidak boleh kosong',
            'email.required' => 'Kolom email tidak boleh kosong',
            'email.email' => 'Email harus berupa alamat email valid'
        ];

        // Custom response validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10',
            'email' => 'required|email'
        ], $messages);

        if($validator->fails()){
            // $messages = $validasi->errors();
            // echo $messages->first('email');
            // foreach($messages->all('<li>:message</li>') as $message){
            //     echo $message;
            // }
            // die;

            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors()
            ], 401);
        }

        $name = $request->input('name');
        $email = $request->input('email');

        $data['status'] = 'success';
        $data['data'] = [
            'name' => $name,
            'email' => $email
        ];
        return response($data, 200);
    }
}
