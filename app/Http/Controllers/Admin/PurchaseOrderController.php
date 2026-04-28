<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseOrderController extends Controller
{
    public function index(){
        return view('admin.purchase_orders.index');     
    }
    public function create(){
        return view('admin.purchase_orders.create');     
    }

    public function pdf(PurchaseOrder $purchaseOrder){
        $pdf = Pdf::loadview('admin.purchase_orders.pdf',[
            'model' => $purchaseOrder,
        ]);
        return $pdf->download("Orden_de_compra_{$purchaseOrder->id}.pdf");
    }
}
