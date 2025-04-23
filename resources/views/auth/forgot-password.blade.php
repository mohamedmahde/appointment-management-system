<!DOCTYPE html>
<html lang="ar" class="light scroll-smooth" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>استعادة كلمة المرور</title>
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
                <div class="flex flex-col justify-center bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 px-4 md:px-10 py-10 w-full">
                    <div class="text-center mb-6">
                        <a href="/">
                            <img src="{{ asset('assets/images/logo-icon-64.png') }}" class="mx-auto" alt="Logo">
                        </a>
                    </div>
                    <div class="title-heading text-center md:my-auto my-10">
                        <h2 class="text-2xl font-bold mb-6 text-indigo-700">استعادة كلمة المرور</h2>
                        <div class="mb-4 text-sm text-gray-600 text-center">
                            {{ __('نسيت كلمة المرور؟ لا مشكلة. فقط أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور.') }}
                        </div>
                        @if (session('status'))
                            <div class="mb-4 text-green-600 text-center">{{ session('status') }}</div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}" class="text-end max-w-md mx-auto">
                            @csrf
                            <div class="mb-4">
                                <label class="font-semibold text-right" for="ForgotEmail">البريد الإلكتروني:</label>
                                <input id="ForgotEmail" name="email" type="email" value="{{ old('email') }}" class="form-input mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-indigo-600 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0 @error('email') border-red-500 @enderror" placeholder="name@example.com" required autofocus>
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="py-2 px-5 inline-block tracking-wide border align-middle duration-500 text-base text-center bg-indigo-600 hover:bg-indigo-700 border-indigo-600 hover:border-indigo-700 text-white rounded-md w-full">إرسال رابط إعادة التعيين</button>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-slate-400">العودة لتسجيل الدخول</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="hidden md:block">
                    <!-- يمكنك وضع صورة جانبية أو معلومات إضافية هنا إذا رغبت -->
                </div>
            </div>
        </div>
    </section>
</body>
</html>

