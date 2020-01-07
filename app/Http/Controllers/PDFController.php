<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function pdfCartaRecomendacao($idUser = null)
    {
        $user = User::find($idUser);
        $pdf = PDF::loadView('pdf/cartaRecomendacao', compact('user'));

        return $pdf->download('Carta de Recomendação - '.$user->name.'.pdf');
    }
}
