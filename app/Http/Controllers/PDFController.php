<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitante;
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

    public function pdfCartaBoasVindas($idUser){
        $user = Visitante::find($idUser);
        $pdf = PDF::loadView('pdf/cartaBoasVindas', compact('user'));

        return $pdf->download($user->nome.'-CartaBoasVindas.pdf');
    }
}
