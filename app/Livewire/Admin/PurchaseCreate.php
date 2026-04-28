<?php

namespace App\Livewire\Admin;

use App\Facades\Kardex;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Purchase;
use App\Models\Inventory;

use App\Services\KardexService;

use Livewire\Component;

class PurchaseCreate extends Component
{
    public $voucher_type = 1;
    
    public $serie;
    
    public $correlative;
    
    public $date;
    
    public $purchase_order_id;
    
    public $supplier_id;
    
    public $warehouse_id;
    
    public $total = 0;
    
    public $observation;
    
    public $product_id;
    
    public $products=[];

    public function boot(){
        //verificar si hay errores de validacion previos
        $this->withValidator(function($validator){
            if($validator->fails()){
                $errors = $validator->errors()->toArray();

                $html = "<ul class='text-left'>";

                foreach ($errors as $error) {
                    $html .= "<li>{$error[0]}</li>";
                }

                $html .= "</ul>";

                $this->dispatch('swal',[
                'icon' => 'error',
                'title' => 'Error de validacion',
                'html' =>  $html,
            ]);
            };
        });
    }

    //se va a ejecutar cuando el componente haya sido renderizado
    //mount calcula el correlativo

    // public function mount(){
    //     $this->correlative = PurchaseOrder::max('correlative')+1;
    // }

    public function updated($property, $value){
        if ($property == 'purchase_order_id') {
            
            $purchaseOrder = PurchaseOrder::find($value);

            if ($purchaseOrder) {

                $this->voucher_type = $purchaseOrder->voucher_type;
                $this->supplier_id = $purchaseOrder->supplier_id;
                
                //en las propiedades se almacena array no colecciones
                $this->products = $purchaseOrder->products->map(function($product){
                    return[
                        'id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $product->pivot->quantity,
                        'price' => $product->pivot->price,
                        'subtotal' => $product->pivot->subtotal,
                    ];
                })->toArray();
            }
        }
    }
   

    public function addProduct(){
        $this->validate([
            'product_id'=> 'required|exists:products,id',
            'warehouse_id'=> 'required|exists:warehouses,id',
        ],[],[
            'product_id'=> 'producto',
            'warehouse_id'=> 'almacén',
        ]);

        $existing=collect($this->products)->firstWhere('id',$this->product_id);

        if($existing){
            $this->dispatch('swal',[
                'icon' => 'warning',
                'title' => 'Producto ya agregado',
                'text' =>  'El producto ya se encuentra en la lista',
            ]);
            return; 
        }        

        $product= Product::find($this->product_id);

        $lastRecord = Kardex::getLastRecord($product->id,$this->warehouse_id);

        $this->products[]=[
            'id'=> $product->id,
            'name'=> $product->name,
            'quantity'=> 1,
            // 'price'=> $lastRecord['cost'],
            // 'subtotal'=> $lastRecord['cost'],  
            'price'    => null,       // <-- EL USUARIO DEBE INGRESAR EL PRECIO
        'subtotal' => 0,         
            
        ];

        $this->reset('product_id');
    }
    
    public function save(){

        $this->validate([
            'voucher_type' =>'required|in:1,2',
            'serie' =>'required|string|max:10',
            'correlative' =>'required|string|max:10',
            'date'=> 'required|nullable|date',
            'purchase_order_id' => 'nullable|exists:purchase_orders,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1', 
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'voucher_type' =>'tipo de comprobante',
            'supplier_id' => 'proveedor',
            'observation' => 'observación',
            'products.*.id' => 'producto',
            'products.*.quantity' => 'cantidad',
            'products.*.price' => 'precio',
        ]);

        $purchase = Purchase::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'purchase_order_id' =>$this->purchase_order_id,
            'supplier_id' => $this->supplier_id,
            'warehouse_id' =>$this->warehouse_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        foreach($this->products as $product){
            $purchase->products()->attach($product['id'],
            [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            //para usar los serivicios debemos instanciarlos, haremos la inyeccion
            //Kardex
            Kardex::registerEntry($purchase, $product, $this->warehouse_id, 'Compra');
            
            // $lastRecord = Inventory::where('product_id',$product['id'])
            // ->where('warehouse_id',$this->warehouse_id)
            // ->latest('id')
            // ->first();

            // //$lastQuantityBalance =  $lastRecord ? $lastRecord->quantity_balance : 0 ;
            // $lastQuantityBalance =  $lastRecord?->quantity_balance ?? 0;
            // $lastTotalBalance =  $lastRecord?->total_balance ?? 0;

            // $newQuantityBalance = $lastQuantityBalance + $product['quantity'];
            // $newTotalBalance = $lastTotalBalance + ($product['quantity'] * $product['price']);
            // $newCostBalance = $newTotalBalance / $newQuantityBalance;

            // Inventory::Create([
            //     'detail' => 'Compra',
            //     'quantity_in' => $product['quantity'], 
            //     'cost_in' => $product['price'], 
            //     'total_in' => $product['subtotal'], 
            //     'quantity_balance' => $newQuantityBalance, 
            //     'cost_balance' => $newCostBalance, 
            //     'total_balance' => $newTotalBalance,
            //     'product_id' => $product['id'], 
            //     'warehouse_id' => $this->warehouse_id, 
            //     'inventoryable_id' => $purchase->id, 
            //     'inventoryable_type' => Purchase::class, 
            // ]);

            // $purchase->inventories()->create([
            //     'detail' => 'Compra',
            //     'quantity_in' => $product['quantity'], 
            //     'cost_in' => $product['price'], 
            //     'total_in' => $product['quantity'] * $product['price'], 
            //     'quantity_balance' => $newQuantityBalance, 
            //     'cost_balance' => $newCostBalance, 
            //     'total_balance' => $newTotalBalance,
            //     'product_id' => $product['id'], 
            //     'warehouse_id' => $this->warehouse_id, 
            // ]);
        }

        session()->flash('swal',[
            'icon' => 'success',
            'title' => '!Bien hecho¡',
            'text' => 'La compra se ha creado exitosamente',
        ]);        
        return redirect()->route('admin.purchases.index');
    }

    public function render()
    {
        return view('livewire.admin.purchase-create');
    }
}
