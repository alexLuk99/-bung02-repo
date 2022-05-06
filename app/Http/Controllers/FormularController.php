<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Request;
use Storage;
 
class FormularController extends Controller
{

    public function index(){
        return view('index');
    }

    public function getData(){
        $klausurDatum  = Request::input('klausurDatum');
        $klausurName  = Request::input('klausurName');
        $radioVal = Request::input("radioBtn");
        $zeiten = json_decode(file_get_contents(storage_path() . "/vorlesungszeiten.json"), true);

        return view('index',[
            'klausurDatum' => $klausurDatum,
            'klausurName' => $klausurName,
            'radioBtn' => $radioVal,
            'zeiten' => $zeiten
            ]);
    }
}
