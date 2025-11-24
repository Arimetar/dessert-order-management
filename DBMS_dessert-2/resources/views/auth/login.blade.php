@extends('layouts.layout')
@section('title', 'เข้าสู่ระบบ')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="w-full max-w-4xl bg-white border border-gray-300 rounded-lg shadow-xl flex flex-col lg:flex-row mx-auto h-[85vh]">
        <!-- Left Side: Branding -->
        <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-[#A31D1D] via-[#BE3144] to-[#E17564] text-white p-10 rounded-l-lg flex flex-col">

            <div class="flex flex-col justify-center items-center text-center h-full">
                <!-- Logo -->
                <img src="\img\logo3.png" alt="Logo" class="mb-4 ">
                <h1 class="text-4xl font-bold mb-2">ร้านป้าแอ๊ดขนมหวาน</h1>
                <p class="text-sm mb-10"><br>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 bg-white p-8 lg:p-12 rounded-r-lg shadow-lg overflow-y-auto flex justify-center items-center h-full">
    <!-- Login Form -->
    <div class="flex-col items-center justify-center flex-grow">
        <h1 class="text-4xl font-bold text-center mb-6">เข้าสู่ระบบพนักงาน</h1>
        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4 text-md">
                <x-label for="email" value="{{ __('อีเมล') }}" class="text-md" />
                <x-input id="email" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-md" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mb-4 text-md">
                <x-label for="password" value="{{ __('รหัสผ่าน') }}" class="text-md"/>
                <x-input id="password" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-md" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('จดจำฉัน') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-center mt-4 ">

                <x-button class="ms-4 ">
                    {{ __('เข้าสู่ระบบ') }}
                </x-button>
            </div>
        </form>
    </div>
</div>

        </div>
    </div>
</div>
@endsection
