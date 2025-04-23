@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">إضافة مستخدم جديد</h1>
            <p class="text-gray-600">إنشاء حساب مستخدم جديد في النظام</p>
        </div>
        <a href="{{ route('users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
            <i class="uil uil-arrow-right ml-1"></i> العودة للقائمة
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block mb-2 font-bold">الاسم</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block mb-2 font-bold">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block mb-2 font-bold">كلمة المرور</label>
                    <input type="password" name="password" id="password" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block mb-2 font-bold">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                </div>
            </div>
            
            <div class="mb-6">
                <label for="user_type" class="block mb-2 font-bold">نوع المستخدم</label>
                <select name="user_type" id="user_type" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('user_type') border-red-500 @enderror" required>
                    <option value="">اختر النوع...</option>
                    <option value="مدير" {{ old('user_type') == 'مدير' ? 'selected' : '' }}>مدير</option>
                    <option value="سكرتير" {{ old('user_type') == 'سكرتير' ? 'selected' : '' }}>سكرتير</option>
                </select>
                @error('user_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block mb-2 font-bold">الأدوار</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($roles as $role)
                    <div class="flex items-center">
                        <input type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}" 
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                        <label for="role_{{ $role->id }}" class="ml-2">{{ $role->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('roles')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                    حفظ المستخدم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
