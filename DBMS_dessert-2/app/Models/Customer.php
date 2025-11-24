<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'CustomerID';


    protected $fillable = ['Customer_name', 'Customer_tel'];


    public function orders(){
        return $this->hasMany(Order::class);
    }
}
