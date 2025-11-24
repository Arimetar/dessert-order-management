@extends('layouts.layout')
@section('title', 'ตะกร้า')
@section('header', 'ตะกร้า')
@section('content')
<div style="margin-top:50px; margin-bottom:50px;">
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg mt-">
        <h1 class="text-4xl font-bold mb-6 text-center text-gray-800">ตะกร้าสินค้า</h1>

        @if($cartItems->isEmpty())
        <p class="text-center text-lg text-gray-500">ตระกร้าของคุณยังไม่มีสินค้าหรือรายการใดๆ</p>
        @else
        @foreach($cartItems as $festivalId => $items)
        <!-- Display festival name -->
        <h2 class="text-xl font-bold mb-4">เทศกาล: {{ $items->first()->festival->Festival_name }}</h2>

        <table class="min-w-full table-auto bg-gray-50 rounded-lg shadow overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-black border-b">รูปภาพขนม</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-black border-b">ชื่อขนม</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-black border-b">จำนวน</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-black border-b">ราคา</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-black border-b">ยอดรวม</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-black border-b">ลบสินค้า</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="hover:bg-gray-100">
                    <td><img src="{{ asset('storage/' . $item->dessert->image) }}"
                            alt="{{ $item->dessert->Dessert_name }}"
                            class=" object-cover rounded-lg my-4 mx-auto w-[100px] h-[100px] ">
                    </td>

                    <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b">{{ $item->dessert->Dessert_name }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b">
                        <form action="{{route('cart.update' , $item['dessert_id'])}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                class="w-16 text-center border border-gray-300 rounded-md p-1">
                            <button type="submit"
                                class="bg-[#f7be5b] text-white py-1 px-3 mt-2 rounded-md hover:bg-[#ffb42f] transition"
                                onclick="return confirm('ยืนยันที่จะแก้ไขจำนวนขนม?')">
                                แก้ไข</button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b">
                        {{ number_format($item->dessert->price, 2) }} บาท
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b">
                        {{ number_format($item->quantity * $item->dessert->price, 2) }} บาท
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b">
                        <form action="{{route('cart.remove' , $item['dessert_id'])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white py-1 px-3 mt-2 rounded-md hover:bg-red-600 transition" 
                                onclick="return confirm('ยืนยันที่จะนำสินค้าออกจากตะกร้า?')">
                                ลบสินค้า</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <!-- คำนวณยอดรวมทั้งหมด -->
            <h2 class="text-xl font-semibold text-gray-800">ยอดรวมทั้งหมด: {{ number_format($items->sum(function($item) {
                return $item->quantity * $item->dessert->price;
            }), 2) }} บาท</h2>
        </div>



        <!-- Open Modal Button -->
        <div class="mt-6 text-right">
            <!-- เพิ่ม data-* สำหรับเก็บข้อมูลที่ต้องการแสดงใน Modal -->
            <a href="{{route('customer.check.out', $items->first()->festival->FestivalID)}}">
                <button data-dialog-target="sign-in-modal"
                    data-festival-id="{{ $items->first()->festival->FestivalID }}"
                    data-festival-name="{{ $items->first()->festival->Festival_name }}"
                    class="bg-green-500 text-white py-3 px-6 rounded-md hover:bg-green-600 transition"
                    type="button">
                    ดำเนินการสั่งซื้อ
                </button>

            </a>

        </div>
        @endforeach
        <!-- Modal Structure 
        <form action="{{ route('customer.order') }}" method="POST">
            @csrf
            <div data-dialog-backdrop="sign-in-modal" data-dialog-backdrop-close="true"
                class="pointer-events-none fixed inset-0 z-[999] grid h-screen w-screen place-items-center bg-black bg-opacity-60 opacity-0 backdrop-blur-sm transition-opacity duration-300">
                <div data-dialog="sign-in-modal"
                    class="relative mx-auto w-full max-w-[24rem] rounded-lg overflow-hidden shadow-sm">
                    <div class="relative flex flex-col bg-white">
                        <div
                            class="relative m-2.5 items-center flex justify-center text-white h-24 rounded-md bg-slate-800">
                            <h3 class="text-2xl">
                                Purchase
                            </h3>
                        </div>
                        <div class="flex flex-col gap-4 p-6">
                            <div class="w-full max-w-sm min-w-[200px]">
                                <label class="block mb-2 text-sm text-slate-600">
                                    Telephone
                                </label>
                                <input type="tel" name="tel" id="tel"
                                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                                    placeholder="Your Telephone" maxlength="10" />
                            </div>

                            <div class="w-full max-w-sm min-w-[200px]">
                                <label class="block mb-2 text-sm text-slate-600">
                                    Your name
                                </label>
                                <input type="text" name="name" id="name"
                                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                                    placeholder="Your name" />
                            </div>
                            <div class="w-full max-w-sm min-w-[200px]">
                                <label class="block mb-2 text-sm text-slate-600">
                                    วันที่จะมารับ ({{\Carbon\Carbon::parse($items->first()->festival->Start_date)->locale('th')->translatedFormat('d F')}} ถึง {{\Carbon\Carbon::parse($items->first()->festival->End_date)->locale('th')->translatedFormat('d F Y')}})
                                </label>
                                <input type="date" id="pickup_date" name="pickup_date" value="{{ old('pickup_date') }}"
                                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                                    placeholder=""
                                    min="{{ $items->first()->festival->Start_date}}"
                                    max="{{$items->first()->festival->End_date}}" />
                            </div>
                            <div class="w-full max-w-sm min-w-[200px]">
                                <label class="block mb-2 text-sm text-slate-600">
                                    ช่วงเวลาที่จะมารับ
                                </label>
                                <select name="pickup_time" id="pickup_time" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow">
                                    <option value="1">ช่วงเช้า</option>
                                    <option value="2">ช่วงบ่าย</option>
                                </select>
                            </div>
                            <input type="number" value="{{$items->first()->festival->FestivalID}}" name="festival_id" hidden>


                        </div>
                        <div class="p-6 pt-0">
                            <button
                                class="w-full rounded-md bg-slate-800 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="submit">
                                Purchase
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        -->
        @endif
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dialog = document.querySelector('[data-dialog="sign-in-modal"]');
    const backdrop = document.querySelector('[data-dialog-backdrop="sign-in-modal"]');
    
    // เก็บข้อมูลของ input field ใน Modal
    const festivalInput = document.querySelector('input[name="festival_id"]');
    const festivalNameInput = document.querySelector('#festival_name'); // สมมติว่ามี <input> หรือ <div> ที่จะแสดงข้อมูลนี้

    // Open the modal
    document.querySelectorAll('[data-dialog-target="sign-in-modal"]').forEach(button => {
        button.addEventListener('click', function() {
            // ดึงข้อมูลจาก data-* attributes ของปุ่มที่กด
            const festivalId = button.getAttribute('data-festival-id');
            const festivalName = button.getAttribute('data-festival-name');

            // ใส่ข้อมูลลงใน Modal
            festivalInput.value = festivalId;
            festivalNameInput.textContent = festivalName;

            // แสดง Modal
            dialog.classList.remove('opacity-0', 'pointer-events-none');
            dialog.classList.add('opacity-100', 'pointer-events-auto');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100', 'pointer-events-auto');
        });
    });

    // Close the modal when clicking the backdrop
    backdrop.addEventListener('click', function() {
        dialog.classList.remove('opacity-100', 'pointer-events-auto');
        dialog.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('opacity-100', 'pointer-events-auto');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
    });

    dialog.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dialog = document.querySelector('[data-dialog="sign-in-modal"]');
        const backdrop = document.querySelector('[data-dialog-backdrop="sign-in-modal"]');

        // Open the modal
        document.querySelector('[data-dialog-target="sign-in-modal"]').addEventListener('click', function() {
            dialog.classList.remove('opacity-0', 'pointer-events-none');
            dialog.classList.add('opacity-100', 'pointer-events-auto');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100', 'pointer-events-auto');
        });

        // Close the modal when clicking the backdrop
        backdrop.addEventListener('click', function() {
            dialog.classList.remove('opacity-100', 'pointer-events-auto');
            dialog.classList.add('opacity-0', 'pointer-events-none');
            backdrop.classList.remove('opacity-100', 'pointer-events-auto');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
        });

        dialog.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
</script>
@endsection