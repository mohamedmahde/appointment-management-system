@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">إدارة المستندات</h1>
            <p class="text-gray-600">قائمة بجميع المستندات المؤرشفة في النظام</p>
        </div>
        <a href="{{ route('documents.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
            <i class="uil uil-plus ml-1"></i> إضافة مستند جديد
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b">
            <form action="{{ route('documents.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بعنوان المستند..." 
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                </div>
                <div class="w-40">
                    <select name="type" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                        <option value="">جميع الأنواع</option>
                        <option value="رسمي" {{ request('type') == 'رسمي' ? 'selected' : '' }}>رسمي</option>
                        <option value="داخلي" {{ request('type') == 'داخلي' ? 'selected' : '' }}>داخلي</option>
                        <option value="خارجي" {{ request('type') == 'خارجي' ? 'selected' : '' }}>خارجي</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                        <i class="uil uil-search ml-1"></i> بحث
                    </button>
                </div>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-right font-semibold">#</th>
                        <th class="py-3 px-4 text-right font-semibold">العنوان</th>
                        <th class="py-3 px-4 text-right font-semibold">النوع</th>
                        <th class="py-3 px-4 text-right font-semibold">الملف</th>
                        <th class="py-3 px-4 text-right font-semibold">المستخدم</th>
                        <th class="py-3 px-4 text-right font-semibold">تاريخ الإضافة</th>
                        <th class="py-3 px-4 text-right font-semibold">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($documents as $document)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">{{ $document->title }}</td>
                        <td class="py-3 px-4">{{ $document->type }}</td>
                        <td class="py-3 px-4">
                            @if($document->file_path)
                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                    <i class="uil uil-file-download"></i> تحميل
                                </a>
                            @else
                                <span class="text-gray-500">لا يوجد ملف</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $document->user->name }}</td>
                        <td class="py-3 px-4">{{ $document->created_at->format('Y-m-d') }}</td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-2 space-x-reverse">
                                <a href="{{ route('documents.show', $document) }}" class="text-blue-600 hover:text-blue-900" title="عرض">
                                    <i class="uil uil-eye text-lg"></i>
                                </a>
                                <a href="{{ route('documents.edit', $document) }}" class="text-yellow-600 hover:text-yellow-900" title="تعديل">
                                    <i class="uil uil-edit text-lg"></i>
                                </a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستند؟');">
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
                        <td colspan="7" class="py-4 px-4 text-center text-gray-500">لا توجد مستندات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-4 py-3 border-t">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection
