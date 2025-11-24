<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'OrderID';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['OrderID','PickUp_Date', 'PickUp_Time' , 'Total_price', 'Status', 'FestivalID', 'CustomerID'];


    public function customer(){
        return $this->belongsTo(Customer::class, 'CustomerID');
    }
    public function employee(){
        return $this->belongsTo(Employee::class, 'EmployeeID');
    }
    public function order_employee(){
        return $this->hasMany(Order_employee::class, 'OrderID');
    }
    public function festival(){
        return $this->belongsTo(Festival::class, 'FestivalID');
    }
    public function order_desserts(){
        return $this->hasMany(Order_Dessert::class, 'OrderID');
    }
}
