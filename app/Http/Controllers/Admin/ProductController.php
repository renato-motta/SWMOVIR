<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $data = $request->validate([
            'name'=> 'required|string|max:255',
            'description'=> 'nullable|string',
            'price'=>'required|numeric|min:0.01',
            'category_id'=>'required|exists:categories,id',
        ],
        [
            'price.min' => 'El precio debe ser mayor o igual a 0.01.',
            // 'price.numeric' => 'El precio debe ser un número válido.',
        ]);

        $product = Product::create($data); 
        
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '!!Bien hecho!!',
            'text' =>  'El producto se ha creado correctamente'
        ]);
        
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Product $product)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'=> 'required|string|max:255',
            'description'=> 'nullable|string',
            'price'=>'required|numeric|min:0.01',
            'category_id'=>'required|exists:categories,id',
            
        ],[
            'price.min' => 'El precio debe ser mayor o igual a 0.01',
            // 'price.numeric' => 'El precio debe ser un número válido.',
        ]);

        $product->update($data); 
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '!!Bien hecho!!',
            'text' =>  'El producto se ha actualizado correctamente'
        ]);
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->inventories()->exists()){
            session()->flash('swal', [
            'icon' => 'error',
            'title' => '¡¡Error!!',
            'text' =>  'No se puede eliminar el producto porque tiene inventarios asociados'
        ]);
            return redirect()->route('admin.products.index', $product);    
        }  

        if($product->purchaseOrders()->exists() || $product->quotes()->exists() ){
            session()->flash('swal', [
            'icon' => 'error',
            'title' => '¡¡Error!!',
            'text' =>  'No se puede eliminar el producto porque tiene ordenes de compra o cotizaciones asociadas'
        ]);
            return redirect()->route('admin.products.index', $product);    
        }

        $product->delete();
        
        session()->flash('swal',[
            'icon' => 'success',
            'title' => '¡¡Bien hecho!!',
            'text' =>  'El producto se ha eliminado correctamente'
        ]);
        return redirect()->route('admin.products.index', $product);    
    }

   // este metodo recibe dos cosas : lo q se esta enviando en el form las imagenes, recibe el parametro de la url
    public function dropzone(Request $request, Product $product){

        $image = $product->images()->create([
            'path' => Storage::put('/images', $request->file('file')),
            'size' => $request->file('file')->getSize(),
        ]);
        
        return response()->json([
            'id' => $image->id,
            'path' => $image->path,
        ]);
    }

    public function kardex(Product $product){
        return view('admin.products.kardex', compact('product'));
    }

    public function import(){
        return view('admin.products.import');
    }
}
