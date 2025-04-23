<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مكتب المدير</title>
    <!-- روابط ملفات القالب المنقولة إلى public/assets -->
    <link rel="stylesheet" href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@iconscout/unicons/css/line.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}">
    @foreach(scandir(base_path('assets/css')) as $file)
        @if($file != '.' && $file != '..' && Str::endsWith($file, '.css') && $file != 'dark-mode-fix.css')
            <link rel="stylesheet" href="{{ asset('assets/css/'.$file) }}">
        @endif
    @endforeach

    <!-- أي ملفات CSS إضافية -->
    @yield('styles')

    {{-- تضمين جميع الصور من assets/images تلقائياً --}}
    @foreach(scandir(base_path('assets/images')) as $file)
        @if($file != '.' && $file != '..' && (Str::endsWith($file, '.png') || Str::endsWith($file, '.jpg') || Str::endsWith($file, '.jpeg') || Str::endsWith($file, '.gif') || Str::endsWith($file, '.svg')))
            {{-- <img src="{{ asset('assets/images/'.$file) }}" alt="صورة تلقائية"> --}}
        @endif
    @endforeach
</head>
<body class="font-nunito text-base text-black">
    <div class="page-wrapper toggled">
        <!-- الشريط الجانبي -->
        @include('partials.sidebar')
        <!-- محتوى الصفحة -->
        <main class="page-content bg-gray-50">
            @include('partials.header')
            <div class="container-fluid relative px-3">
                <div class="layout-specing">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    <!-- ملفات الجافاسكريبت -->
    <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/apexchart.init.js') }}"></script>
    @foreach(scandir(base_path('assets/js')) as $file)
        @if($file != '.' && $file != '..' && $file != 'dark-mode.js')
            <script src="{{ asset('assets/js/'.$file) }}"></script>
        @endif
    @endforeach
    @yield('scripts')
</body>
</html>
