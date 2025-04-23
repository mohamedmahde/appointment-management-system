@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">تعديل المستخدم</h1>
            <p class="text-gray-600">تعديل بيانات المستخدم {{ $user->name }}</p>
        </div>
        <a href="{{ route('users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
            <i class="uil uil-arrow-right ml-1"></i> العودة للقائمة
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="photo" class="block mb-2 font-bold">صورة المستخدم</label>
                    @if($user->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$user->photo) }}" alt="User Photo" class="w-20 h-20 rounded-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="photo" id="photo" accept="image/*" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                    <div class="mt-1 text-sm text-gray-500">
                        الصيغ المدعومة: JPG, PNG, GIF. الحجم الأقصى: 2MB
                    </div>
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="name" class="block mb-2 font-bold">الاسم</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block mb-2 font-bold">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block mb-2 font-bold">كلمة المرور <span class="text-gray-500 text-sm">(اتركها فارغة إذا لم ترغب في تغييرها)</span></label>
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
                <label class="block mb-2 font-bold">الأدوار</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($roles as $role)
                    <div class="flex items-center">
                        <input type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}" 
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }}>
                        <label for="role_{{ $role->id }}" class="mr-2">{{ $role->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('roles')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
