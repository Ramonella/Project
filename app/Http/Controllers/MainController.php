<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Redirect;
use Response;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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

    public function guardar(Request $request){
         if (Input::hasFile('image'))
        {
            $imagename = time();
            $file = $request->file('image');
            $file->move('images', $imagename);

            $contact = new Contact();
            $contact->first_name = $request->input('txtInputFirstName');
            $contact->last_name = $request->input('txtInputLastName');
            $contact->email = $request->input('txtInputEmail');
            $contact->phone = $request->input('txtInputPhone');
            $contact->company = $request->input('txtInputCompany');
            $contact->image = $imagename;
            $contact->user_id = Auth::user()->id;
            $contact->save();
            
            return $contact->toJson();
            
        } else {

            return response(["resp" => "Sin imagen" ], 500);
        }
         
    }

}

