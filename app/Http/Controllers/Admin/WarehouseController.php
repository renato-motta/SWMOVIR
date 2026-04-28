<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.warehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->all(); 
        
        $data= $request->validate([ 
            'name'=> 'required|string|max:255',
            'location'=>'required|string|max:255',
        ]);
        
        $warehouse = warehouse::create($data);

        session()->flash('swal',[
            'icon' => 'success',
            'title' => '!!Bien hecho!!',
            'text' =>  'El Almacén ha sido creado correctamente'
        ]);

        return redirect()->route('admin.warehouses.index', $warehouse);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(warehouse $warehouse)
    {
        return view('admin.warehouses.edit', compact('warehouse'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, warehouse $warehouse)
    {
         $data= $request->validate([ 
            'name'=> 'required|string|max:255',
            'location'=>'required|string|max:255',
        ]);
        
        $warehouse->update($data);

        session()->flash('swal',[
            'icon' => 'success',
            'title' => '!!Bien hecho!!',
            'text' =>  'El Almacén ha sido actualizado correctamente'
        ]);

        return redirect()->route('admin.warehouses.index', $warehouse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(warehouse $warehouse)
    {
        if($warehouse->inventories()->exists()){
            session()->flash('swal',[
                'icon' => 'error',
                'title' => '¡¡Error!!',
                'text' =>  'No se puede eliminar el almacén porque tiene inventarios asociados.',
            ]);
            return redirect()->route('admin.warehouses.index');
        }
        
        $warehouse->delete();

        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡¡Bien hecho!!',
            'text' =>  'El almacen se ha eliminado correctamente'
        ]);
        return redirect()->route('admin.warehouses.index');
    }

    public function import(){
        return view('admin.warehouses.import');
    }
}
