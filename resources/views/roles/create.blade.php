@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">إضافة دور جديد</h1>
            <p class="text-gray-600">إنشاء دور جديد في النظام</p>
        </div>
        <a href="{{ route('roles.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
            <i class="uil uil-arrow-right ml-1"></i> العودة للقائمة
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <label for="name" class="block mb-2 font-bold">اسم الدور</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="block mb-2 font-bold">وصف الدور</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                    حفظ الدور
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
