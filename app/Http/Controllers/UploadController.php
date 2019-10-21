<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function setFiles(Request $request){
        dd($request->all());
        return [];
    }
}
