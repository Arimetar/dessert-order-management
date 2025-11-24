<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Dessert;
use App\Models\Employee;
use App\Models\Festival;
use App\Models\Order_Dessert;
use App\Models\Order_employee;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function changeStatus($order_id, $status)
    {
        $order = Order::find($order_id);
        $order->Status = $status;
        $order->save();
        $emp_id = Employee::where('user_id', Auth::id())->first();
        Order_employee::create([
            'OrderID' => $order_id,
            'EmployeeID' => $emp_id->EmployeeId,
            'status' => $status,
        ]);
        return redirect()->back()->with('success', 'เปลี่ยนสถานะคำสั่งซื้อสำเร็จ');
    }

    public function filterStatusOrder($status)
    {
        $orders = Order::Where('Status', $status)->get();
        $festivals = Festival::all();
        $quantity = Cart::WHERE('session_id', session()->getId())->sum('quantity');
        return view('admin.orderList', compact('orders', 'quantity', 'festivals'));
    }

    public function orderDetailAdmin($order_id)
    {
        $order = Order::find($order_id);
        return view('admin.orderDetail', compact('order'));
    }

    public function filterByFestival(Request $request)
    {
        if($request->input('festival_id')==0){
            return redirect()->route('admin.orders');
        }
        // ดึงข้อมูลเทศกาลทั้งหมด
        $festivals = Festival::all();

        // ดึงข้อมูลคำสั่งซื้อทั้งหมด (หรือกรองตามเทศกาลหากมีการเลือก)
        $selectedFestivalID = $request->input('festival_id');
        $orders = Order::when($selectedFestivalID, function ($query, $selectedFestivalID) {
            return $query->where('FestivalID', $selectedFestivalID);
        })->get();
        // ดึงข้อมูลขนมทั้งหมด
        $desserts = Dessert::all();
        
        // คำนวณยอดจำนวนขนมตามประเภท (กรองตามเทศกาลหากมีการเลือก)
        $dessertTypes = [];
        foreach ($desserts as $dessert) {
            $totalAmount = Order_Dessert::join('orders', 'order__desserts.OrderID', '=', 'orders.OrderID')
            ->where('order__desserts.DessertID', $dessert->DessertID)
            ->when($selectedFestivalID, function ($query, $selectedFestivalID) {
                return $query->where('orders.FestivalID', $selectedFestivalID);
            })
            ->sum('Amount');
            $dessertTypes[$dessert->Dessert_name] = $totalAmount;
        }
        return view('admin.orderList', compact('orders', 'festivals', 'dessertTypes'));
    }

    public function index()
    {
        $festivals = Festival::all();
        $orders = Order::all();
        $desserts = Dessert::all();

        // คำนวณยอดจำนวนขนมตามประเภท
        $dessertTypes = [];
        foreach ($desserts as $dessert) {
            $totalAmount = Order_Dessert::where('DessertID', $dessert->DessertID)->sum('Amount');
            $dessertTypes[$dessert->Dessert_name] = $totalAmount;
        }
        return view('admin.orderList', compact('orders', 'festivals', 'dessertTypes'));
    }

    public function order(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:10|min:10',
            'pickup_time' => 'required',
            'pickup_date' => 'required'
        ]);

        // ใช้ first() เพื่อดึงลูกค้าเดี่ยว
        $customer = Customer::where('Customer_tel', $request->tel)->first();

        // ตรวจสอบว่าลูกค้ามีอยู่หรือไม่
        if (is_null($customer)) {
            $customer = Customer::create([
                'Customer_name' => $request->name,
                'Customer_tel' => $request->tel
            ]);
        }
        $customer = Customer::where('Customer_tel', $request->tel)->first();
        $customerid = $customer->CustomerID;

        // ดึงข้อมูลจาก cart ตาม festival ที่จะสั่งซื้อ
        $cartItems = Cart::where('session_id', session()->getId())->where('festival_id', $request->festival_id)->get();

        // คำนวณจำนวนเงินทั้งหมดของ order
        $orderPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->dessert->price;
        });

        // สร้างคำสั่งซื้อใหม่
        $order = Order::create([
            'PickUp_Date' => $request->pickup_date,
            'PickUp_Time' => $request->pickup_time,
            'Status' => 1,
            'Total_price' => $orderPrice,
            'CustomerID' => $customerid,
            'FestivalID' => $request->festival_id
        ]);

        $cart = session()->get('cart', []);
        foreach ($cartItems as $item) {
            $totalPrice = $item->quantity * $item->price;
            Order_Dessert::create([
                'OrderID' => $order->OrderID,
                'DessertID' => $item->dessert_id,
                'Amount' => $item->quantity,
                'Total_Price' => $totalPrice,
            ]);
            unset($cart[$item->dessert_id]);
            session()->put('cart', $cart);
            $item->delete();
        }

        $cart = session()->get('cart', []);
        // ล้างตะกร้าสินค้า
        if (empty($cart)) {
            session()->put('cart', []);
        } else {
            session()->put('cart', $cart);
        }

        return redirect()->route('dessert.home')->with('success', 'ขอบคุณสำหรับการสั่งซื้อ โปรดรอการยืนยันจากพนักงานในสองวันทำการ!');
    }
}
