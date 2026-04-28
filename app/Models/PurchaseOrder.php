<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Product;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'supplier_id',
        'total',
        'observation',
    ];   

    protected $casts = [
        'date' => 'datetime',
    ];
    //Relacion uno a muchos inversa
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
}
