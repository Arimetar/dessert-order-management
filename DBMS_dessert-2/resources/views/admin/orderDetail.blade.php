@extends('layouts.layout')
@section('title', 'รายละเอียดคำสั่งซื้อ')
@section('header', 'รายละเอียดคำสั่งซื้อที่ '.'#'.$order->OrderID)
@section('content')
<div style="margin-top:20px;">
    <div class="container mx-auto max-w-[80%] p-6 bg-white rounded-lg shadow-lg ">
        @if($order->Status == 1)
        <div class="flex justify-center items-center">
            <div class="flex-1 text-center">
                <a href="{{ route('order.status.change', ['order_id' => $order->OrderID, 'status' => 2]) }}">
                    <button class="bg-green-500 text-white py-3 px-6 rounded-md hover:bg-green-600 transition" type="button" onclick="return confirm('คุณยืนยันที่จะยืนยันคำสั่งซื้อ #{{$order->OrderID}} หรือไม่?')">
                        ยืนยันคำสั่งซื้อ
                    </button>
                </a>
            </div>
            <div class="flex-1 text-center">
                <a href="{{ route('order.status.change', ['order_id' => $order->OrderID, 'status' => 0]) }}">
                    <button class="border border-red-500 text-red-500 py-3 px-6 rounded-md hover:bg-red-500 hover:text-white transition" type="button" onclick="return confirm('คุณยืนยันที่จะยกเลิกคำสั่งซื้อ #{{$order->OrderID}} หรือไม่?')">
                        ยกเลิกคำสั่งซื้อ
                    </button>
                </a>
            </div>
        </div>
        @elseif($order->Status == 2)
        <div class="flex-1 text-center pb-3">
            <p>ยืนยันคำสั่งซื้อโดย {{$order->order_employee()->where('status', 2)->first()->employee->Employee_name}}</p>
        </div>
        <div class="flex justify-center items-center">
            <div class="flex-1 text-center">
                <a href="{{ route('order.status.change', ['order_id' => $order->OrderID, 'status' => 3]) }}">
                    <button class="bg-green-500 text-white py-3 px-6 rounded-md hover:bg-green-600 transition" type="button" onclick="return confirm('คุณยืนยันการชำระเงินของคำสั่งซื้อ #{{$order->OrderID}}?')">
                        ยืนยันการชำระเงิน
                    </button>
                </a>
            </div>
        </div>
        @elseif($order->Status == 3)
        <div class="flex-1 text-center pb-3">
            <p>ยืนยันคำสั่งซื้อโดย {{$order->order_employee()->where('status', 2)->first()->employee->Employee_name}} เมื่อวันที่ {{$order->order_employee()->where('status', 2)->first()->created_at}}</p>
        </div>
        <div class="flex-1 text-center pb-3">
            <p>ยืนยันการชำระเงินโดย {{$order->order_employee()->where('status', 3)->first()->employee->Employee_name}} เมื่อวันที่ {{$order->order_employee()->where('status', 3)->first()->created_at}}</p>
        </div>
        <div class="flex justify-center items-center">
            <div class="flex-1 text-center">
                <a href="{{ route('order.status.change', ['order_id' => $order->OrderID, 'status' => 4]) }}">
                    <button class="bg-green-500 text-white py-3 px-6 rounded-md hover:bg-green-600 transition" type="button" onclick="return confirm('คุณยืนยันการเข้ารับสินค้าของคำสั่งซื้อ #{{$order->OrderID}}?')">
                        ยืนยันการเข้ารับสินค้า
                    </button>
                </a>
            </div>
        </div>
        @elseif($order->Status == 4)
        <div class="flex-1 text-center pb-3">
            <p>ยืนยันคำสั่งซื้อโดย {{$order->order_employee()->where('status', 2)->first()->employee->Employee_name}} เมื่อวันที่ {{$order->order_employee()->where('status', 2)->first()->created_at}}</p>
        </div>
        <div class="flex-1 text-center pb-3">
            <p>ยืนยันการชำระเงินโดย {{$order->order_employee()->where('status', 3)->first()->employee->Employee_name}} เมื่อวันที่ {{$order->order_employee()->where('status', 3)->first()->created_at}}</p>
        </div>
        <div class="flex-1 text-center pb-3">
            <p>ยืนยันการเข้ารับสินค้าโดย {{$order->order_employee()->where('status', 3)->first()->employee->Employee_name}} เมื่อวันที่ {{$order->order_employee()->where('status', 4)->first()->created_at}}</p>
        </div>
        @else
        <div class="flex-1 text-center pb-3">
            <p>ยืนยันการยกเลิกคำสั่งซื้อโดย {{$order->order_employee()->where('status', 0)->first()->employee->Employee_name}}</p>
        </div>
        @endif
    </div>
