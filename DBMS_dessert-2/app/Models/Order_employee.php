<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_employee extends Model
{
    use HasFactory;

    protected $fillable = ['EmployeeID', 'OrderID' , 'status'];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID', 'OrderID'); // กำหนดให้ 'orderID' เป็น foreign key
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID'); // กำหนดให้ 'EmployeeID' เป็น foreign key
    }
}
