<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | sweet</title>
    <link rel="icon" href="{{ asset('/img/logosweetchoice2.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">


    <style>
        .slide {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slide.active {
            opacity: 1;
        }

        .slide img {
            object-fit: cover;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- from cdn -->
    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/dialog.js"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen font-kanit">
    <div class="flex w-full h-[100px] bg-gradient-to-r from-[#8B0000] via-[#B22222] to-[#8B0000] shadow-lg">
        <div class="container flex items-center justify-between h-[100px] mx-auto px-6 text-white">
            <!-- โลโก้ -->
            <a href="{{ route('dessert.home') }}" class="flex items-center min-w-[200px] ">
                <img src="/img/logo3.png" alt="dessert" width="80" height="60">
                <x-application-mark class="block h-9 w-auto font-s" />
            </a>
            <div>
                <ul class="flex gap-7">
                    <!-- Login/Register Section -->
                    @auth
                    <li><a href="{{route('admin.orders')}}" class="text-white hover:text-[#ffb42f]">คำสั่งซื้อทั้งหมด</a></li>
                    
                    <li class="relative group">
                        <button class="text-white hover:text-[#ffb42f] inline-flex items-center ">
                            จัดการ
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div class="absolute hidden group-hover:block bg-white shadow-lg border mt-1 rounded-lg z-50 min-w-max">
                            <a href="{{route('admin.festivals')}}" class="text-black block px-4 py-2 text-black hover:bg-gray-100">จัดการเทศกาล</a>
                            <a href="{{ route('admin.dessert') }}" class="text-black block px-4 py-2 text-black hover:bg-gray-100">จัดการขนม</a>
                        </div>
                    </li>
                    <li class="relative group">
                        <button class="text-white hover:text-[#ffb42f] inline-flex items-center  " >
                            {{ Auth::user()->name }}
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div class="absolute hidden group-hover:block bg-white shadow-lg border mt-1 rounded-lg z-50 min-w-max">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();" class="block px-4 py-2 text-black hover:bg-gray-100">ออกจากระบบ</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a href="{{ route('register.page') }}" class="block px-4 py-2 text-black hover:bg-gray-100">สร้างบัญชี</a>

                        </div>
                    </li>
                    @else
                    <li><a href="{{ route('dessert.home') }}" class="text-white hover:text-[#ffde00]">หน้าหลัก</a></li>
                    <li><a href="{{ route('customer.check') }}" class="text-white hover:text-[#ffde00]">ตรวจสอบสถานะ</a></li>
                    @if(isset($quantity))<li>
                        <a href="{{route('cart.show')}}"
                            class="relative flex items-center text-white hover:text-[#ffde00]">
                            <span>ตะกร้า</span>
                            <!-- Display Cart Count -->
                            <span class="absolute top-[-15px] right-[-10px] bg-red-600 text-white text-xs rounded-full px-2 py-1">
                                {{ $quantity }}
                            </span>
                        </a>
                    </li>
                    @endif
                    <!--<a href="{{ route('register.page') }}" class="text-black hover:text-[#FF2D20]">สร้างบัญชี</a>-->
                    <a href="{{ route('login') }}" class="text-white hover:text-[#ffde00]">เข้าสู่ระบบพนักงาน</a>
                    @endauth

                </ul>
            </div>
        </div>
    </div>
    <div class="flex items-center w-full h-[70px] bg-gradient-to-r from-[#7F0000] via-[#A52A2A] to-[#7F0000] shadow-inner  shadow-lg">
    <div class="container mx-auto px-4 ">
        <h2 class="font-semibold text-xl text-white leading-tight ">
            @yield('header')
        </h2>
    </div>
</div>


    @yield('content')

    <footer class="w-full bg-gradient-to-r from-[#8B0000] via-[#B22222] to-[#8B0000] text-gray-800 py-6 mx-auto border-t border-gray-300 text-white mt-auto">
    <div class="max-w-[60%] mx-auto px-4 text-center">
        <h5 class="text-lg font-semibold mb-2">ติดต่อได้ที่</h5>
        <p class="text-md">ข้างโลตัสรอบเมือง ตำบลในเมือง อำเภอเมืองขอนแก่น ขอนแก่น 40000</p>
        <p class="text-sm">Contact 1: +123 456 7890</p>
        <p class="text-sm">Contact 2: +123 456 7890</p>
    </div>
    <div class="mt-6 border-t border-gray-300 pt-4">
        <p class="text-center text-sm">&copy; {{ date('Y') }} ร้านป้าแอ๊ดขนมหวาน. All rights reserved.</p>
    </div>
</footer>

</body>

</html>

<script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        const slides = document.getElementsByClassName("slide");
        for (let i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        slides[slideIndex - 1].classList.add("active");
        setTimeout(showSlides, 10000);
    }
</script>