<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Warehouse;


class Sale extends Model
{
    protected $fillable=[
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'quote_id',
        'customer_id',
        'warehouse_id',
        'total',
        'observation',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    //Relacion uno a muchos inversa
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    //Relacion uno a muchos inversa
    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
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
