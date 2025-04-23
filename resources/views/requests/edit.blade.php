@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <h2 class="text-xl font-bold mb-4">تعديل الطلب</h2>
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('requests.update', $request->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block mb-2 font-semibold">عنوان الطلب</label>
            <input type="text" id="title" name="title" class="form-input w-full" required value="{{ old('title', $request->title) }}">
        </div>
        <div class="mb-4">
            <label for="interviewee_name" class="block mb-2 font-semibold">اسم شخص المقابلة</label>
            <input type="text" id="interviewee_name" name="interviewee_name" class="form-input w-full" required value="{{ old('interviewee_name', $request->interviewee_name) }}">
        </div>
        <div class="mb-4">
            <label for="description" class="block mb-2 font-semibold">سبب المقابلة</label>
            <textarea id="description" name="description" class="form-input w-full" rows="3" required>{{ old('description', $request->description) }}</textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">حفظ التعديلات</button>
    </form>
</div>
@endsection
