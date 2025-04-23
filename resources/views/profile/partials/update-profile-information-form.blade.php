<section dir="rtl" class="p-4 sm:p-6 bg-white dark:bg-slate-900 rounded-lg shadow w-full">
    <header class="flex justify-end items-center mb-6 space-x-reverse space-x-2">
        <i data-feather="user" class="text-slate-400 fea icon-ex-md"></i>
        <h5 class="text-xl font-semibold text-right">{{ __('بيانات المستخدم الشخصية') }}</h5>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-col md:flex-row-reverse items-center md:justify-end mb-6 gap-4">
            <img src="{{ $user->profile_photo_url ?? asset('assets/images/avatar.png') }}" alt="صورة المستخدم" class="w-24 h-24 rounded-full object-cover border-2 border-gray-200 dark:border-gray-800">
            <div class="flex flex-col items-center md:items-end gap-2">
                <label for="profile_photo" class="cursor-pointer px-3 py-1 bg-gray-100 dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded text-sm text-slate-700 dark:text-slate-200 hover:bg-gray-200 dark:hover:bg-slate-700">
                    {{ __('تغيير الصورة الشخصية') }}
                    <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*">
                </label>
                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col">
                <label for="name" class="mb-2 font-semibold text-slate-700 dark:text-slate-200 text-right">{{ __('الاسم') }}</label>
                <input id="name" name="name" type="text" class="form-input w-full py-2 px-3 rounded border border-gray-200 focus:border-indigo-600 dark:bg-slate-900 dark:text-slate-200 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="flex flex-col">
                <label for="email" class="mb-2 font-semibold text-slate-700 dark:text-slate-200 text-right">{{ __('البريد الإلكتروني') }}</label>
                <input id="email" name="email" type="email" class="form-input w-full py-2 px-3 rounded border border-gray-200 focus:border-indigo-600 dark:bg-slate-900 dark:text-slate-200 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0" value="{{ old('email', $user->email) }}" required autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <p class="mt-2 text-sm text-right text-gray-800 dark:text-slate-200">
                        {{ __('بريدك الإلكتروني غير موثق.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900">{{ __('إعادة إرسال رابط التحقق') }}</button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600 text-right">{{ __('تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.') }}</p>
                    @endif
                @endif
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">{{ __('حفظ التعديلات') }}</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="mr-4 text-sm text-green-600">{{ __('تم الحفظ بنجاح') }}</p>
            @endif
        </div>
    </form>
</section>
