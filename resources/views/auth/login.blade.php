<!DOCTYPE html>
<html lang="ar" class="light scroll-smooth" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- Css -->
    <link href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}">
</head>
<body class="font-nunito text-base text-black dark:text-white dark:bg-slate-900" dir="rtl">

    <section class="relative overflow-hidden min-h-screen">
        <div class="absolute inset-0 bg-indigo-600/[0.02]"></div>
        <div class="container-fluid relative">
            <div class="grid grid-cols-1 md:grid-cols-2 min-h-screen items-center">
                <div class="flex flex-col justify-center bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 px-4 md:px-10 py-10">
                    <div class="text-center mb-6">
                        <a href="/">
                            <img src="{{ asset('assets/images/logo-icon-64.png') }}" class="mx-auto" alt="Logo">
                        </a>
                    </div>
                    <div class="title-heading text-center md:my-auto my-10">
                        @if(session('status'))
                            <div class="mb-4 text-green-600 text-center">{{ session('status') }}</div>
                        @endif
                        <form method="POST" action="{{ route('login') }}" class="text-end max-w-md mx-auto">
                            @csrf
                            <div class="grid grid-cols-1 gap-4">
                                <div class="mb-4">
                                    <label class="font-semibold text-right" for="LoginEmail">البريد الإلكتروني:</label>
                                    <input id="LoginEmail" name="email" type="email" value="{{ old('email') }}" class="form-input mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-indigo-600 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0 @error('email') border-red-500 @enderror" placeholder="name@example.com" required autofocus>
                                    @error('email')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="font-semibold text-right" for="LoginPassword">كلمة المرور:</label>
                                    <input id="LoginPassword" name="password" type="password" class="form-input mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-indigo-600 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0 @error('password') border-red-500 @enderror" placeholder="كلمة السر:" required>
                                    @error('password')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="flex justify-between mb-4">
                                    <div class="flex items-center mb-0">
                                        <input class="form-checkbox rounded border-gray-200 dark:border-gray-800 text-indigo-600 focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50 me-2" type="checkbox" name="remember" id="RememberMe" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-checkbox-label text-slate-400" for="RememberMe">تذكرني</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-slate-400">نسيت كلمة المرور؟</a>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="py-2 px-5 inline-block tracking-wide border align-middle duration-500 text-base text-center bg-indigo-600 hover:bg-indigo-700 border-indigo-600 hover:border-indigo-700 text-white rounded-md w-full">دخول</button>
                                </div>
                                <div class="text-center">
                                    <span class="text-slate-400 me-2">ليس لديك حساب؟</span>
                                    {{-- @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="text-black dark:text-white font-bold inline-block">تسجيل جديد</a>
                                    @endif --}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="text-center mt-6">
                        <p class="mb-0 text-slate-400"> {{ date('Y') }}. Design with <i class="mdi mdi-heart text-red-600"></i> by wadmahdi.</p>
                    </div>
                </div>
                <div class="flex items-center justify-center px-4 md:px-10 py-10 w-full">
                    <div class="w-full max-w-md mx-auto space-y-8">
                        <div class="w-full">
                            <img src="{{ asset('assets/images/contact.svg') }}" class="w-3/4 md:w-full mx-auto h-auto" alt="">
                        </div>
                        <div class="p-6 bg-white dark:bg-slate-900 border-2 border-indigo-600 rounded-2xl text-center md:text-right">
                            <p class="font-semibold leading-normal">انظام إدارة المستندات والمواعيد والأرشفة الإلكتروني</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>