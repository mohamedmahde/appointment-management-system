@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">إدارة الأدوار والصلاحيات</h1>
            <p class="text-gray-600">قائمة بجميع الأدوار في النظام</p>
        </div>
        <a href="{{ route('roles.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
            <i class="uil uil-plus ml-1"></i> إضافة دور جديد
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-right font-semibold">#</th>
                        <th class="py-3 px-4 text-right font-semibold">الاسم</th>
                        <th class="py-3 px-4 text-right font-semibold">الوصف</th>
                        <th class="py-3 px-4 text-right font-semibold">عدد المستخدمين</th>
                        <th class="py-3 px-4 text-right font-semibold">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($roles as $role)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">{{ $role->name }}</td>
                        <td class="py-3 px-4">{{ $role->description }}</td>
                        <td class="py-3 px-4">{{ $role->users->count() }}</td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-2 space-x-reverse">
                                <a href="{{ route('roles.edit', $role) }}" class="text-yellow-600 hover:text-yellow-900" title="تعديل">
                                    <i class="uil uil-edit text-lg"></i>
                                </a>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="حذف">
                                        <i class="uil uil-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">لا توجد أدوار</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-4 py-3 border-t">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection
