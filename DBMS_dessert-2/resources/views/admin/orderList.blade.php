@extends('layouts.layout')
@section('title', 'รายการทั้งหมด')
@section('header', 'รายการคำสั่งซื้อทั้งหมด')
@section('content')
<style>
    .status-filter.active {
    transform: scale(1.05);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}
</style>
@if($orders)
<div style="margin-top:20px;">
    <div class="container mx-auto max-w-[80%] p-6 bg-white rounded-lg shadow-lg">
        <!-- แสดงยอดจำนวนขนมทั้งหมดตามประเภท -->
        <h2 class="text-lg font-semibold mb-4">ยอดจำนวนขนมทั้งหมดตามประเภท</h2>
        <div class="overflow-y-auto max-h-96"> <!-- เพิ่มการเลื่อนในกรณีข้อมูลเกิน -->
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-lg font-semibold text-gray-800">ประเภทขนม</th>
                        <th class="py-3 px-6 text-left text-lg font-semibold text-gray-800">จำนวน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dessertTypes as $type => $count)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-6 text-lg font-medium text-gray-700">{{ $type }}</td>
                            <td class="py-3 px-6 text-lg font-medium {{ $count == 0 ? 'text-red-500' : 'text-gray-700' }}">
                                {{ $count }} 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
        @endif
        <div style="margin-top:20px;">
           <div class="container mx-auto max-w-[80%] p-6 bg-white rounded-lg shadow-lg mb-6"> <!-- เพิ่ม mb-6 ที่นี่ -->
                <!-- แสดงยอดจำนวนคำสั่งซื้อแต่ละสถานะในปุ่ม -->
                <div class="flex mx-auto mb-4">
            <button data-status="1" class="w-1/5 status-filter mr-4 p-6 rounded-lg shadow-lg text-center transition duration-200 
                bg-white text-black hover:scale-105 hover:shadow-xl">
                <p class="text-lg font-semibold text-yellow-600">รอการยืนยันคำสั่งซื้อ</p>
                <p class="text-sm text-gray-500">{{ count($orders->where('Status', 1)) }} รายการ</p>
            </button>

            <button data-status="2" class="w-1/5 status-filter mr-4 p-6 rounded-lg shadow-lg text-center transition duration-200 
                bg-white text-black  hover:scale-105 hover:shadow-xl">
                <p class="text-lg font-semibold text-blue-600">ยืนยันคำสั่งซื้อแล้ว</p>
                <p class="text-sm text-gray-500">{{ count($orders->where('Status', 2)) }} รายการ</p>
            </button>

            <button data-status="3" class="w-1/5 status-filter mr-4 p-6 rounded-lg shadow-lg text-center transition duration-200 
                bg-white text-black hover:scale-105 hover:shadow-xl">
                <p class="text-lg font-semibold text-green-600">ชำระเงินแล้ว</p>
                <p class="text-sm text-gray-500">{{ count($orders->where('Status', 3)) }} รายการ</p>
            </button>

            <button data-status="4" class="w-1/5 status-filter mr-4 p-6 rounded-lg shadow-lg text-center transition duration-200 
                bg-white text-black  hover:scale-105 hover:shadow-xl">
                <p class="text-lg font-semibold text-teal-600">เข้ารับสินค้าแล้ว</p>
                <p class="text-sm text-gray-500">{{ count($orders->where('Status', 4)) }} รายการ</p>
            </button>

            <button data-status="0" class="w-1/5 status-filter mr-4 p-6 rounded-lg shadow-lg text-center transition duration-200 
                bg-white text-black  hover:scale-105 hover:shadow-xl ">
                <p class="text-lg font-semibold text-red-600">ยกเลิกคำสั่งซื้อ</p>
                <p class="text-sm text-gray-500">{{ count($orders->where('Status', 0)) }} รายการ</p>
            </button>
        </div>




        <!-- ตารางแสดงคำสั่งซื้อทั้งหมด -->
        @if($orders->isEmpty() || !$orders)
        <div class="p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div class="flex-1 text-center">ไม่พบคำสั่งซื้อ</div>
            </div>
        </div>
        @else
        <div class="bg-gray-50 p-4 rounded-lg border-y mb-3">
            <div class="flex justify-between items-center">
                <div class="flex-1 text-center">ชื่อผู้สั่ง</div>
                <div class="flex-1 text-center">เทศกาล</div>
                <div class="flex-1 text-center">วันที่เข้ารับสินค้า</div>
                <div class="flex-1 text-center">ช่วงเวลาเข้ารับสินค้า</div>
                <div class="flex-1 text-center">สถานะคำสั่งซื้อ</div>
                <div class="flex-1 text-center">รายละเอียดคำสั่งซื้อ</div>
            </div>
        </div>
        @foreach($orders as $order)
        <div class="p-4 rounded-lg border-b mb-3 order-row" data-status="{{ $order->Status }}">
            <div class="flex justify-between items-center">
                <div class="flex-1 text-center">{{$order->customer->Customer_name}}</div>
                <div class="flex-1 text-center">{{$order->festival()->withTrashed()->first()->Festival_name}}</div>
                <div class="flex-1 text-center">{{ \Carbon\Carbon::parse($order->PickUp_date)->locale('th')->translatedFormat('d F Y') }}</div>
                @if($order->PickUp_time == 1)
                <div class="flex-1 text-center">ช่วงเช้า (08:00 - 12:00)</div>
                @else
                <div class="flex-1 text-center">ช่วงบ่าย (13:00 - 17:00)</div>
                @endif

                <!-- สถานะคำสั่งซื้อ -->
                <div class="flex-1 text-center 
                    @if($order->Status == 1) text-yellow-500 @elseif($order->Status == 2) text-blue-500 
                    @elseif($order->Status == 3) text-green-500 @elseif($order->Status == 4) text-teal-500
                    @else text-red-500 @endif">
                    @if($order->Status == 1)
                        รอการยืนยันคำสั่งซื้อ
                    @elseif($order->Status == 2)
                        ยืนยันคำสั่งซื้อแล้ว
                    @elseif($order->Status == 3)
                        ชำระเงินแล้ว
                    @elseif($order->Status == 4)
                        เข้ารับสินค้าแล้ว
                    @else
                        ยกเลิกคำสั่งซื้อ
                    @endif
                </div>

                <div class="flex-1 text-center">
                    <a href="{{ route('admin.order.detail', $order->OrderID) }}" target="_blank">
                        <button class="bg-white border-2 border-gray-400 text-black py-3 px-6 rounded-md hover:bg-[#ffb42f] hover:text-white transition" type="button">
                            รายละเอียดคำสั่งซื้อ
                        </button>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // เลือกปุ่มกรองทั้งหมด
        document.querySelectorAll('.status-filter').forEach(function(button) {
            button.addEventListener('click', function() {
                // รับสถานะที่เลือกจาก data-status
                const selectedStatus = this.getAttribute('data-status');
                // เลือกรายการคำสั่งซื้อทั้งหมด
                const orders = document.querySelectorAll('.order-row');

                // วนลูปเพื่อซ่อนหรือแสดงรายการตามสถานะ
                orders.forEach(function(order) {
                    if (selectedStatus === "" || order.getAttribute('data-status') === selectedStatus) {
                        order.style.display = ""; // แสดงรายการ
                    } else {
                        order.style.display = "none"; // ซ่อนรายการ
                    }
                });
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".status-filter");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            buttons.forEach(btn => btn.classList.remove("active"));

            this.classList.add("active");
        });
    });
});

</script>
@endsection