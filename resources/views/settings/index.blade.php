@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">إعدادات النظام</h1>
            <p class="text-gray-600">إدارة إعدادات النظام والحساب الشخصي</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- قائمة الإعدادات الجانبية -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 bg-gray-50 border-b">
                    <h3 class="font-medium">أقسام الإعدادات</h3>
                </div>
                <div class="divide-y">
                    <a href="#system" class="block p-4 hover:bg-gray-50 transition">
                        <div class="flex items-center">
                            <i class="uil uil-setting ml-3 text-purple-600"></i>
                            <span>إعدادات النظام</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- محتوى الإعدادات -->
        <div class="lg:col-span-2">
            <div id="system" class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">إعدادات النظام</h2>
                <p class="text-gray-600 mb-4">إعدادات عامة للنظام</p>
                <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-6 mt-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block mb-1 font-medium">اسم النظام</label>
                        <input type="text" name="site_name" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="{{ old('site_name', \App\Http\Controllers\SettingsController::get('site_name', config('app.name'))) }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">البريد الإلكتروني للدعم</label>
                        <input type="email" name="support_email" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="{{ old('support_email', \App\Http\Controllers\SettingsController::get('support_email', config('mail.from.address'))) }}">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">شعار النظام</label>
                        <input type="file" name="site_logo" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @php $logo = \App\Http\Controllers\SettingsController::get('site_logo'); @endphp
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="شعار النظام" class="h-16 mt-2">
                        @endif
                    </div>
                    
                    
                    <div class="pt-4">
                        <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">حفظ الإعدادات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection