<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order_Dessert extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['DessertID', 'OrderID' , 'Amount', 'Total_Price'];

    
    // กำหนดชื่อคอลัมน์ที่ใช้เป็น foreign key ถ้าไม่ตรงกับ convention ของ Laravel
    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID', 'OrderID'); // กำหนดให้ 'orderID' เป็น foreign key
    }

    public function dessert()
    {
        return $this->belongsTo(Dessert::class, 'DessertID', 'DessertID'); // เช่นเดียวกันกับ 'dessertID'
    }

}
