<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dessert;
use App\Models\Cart;
use App\Models\Festival;
use App\Models\Festival_Dessert;

class DessertController extends Controller
{
    //
    public function index(Request $request) {
        $desserts = Dessert::whereNull('deleted_at')->paginate(12);
        $festivals = Festival::all();
        $quantity = Cart::WHERE('session_id',session()->getId())->sum('quantity');

        if($request->has('festival_id')) {
            if($request->festival_id == 0){
                $festivalDesserts = Dessert::all();
            }else{
                $festivalDesserts = Festival_Dessert::WHERE('FestivalID' , $request->festival_id)->join('desserts' , 'festival__desserts.DessertID' , '=' , 'desserts.DessertID')->whereNull('desserts.deleted_at')->select('desserts.Dessert_name' , 'desserts.DessertID' , 'desserts.image' , 'desserts.price')->get();
            }
        }else {
            $fes = Festival::whereNull('deleted_at')->first();
            $festivalDesserts = Festival_Dessert::WHERE('FestivalID' , $fes->FestivalID)->join('desserts' , 'festival__desserts.DessertID' , '=' , 'desserts.DessertID')->whereNull('desserts.deleted_at')->select('desserts.Dessert_name' , 'desserts.DessertID' , 'desserts.image' , 'desserts.price')->get();
        }
        
        return view('home' , compact('desserts' , 'quantity' , 'festivals' , 'festivalDesserts'));
    }

    public function dessertList() {
        $festivals = Festival::all();
        $desserts = Dessert::all();
        $off_dessert = Dessert::onlyTrashed()->get();;
        return view('admin.dessert' , compact('festivals', 'desserts', 'off_dessert'));
    }
    public function filterDessert(Request $request) {
        if($request->festival_id == 0){
            return redirect()->route('admin.dessert');
        }
        $festivals = Festival::all();        
        // ดึงข้อมูลสินค้าที่ไม่ถูก soft delete
        $desserts = Festival_Dessert::where('FestivalID', $request->festival_id)
            ->join('desserts', 'festival__desserts.DessertID', '=', 'desserts.DessertID')
            ->whereNull('desserts.deleted_at') // เงื่อนไขนี้ใช้เพื่อดึงข้อมูลที่ไม่ถูกลบ
            ->select('desserts.Dessert_name', 'desserts.DessertID', 'desserts.image', 'desserts.price')
            ->get();

        // ดึงข้อมูลสินค้าที่ถูก soft delete (deleted_at ไม่เท่ากับ null)
        $off_dessert = Festival_Dessert::where('FestivalID', $request->festival_id)
            ->join('desserts', 'festival__desserts.DessertID', '=', 'desserts.DessertID')
            ->whereNotNull('desserts.deleted_at') // เงื่อนไขนี้ใช้เพื่อเช็คว่า deleted_at ไม่ใช่ null
            ->withTrashed() // เพื่อดึงข้อมูลที่ถูก soft delete
            ->select('desserts.Dessert_name', 'desserts.DessertID', 'desserts.image', 'desserts.price')
            ->get();
         return view('admin.dessert' , compact('festivals', 'desserts', 'off_dessert'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        //เก็บข้อมูลภาพเป็นpathลงในfolderในstorage laravelก่อนแล้วค่อยดึงจากpathมาแสดงในหน้าblade
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('desserts', 'public');
        } else {
            $imagePath = null;
        }
    
        // สร้างข้อมูลในฐานข้อมูล
        $dessert = Dessert::create([
            'Dessert_name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'Description' => $request->Description ?? 'N/A',
        ]);

        Festival_Dessert::create([
            'DessertID' => $dessert->DessertID,
            'FestivalID' => $request->festival_id,  // ต้องตรวจสอบว่า `festival_id` ถูกส่งมา
        ]);
    
        // ส่งกลับไปที่หน้า dashboard พร้อมข้อความสำเร็จ
        return redirect()->route('admin.dessert')->with('success', 'Dessert added successfully!');
    }

    public function offDessert($dessertID){
        Dessert::find($dessertID)->delete();
        return redirect()->back()->with('complete', 'แก้ไขสถานะขนมเสร็จสิ้น');
    }

    public function onDessert($dessertID){
        Dessert::withTrashed()->where('DessertID',$dessertID)->restore();
        return redirect()->back()->with('complete', 'แก้ไขสถานะขนมเสร็จสิ้น');
    }

}
