<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    public function index(){
        return view('admin.quotes.index');     
    }
    public function create(){
        return view('admin.quotes.create');     
    }

    public function pdf(Quote $quote){
        $pdf = Pdf::loadview('admin.quotes.pdf',[
            'model' => $quote,
        ]);

        return $pdf->download("Cotizacion_{$quote->id}.pdf");
    }
}
