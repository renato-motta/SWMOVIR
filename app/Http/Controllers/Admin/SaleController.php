<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index(){
        return view('admin.sales.index');     
    }
    public function create(){
        return view('admin.sales.create');
    }

    public function pdf(Sale $sale){
        $pdf = Pdf::loadview('admin.sales.pdf',[
            'model' => $sale,
        ]);

        return $pdf->download("venta_{$sale->id}.pdf");
    }
}
