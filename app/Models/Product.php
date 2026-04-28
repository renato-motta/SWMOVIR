<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use App\Models\Sale;
use App\Models\Image;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'sku',
        'barcode',
        'price',
        'category_id',
        'stock',
    ];

    //Accesores
    protected function image(): Attribute
    {
        return Attribute::make(get: fn() => $this->images->count() ? Storage::url($this->images->first()->path) : 'https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png',);
    }


    //Relacion uno a muchos inversa
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Relacion uno a muchos
    public function inventories(){
        return $this->hasMany(Inventory::class);
    }

    //Relacion uno a muchos polimórfica
    public function purchaseOrders(){
        return $this->morphedByMany(PurchaseOrder::class,'productable');
    }

    //Relacion uno a muchos polimórfica
    public function quotes(){
        return $this->morphedByMany(Quote::class,'productable');
    }

    //Relacion uno a muchos polimórfica
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');   
    }

    public function sales()
    {
        return $this->morphToMany(\App\Models\Sale::class, 'productable');
    }
}
