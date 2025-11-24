<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    protected $table = 'festivals';
    protected $primaryKey = 'FestivalID';
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['Festival_name', 'start_date' , 'end_date'];

    public function festival_desserts(){
        return $this->hasMany(Festival_Dessert::class, 'FestivalID');
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
