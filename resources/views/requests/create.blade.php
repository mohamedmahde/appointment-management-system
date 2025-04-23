@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    @if (
        \Session::has('success'))
        <div class="alert alert-success mb-4">
            {{ \Session::get('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2 class="text-xl font-bold mb-4">إرسال طلب مقابلة إلى المدير</h2>
    <form action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block mb-2 font-semibold">عنوان الطلب</label>
            <select id="title" name="title" class="form-input w-full" required>
                <option value="">اختر عنوان الطلب...</option>
                <option value="توقيع عقد">توقيع عقد</option>
                <option value="طلب حاجات">طلب حاجات</option>
                <option value="شرح تقرير للجنة">شرح تقرير للجنة</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="interviewee_name" class="block mb-2 font-semibold">اسم شخص المقابلة</label>
            <input type="text" id="interviewee_name" name="interviewee_name" class="form-input w-full" required placeholder="مثال: أحمد محمد...">
        </div>
        <div class="mb-4">
            <label for="description" class="block mb-2 font-semibold">سبب المقابلة</label>
            <textarea id="description" name="description" class="form-input w-full" rows="3" required></textarea>
        </div>
        <input type="hidden" name="type" value="مقابلة">
        <div class="mb-4">
            <label for="file" class="block mb-2 font-semibold">ملف مرفق (اختياري)</label>
            <input type="file" id="file" name="file" class="form-input w-full">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">إرسال الطلب</button>
    </form>
</div>
@endsection
