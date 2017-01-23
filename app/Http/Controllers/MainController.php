<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Redirect;
use Response;
use View;

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
    public function buscar(Request $request){
        $id = Auth::user()->id;
        $usuarios = Contact::where(function($query) use ($request){
                        $query->where('first_name', 'like', '%' . $request->input('nombre') . '%')
                        ->orWhere('last_name', 'like', '%' . $request->input('nombre') . '%')
                        ->orWhere('email', 'like', '%' . $request->input('nombre') . '%')
                        ->orWhere('company', 'like', '%' . $request->input('nombre') . '%')
                        ->orWhere('phone', 'like', '%' . $request->input('nombre') . '%')
                        ;
                    })->where('user_id', $id)->get();

        $html = View::make('table')->with("usuarios",$usuarios)->render();
        return response(["content" => $html], 200);
    }

    public function subirTemp(Request $request){
        if (Input::hasFile('image'))
        {
            $imagename = 'tmp';
            $file = $request->file('image');
            $file->move('images/tmp', $imagename);
            return response(["image" => "ok"], 200);

        } else {
            return response(["image" => "ko"], 500);
        }

    }
    public function actualizarContacto(Request $request){
        $contact = Contact::find($request->input('id'));
        if(Input::hasFile('image')){
            
            $imagename = time();
            $file = $request->file('image');
            $file->move('images', $imagename);

            $contact->first_name = $request->input('txtUpFirstName');
            $contact->last_name = $request->input('txtUpLastName');
            $contact->email = $request->input('txtUpEmail');
            $contact->phone = $request->input('txtUpPhone');
            $contact->company = $request->input('txtUpComany');
            $contact->image = $imagename;
            $contact->save();

            $contact = Contact::find($request->input('id'));

            return Response::json($contact);

        } else {
            //Actualizar sin imagen
            $contact->first_name = $request->input('txtUpFirstName');
            $contact->last_name = $request->input('txtUpLastName');
            $contact->email = $request->input('txtUpEmail');
            $contact->phone = $request->input('txtUpPhone');
            $contact->company = $request->input('txtUpComany');
            $contact->save();

            $contact = Contact::find($request->input('id'));

            return Response::json($contact);

        }
    }

}

