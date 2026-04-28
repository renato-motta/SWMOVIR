<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    //habilitamos la asignacion masiva

    protected $fillable = [
        'name'
    ];
}
