<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function getAll(){
        $states = Departments::all();
        return response()->json($states);
    }

}
