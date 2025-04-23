@extends('layouts.dashboard')

@section('content')
@if(auth()->user()->user_type == 'مدير')
<div class="container mx-auto px-4 py-5">
    <h2 class="text-xl font-bold mb-4">جدول المواعيد</h2>
    <!-- شريط الفلترة أعلى جدول المواعيد -->
    <div id="filters-bar" style="margin-bottom: 1rem; display: flex; flex-direction: row-reverse; gap: .5rem; align-items: center;">

        <input type="text" id="searchInput" placeholder="🔍 ابحث عن موعد أو اسم..." class="form-input w-1/2 rounded border px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" style="direction:rtl">
        <select id="filterType" class="form-input rounded border px-2 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" style="background:#fff !important; min-width:150px !important;">
            <option value="today">طلبات اليوم</option>
            <option value="week">طلبات هذا الأسبوع</option>
            <option value="date">حسب تاريخ محدد</option>
            <option value="all">كل الطلبات</option>
        </select>
        <input type="date" id="datePicker" class="form-input rounded border px-2 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" style="display:none; background:#fff !important; min-width:150px !important;" />
    </div>
    <style>
        #filters-bar { z-index: 1000; }
        #filters-bar select, #filters-bar input[type=date] {
            background: #fff !important;
            min-width: 150px !important;
            color: #222;
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchInput');
        const filterType = document.getElementById('filterType');
        const datePicker = document.getElementById('datePicker');
        // اجعل الفلترة الافتراضية لطلبات اليوم
        let filterMode = 'today';
        let filterDate = null;
        input.addEventListener('input', filterRows);
        filterType.addEventListener('change', function() {
            filterMode = filterType.value;
            if (filterMode === 'date') {
                datePicker.style.display = '';
            } else {
                datePicker.style.display = 'none';
                filterDate = null;
            }
            filterRows();
        });
        datePicker.addEventListener('change', function() {
            filterDate = datePicker.value;
            filterRows();
        });
        function filterRows() {
            const filter = input.value.trim().toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            const today = new Date();
            const weekStart = new Date(today);
            weekStart.setDate(today.getDate() - today.getDay()); // بداية الأسبوع (الأحد)
            const weekEnd = new Date(today);
            weekEnd.setDate(today.getDate() + (6 - today.getDay())); // نهاية الأسبوع (السبت)
            let anyVisible = false;
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                let show = text.includes(filter);
                const dateTd = row.querySelector('td:nth-child(7)');
                if (dateTd) {
                    const dateText = dateTd.textContent.trim();
                    const datePart = dateText.split(' ')[0];
                    const [y, m, d] = datePart.split('-');
                    if (y && m && d) {
                        const rowDate = new Date(Number(y), Number(m)-1, Number(d));
                        if (filterMode === 'today') {
                            show = show && rowDate.getFullYear() === today.getFullYear() && rowDate.getMonth() === today.getMonth() && rowDate.getDate() === today.getDate();
                        } else if (filterMode === 'week') {
                            show = show && rowDate >= weekStart && rowDate <= weekEnd;
                        } else if (filterMode === 'date') {
                            if (filterDate) {
                                const [fy, fm, fd] = filterDate.split('-');
                                show = show && rowDate.getFullYear() === Number(fy) && rowDate.getMonth() === Number(fm)-1 && rowDate.getDate() === Number(fd);
                            } else {
                                show = false;
                            }
                        }
                        // إذا كان all لا فلترة بالتاريخ
                    } else {
                        show = false;
                    }
                } else {
                    show = false;
                }
                row.style.display = show ? '' : 'none';
                if (show) anyVisible = true;
            });
            // إظهار رسالة إذا لم توجد نتائج
            let noResult = document.getElementById('noResultRow');
            if (!anyVisible) {
                if (!noResult) {
                    noResult = document.createElement('tr');
                    noResult.id = 'noResultRow';
                    noResult.innerHTML = `<td colspan="8" class="py-4 text-center text-gray-400">لا توجد نتائج مطابقة للفلترة الحالية.</td>`;
                    const tbody = document.querySelector('table tbody');
                    tbody.appendChild(noResult);
                }
            } else {
                if (noResult) noResult.remove();
            }
        }
        // فلترة مبدئية: اليوم فقط
        filterRows();
    });
    </script>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-right">العنوان</th>
