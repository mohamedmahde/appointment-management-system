@extends('layouts.dashboard')
@section('content')
<div class="w-full px-2 sm:px-4 md:px-0 max-w-4xl mx-auto" dir="rtl">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6 rtl">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-2 rtl:text-right">
            <i class="uil uil-user-circle text-indigo-600 text-3xl"></i>
            الملف الشخصي
        </h2>
        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold text-sm transition">
            <i class="uil uil-refresh"></i>
            تحديث البيانات
        </a>
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-4 sm:p-6 mb-6 overflow-x-auto rtl">
        @include('profile.partials.update-profile-information-form')
    </div>
    <div class="bg-white dark:bg-slate-900 rounded-lg shadow-md p-4 sm:p-6 overflow-x-auto rtl">
        @include('profile.partials.update-password-form')
    </div>
</div>
@endsection
