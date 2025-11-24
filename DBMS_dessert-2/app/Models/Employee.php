<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'EmployeeID';

    protected $fillable = ['Employee_name', 'position', 'user_id' ];

    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function order_employee() {
        return $this->hasMany(Order_employee::class, 'EmployeeID');
    }
}
