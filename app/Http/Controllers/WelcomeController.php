<?php namespace App\Http\Controllers;

use App\Marker;

class WelcomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */

    public function index()
    {
        $markers = Marker::all();
        return view('welcome')->with('markers', $markers);
    }


    public function addNewMarker($lat, $lng, $desc)
    {
        Marker::create(['latitude' => $lat, 'longitude' => $lng, 'description' => $desc]);
        return $this->getMarkers();
    }


    public function removeMarker($id)
    {
        $marker = Marker::find($id);
        $marker->delete();
    }

    public function getMarkers()
    {
        $markers = Marker::all();
        return $markers;
    }


}
