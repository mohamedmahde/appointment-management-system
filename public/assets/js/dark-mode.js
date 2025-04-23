// dark-mode.js
// This script toggles dark mode based on the value from the backend (window.isDarkMode)
(function() {
    // يجب أن تكون قيمة window.isDarkMode معرفة في القالب
    function applyDarkMode(isDark) {
        const body = document.body;
        if (isDark) {
            body.classList.add('dark');
            body.classList.remove('text-black');
            body.classList.add('text-white');
            body.classList.add('bg-slate-900');
        } else {
            body.classList.remove('dark');
            body.classList.remove('text-white');
            body.classList.remove('bg-slate-900');
            body.classList.add('text-black');
        }
    }
    if (typeof window.isDarkMode !== 'undefined') {
        applyDarkMode(window.isDarkMode);
    }
})();
