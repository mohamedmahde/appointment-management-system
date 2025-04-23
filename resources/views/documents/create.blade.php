@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <h2 class="text-xl font-bold mb-4">إضافة مستند جديد</h2>
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block mb-2 font-semibold">عنوان المستند</label>
            <input type="text" id="title" name="title" class="form-input w-full" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block mb-2 font-semibold">وصف المستند</label>
            <textarea id="description" name="description" class="form-input w-full" rows="3"></textarea>
        </div>
        <div class="mb-4">
            <label for="type" class="block mb-2 font-semibold">نوع المستند</label>
            <select id="type" name="type" class="form-input w-full" required>
                <option value="رسمي">رسمي</option>
                <option value="داخلي">داخلي</option>
                <option value="خارجي">خارجي</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="file" class="block mb-2 font-semibold">ملف المستند (اختياري)</label>
            <input type="file" id="file" name="file" class="form-input w-full">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">حفظ المستند</button>
    </form>
</div>
@endsection
