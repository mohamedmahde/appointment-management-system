@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <h2 class="text-xl font-bold mb-4">تفاصيل طلب المقابلة</h2>
    <div class="bg-white rounded shadow p-5 mb-6">
        <div class="card-body">
        <h5 class="card-title">{{ $request->title }}</h5>
        @if ((auth()->id() === $request->sender_id || (auth()->user() && auth()->user()->user_type === 'مدير')) && $request->status === 'قيد المراجعة')
    <style>
        .icon-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .icon-view { background: #2563eb; color: #fff; }
        .icon-view:hover { background: #1d4ed8; }
        .icon-edit { background: #f59e42; color: #fff; }
        .icon-edit:hover { background: #d97706; }
        .icon-delete { background: #dc2626; color: #fff; }
        .icon-delete:hover { background: #b91c1c; }
        .icon-btn .icon { font-size: 1.1em; margin-left: 0.5em; }
        [dir="rtl"] .icon-btn .icon { margin-left: 0; margin-right: 0.5em; }
    </style>
    <div class="flex flex-row-reverse gap-2 mt-2">
        <a href="{{ route('requests.show', $request->id) }}" class="icon-btn icon-view" title="عرض الطلب">
            <span class="icon">👁️</span> عرض
        </a>
        <a href="{{ route('requests.edit', $request->id) }}" class="icon-btn icon-edit" title="تعديل الطلب">
            <span class="icon">✏️</span> تعديل
        </a>
        <form action="{{ route('requests.destroy', $request->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من حذف الطلب؟');">
            @csrf
            @method('DELETE')
            <button type="submit" class="icon-btn icon-delete" title="حذف الطلب">
                <span class="icon">🗑️</span> حذف
            </button>
        </form>
    </div>
@endif
        </div>
        <table class="min-w-full bg-white rounded shadow mb-6 border">
            <tbody>
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right w-1/4">العنوان</th>
                    <td class="py-2 px-4">{{ $request->title }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">اسم الشخص</th>
                    <td class="py-2 px-4">{{ $request->interviewee_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">السبب</th>
                    <td class="py-2 px-4">{{ $request->description }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">الحالة</th>
                    <td class="py-2 px-4">{{ $request->status }}</td>
                </tr>
                @if($request->file_path)
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">الملف المرفق</th>
                    <td class="py-2 px-4">
                        <a href="{{ route('requests.download', $request->id) }}" class="text-indigo-600 hover:underline">{{ $request->file_name ?? 'تحميل الملف' }}</a>
                    </td>
                </tr>
                @endif
                @if($request->status === 'مرفوض')
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">سبب الرفض</th>
                    <td class="py-2 px-4">{{ $request->rejection_reason }}</td>
                </tr>
                @endif
                @if($request->status === 'مقبول' || $request->status === 'مؤجل')
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">وقت المقابلة</th>
                    <td class="py-2 px-4">{{ $request->scheduled_time }}</td>
                </tr>
                @endif
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">المرسل</th>
                    <td class="py-2 px-4">{{ $request->sender->name }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">المدير</th>
                    <td class="py-2 px-4">{{ $request->receiver ? $request->receiver->name : '-' }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 bg-gray-50 text-right">تاريخ الإنشاء</th>
                    <td class="py-2 px-4">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @if(auth()->user()->id === $request->receiver_id && $request->status === 'قيد المراجعة')
    <form action="{{ route('requests.update', $request->id) }}" method="POST" class="space-y-4">
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
            <label for="scheduled_time" class="block font-semibold mb-2">حدد وقت المقابلة:</label>
            <input type="datetime-local" name="scheduled_time" id="scheduled_time" class="form-input w-full">
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
@if(session('success'))
    @php
        $successMsg = session('success');
        $status = '';
        if (strpos($successMsg, 'قبول') !== false) {
            $status = 'تم قبول المقابلة';
        } elseif (strpos($successMsg, 'رفض') !== false) {
            $status = 'تم رفض المقابلة';
        } elseif (strpos($successMsg, 'تأجيل') !== false || strpos($successMsg, 'مؤجل') !== false) {
            $status = 'تم تأجيل المقابلة';
        }
    @endphp
    <script>
        let status = @json($status);
        if(status) {
            let utter = new SpeechSynthesisUtterance(status);
            utter.lang = 'ar-SA';
            window.speechSynthesis.speak(utter);
        }
    </script>
@endif
@endsection
