<?php

namespace App\Http\Controllers;

use App\Models\Dessert;
use Illuminate\Http\Request;
use App\Models\Festival;
use App\Models\Festival_Dessert;

class FestivalController extends Controller
{
    //

    public function index()
    {
        $festivals = Festival::orderBy('Start_date', 'desc')->get();
        $desserts = Dessert::all();
        $off_festivals = Festival::onlyTrashed()->get();
        return view('admin.festivals', compact('festivals', 'off_festivals', 'desserts'));
    }

    public function updateFestivalDesserts(Request $request)
    {
        // รับข้อมูลจากฟอร์ม
        $selectedDesserts = $request->input('desserts', []);
        $festivalId = $request->input('festival_id');
        // ดึงข้อมูลขนมเดิมในเทศกาล
        $existingDesserts = Festival_Dessert::where('FestivalID', $festivalId)->get();
        // Soft Delete ขนมที่ไม่ได้ถูกเลือก

        foreach ($existingDesserts as $existingDessert) {
            if (!in_array($existingDessert->DessertID, $selectedDesserts)) {
                $existingDessert->delete(); // Soft Delete
            }
        }

        // เพิ่มหรือกู้คืนขนมที่ถูกเลือก
        foreach ($selectedDesserts as $dessertId) {
            // ตรวจสอบว่าขนมมีอยู่ในเทศกาลแล้วหรือไม่
            $festivalDessert = Festival_Dessert::withTrashed()
                ->where('FestivalID', $festivalId)
                ->where('DessertID', $dessertId)
                ->first();
            if ($festivalDessert) {
                    // หากพบข้อมูลและถูก Soft Delete ไว้ ให้กู้คืน
                    $festivalDessert->restore();
            } else {
                // หากไม่พบข้อมูล ให้เพิ่มข้อมูลใหม่
                Festival_Dessert::create([
                    'FestivalID' => $festivalId,
                    'DessertID' => $dessertId,
                ]);
            }
        }

        // Redirect ไปยังหน้าอื่น
        return redirect()->back()->with('complete', 'บันทึกข้อมูลสำเร็จ');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Festival_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|',
        ]);

        if (strtotime($request->start_date) >= strtotime($request->end_date)) {
            return redirect()->back()->with('error', 'โปรดใส่วันสิ้นสุดเทศกาลให้ห่างจากวันเริ่มต้นอย่างถูกต้อง')->withInput();
        };

        Festival::create([
            'Festival_name' => $request->Festival_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);


        return redirect()->route('admin.festivals')->with('success', 'เพิ่มเทศกาลสำเร็จ');
    }

    public function offFestival($festival_id)
    {
        Festival::find($festival_id)->delete();
        return redirect()->back()->with('complete', 'แก้ไขสถานะสำเร็จ');
    }
    public function onFestival($festival_id)
    {
        Festival::withTrashed()->where('FestivalID', $festival_id)->restore();
        return redirect()->back()->with('complete', 'แก้ไขสถานะสำเร็จ');
    }
}
