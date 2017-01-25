<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use View;

class GmapsController extends Controller
{
    public function index()
    {
        //configuaración
        $config = array();
        $config['center'] = '15.5, -90.25';
        $config['map_width'] = 600;
        $config['map_height'] = 400;
        $config['zoom'] = 6;
        $config['onboundschanged'] = 'if (!centreGot) {
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new google.maps.LatLng(15.5, -90.25)

            });
        }
        centreGot = true;';

        \Gmaps::initialize($config);

        $marker = array();
        \Gmaps::add_marker($marker);

        $map = \Gmaps::create_map();


        //$html = View::make('modalmap')->with('map', compact('map'))->render();
        //
        return view('modalmap', compact('map'));
        //return response(["content" => $html], 200);
    }
}
