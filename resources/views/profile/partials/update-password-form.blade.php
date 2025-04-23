<section dir="rtl" class="p-4 sm:p-6 bg-white dark:bg-slate-900 rounded-lg shadow w-full">
    <header class="flex justify-end items-center mb-6 space-x-reverse space-x-2">
        <i data-feather="lock" class="text-slate-400 fea icon-ex-md"></i>
        <h5 class="text-xl font-semibold text-right">{{ __('تحديث كلمة المرور') }}</h5>
    </header>

    <p class="mt-2 text-sm text-right text-gray-600 dark:text-slate-200">{{ __('تأكد من استخدام كلمة مرور قوية وعشوائية لحماية حسابك.') }}</p>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="flex flex-col">
            <label for="update_password_current_password" class="mb-2 font-semibold text-right text-slate-700 dark:text-slate-200">{{ __('كلمة المرور الحالية') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-input w-full py-2 px-3 rounded border border-gray-200 focus:border-indigo-600 dark:bg-slate-900 dark:text-slate-200 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="flex flex-col">
            <label for="update_password_password" class="mb-2 font-semibold text-right text-slate-700 dark:text-slate-200">{{ __('كلمة المرور الجديدة') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-input w-full py-2 px-3 rounded border border-gray-200 focus:border-indigo-600 dark:bg-slate-900 dark:text-slate-200 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="flex flex-col">
            <label for="update_password_password_confirmation" class="mb-2 font-semibold text-right text-slate-700 dark:text-slate-200">{{ __('تأكيد كلمة المرور') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input w-full py-2 px-3 rounded border border-gray-200 focus:border-indigo-600 dark:bg-slate-900 dark:text-slate-200 dark:border-gray-800 dark:focus:border-indigo-600 focus:ring-0" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex justify-end items-center gap-4 mt-6">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">{{ __('حفظ التعديلات') }}</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="mr-4 text-sm text-green-600">{{ __('تم التحديث بنجاح') }}</p>
            @endif
        </div>
    </form>
</section>
