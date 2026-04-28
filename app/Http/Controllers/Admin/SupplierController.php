<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Identity;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $identities = Identity::all();
        return view('admin.suppliers.create',compact('identities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'identity_id'=> 'required|exists:identities,id',
            'document_number'=> 'required|string|max:20|unique:suppliers,document_number',
            'name'=> 'required|string|max:255',
            'address'=>'nullable|string|max:255',
            'email'=> 'nullable|email|max:255',
            'phone'=> 'nullable|string|max:20',
        ]);
        
        $supplier = Supplier::create($data); 
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '!!Bien hecho!!',
            'text' =>  'El proveddor ha sido creado correctamente'
        ]);
        return redirect()->route('admin.suppliers.index', $supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $identities = Identity::all();
        return view('admin.suppliers.edit', compact('supplier','identities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'identity_id'=> 'required|exists:identities,id',
            'document_number'=> 'required|string|max:20|unique:suppliers,document_number,' . $supplier->id,
            'name'=> 'required|string|max:255',
            'address'=>'nullable|string|max:255',
            'email'=> 'nullable|email|max:255',
            'phone'=> 'nullable|numeric|max:20',
        ]);
        
        $supplier ->update($data); 
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '!!Bien hecho!!',
            'text' =>  'El proveedor se ha actualizado correctamente'
        ]);
        return redirect()->route('admin.suppliers.edit', $supplier);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if($supplier->purchaseOrders()->exists() || $supplier->purchase()->exists()){
            session()->flash('swal',[
            'icon' => 'error',
            'title' => '¡¡Error!!',
            'text' =>  'No se puede eliminar el proveedor porque tiene órdenes de compra o compras asociadas'
        ]);
            return redirect()->route('admin.suppliers.index', $supplier);    
        }

        $supplier->delete();
        
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡¡Bien hecho!!',
            'text' =>  'El proveedor se ha eliminado correctamente'
        ]);
            return redirect()->route('admin.suppliers.index', $supplier);    
    }

    public function import(){
        return view('admin.suppliers.import');
    }
}
