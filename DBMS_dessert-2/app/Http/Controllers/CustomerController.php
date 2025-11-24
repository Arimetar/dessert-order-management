<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\Festival;
use App\Models\Order;

class CustomerController extends Controller
{
    
    public function index(Request $request) {
        $quantity = Cart::WHERE('session_id',session()->getId())->sum('quantity');
        
        return view('checkStatus', compact('quantity'));
    }

    public function check(Request $request){
        $quantity = Cart::WHERE('session_id',session()->getId())->sum('quantity');

        $customer = Customer::where('Customer_tel', $request->tel)->get();
        if (!$customer || $customer->isEmpty()) {
            return view('checkStatus', compact('quantity'))->with('error','ไม่พบข้อมูลในระบบ');
        }
        
        $orders = Order::where('CustomerID', $customer[0]->CustomerID)->orderBy('Status')->get();
        $festivals = Festival::withTrashed()->get(); 
        return view('checkStatus', compact('quantity', 'orders', 'customer', 'festivals'));

    }

    public function checkOut($festival_id) {
        $cartItems = Cart::where('session_id', session()->getId())->where('festival_id', $festival_id)->get();
        $festival = Festival::find($festival_id);

        // คำนวณจำนวนเงินทั้งหมดของ order
        $orderPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->dessert->price;
        });
        return view('checkOut', compact('orderPrice', 'festival', 'cartItems'));
    }

    public function orderDetail($order_id){
        $order = Order::find($order_id);
        return view('orderDetail', compact('order'));
    }



    
}
