<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dessert;
use App\Models\Cart;
use App\Models\Festival;
use App\Models\Festival_Dessert;

class adminController extends Controller
{
    public function index(Request $request) {
        $desserts = Dessert::paginate(12);
        $festivals = Festival::all();
        $quantity = Cart::WHERE('session_id',session()->getId())->sum('quantity');

        if($request->has('festival_id')) {
            $festivalDesserts = Festival_Dessert::WHERE('FestivalID' , $request->festival_id)->join('desserts' , 'festival__desserts.DessertID' , '=' , 'desserts.DessertID')->select('desserts.Dessert_name' , 'desserts.DessertID' , 'desserts.image' , 'desserts.price')->get();
        }else {
            $festivalDesserts = [];
        }
        
        return view('admin.home' , compact('desserts' , 'quantity' , 'festivals' , 'festivalDesserts'));
    }
}
