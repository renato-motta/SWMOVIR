<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\Warehouse;

class Inventory extends Model
{
    protected $fillable=[
        'detail',
        'quantity_in',
        'cost_in',
        'total_in',
        'quantity_out',
        'cost_out',
        'total_out',
        'quantity_balance',
        'cost_balance',
        'total_balance',
        'product_id',
        'warehouse_id',
        'inventoryable_id',
        'inventoryable_type',
    ];

    //Relacion uno a muchos inversa
    public function products(){
        return $this->belongsTo(Product::class);
    }

    //Relacion uno a muchos inversa
    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    //relacion polimórfica
    public function inventoryable(){
        return $this->morphTo();
    }
}
