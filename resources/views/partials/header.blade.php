<!-- رأس الصفحة -->
<div class="top-header">
    <div class="header-bar flex justify-between">
        <div class="flex items-center space-x-1">
            <!-- Sidebar toggle for mobile/tablet -->
            <a href="#" class="xl:hidden block me-2 text-2xl text-slate-900 hover:text-indigo-600" aria-label="Toggle sidebar">
                <i class="uil uil-bars"></i>
            </a>
            <!-- Logo for desktop -->
            <a href="#" class="hidden xl:block me-2">
                @php $logo = \App\Http\Controllers\SettingsController::get('site_logo'); @endphp
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" style="height:32px;max-width:120px;">
                @else
                    <img src="{{ asset('assets/images/logo-icon-32.png') }}" alt="Logo">
                @endif
            </a>
            <span class="font-bold text-xl">مكتب المدير</span>
        </div>
        <ul class="list-none mb-0 space-x-1">
            <li class="dropdown inline-block relative">
                <a href="#" class="dropdown-toggle h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 hover:bg-gray-100 border border-gray-100 text-slate-900 rounded-full">
                    <i class="uil uil-bell"></i>
                </a>
                <!-- قائمة الإشعارات هنا -->
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
                                    console.log('Notification sound played:', audio.src);
                                    if(errSpan) errSpan.style.display = 'none';
                                }).catch(function(e){
                                    if(errSpan) {
                                        errSpan.innerText = 'لم يتم تشغيل صوت الإشعار: يجب الضغط على أي مكان في الصفحة أو زر السماعة.';
                                        errSpan.style.display = 'inline';
                                    }
                                    console.error('فشل تشغيل صوت الإشعار:', e);
                                });
                            }
                        }
                        // حاول التشغيل تلقائيًا عند ظهور الإشعار
                        setTimeout(playNotifAudio, 300);
                        // زر التشغيل اليدوي
                        document.getElementById('notif-play-btn').onclick = playNotifAudio;
                        // إخفاء الإشعار بعد 6 ثوانٍ
                        var notif = document.getElementById('notif-alert');
                        if(notif) {
                            setTimeout(function(){ notif.style.display = 'none'; }, 6000);
                        }
                    </script>
                @endif
            </li>
            <li class="dropdown inline-block relative" x-data="{ open: false }">
                <a href="javascript:void(0)" @click="open = !open" class="dropdown-toggle h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 hover:bg-gray-100 border border-gray-100 text-slate-900 rounded-full">
                    <i class="uil uil-user"></i>
                </a>
                <!-- قائمة المستخدم -->
                <div x-show="open" @click.away="open = false" class="dropdown-menu absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10" style="min-width: 10rem; right: 0; left: auto;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">الملف الشخصي</a>
                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">الإعدادات</a>
                    <div class="border-t border-gray-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">تسجيل الخروج</a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>

<!-- تضمين Alpine.js إذا لم يكن موجودًا بالفعل -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
