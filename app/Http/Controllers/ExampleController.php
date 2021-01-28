<?php

namespace App\Http\Controllers;

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
}
