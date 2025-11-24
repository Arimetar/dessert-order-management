<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dessert;
use Illuminate\Support\Facades\Session; 
use App\Models\Cart;
class CartController extends Controller
{
    //
    
    public function addToCart(Request $request,$dessertId) {
        $dessert = Dessert::findOrFail($dessertId);
        $festivalId = $request->input('festival_id');
        $cart = session()->get('cart',[]);
        if(isset($cart[$dessertId])) {
            $cart[$dessertId]['quantity']++;
            
            $cartItem = Cart::where('dessert_id', $dessertId)
                            ->where('session_id', session()->getId())
                            ->first();

            if ($cartItem) {
                // ถ้ามีรายการในฐานข้อมูลแล้ว ให้ทำการอัปเดต quantity
                $cartItem->update([
                    'quantity' => $cartItem->quantity + $request->amount
                ]);
            }
        } else {
            $cart[$dessertId] = [
                "name" => $dessert->Dessert_name,
                "price" => $dessert->price,
                "quantity" => $request->amount,
            ];
            // บันทึกข้อมูลสินค้าในฐานข้อมูล
            Cart::create([
                'dessert_id' => $dessertId,
                'festival_id' => $festivalId,
                'session_id' => session()->getId(),
                'quantity' => $request->amount,
                'price' => $dessert->price,
            ]);
        }
        
        // อัปเดตข้อมูลใน session เสมอ
        session()->put('cart', $cart);
        $quantity = Cart::WHERE('session_id',session()->getId())->sum('quantity');
        // รีไดเรกต์กลับไปหน้าเดิมพร้อมข้อความสำเร็จ
        return redirect()->route('dessert.home', ['festival_id' => $festivalId])->with('success', 'สินค้าของท่านถูกเพิ่มลงในตะกร้าเรียบร้อยแล้ว ท่านสามารถตรวจสอบและดำเนินการต่อได้ที่แท็บตะกร้า')->with('quantity');
    }
    

    public function showCart() {
        $cart = Session::get('cart', []);
        
        // ดึงข้อมูล Cart และพร้อมกับข้อมูลของ Dessert โดยใช้ Eager Loading
        $cartItems = Cart::whereIn('dessert_id', array_keys($cart))
                         ->where('session_id', session()->getId())
                         ->with('dessert') // ใช้กับ eager loading
                         ->get();

        $cartItems = $cartItems->groupBy('festival_id');
        $quantity = Cart::WHERE('session_id',session()->getId())->sum('quantity');
        $cartID = Cart::WHERE('session_id',session()->getId())->get();
        return view('cart.show', compact('cartItems','quantity','cartID'));
    }

    public function updateQuantity(Request $request,$dessertId) {
        $validateData = $request->validate([
            'quantity' => 'required',
        ]);

        $cart = session()->get('cart', []);

        if(isset($cart[$dessertId])) {
            $cart[$dessertId]['quantity'] = $validateData['quantity'];

            $cartItem = Cart::WHERE('dessert_id' , $dessertId)->WHERE('session_id' , session()->getId())->first();

            if($cartItem) {
                $cartItem->update([
                    'quantity' => $validateData['quantity'],
                ]);
            }
        }
        

        session()->put('cart' , $cart);

        return back()->with('success', 'Quantity updated successfully.');

    }

    public function removeProduct($dessertId) {
        $cart = session()->get('cart', []);
        if(isset($cart[$dessertId])) {
            unset($cart[$dessertId]);
            session()->put('cart' , $cart);
        }

        $cartItem = Cart::WHERE('dessert_id' , $dessertId)->WHERE('session_id' , session()->getId())->first();

            if($cartItem) {
                $cartItem->delete();
            }

        $quantity = Cart::WHERE('session_id',session()->getId())->sum('quantity');

        return back()->with('success', 'Item removed from the cart.')->with('quantity');

    }
    
    
}
