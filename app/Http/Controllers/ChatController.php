<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Redirect;
use Response;
use View;
use Storage;

class ChatController extends Controller
{
    public function setMessages(Request $request){
        $redis = Redis::connection();

    	$array = json_decode( $request->input('datos'), true);
    	while ($val = current($array)) {
    		
    		$redis->set(key($array), json_encode($val));
    		next($array);
		}


        return "fin";
    }
    public function getMessages(Request $request){
        return "null";
    }
}
