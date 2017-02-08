<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Contact;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\File;
use Redirect;
use Response;
use View;
use Storage;


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
           
            /*$ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, "https://restcountries.eu/rest/v1/all"); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $output = curl_exec($ch); 
            curl_close($ch); */
            $output = $this->readConuntries();
            
            $data['countries'] = json_decode($output, true);
            $data['unseen_messages'] = ChatController::getUnseenMessages();
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
    public function getUser(Request $request){
        $user = User::find($request->input('id'));
        return $user->toJson();
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

            $countycode = $request->input('slt-code');
            $countryname = $request->input('slt-countryname');
            $latlng_dump = $request->input('slt-latlng');

            
            try{
                $contact = new Contact();
                $contact->first_name = $request->input('txtInputFirstName');
                $contact->last_name = $request->input('txtInputLastName');
                $contact->email = $request->input('txtInputEmail');
                $contact->phone = $request->input('txtInputPhone');
                $contact->company = $request->input('txtInputCompany');
                $contact->image = $imagename;
                $contact->country_code = $countycode;
                $contact->country_name = $countryname;
                $contact->latlng = $latlng_dump;
                $contact->user_id = Auth::user()->id;
                $contact->save();
                return $contact->toJson();

            } catch(\Illuminate\Database\QueryException $e){
                return response(["resp" => "The email already associated to other contact!" ], 200);
            }
            
            
        } else {

            return response(["resp" => "Please attach image!" ], 200);
        }
         
    }
    public function buscar(Request $request){
        $id = Auth::user()->id;
        $searchValues = preg_split('/\s+/', $request->input('nombre'), -1, PREG_SPLIT_NO_EMPTY);
        $usuarios = Contact::where(function($query) use ($request, $searchValues){
                        $query
                        ->where(function($q) use ($searchValues){
                            foreach ($searchValues as $value) {
                                $q 
                                -> where('first_name', 'like', '%' . $value . '%')
                                -> orWhere('last_name', 'like', '%' . $value . '%')
                                ;
                            }
                        })
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
            $contact->company = $request->input('txtUpCompany');
            $contact->image = $imagename;
            $contact->save();

            $contact = Contact::find($request->input('id'));

            return $contact->toJson();

        } else {
            //Actualizar sin imagen
            $contact->first_name = $request->input('txtUpFirstName');
            $contact->last_name = $request->input('txtUpLastName');
            $contact->email = $request->input('txtUpEmail');
            $contact->phone = $request->input('txtUpPhone');
            $contact->company = $request->input('txtUpCompany');
            $contact->save();

            $contact = Contact::find($request->input('id'));

            return $contact->toJson();

        }
    }
    public function getUserId(Request $request){
        $user = User::where('email', $request->input('email'))->get()->first();
        
        return $user->id;

    }
    public function readConuntries(){

        return File::get(storage_path('all.json'));
    }

    public function isContact(Request $request){
        $id = Auth::user()->id;
        $id_sender = $request->input('id_sender');

        $result = Contact::where('id', $id_sender)
                         ->where('user_id', $id)
                         ->get();
        $count = $result->count();
        if($count > 0){
            return 1;
        } else {
            return 0;
        }
    }

}

