<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Festival_Dessert extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = ['DessertID', 'FestivalID'];
    public $incrementing = false;

    protected $table = 'festival__desserts'; // ระบุชื่อ table หากไม่เป็นไปตาม Laravel convention

    protected $fillable = [
        'FestivalID',
        'DessertID',
        'deleted_at'
    ];

    public function festival()
    {
        return $this->belongsTo(Festival::class, 'FestivalID', 'FestivalID');
    }

    public function dessert()
    {
        return $this->belongsTo(Dessert::class, 'DessertID', 'DessertID');
    }

    

    
}
