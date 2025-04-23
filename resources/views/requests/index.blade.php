@extends('layouts.dashboard')

@section('content')
@if(session('notification'))
    <div id="notif-alert" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-white border border-green-400 text-green-700 px-6 py-3 rounded shadow flex items-center space-x-2 animate-fade-in-up" style="min-width:250px;">
        <i class="uil uil-bell text-2xl me-2"></i>
        <span>{{ session('notification.message') }}</span>
        <audio id="notif-audio" src="{{ asset('assets/sounds/' . session('notification.sound')) }}" preload="auto"></audio>
        <button id="notif-play-btn" title="تشغيل الصوت يدويًا" style="margin-right: 8px; background: #eee; border: none; border-radius: 50%; width: 32px; height: 32px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
            <i class="uil uil-volume-up"></i>
        </button>
        <span id="notif-error" style="color: red; margin-right: 8px; display: none;"></span>
    </div>
    <script>
        function playNotifAudio() {
            var audio = document.getElementById('notif-audio');
            var errSpan = document.getElementById('notif-error');
            if(audio) {
                audio.currentTime = 0;
                audio.play().then(()=>{
                    if(errSpan) errSpan.style.display = 'none';
                }).catch(function(e){
                    if(errSpan) {
                        errSpan.innerText = 'لم يتم تشغيل صوت الإشعار: يجب الضغط على أي مكان في الصفحة أو زر السماعة.';
                        errSpan.style.display = 'inline';
                    }
                });
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            var notifBtn = document.getElementById('notif-play-btn');
            if(notifBtn) notifBtn.addEventListener('click', playNotifAudio);
            // محاولة تشغيل الصوت تلقائياً عند ظهور الإشعار
            playNotifAudio();
        });
    </script>
@endif
<div class="container mx-auto px-4 py-5">
    <h2 class="text-xl font-bold mb-4">قائمة طلبات المقابلة</h2>
    <a href="{{ route('requests.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 mb-4 inline-block">إرسال طلب مقابلة جديد</a>
    <div class="mb-4 flex flex-row-reverse">
        <input type="text" id="searchInput" placeholder="🔍 ابحث عن طلب أو اسم..." class="form-input w-1/2 rounded border px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" style="direction:rtl">
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchInput');
        input.addEventListener('input', function() {
            const filter = input.value.trim().toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    });
    </script>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-right">العنوان</th>
<th class="py-2 px-4 border-b text-right">اسم الشخص</th>
                <th class="py-2 px-4 border-b text-right">المرسل</th>
                <th class="py-2 px-4 border-b text-right">المدير</th>
                <th class="py-2 px-4 border-b text-right">الحالة</th>
                <th class="py-2 px-4 border-b text-right">تاريخ الإنشاء</th>
                <th class="py-2 px-4 border-b text-right">إجراء</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
            <tr>
                <td class="py-2 px-4 border-b">{{ $request->title }}</td>
<td class="py-2 px-4 border-b">{{ $request->interviewee_name ?? '-' }}</td>
                <td class="py-2 px-4 border-b">{{ $request->sender->name }}</td>
                <td class="py-2 px-4 border-b">{{ $request->receiver ? $request->receiver->name : '-' }}</td>
                <td class="py-2 px-4 border-b">{{ $request->status }}</td>
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
    .icon-edit { background: #f59e42; color: #fff; }
    .icon-edit:hover { background: #d97706; }
    .icon-delete { background: #dc2626; color: #fff; }
    .icon-delete:hover { background: #b91c1c; }
    .icon-btn .icon { font-size: 1.1em; margin-left: 0.5em; }
    [dir="rtl"] .icon-btn .icon { margin-left: 0; margin-right: 0.5em; }
</style>
<div class="flex flex-row-reverse gap-2 justify-center">
    <a href="{{ route('requests.show', $request->id) }}" class="icon-btn icon-view" title="عرض الطلب">
        <span class="icon">👁️</span> عرض
    </a>
    @if (auth()->id() === $request->sender_id || (auth()->user() && (auth()->user()->user_type === 'مدير' || auth()->user()->user_type === 'سكرتير')))
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
@endif
</div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-2 px-4 border-b text-center">لا توجد طلبات</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
