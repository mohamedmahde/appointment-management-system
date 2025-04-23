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
<style>
.btn-details {
    display: inline-block;
    padding: 0.5rem 1.2rem;
    background: #2563eb;
    color: #fff !important;
    border-radius: 0.375rem;
    font-weight: 600;
    font-size: 1em;
    text-align: center;
    transition: background 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px rgba(37,99,235,0.08);
    border: none;
    outline: none;
    text-decoration: none !important;
}
.btn-details:hover, .btn-details:focus {
    background: #1d4ed8;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(37,99,235,0.13);
    text-decoration: none !important;
}
</style>
<div class="container mx-auto px-4 py-5">
    <h2 class="text-xl font-bold mb-4">الطلبات المرفوضة</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-right">العنوان</th>
                <th class="py-2 px-4 border-b text-right">اسم الشخص</th>
                <th class="py-2 px-4 border-b">الوصف</th>
                <th class="py-2 px-4 border-b">سبب الرفض</th>
                <th class="py-2 px-4 border-b">تاريخ الإنشاء</th>
                <th class="py-2 px-4 border-b">الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
            <tr>
                <td class="py-2 px-4 border-b">{{ $request->title }}</td>
<td class="py-2 px-4 border-b">{{ $request->interviewee_name ?? '-' }}</td>
                <td class="py-2 px-4 border-b">{{ $request->description }}</td>
                <td class="py-2 px-4 border-b">{{ $request->rejection_reason }}</td>
                <td class="py-2 px-4 border-b">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('requests.show', $request->id) }}" class="btn-details">عرض التفاصيل</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-2 px-4 border-b text-center">لا توجد طلبات مرفوضة</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
