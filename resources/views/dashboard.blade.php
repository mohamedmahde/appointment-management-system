@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-5">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">لوحة التحكم</h1>
        <p class="text-gray-600">مرحباً بك في النظام الإداري</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-5">
            <h3 class="text-lg font-bold mb-2">المستخدمون</h3>
            <p class="text-3xl font-bold">{{ \App\Models\User::count() }}</p>
            <a href="{{ route('users.index') }}" class="text-indigo-600 hover:underline block mt-3">عرض الكل</a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-5">
            <h3 class="text-lg font-bold mb-2">المستندات</h3>
            <p class="text-3xl font-bold">{{ \App\Models\Document::count() }}</p>
            <a href="{{ route('documents.index') }}" class="text-indigo-600 hover:underline block mt-3">عرض الكل</a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-5">
            <h3 class="text-lg font-bold mb-2">الطلبات</h3>
            <p class="text-3xl font-bold">{{ \App\Models\Request::count() }}</p>
            <a href="{{ route('requests.index') }}" class="text-indigo-600 hover:underline block mt-3">عرض الكل</a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-5">
            <h3 class="text-lg font-bold mb-2">المواعيد</h3>
            <p class="text-3xl font-bold">{{ \App\Models\Appointment::count() }}</p>
            <a href="{{ route('appointments.index') }}" class="text-indigo-600 hover:underline block mt-3">عرض الكل</a>
        </div>
    </div>
    <!-- جدول مختصر للمواعيد -->
    <div class="bg-white rounded-lg shadow p-5 mb-8">
        <h3 class="text-lg font-bold mb-4">جدول المواعيد القادمة</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-right">العنوان</th>
                        <th class="py-2 px-4 border-b text-right">الطالب</th>
                        <th class="py-2 px-4 border-b text-right">المدير</th>
                        <th class="py-2 px-4 border-b text-right">وقت الموعد</th>
                        <th class="py-2 px-4 border-b text-right">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Appointment::whereNotNull('appointment_time')->orderBy('appointment_time','asc')->take(5)->get() as $appointment)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $appointment->title ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $appointment->requester->name ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $appointment->manager->name ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $appointment->appointment_time ? $appointment->appointment_time->format('Y-m-d H:i') : '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $appointment->status ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-2 px-4 border-b text-center">لا توجد مواعيد قادمة</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('appointments.index') }}" class="text-indigo-600 hover:underline block mt-3">عرض كل المواعيد</a>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-5">
            <h3 class="text-lg font-bold mb-4">آخر الطلبات</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-right">العنوان</th>
                            <th class="py-2 px-4 border-b text-right">المرسل</th>
                            <th class="py-2 px-4 border-b text-right">التاريخ</th>
                            <th class="py-2 px-4 border-b text-right">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Request::latest()->take(5)->get() as $request)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $request->title }}</td>
                            <td class="py-2 px-4 border-b">{{ $request->sender->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $request->created_at->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b">{{ $request->status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-2 px-4 border-b text-center">لا توجد طلبات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-5">
            <h3 class="text-lg font-bold mb-4">المواعيد القادمة</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-right">العنوان</th>
                            <th class="py-2 px-4 border-b text-right">الطالب</th>
                            <th class="py-2 px-4 border-b text-right">التاريخ</th>
                            <th class="py-2 px-4 border-b text-right">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Appointment::where('appointment_time', '>=', now())->orderBy('appointment_time')->take(5)->get() as $appointment)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $appointment->title }}</td>
                            <td class="py-2 px-4 border-b">{{ $appointment->requester->name }}</td>
                            <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d H:i') }}</td>
                            <td class="py-2 px-4 border-b">{{ $appointment->status }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-2 px-4 border-b text-center">لا توجد مواعيد قادمة</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<audio id="notifySound" src="{{ asset('sounds/notify.mp3') }}" preload="auto"></audio>
<script>
// مثال: تشغيل الصوت إذا كان هناك طلب جديد أو تحديث قرار
@if(session('success'))
    document.getElementById('notifySound').play();
@endif
// يمكن توسيع المنطق باستخدام WebSocket أو polling لمتابعة التغييرات الحية
</script>
@endsection
