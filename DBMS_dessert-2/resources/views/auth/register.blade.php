@extends('layouts.layout')
@section('title', 'ลงทะเบียน')
@section('content')
<div style="margin-top:50px; margin-bottom:50px; ">
    <div class="container mx-auto max-w-[40%] p-6 bg-white rounded-lg shadow-lg ">
        <div class="text-center my-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">ลงทะเบียนพนักงาน</h1>
        </div>
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('ชื่อ-สกุล') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>
            
            <div class="mt-4">
                <x-label for="email" value="{{ __('อีเมล') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="position" value="{{ __('ตำแหน่ง') }}" />
                <x-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" required/>
            </div>
            
            <div class="mt-4">
                <x-label for="password" value="{{ __('รหัสผ่าน') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('ยืนยันรหัสผ่าน') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                

                <x-button class="ms-4">
                    {{ __('ลงทะเบียน') }}
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection