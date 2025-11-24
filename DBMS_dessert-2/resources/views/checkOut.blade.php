<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>check out | sweet</title>
        <link rel="icon" href="{{ asset('/img/pic1.png') }}" type="image/png">
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
</head>
<body class="bg-gradient-to-r from-[#8C0F18] via-[#9E131F] to-[#6F0E14] flex justify-center items-center min-h-screen overflow-auto font-kanit relative bg-black bg-opacity-80">
    
    <div class="w-full max-w-[80%] p-6 bg-white rounded-lg shadow-xl">
        <div class="container mx-auto ">
            <!-- Invoice -->
            <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
                <!-- Grid -->
                <div class="mb-5 pb-5 flex justify-between items-center border-b border-gray-700 dark:border-neutral-700">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">รายละเอียดคำสั่งซื้อ</h2>
                    </div>
                </div>
                <!-- End Grid -->

                <form action="{{ route('customer.order') }}" method="POST">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6"> <!-- เพิ่ม gap 6 เพื่อให้มีช่องว่างมากขึ้นระหว่างคอลัมน์ -->
                        <div class="space-y-6"> <!-- เพิ่ม space-y-6 เพื่อเพิ่มช่องว่างระหว่างแต่ละรายการ -->
                            <dl class="flex flex-col sm:flex-row gap-x-3 text-md">
                                <dt class="min-w-[120px] text-gray-800 ">ชื่อผู้สั่ง :</dt> <!-- เพิ่ม min-width -->
                                <dd>
                                    <input type="text" name="name" id="name"
                                        class="w-full border border-slate-300 rounded-md px-3 py-2"
                                        placeholder="กรอกชื่อของคุณ" autofocus />
                                </dd>
                            </dl>
                            <dl class="flex flex-col sm:flex-row gap-x-3 text-md">
                                <dt class="min-w-[120px] text-gray-800">เบอร์โทร :</dt> <!-- เพิ่ม min-width -->
                                <dd>
                                    <input type="tel" name="tel" id="tel"
                                        class="w-full border border-slate-300 rounded-md px-3 py-2"
                                        placeholder="กรอกเบอร์โทรของคุณ" maxlength="10" />
                                </dd>
                            </dl>
                        </div>

                        <div class="space-y-6"> <!-- เพิ่ม space-y-6 เพื่อเพิ่มช่องว่างระหว่างแต่ละรายการ -->
                            
                            <dl class="flex flex-col sm:flex-row gap-x-3 text-md">
                                <dt class="min-w-[120px] text-gray-800">วันที่จะเข้ารับสินค้า :</dt> <!-- เพิ่ม min-width -->
                                <dd>
                                    <input type="date" id="pickup_date" name="pickup_date"
                                        value="{{ old('pickup_date') }}"
                                        class="w-full border border-gray-300 rounded-md px-3 py-2"
                                        min="{{ $festival->Start_date}}" max="{{$festival->End_date}}" />
                                </dd>
                            </dl>
                            <dl class="flex flex-col sm:flex-row gap-x-3 text-md">
                                <dt class="min-w-[120px] text-gray-800">ช่วงเวลาที่จะเข้ารับ :</dt> <!-- เพิ่ม min-width -->
                                <dd>
                                    <select name="pickup_time" id="pickup_time"
                                        class="min-w-[150px] border border-slate-300 rounded-md px-3 py-2">
                                        <option value="1">ช่วงเช้า</option>
                                        <option value="2">ช่วงบ่าย</option>
                                    </select>
                                </dd>
                            </dl>
                            <dl class="flex flex-col sm:flex-row gap-x-3 text-md">
                                <dt class="min-w-[120px] text-gray-800">เทศกาล :</dt> <!-- เพิ่ม min-width -->
                                <dd class="font-medium text-gray-800">
                                    {{$festival->Festival_name}} 
                                    <input hidden name="festival_id" type="number" value="{{$festival->FestivalID}}">
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="mt-6 border border-gray-800 p-4 rounded-lg space-y-4">
                        <div class="hidden sm:grid sm:grid-cols-5">
                            <div class="sm:col-span-2 text-s font-medium text-gray-800 uppercase">รายการ</div>
                            <div class="text-start text-s font-medium text-gray-800 uppercase">จำนวน</div>     
                            <div class="text-start text-s font-medium text-gray-800 uppercase">หน่วยละ</div>
                            <div class="text-end text-s font-medium text-gray-800 uppercase">จำนวนเงิน</div>
                        </div>

                        <div class="hidden sm:block border-b border-gray-800"></div>
                        @foreach($cartItems as $order_dessert)
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                            
                            <div class="col-span-full sm:col-span-2">
                                <p class="font-medium text-gray-800">
                                    {{$order_dessert->dessert()->withTrashed()->first()->Dessert_name}}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-800">{{$order_dessert->quantity}}</p>
                            </div>
                            <div>
                                <p class="text-gray-800">฿{{$order_dessert->price}}</p>
                            </div>
                            <div>
                                <p class="sm:text-end text-gray-800">
                                    ฿{{$order_dessert->price * $order_dessert->quantity}}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- End Table -->

                    <!-- Flex -->
                    <div class="mt-8 flex sm:justify-end">
                        <div class="w-full max-w-2xl sm:text-end space-y-2">
                            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-800">รวมเงิน :</dt>
                                    <dd class="col-span-2 font-medium text-gray-800">{{$orderPrice}} บาท</dd>
                                </dl>
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-800">
                                        <a href="{{route('cart.show')}}">
                                            <button class="border border-red-500 text-red-500 py-3 px-6 rounded-md hover:bg-red-500 hover:text-white transition"
                                                type="button">
                                                ยกเลิก
                                            </button>
                                        </a>
                                    </dt>
                                    <dd class="col-span-2 font-medium text-gray-800">
                                        <button class="w-full bg-green-500 text-white py-3 px-6 rounded-md hover:bg-green-600 transition"
                                            type="submit" onclick="return confirm('ยืนยันที่จะดำเนินการสั่งซื้อ?')">
                                            สั่งซื้อ
                                        </button>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <!-- End Flex -->
                </form>
            </div>
        </div>
    </div>
</body>



</html>