<th class="py-2 px-4 border-b text-right">اسم الشخص</th>
                <th class="py-2 px-4 border-b text-right">الطالب</th>
                <th class="py-2 px-4 border-b text-right">المدير</th>
                <th class="py-2 px-4 border-b text-right">وقت الموعد</th>
                <th class="py-2 px-4 border-b text-right">الحالة</th>
                <th class="py-2 px-4 border-b text-right">تاريخ الإنشاء</th>
                <th class="py-2 px-4 border-b text-right">إجراء</th>
            </tr>
        </thead>
        <tbody>
            @php
    $requests = \App\Models\Request::with(['sender', 'receiver'])
        ->where('type', 'مقابلة')
        ->orderByDesc('created_at')
        ->paginate(5);
@endphp
@forelse($requests as $request)
<tr>
    <td class="py-2 px-4 border-b">{{ $request->title ?? '-' }}</td>
<td class="py-2 px-4 border-b">{{ $request->interviewee_name ?? '-' }}</td>
    <td class="py-2 px-4 border-b">{{ $request->sender->name ?? '-' }}</td>
    <td class="py-2 px-4 border-b">{{ $request->receiver->name ?? '-' }}</td>
    <td class="py-2 px-4 border-b">{{ $request->scheduled_time ? $request->scheduled_time : '-' }}</td>
    <td class="py-2 px-4 border-b">{{ $request->status ?? '-' }}</td>
    <td class="py-2 px-4 border-b">{{ $request->created_at->format('Y-m-d H:i') }}</td>
    <td class="py-2 px-4 border-b">
        <style>
.icon-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.35rem 0.7rem;
    border-radius: 0.375rem;
    font-weight: 500;
    border: none;
    cursor: pointer;
    font-size: 0.95em;
    transition: background 0.2s;
    margin-left: 0.25em;
    margin-right: 0.25em;
}
.icon-view { background: #2563eb; color: #fff; }
.icon-view:hover { background: #1d4ed8; }
.icon-action { background: #6366f1; color: #fff; }
.icon-action:hover { background: #4338ca; }
.icon-btn .icon { font-size: 1.1em; margin-left: 0.5em; }
[dir="rtl"] .icon-btn .icon { margin-left: 0; margin-right: 0.5em; }
</style>
<a href="{{ route('requests.show', $request->id) }}" class="icon-btn icon-view" title="عرض الطلب"><span class="icon">👁️</span>عرض</a>

        @if(auth()->user()->user_type == 'مدير')
        <form action="{{ route('requests.update', $request->id) }}" method="POST" class="mt-2 space-y-1" style="min-width:180px" enctype="multipart/form-data" onsubmit="return validateSchedule{{ $request->id }}(this)">
    @csrf
    @method('PUT')
    <select name="action" class="form-input w-full mb-1" id="actionSelect{{ $request->id }}" data-id="{{ $request->id }}">
        <option value="accept">قبول المقابلة فورًا</option>
        <option value="schedule">تحديد وقت لاحق</option>
        <option value="reject">رفض المقابلة</option>
    </select>
    <div id="scheduleField{{ $request->id }}" style="display:none">
        <input type="datetime-local" name="scheduled_time" class="form-input w-full mb-1" id="scheduledInput{{ $request->id }}" data-id="{{ $request->id }}">
    </div>

    <div id="rejectionReasonField{{ $request->id }}" style="display:none">
        <textarea name="rejection_reason" class="form-input w-full mb-1" placeholder="سبب الرفض..." id="rejectionInput{{ $request->id }}" data-id="{{ $request->id }}"></textarea>
    </div>
    <button type="submit" class="icon-btn icon-action" title="إرسال القرار"><span class="icon">📤</span>إرسال القرار</button>
</form>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="py-2 px-4 border-b text-center">لا توجد مواعيد</td>
</tr>
@endforelse
</tbody>
</table>
<div class="mt-4 flex justify-center">
    {{ $requests->links() }}
</div>
        </tbody>
    </table>
</div>
@include('appointments.index_js')
@else
<div class="container mx-auto px-4 py-5 text-center text-gray-500">
    جدول المواعيد متاح فقط للمدير.
</div>
@endif
@if(session('success'))
    <script>
        let msg = @json(session('success'));
        let status = '';
        @if(session('success').includes('قبول'))
            status = 'تم قبول المقابلة';
        @elseif(session('success').includes('رفض'))
            status = 'تم رفض المقابلة';
        @elseif(session('success').includes('تأجيل') || session('success').includes('مؤجل'))
            status = 'تم تأجيل المقابلة';
        @endif
        if(status) {
            let utter = new SpeechSynthesisUtterance(status);
            utter.lang = 'ar-SA';
            window.speechSynthesis.speak(utter);
        }
    </script>
@endif
@endsection
