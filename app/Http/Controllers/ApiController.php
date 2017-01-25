<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    //getAllCountries
    public function getAllCountries(){
    	$ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://restcountries.eu/rest/v1/all"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch); 
        return $output; 
    }
}
