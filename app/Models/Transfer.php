<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Warehouse;
use App\Models\Product;

class Transfer extends Model
{
    protected $fillable = [
        'serie',
        'correlative',
        'date',
        'total',
        'observation',
        'origin_warehouse_id',
        'destination_warehouse_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
    
    //Relacion uno a muchos inversa
    public function originWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'origin_warehouse_id');
    }

    //Relacion uno a muchos inversa
    public function destinationWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    //Relacion muchos a muchos polimórfica  , morphToMany:muchos a muchos
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')
        ->withPivot('quantity','price','subtotal')
        ->withTimestamps();   
    }

    //Relacion uno a muchos polimorfica
    public function inventories(){
        return $this->morphMany(Inventory::class, 'inventoryable');
    }
}
