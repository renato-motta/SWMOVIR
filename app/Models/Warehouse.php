<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Inventory;

class Warehouse extends Model
{
    protected $fillable=[
        'name',
        'location',
    ];

    //relacion uno a muchos
    public function inventories(){
        return $this->hasMany(Inventory::class);
    }
}
