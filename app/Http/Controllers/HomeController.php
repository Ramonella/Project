<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Contact;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChatController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $data['usuarios'] = Contact::where('user_id', $id)->get();

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://restcountries.eu/rest/v1/all"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch); 
        $data['countries'] = json_decode($output, true);
        $data['unseen_messages'] = ChatController::getUnseenMessages();
        return view("home", $data);
        
    }
}
