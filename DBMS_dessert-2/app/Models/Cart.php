<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = [
        'dessert_id',
        'session_id',
        'quantity',
        'price',
        'festival_id'
    ];

    public function dessert()
    {
        return $this->belongsTo(Dessert::class, 'dessert_id');
    }

    public function festival()
    {
        return $this->belongsTo(Festival::class, 'festival_id');
    }
}
