<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Warehouse;
use App\Models\Reason;
use App\Models\Product;
use App\Models\Inventory;

class Movement extends Model
{
    protected $fillable=[
        'type',
        'serie',
        'correlative',
        'date',
        'warehouse_id',
        'total',
        'observation',
        'reason_id',
    ];

    protected $casts=[
        'date'=> 'datetime',
    ];

    //Relacion uno a muchos inversa
    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    //Relacion uno a muchos inversa
    public function reason(){
        return $this->belongsTo(Reason::class);
    }

    //Relacion muchos a muchos polimórfica  , morphToMany:muchos a muchos
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')
        ->withPivot('quantity','price','subtotal')
        ->withTimestamps();   
    }

    //Relacion uno a muchos polimórfica 
    public function inventories(){
        return $this->morphMany(Inventory::class, 'inventoryable');
    }

   
}
