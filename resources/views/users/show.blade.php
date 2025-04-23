@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">بيانات المستخدم</h1>
            <p class="text-gray-600">عرض تفاصيل المستخدم {{ $user->name }}</p>
        </div>
        <div class="flex space-x-2 space-x-reverse">
            <a href="{{ route('users.edit', $user) }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">
                <i class="uil uil-edit ml-1"></i> تعديل
            </a>
            <a href="{{ route('users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                <i class="uil uil-arrow-right ml-1"></i> العودة للقائمة
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center mb-6">
                    <div class="inline-block h-24 w-24 rounded-full overflow-hidden bg-gray-100">
                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14.75c2.67 0 8 1.33 8 4v1.25H4v-1.25c0-2.67 5.33-4 8-4zm0-9.5a4 4 0 110 8 4 4 0 010-8z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-xl font-bold">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
                
                <div class="border-t pt-4">
                    <h3 class="font-bold mb-2">الأدوار</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($user->roles as $role)
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">{{ $role->name }}</span>
                        @empty
                            <p class="text-gray-500">لا توجد أدوار مخصصة</p>
                        @endforelse
                    </div>
                </div>
                
                <div class="border-t mt-4 pt-4">
                    <h3 class="font-bold mb-2">معلومات الحساب</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-gray-600">تاريخ الإنشاء:</div>
                        <div>{{ $user->created_at->format('Y-m-d') }}</div>
                        
                        <div class="text-gray-600">آخر تحديث:</div>
                        <div>{{ $user->updated_at->format('Y-m-d') }}</div>
                        
                        <div class="text-gray-600">حالة البريد:</div>
                        <div>
                            @if($user->email_verified_at)
                                <span class="text-green-600">مفعل</span>
                            @else
                                <span class="text-red-600">غير مفعل</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="border-b">
                    <nav class="flex">
                        <button type="button" class="px-4 py-3 font-medium border-b-2 border-indigo-500 text-indigo-600">المستندات</button>
                        <button type="button" class="px-4 py-3 font-medium text-gray-600 hover:text-gray-800">الطلبات</button>
                        <button type="button" class="px-4 py-3 font-medium text-gray-600 hover:text-gray-800">المواعيد</button>
                    </nav>
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold mb-4">المستندات ({{ $user->documents->count() }})</h3>
                    
                    @if($user->documents->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 text-right font-semibold">العنوان</th>
                                        <th class="py-2 px-4 text-right font-semibold">النوع</th>
                                        <th class="py-2 px-4 text-right font-semibold">التاريخ</th>
                                        <th class="py-2 px-4 text-right font-semibold">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->documents as $document)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4">{{ $document->title }}</td>
                                        <td class="py-2 px-4">{{ $document->type }}</td>
                                        <td class="py-2 px-4">{{ $document->created_at->format('Y-m-d') }}</td>
                                        <td class="py-2 px-4">
                                            <a href="{{ route('documents.show', $document) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="uil uil-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">لا توجد مستندات لهذا المستخدم</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
