<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "contacts";

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'company', 'image', 'country_code', 'country_name',  'latlng', 'user_id'];
    public function user(){

    	$this->belongsTo('App\User');
    }

  

}
