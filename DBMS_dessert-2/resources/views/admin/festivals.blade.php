@extends('layouts.layout')
@section('title', 'จัดการเทศกาล')
@section('header', 'จัดการเทศกาล')
@section('content')
<div style="margin-top:50px; ">
    <div class="container mx-auto max-w-[80%] p-6 bg-white rounded-lg shadow-lg ">
        @if(session('complete'))
        <div class="container bg-green-500 max-w-[100%] justify-center text-white p-4 rounded-lg mb-4">
            {{ session('complete') }}
        </div>
        @endif
        <div class="flex">
            <div class="p-6 w-1/2 mr-2 rounded-lg shadow-lg text-center transition duration-200">
                <p class="text-lg font-semibold text-green-600">เทศกาลที่เปิดให้สั่ง</p>
                <p class="text-sm text-gray-500">{{count($festivals)}} เทศกาล</p>
            </div>
            <div class="p-6 w-1/2 mr-2 rounded-lg shadow-lg text-center transition duration-200">
                <p class="text-lg font-semibold text-red-600" >เทศลการที่ปิดไม่ให้สั่ง</p>
                <p class="text-sm text-gray-500">@if($off_festivals->isEmpty()) 0 @else {{count($off_festivals)}} @endifเทศกาล</p>
            </div>
        </div>
    </div>
</div>

<div style="margin-top:25px;">
    <div class="container mx-auto max-w-[80%] p-6 bg-white rounded-lg shadow-lg flex">


        <div class="w-1/3 p-6 bg-white rounded-lg shadow-lg my-8">
            <h1 class="text-2xl font-semibold mb-6 text-center">เพิ่มเทศกาลใหม่</h1>

            @if(session('error'))
            <div class="bg-red-400 text-white p-4 rounded-lg mb-4">
                {{ session('error') }}
            </div>
            @endif
            @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('admin.festivals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Festival Name -->
                <div class="mb-4">
                    <label for="Festival_name" class="block text-lg font-medium text-gray-700">ชื่อเทศกาล</label>
                    <input type="text" name="Festival_name" id="Festival_name"
                        class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('Festival_name') }}" required placeholder="เช่น ตรุษจีน 2566">
                    @error('Festival_name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Start Date -->
                <div class="mb-4">
                    <label for="start_date" class="block text-lg font-medium text-gray-700">วันเริ่มต้นเทศกาล</label>
                    <input type="date" name="start_date" id="start_date"
                        class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('start_date') }}" required>
                    @error('start_date')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- End Date -->
                <div class="mb-4">
                    <label for="end_date" class="block text-lg font-medium text-gray-700">วันสิ้นสุดเทศกาล</label>
                    <input type="date" name="end_date" id="end_date"
                        class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ old('end_date') }}" required>
                    @error('end_date')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full hover:bg-[#ffb42f] bg-[#f7be5b] text-white p-3 rounded-lg  focus:outline-none focus:ring-2 focus:ring-blue-500 mt-5">
                    เพิ่มเทศกาลใหม่
                </button>
            </form>
        </div>
        <!-- Container หลัก -->
        <div class="w-2/3 p-6 bg-white rounded-lg shadow-lg my-8 ml-6">

            <!-- หัวตาราง แยกออกมา -->
            <div class="bg-gray-200 rounded-t-lg">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-10 py-3 text-left text-sm font-medium text-gray-600 border-b">ชื่อเทศกาล</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 border-b">วันเริ่มต้น</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 border-b">วันสิ้นสุด</th>
                            <th class="px-10 py-3 text-left text-sm font-medium text-gray-600 border-b text-center">เปิด-ปิด เทศกาล</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="overflow-y-auto max-h-[350px] border-t border-gray-300">
                <table class="min-w-full table-auto bg-gray-50">
                    <tbody>
                        @foreach($festivals as $festival)
                        <tr class="hover:bg-gray-100">
                            <td class="px-10 py-4 text-sm font-medium text-gray-700 border-b">{{$festival->Festival_name}}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b">
                                {{ \Carbon\Carbon::parse($festival->Start_date)->locale('th')->translatedFormat('d F Y')}}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-700 border-b">
                                {{ \Carbon\Carbon::parse($festival->End_date)->locale('th')->translatedFormat('d F Y')}}
                            </td>
                            <td class="px-10 py-4 text-sm font-medium text-gray-700 border-b">
                                <a href="{{ route('admin.festival.off', $festival->FestivalID) }}">
                                    <button type="button"
                                        class="flex mx-auto justify-left min-w-[130px] border border-black text-gray-700 py-3 px-6 rounded-md hover:bg-red-500 hover:text-white transition"
                                        onclick="return confirm('ยืนยันที่จะปิดไม่ให้สั่งขนมในเทศกาล{{$festival->Festival_name}}?')">
                                        ปิดไม่ให้สั่งซื้อ
                                    </button>
                                </a>
                            </td>

                        </tr>
                        @endforeach
                        @foreach($off_festivals as $festival)
                        <tr class="hover:bg-gray-100">
                            <td class="px-10 py-4 text-sm font-medium text-gray-300 border-b">
                                {{$festival->Festival_name}}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-300 border-b">
                                {{$festival->Start_date}}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-300 border-b">
                                {{$festival->End_date}}
                            </td>
                            <td class="px-10 py-4 text-sm font-medium text-gray-300 border-b">
                                <a href="{{ route('admin.festival.on', $festival->FestivalID) }}">
                                    <button type="submit"
                                        class="flex mx-auto justify-center min-w-[130px] border border-gray-400 text-gray-400 py-3 px-6 rounded-md hover:bg-green-600 hover:text-white transition"
                                        onclick="return confirm('ยืนยันที่จะเปิดให้สั่งขนมในเทศกาล{{$festival->Festival_name}}?')">
                                        เปิดให้สั่งซื้อ
                                    </button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        </table>
    </div>
</div>
</div>


<script>
    // เปิด Popup
    document.getElementById('open-popup').addEventListener('click', function() {
        document.getElementById('popup').classList.remove('hidden');
    });

    // ปิด Popup
    document.getElementById('close-popup').addEventListener('click', function() {
        document.getElementById('popup').classList.add('hidden');
    });

    // เพิ่มขนม
    function addDessert() {
        const select = document.getElementById('dessert-select');
        const dessertId = select.value;
        const dessertName = select.options[select.selectedIndex].text;

        // เพิ่มขนมลงในรายการปัจจุบัน
        const currentDesserts = document.getElementById('current-desserts');
        const li = document.createElement('li');
        li.className = 'flex items-center justify-between p-2 bg-gray-100 rounded-lg';
        li.innerHTML = `
        <span>${dessertName}</span>
        <button type="button" class="text-red-500 hover:text-red-700" onclick="removeDessert(${dessertId})">ลบ</button>
    `;
        currentDesserts.appendChild(li);

        // เพิ่ม input hidden ในฟอร์ม
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'desserts[]';
        input.value = dessertId;
        document.getElementById('selected-desserts-inputs').appendChild(input);
    }

    // ลบขนม
    function removeDessert(dessertId) {
        const li = document.querySelector(li button[onclick="removeDessert(${dessertId})"]).parentElement;
        li.remove();

        // ลบ input hidden ที่เกี่ยวข้อง
        const inputs = document.querySelectorAll('#selected-desserts-inputs input');
        inputs.forEach(input => {
            if (input.value == dessertId) {
                input.remove();
            }
        });
    }
</script>
@endsection