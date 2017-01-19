<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Contact;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Response;

class MainController extends Controller
{
     public function show()
    {
       if (Auth::check()) {
            $id = Auth::user()->id;
            $data['usuarios'] = Contact::where('user_id', $id)->get();
            
            return view("home", $data);
       }else{
            return Redirect::to('login');
       }       
       
    }
    public function store(Request $request){

        $contact = Contact::create($request->all());
        
    
        return Response::json($contact);
    }

    public function getContact(Request $request){
        $contact = Contact::find($request->input('id'));
        return $contact->toJson();
    }

    public function update(Request $request){
        $contact = Contact::find($request->input('id'));

        $contact->first_name = $request->input('first_name');
        $contact->last_name = $request->input('last_name');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        $contact->company = $request->input('company');
        $contact->image = $request->input('image');

        $contact->save();

        $contact = Contact::find($request->input('id'));

        return Response::json($contact);

    }

    public function delete(Request $request){
        Contact::destroy($request->input('id'));
        return response(["status" => "ok"], 200);
    }
}