</div>
<div style="margin-top:20px; margin-bottom:50px;">
    <div class="container mx-auto max-w-[80%] p-6 bg-white rounded-lg shadow-lg ">
        <!-- Invoice -->
        <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
            <!-- Grid -->
            <div class="mb-5 pb-5 flex justify-between items-center border-b border-gray-700 dark:border-neutral-700">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 ">คำสั่งซื้อที่ #{{$order->OrderID}}</h2>
                </div>
                <!-- Col -->
                <div class="inline-flex gap-x-2">
                    @if($order->Status == 1)
                    <dd class="text-yellow-500 dark:text-yellow-500">
                        รอการยืนยันคำสั่งซื้อ
                    </dd>
                    @elseif($order->Status == 2)
                    <dd class="text-blue-500 dark:text-blue-500">
                        ยืนยันคำสั่งซื้อแล้ว
                    </dd>
                    @elseif($order->Status == 3)
                    <dd class="text-green-700 dark:text-green-700">
                    ชำระเงินแล้ว
                    </dd>
                    @elseif($order->Status == 4)
                    <dd class="text-teal-500 dark:text-teal-500">
                        เข้ารับสินค้าแล้ว
                    </dd>
                    @else
                    <dd class="text-red-700 dark:text-red-700">
                        ยกเลิกคำสั่งซื้อ
                    </dd>
                    @endif
                </div>
                <!-- Col -->
            </div>
            <!-- End Grid -->
            <!-- Grid -->
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <div class="grid space-y-3">
                        <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                            <dt class="min-w-36 max-w-50 text-gray-800 dark:text-neutral-800">
                                ชื่อผู้สั่ง :
                            </dt>
                            <dd class="text-gray-800 dark:text-neutral-800">
                                {{$order->customer->Customer_name}}
                            </dd>
                        </dl>
                        <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                            <dt class="min-w-36 max-w-50 text-gray-800 dark:text-neutral-800">
                                เบอร์โทร :
                            </dt>
                            <dd class="text-gray-800 dark:text-neutral-800">
                                {{$order->customer->Customer_tel}}
                            </dd>
                        </dl>
                    </div>
                </div>
                <!-- Col -->

                <div>
                    <div class="grid space-y-3">

                        <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                            <dt class="min-w-36 max-w-50 text-gray-800 dark:text-neutral-800">
                                วันที่จะเข้ารับสินค้า :
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-neutral-800">
                                {{ \Carbon\Carbon::parse($order->PickUp_date)->locale('th')->translatedFormat('d F Y') }}
                            </dd>
                        </dl>

                        <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                            <dt class="min-w-36 max-w-50 text-gray-800 dark:text-neutral-800">
                                ช่วงเวลา :
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-neutral-800">
                                @if($order->PickUp_time == 1)
                                <div class="flex-1 text-center">ช่วงเช้า (08:00 - 12:00)</div>
                                @else
                                <div class="flex-1 text-center">ช่วงบ่าย (13:00 - 17:00)</div>
                                @endif
                            </dd>
                        </dl>

                        <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                            <dt class="min-w-36 max-w-50 text-gray-800 dark:text-neutral-800">
                                เทศกาล :
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-neutral-800">
                                {{$order->festival()->withTrashed()->first()->Festival_name}}
                            </dd>
                        </dl>
                        <!--
                        <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                            <dt class="min-w-36 max-w-50 text-gray-800 dark:text-neutral-800">
                                สถานะคำสั่งซื้อ :
                            </dt>
                            @if($order->Status == 0)
                            <dd class="font-medium text-gray-400 dark:text-neutral-400">
                                รอการยืนยันคำสั่งซื้อ
                            </dd>
                            @elseif($order->Status == 0)
                            <dd class="font-medium text-gray-400 dark:text-neutral-400">
                                ยกเลิกคำสั่งซื้อ
                            </dd>
                            @else
                            <dd class="font-medium text-green-400 dark:text-green-400">
                                ยืนยันคำสั่งซื้อแล้ว
                            </dd>
                        </dl>
                        
                        <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                            <dt class="min-w-36 max-w-50 text-gray-800 dark:text-neutral-800">
                                การชำระเงิน :
                            </dt>
                            @if($order->Status <=2)
                            <dd class="font-medium text-red-400 dark:text-red-400">
                                ยังไม่ชำระเงิน
                            </dd>
                            @else
                            <dd class="font-medium text-green-400 dark:text-green-400">
                                ชำระเงินแล้ว
                            </dd>
                            @endif
                        </dl>
                        <dl class="flex flex-col sm:flex-row gap-x-3 text-sm">
                            <dt class="min-w-36 max-w-50 text-gray-800 dark:text-neutral-800">
                                การเข้ารับสินค้า :
                            </dt>
                            <dd class="font-medium text-red-400 dark:text-red-400">
                            </dd>
                        </dl>
                        @endif
                    -->
                    </div>
                </div>
                <!-- Col -->
            </div>
            <!-- End Grid -->

            <!-- Table -->
            <div class="mt-6 border border-gray-800 p-4 rounded-lg space-y-4 dark:border-neutral-700">
                <div class="hidden sm:grid sm:grid-cols-5">
                    <div class="sm:col-span-2 text-s font-medium text-gray-800 uppercase dark:text-neutral-800">รายการ</div>
                    <div class="text-start text-s font-medium text-gray-800 uppercase dark:text-neutral-800">จำนวน</div>
                    <div class="text-start text-s font-medium text-gray-800 uppercase dark:text-neutral-800">หน่วยละ</div>
                    <div class="text-end text-s font-medium text-gray-800 uppercase dark:text-neutral-800">จำนวนเงิน</div>
                </div>

                <div class="hidden sm:block border-b border-gray-800 dark:border-neutral-700"></div>

                @foreach($order->order_desserts as $order_dessert)
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
            
                    <div class="col-span-full sm:col-span-2">
                        <h5 class="sm:hidden text-xs font-medium text-gray-800 uppercase dark:text-neutral-800">Item</h5>
                        <p class="font-medium text-gray-800 dark:text-neutral-800">{{$order_dessert->dessert()->withTrashed()->first()->Dessert_name}}</p>
                    </div>
                    <div>
                        <h5 class="sm:hidden text-xs font-medium text-gray-800 uppercase dark:text-neutral-800">Qty</h5>
                        <p class="text-gray-800 dark:text-neutral-800">{{$order_dessert->Amount}}</p>
                    </div>
                    <div>
                        <h5 class="sm:hidden text-xs font-medium text-gray-800 uppercase dark:text-neutral-800">Rate</h5>
                        <p class="text-gray-800 dark:text-neutral-800">฿{{$order_dessert->dessert()->withTrashed()->first()->price}}</p>
                    </div>
                    <div>
                        <h5 class="sm:hidden text-xs font-medium text-gray-800 uppercase dark:text-neutral-800">Amount</h5>
                        <p class="sm:text-end text-gray-800 dark:text-neutral-800">฿{{$order_dessert->Total_Price}}</p>
                    </div>
                </div>
                @endforeach
                <div class="sm:hidden border-b border-gray-800 dark:border-neutral-700"></div>
            </div>
            <!-- End Table -->
            <!-- Flex -->
            <div class="mt-8 flex sm:justify-end">
                <div class="w-full max-w-2xl sm:text-end space-y-2">
                    <!-- Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                        <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-800 dark:text-neutral-800">รวมเงิน :</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-800">{{$order->Total_price}} บาท</dd>
                        </dl>
                        @if($order->Status !=0 && $order->Status !=1)
                            @if($order->Status >=3)
                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                <dt class="col-span-3 text-gray-800 dark:text-neutral-800">การชำระ :</dt>
                                <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-800">ชำระเงินแล้ว <br>{{$order->order_employee()->where('status', 3)->first()->created_at}}</dd>
                            </dl>
                            @else
                            <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                <dt class="col-span-3 text-gray-800 dark:text-neutral-800">การชำระ :</dt>
                                <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-800">ค้างชำระ</dd>
                            </dl>
                                @if($order->Status ==4)

                                @else
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-800 dark:text-neutral-800">การเข้ารับสินค้า :</dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-800">ยังไม่เข้ารับสินค้า</dd>
                                </dl>
                                @endif
                            @endif
                        @endif
                        <!--
                        <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-800 dark:text-neutral-800">Tax:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-800">$39.00</dd>
                        </dl>
    
                        <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-800 dark:text-neutral-800">Amount paid:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-800">$2789.00</dd>
                        </dl>
    
                        <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                            <dt class="col-span-3 text-gray-800 dark:text-neutral-800">Due balance:</dt>
                            <dd class="col-span-2 font-medium text-gray-800 dark:text-neutral-800">$0.00</dd>
                        </dl>
    -->
                    </div>
                    <!-- End Grid -->
                </div>
            </div>
            <!-- End Flex -->

            <div class="mt-8 sm:mt-12">
                <h4 class="text-lg font-semibold text-gray-800">ขอบคุณสำหรับการสั่งซื้อ!</h4>
                <p class="text-gray-500 dark:text-neutral-500">หากต้องการแก้ไขคำสั่งซื้อหรือมีต้องการสอบถามโปรดติดต่อตามที่อยู่นี้:</p>
                <div class="mt-2">
                    <p class="block text-sm font-medium text-gray-800">ข้างโลตัสรอบเมือง ตำบลในเมือง อำเภอเมืองขอนแก่น ขอนแก่น 40000</p>
                    <p class="block text-sm font-medium text-gray-800">086-666-6666</p>
                    <p class="block text-sm font-medium text-gray-800">099-999-9999</p>
                </div>
            </div>
            <!-- End Invoice -->
        </div>
    </div>
</div>
@endsection