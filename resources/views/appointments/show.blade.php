@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <h2 class="text-xl font-bold mb-4">تفاصيل الموعد</h2>
    <div class="bg-white rounded shadow p-5 mb-6">
        <div class="mb-2"><strong>العنوان:</strong> {{ $appointment->title }}</div>
        <div class="mb-2"><strong>الوصف:</strong> {{ $appointment->description }}</div>
        <div class="mb-2"><strong>الطالب:</strong> {{ $appointment->requester->name ?? '-' }}</div>
        <div class="mb-2"><strong>المدير:</strong> {{ $appointment->manager->name ?? '-' }}</div>
        <div class="mb-2"><strong>وقت الموعد:</strong> {{ $appointment->appointment_time ? $appointment->appointment_time->format('Y-m-d H:i') : '-' }}</div>
        <div class="mb-2"><strong>الحالة:</strong> {{ $appointment->status ?? '-' }}</div>
        <div class="mb-2"><strong>تاريخ الإنشاء:</strong> {{ $appointment->created_at->format('Y-m-d H:i') }}</div>
    </div>
    @if(auth()->user()->id === $appointment->manager_id && ($appointment->status === null || $appointment->status === 'قيد المراجعة'))
    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-semibold mb-2">الإجراء:</label>
            <select name="action" id="action" class="form-input w-full" required onchange="toggleActionFields()">
                <option value="accept">قبول المقابلة فورًا</option>
                <option value="schedule">تحديد وقت لاحق</option>
                <option value="reject">رفض المقابلة</option>
            </select>
        </div>
        <div id="scheduleField" class="hidden">
            <label for="appointment_time" class="block font-semibold mb-2">حدد وقت المقابلة:</label>
            <input type="datetime-local" name="appointment_time" id="appointment_time" class="form-input w-full">
        </div>
        <div id="rejectionReasonField" class="hidden">
            <label for="rejection_reason" class="block font-semibold mb-2">سبب الرفض:</label>
            <textarea name="rejection_reason" id="rejection_reason" class="form-input w-full"></textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">إرسال القرار</button>
    </form>
    <script>
    function toggleActionFields() {
        var action = document.getElementById('action').value;
        document.getElementById('scheduleField').style.display = (action === 'schedule') ? 'block' : 'none';
        document.getElementById('rejectionReasonField').style.display = (action === 'reject') ? 'block' : 'none';
    }
    document.getElementById('action').addEventListener('change', toggleActionFields);
    window.onload = toggleActionFields;
    </script>
    @endif
</div>
@endsection
