@extends('layouts.layout')
@section('title', 'รายการขนม')
@section('header', 'รายการขนม')
@section('content')
<div style="margin-top:50px;">
    <div class="container mx-auto max-w-[80%] p-6 bg-white rounded-lg shadow-lg">
        
        @if(session('complete'))
            <div class="container bg-green-500 max-w-full justify-center text-white p-4 rounded-lg mb-4">
                {{ session('complete') }}
            </div>
        @endif
        
           
       
        <form method="GET" action="{{ route('admin.dessert.filter') }}" class="flex justify-end items-center mb-4">
            <label for="festival_id" class="text-lg mr-2">เลือกเทศกาล:</label>
            <select name="festival_id" id="festival_id" class="block w-[200px] p-2 border rounded-md" onchange="this.form.submit()">
                <option value="0">ทุกเทศกาล</option>
                @foreach($festivals as $festival)
                    <option value="{{ $festival->FestivalID }}" 
                        {{ request('festival_id') == $festival->FestivalID ? 'selected' : '' }}>
                        {{ $festival->Festival_name }}
                    </option>
                @endforeach
            </select>
        </form>


        <!-- ข้อมูลจำนวนขนมทั้งหมด, เปิดให้สั่งซื้อ, ไม่เปิดให้สั่งซื้อ -->
       <div class="flex space-x-4">
    <div class=" p-6 flex-1 rounded-lg shadow-lg text-center transition duration-200 border border-gradient-to-r from-purple-500 to-pink-500 mb-8">
        <p class="text-lg font-semibold">ประเภทขนมทั้งหมด</p>
        <p class="text-sm text-black">
            @if($off_dessert->isEmpty())
                {{ count($desserts) }}
            @else
                {{ count($off_dessert) + count($desserts) }}
            @endif รายการ
        </p>
    </div>
    <div class=" p-6 flex-1 rounded-lg shadow-lg text-center transition duration-200 border border-gradient-to-r from-green-500 to-blue-500 mb-8">
        <p class="text-lg font-semibold text-green-600">เปิดให้สั่งซื้อ</p>
        <p class="text-sm text-gray-500">{{ count($desserts) }} รายการ</p>
    </div>
    <div class="p-6 flex-1 rounded-lg shadow-lg text-center transition duration-200 border border-gradient-to-r from-yellow-500 to-red-500 mb-8">
        <p class="text-lg font-semibold text-red-600">ไม่เปิดให้สั่งซื้อ</p>
        <p class="text-sm text-gray-500">
            @if($off_dessert->isEmpty()) 0 @else {{ count($off_dessert) }} @endif รายการ
        </p>
    </div>
</div>

        
    </div>
</div>

<div style="margin-top:25px;">
    <div class="container mx-auto max-w-[80%] p-6 bg-white rounded-lg shadow-lg mb-6">
        <div class="flex space-x-8">
            <!-- ฟอร์ม -->
            <div class="w-[35%] p-6 rounded-lg shadow-lg bg-white">
                <h1 class="text-xl font-semibold mb-4 text-center">เพิ่มขนมประเภทใหม่</h1>

                @if(session('success'))
                    <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('desserts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Dessert Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-lg font-medium text-gray-700">ชื่อขนม</label>
                        <input type="text" name="name" id="name"
                            class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('name') }}" required placeholder="เช่น ขนมเทียนไส้หวาน">
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-lg font-medium text-gray-700">ราคาต่อหน่วย</label>
                        <input type="number" name="price" id="price"
                            class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('price') }}" min=1 required placeholder="เช่น 6">
                        @error('price')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="form-group mb-4">
                        <label for="image" class="block text-lg font-medium text-gray-700">ภาพประกอบขนม (ไม่บังคับ)</label>
                        <input type="file" name="image" id="image"
                            class="w-full p-3 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            accept="image/*">
                        @error('image')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="festival_id" class="block text-gray-700 font-semibold mb-2">เลือกเทศกาล</label>
                        <select name="festival_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach($festivals as $festival)
                                <option value="{{ $festival->FestivalID }}">{{ $festival->Festival_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full hover:bg-[#ffb42f] bg-[#f7be5b] text-white p-3 rounded-lg  focus:outline-none focus:ring-2 focus:ring-blue-500 mt-5">
                        เพิ่มขนม
                    </button>
                </form>
            </div>

      <!-- รายการขนม -->
<div class="w-[65%] p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-xl font-semibold mb-4 text-center">รายการขนม</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 overflow-y-auto" style="max-height: 400px;">
        @foreach($desserts as $dessert)
            <div class="p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex flex-col justify-between border border-gray-300 bg-white">
                <div class="text-center">
                    <!-- Show Dessert Image -->
                    @if($dessert->image)
                        <img src="{{ asset('storage/' . $dessert->image) }}" alt="{{ $dessert->Dessert_name }} "
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                        <img src="https://via.placeholder.com/300" alt="รูป{{ $dessert->Dessert_name }} "
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    @endif

                    <h2 class="text-lg font-semibold mb-2">{{ $dessert->Dessert_name }}</h2> <!-- ปรับขนาดชื่อขนม -->
                    <p class="text-lg font-medium text-gray-700">{{ number_format($dessert->price, 2) }} บาท</p>
                    <a href="{{ route('admin.dessert.off', $dessert->DessertID) }}">
                        <button type="submit"
                                class="border border-black mt-4 text-gray-700 py-3 px-6 rounded-md hover:bg-red-600 hover:text-white transition"
                                onclick="return confirm('ยืนยันที่จะปิดไม่ให้สั่งขนม{{$dessert->Dessert_name}}?')">
                            ปิดไม่ให้สั่งซื้อ
                        </button>
                    </a>
                </div>
            </div>
        @endforeach

        @if(!($off_dessert->isEmpty()))
            @foreach($off_dessert as $dessert)
                <div class="p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex flex-col justify-between border border-gray-300 bg-gray-200">
                    <div class="text-center">
                        @if($dessert->image)
                            <img src="{{ asset('storage/' . $dessert->image) }}" alt="{{ $dessert->Dessert_name }} "
                                 class="w-full h-48 object-cover rounded-lg mb-4">
                        @else
                            <img src="https://via.placeholder.com/300" alt="No image"
                                 class="w-full h-48 object-cover rounded-lg mb-4">
                        @endif

                        <h2 class="text-lg text-gray-300 font-semibold mb-2">{{ $dessert->Dessert_name }}</h2> <!-- ปรับขนาดชื่อขนม -->
                        <p class="text-lg text-gray-300 font-medium">{{ number_format($dessert->price, 2) }} บาท</p>
                        <a href="{{ route('admin.dessert.on', $dessert->DessertID) }}">
                            <button type="submit"
                                    class="border border-gray-300 mt-4 text-gray-300 py-3 px-6 rounded-md hover:bg-green-600 hover:text-white transition"
                                    onclick="return confirm('ยืนยันที่จะเปิดให้สั่งขนม{{$dessert->Dessert_name}}?')">
                                เปิดให้สั่งซื้อ
                            </button>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>


        </div>
    </div>
</div>



@endsection