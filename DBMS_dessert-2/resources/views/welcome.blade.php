<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Choice</title>
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

<body>
    <div class="flex w-full h-[80px] bg-white border-b border-gray-100">
        <div class="container flex items-center justify-between h-full mx-auto ">
            <div>
                <a href="{{ route('dessert.home') }}" class="text-black font-bold">Dessert</a>
            </div>
            <div>
                <ul class="flex gap-7">
                    <li><a href="">หน้าหลัก</a></li>
                    <li><a href="">ตรวจสอบสถานะ</a></li>
                    <li>
                        <a href="{{route('cart.show')}}"
                            class="relative flex items-center text-black hover:text-[#FF2D20]">
                            <span>ตะกร้า</span>
                            <!-- Display Cart Count -->
                            <span
                                class="absolute top-[-10px] right-[-10px] bg-red-600 text-white text-xs rounded-full px-2 py-1">
                                {{ $quantity }}
                            </span>

                        </a>
                    </li>
                    <!-- Login/Register Section -->
                    @if (Route::has('login'))
                    <li>
                        @auth
                        <a href="{{ url('/dashboard') }}" class="text-black hover:text-[#FF2D20]">Dashboard</a>
                        @else
                        <a href="{{ route('login') }}" class="text-black hover:text-[#FF2D20]">Log in</a>

                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-black hover:text-[#FF2D20]">Register</a>
                        @endif
                        @endauth
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

     <!-- Slideshow Container -->
     <div class="slideshow-container overflow-hidden shadow-md mb-8">
        <!-- Slides -->
        <div class="slide active">
            <a href="">
                <img src="{{ asset('img/poster4.png') }}" alt="Poster 2" class="absolute w-full h-auto object-cover">
            </a>
        </div>
        <div class="slide active">
            <a href="">
                <img src="{{ asset('img/poster4.png') }}" alt="Poster 3" class="absolute w-full h-auto object-cover">
            </a>
        </div>
        <div class="">
            <a href="">
                <img src="{{ asset('img/poster4.png') }}" alt="Notuse" class=" w-full h-auto object-cover">
            </a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-6">
        <!-- Banner Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Delicious Desserts Just For You!</h1>
            <p class="text-lg text-gray-600">Browse through our wide selection of mouth-watering desserts</p>
        </div>

        <!-- Festival Select Section -->
        <div class="flex items-center gap-4 mb-6">
            <label for="festival_id" class="text-lg">Select Festival</label>
            <form method="GET" action="{{ route('dessert.home') }}">
                <select name="festival_id" id="festival_id" class="p-2 border rounded-md" onchange="this.form.submit()">
                    <option value="">Select Festival</option>
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
        <div
            class="grid grid-cols-1 overflow-x-auto whitespace-nowrap p-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($festivalDesserts as $dessert)
            <div class="bg-gray-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <div class="text-center">
                    <!-- Show Dessert Image -->
                    @if($dessert->image)
                    <img src="{{ asset('storage/' . $dessert->image) }}" alt="{{ $dessert->Dessert_name }}"
                        class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                    <img src="https://via.placeholder.com/300" alt="No image"
                        class="w-full h-48 object-cover rounded-lg mb-4">
                    @endif

                    <h2 class="text-xl font-semibold mb-2">{{ $dessert->Dessert_name }}</h2>
                    <p class="text-lg font-medium text-gray-700">{{ number_format($dessert->price, 2) }} บาท</p>
                </div>
                <!-- Add to Cart Button -->
                <form action="{{ route('cart.add', ['dessert' => $dessert->DessertID , 'festival_id' => request('festival_id')]) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-5">เพิ่มลงตะกร้า</button>
                </form>

            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $desserts->links() }}
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-6 mt-12 mx-auto">
    <div class="max-w-[60%] mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between">
            <div class="mb-4 md:mb-0">
                <h5 class="text-lg font-semibold">{{ __('message.home_contact') }}</h5>
                <p class="text-sm">Email: support@example.com</p>
                <p class="text-sm">Phone: +123 456 7890</p>
            </div>
            <div class="mb-4 md:mb-0">
                <h5 class="text-lg font-semibold">{{ __('message.home_follow') }}</h5>
                <div class="flex space-x-4 mt-2">
                    <a href="#" class="text-gray-400 hover:text-white">Facebook</a>
                    <a href="#" class="text-gray-400 hover:text-white">Twitter</a>
                    <a href="#" class="text-gray-400 hover:text-white">Instagram</a>
                </div>
            </div>
            <div>
                <h5 class="text-lg font-semibold">{{ __('message.home_legal') }}</h5>
                <p class="text-sm"><a href="#" class="text-gray-400 hover:text-white">{{ __('message.home_privacy') }}</a></p>
                <p class="text-sm"><a href="#" class="text-gray-400 hover:text-white">{{ __('message.home_termsofservice') }}</a></p>
            </div>
        </div>
    </div>
    <div class="mt-6 border-t border-gray-700 pt-4">
        <p class="text-center text-sm">&copy; {{ date('Y') }} MEDICHECK. All rights reserved.</p>
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
            if (slideIndex > slides.length) {slideIndex = 1}
            slides[slideIndex - 1].classList.add("active");
            setTimeout(showSlides, 10000);
        }
</script>
