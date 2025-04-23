@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">إدارة المستخدمين</h1>
            <p class="text-gray-600">قائمة بجميع المستخدمين في النظام</p>
        </div>
        <a href="{{ route('users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
            <i class="uil uil-plus ml-1"></i> إضافة مستخدم جديد
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-right font-semibold">#</th>
                        <th class="py-3 px-4 text-right font-semibold">الاسم</th>
                        <th class="py-3 px-4 text-right font-semibold">البريد الإلكتروني</th>
                        <th class="py-3 px-4 text-right font-semibold">الأدوار</th>
                        <th class="py-3 px-4 text-right font-semibold">تاريخ الإنشاء</th>
                        <th class="py-3 px-4 text-right font-semibold">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4">
                            @foreach($user->roles as $role)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded ml-1">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="py-3 px-4">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-2 space-x-reverse">
                                <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-900" title="عرض">
                                    <i class="uil uil-eye text-lg"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900" title="تعديل">
                                    <i class="uil uil-edit text-lg"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
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
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">لا يوجد مستخدمين</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-4 py-3 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
