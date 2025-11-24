<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Dessert extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'DessertID';
    
    protected $fillable = ['Dessert_name', 'price' , 'image'];

    public function festival_desserts(){
        return $this->hasMany(Festival_Dessert::class, 'DessertID');
    }
    public function order_desserts(){
        return $this->hasMany(Order_Dessert::class, 'DessertID');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
