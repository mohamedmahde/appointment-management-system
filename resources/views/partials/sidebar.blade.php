<!-- الشريط الجانبي -->
<nav id="sidebar" class="sidebar-wrapper sidebar-dark">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo-light.png') }}" height="24" alt=""></a>
        </div>
        <ul class="sidebar-menu border-t border-white/10" data-simplebar style="height: calc(100% - 70px);">
            <li class="sidebar-dropdown">
                <a href="#"><i class="uil uil-chart-line me-2"></i>لوحة التحكم</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="#"><i class="uil uil-user me-2"></i>إدارة المستخدمين</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ route('users.index') }}">المستخدمون</a></li>
                        <li><a href="{{ route('roles.index') }}">الأدوار والصلاحيات</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="#"><i class="uil uil-file me-2"></i>الطلبات والمستندات</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ route('requests.index') }}">كل الطلبات</a></li>
                        <li><a href="{{ route('requests.accepted') }}">الطلبات المقبولة</a></li>
                        <li><a href="{{ route('requests.rejected') }}">الطلبات المرفوضة</a></li>
                        <li><a href="{{ route('requests.scheduled') }}">الطلبات المؤجلة</a></li>
                        {{-- <li><a href="{{ route('documents.index') }}">المستندات المؤرشفة</a></li> --}}
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="#"><i class="uil uil-calendar-alt me-2"></i>جدول المواعيد</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ route('appointments.index') }}">المواعيد</a></li>
                    </ul>
                </div>
            </li>
            {{-- <li class="sidebar-dropdown">
                <a href="#"><i class="uil uil-comments me-2"></i>الدردشة الداخلية</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ route('chat.index') }}">المحادثات</a></li>
                    </ul>
                </div>
            </li> --}}
            <li class="sidebar-dropdown">
                <a href="#"><i class="uil uil-setting me-2"></i>الإعدادات العامة</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="{{ route('settings') }}">الإعدادات</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
