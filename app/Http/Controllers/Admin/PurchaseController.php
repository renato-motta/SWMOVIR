<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseController extends Controller
{
    public function index(){
        return view('admin.purchases.index');     
    }
    public function create(){
        return view('admin.purchases.create');
    }

    public function pdf(Purchase $purchase){
        $pdf = Pdf::loadview('admin.purchases.pdf',[
            'model' => $purchase,
        ]);

        return $pdf->download("compra_{$purchase->id}.pdf");
    }
}
