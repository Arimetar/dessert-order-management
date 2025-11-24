@extends('layouts.layout')
@section('title', 'ตรวจสอบสถานะ')
@section('header', 'ตรวจสอบสถานะ')
@section('content')
<div style="margin-top:50px; margin-bottom:50px;">
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg ">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">ค้นหาคำสั่งซื้อ</h1>
        </div>
        <div class="flex justify-center">
            <form action="{{ route('customer.check.status') }}" method="POST">
                @csrf
                <div class="w-full max-w-sm min-w-[700px]">
                    <div class="relative flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute w-5 h-5 top-2.5 left-2.5 text-slate-600">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                        </svg>

                        <input
                            class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md pl-10 pr-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                            type="text" name="tel" id="tel" maxlength="10" placeholder="ค้นหาด้วยเบอร์โทรศัพท์" />

                        <button
                            class=" rounded-md py-2 px-4 border 
                            border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg 
                            focus:bg-[#ffb42f] focus:shadow-none active:bg-[#ffb42f] hover:bg-[#ffb42f] bg-[#f7be5b] active:shadow-none 
                            disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2"
                            type="submit">
                            ค้นหา
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @if(isset($orders))
    <div class="grid grid-cols-1 overflow-x-auto whitespace-nowrap p-3 gap-2"> <!-- ลด gap -->
        <div class="bg-gray-100 p-3 rounded-lg shadow-md transition-shadow mb-2"> <!-- ลด padding และ margin -->
            <div class="flex justify-between items-center">
                <div class="flex-1 text-center">ชื่อผู้สั่งซื้อสินค้า</div>
                <div class="flex-1 text-center">เทศกาล</div>
                <div class="flex-1 text-center">วันที่เข้ารับสินค้า</div>
                <div class="flex-1 text-center">เวลาเข้ารับสินค้า</div>
                <div class="flex-1 text-center">สถานะคำสั่งซื้อ</div>
                <div class="flex-1 text-center">รายละเอียดคำสั่งซื้อ</div>
            </div>
        </div>
        @foreach($orders as $order)
            <div class="bg-white p-3 rounded-lg shadow-md hover:shadow-lg transition-shadow mb-2"> <!-- ลด padding และ margin -->
                <div class="flex justify-between items-center">
                    <div class="flex-1 text-center">{{$customer[0]->Customer_name}}</div>
                    <div class="flex-1 text-center">{{ $festivals->find($order->FestivalID)->Festival_name }}</div>
                    <div class="flex-1 text-center">{{ \Carbon\Carbon::parse($order->PickUp_date)->locale('th')->translatedFormat('d F Y') }}</div>
                    @if($order->PickUp_time == 1)
                    <div class="flex-1 text-center">ช่วงเช้า (08:00 - 12:00)</div>
                    @else
                    <div class="flex-1 text-center">ช่วงบ่าย (13:00 - 17:00)</div>
                    @endif
                    @if($order->Status == 1)
                    <div class="flex-1 text-center text-yellow-500">รอการยืนยันคำสั่งซื้อ</div>
                    @elseif($order->Status == 2)
                    <div class="flex-1 text-center text-blue-500">ยืนยันคำสั่งซื้อแล้ว</div>
                    @elseif($order->Status == 3)
                    <div class="flex-1 text-center text-green-500">ชำระเงินแล้ว</div>
                    @elseif($order->Status == 4)
                    <div class="flex-1 text-center text-teal-500" >เข้ารับสินค้าแล้ว</div>
                    @else
                    <div class="flex-1 text-center text-red-500">ยกเลิกคำสั่งซื้อ</div>
                    @endif
                    <div class="flex-1 text-center">
                        <a href="{{ route('order.detail', $order->OrderID) }}" target="_blank">
                            <button class="bg-white border-2 border-gray-400 text-black py-3 px-6 rounded-md hover:bg-[#ffb42f] hover:text-white transition" type="button">
                                รายละเอียดคำสั่งซื้อ
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif


        @isset($error)
        <div class="grid grid-cols-1 overflow-x-auto whitespace-nowrap p-4 gap-3">
            <div class="bg-gray-100 p-4 rounded-lg shadow-md transition-shadow mb-4">
                <div class="flex justify-between items-center">
                    <div class="flex-1 text-center">{{$error}}</div>
                </div>
            </div>
        </div>
        @endif

    </div>

</div>
</div>
<script>
    // ฟังก์ชันเปิด Modal สำหรับออเดอร์ที่ระบุ
    function openModal(orderId) {
        document.getElementById('modal-' + orderId).classList.remove('hidden');
    }

    // ฟังก์ชันปิด Modal สำหรับออเดอร์ที่ระบุ
    function closeModal(orderId) {
        document.getElementById('modal-' + orderId).classList.add('hidden');
    }
</script>
@endsection