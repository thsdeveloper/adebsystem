<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Neighborhood;
use App\Models\State;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function getStates(){
        $states = State::all();
        return response()->json($states);
    }

    public function getCities($ufState){
        $states = City::where('uf', $ufState)->get();
        return response()->json($states);
    }




}
