@extends('layouts.layout')
@section('title', 'หน้าหลัก')
@section('header', 'หน้าหลัก')
@section('content')
<!-- Slideshow Container -->
<div class="slideshow-container overflow-hidden shadow-md mb-8">
    <!-- Slides -->
    <div class="slide active">
        <a href="">
            <img src="{{ asset('img/poster1.png') }}" alt="Poster 2" class="absolute w-full h-auto object-cover">
        </a>
    </div>
    <div class="slide active">
        <a href="">
            <img src="{{ asset('img/poster2.png') }}" alt="Poster 3" class="absolute w-full h-auto object-cover">
        </a>
    </div>
    <div class="">
        <a href="">
            <img src="{{ asset('img/poster1.png') }}" alt="Notuse" class=" w-full h-auto object-cover">
        </a>
    </div>
</div>
<div style="margin-top:50px; margin-bottom:50px;">
    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-lg ">
        @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
        @endif
        <!-- Banner Section -->
        <div class="text-center my-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">เลือกเทศกาลที่ต้องการได้เลย!</h1>
            <p class="text-lg text-gray-600">กรุณาเลือกเทศกาลที่ท่านต้องการ เพื่อค้นหาขนมที่เปิดขายและทำการสั่งซื้อ</p>
        </div>

        <!-- Festival Select Section -->
        <div class="flex items-center gap-4 mb-6 justify-center">
            <label for="festival_id" class="text-lg">เลือกเทศกาล:</label>
            <form method="GET" action="{{ route('dessert.home') }}">
                <select name="festival_id" id="festival_id" class="block w-p-2 border rounded-md" onchange="this.form.submit()">
                    @foreach($festivals as $festival)
                    <option value="{{ $festival->FestivalID }}"
                        {{ request('festival_id') == $festival->FestivalID ? 'selected' : '' }}>
                        {{ $festival->Festival_name }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>

       <!-- Product Grid Section -->
<div class="grid grid-cols-1 overflow-x-auto whitespace-nowrap p-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($festivalDesserts as $dessert)
    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:translate-y-[-10px]">
        <div class="text-center">
            <!-- Show Dessert Image -->
            @if($dessert->image)
            <img src="{{ asset('storage/' . $dessert->image) }}" alt="{{ $dessert->Dessert_name }}" class="w-full h-48 object-cover rounded-lg mb-4 transition-all duration-500 hover:opacity-90">
            @else
            <img src="https://via.placeholder.com/300" alt="No image" class="w-full h-48 object-cover rounded-lg mb-4 transition-all duration-500 hover:opacity-90">
            @endif

            <h2 class="text-xl font-semibold mb-2 text-gray-800 hover:text-blue-500 transition-all duration-300">{{ $dessert->Dessert_name }}</h2>
            <p class="text-lg font-medium text-gray-700 mb-4">{{ number_format($dessert->price, 2) }} บาท</p>
        </div>

        <!-- Add to Cart Button -->
        <form action="{{ route('cart.add', ['dessert' => $dessert->DessertID , 'festival_id' => request('festival_id')]) }}" method="POST">
            @csrf
            <div class="w-full max-w-sm relative mt-4">
                <label class="block mb-1 text-sm text-slate-600">จำนวนชิ้น</label>
                <div class="relative bg-white">
                    <button class="decreaseButton absolute left-1 top-1 rounded-md border border-transparent p-1.5 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button" data-dessertid="{{ $dessert->DessertID }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                            <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
                        </svg>
                    </button>
                    <input id="amount_{{ $dessert->DessertID }}" name="amount" type="number" value="1" min='1'
                        class="w-full bg-transparent placeholder:text-slate-400 text-center text-sm border border-slate-200 rounded-md py-2 pl-10 pr-10 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />
                    <button class="increaseButton absolute right-1 top-1 rounded-md border border-transparent p-1.5 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type="button" data-dessertid="{{ $dessert->DessertID }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                            <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-[#f7be5b] text-white p-3 rounded-lg hover:bg-gradient-to-l focus:outline-none focus:ring-2 focus:ring-blue-500 mt-4 transition-all duration-300 ease-in-out transform hover:scale-105 hover:translate-y-[-5px] hover:bg-[#ffb42f]">เพิ่มลงตะกร้า</button>
            </div>
        </form>
    </div>
    @endforeach
</div>


        <!-- Pagination -->
        <div class="mt-6">
            {{ $desserts->links() }}
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle increase button
    document.querySelectorAll('.increaseButton').forEach(button => {
        button.addEventListener('click', function () {
            const dessertId = this.getAttribute('data-dessertid');
            const inputField = document.getElementById(`amount_${dessertId}`);
            let currentValue = parseInt(inputField.value);
            inputField.value = currentValue + 1;
        });
    });

    // Handle decrease button
    document.querySelectorAll('.decreaseButton').forEach(button => {
        button.addEventListener('click', function () {
            const dessertId = this.getAttribute('data-dessertid');
            const inputField = document.getElementById(`amount_${dessertId}`);
            let currentValue = parseInt(inputField.value);
            if (currentValue > 1) {
                inputField.value = currentValue - 1;
            }
        });
    });
});

</script>


@endsection