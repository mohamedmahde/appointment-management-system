/**
 * ملف JavaScript مخصص لتفعيل وظائف الشريط الجانبي
 */

document.addEventListener('DOMContentLoaded', function() {
    // تفعيل الشريط الجانبي عند النقر على زر القائمة في الهيدر
    const menuToggleBtn = document.querySelector('.top-header .me-2');
    if (menuToggleBtn) {
        menuToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.page-wrapper').classList.toggle('toggled');
        });
    }
    
    // تفعيل قائمة الملف الشخصي المنسدلة
    const userProfileToggle = document.querySelector('.dropdown-toggle .uil-user');
    if (userProfileToggle) {
        const profileDropdownToggle = userProfileToggle.closest('.dropdown-toggle');
        if (profileDropdownToggle) {
            profileDropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                const dropdown = this.closest('.dropdown');
                dropdown.classList.toggle('show');
                
                // عرض أو إخفاء القائمة المنسدلة الموجودة في القالب
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                if (dropdownMenu) {
                    dropdownMenu.style.display = dropdown.classList.contains('show') ? 'block' : 'none';
                }
            });
            
            // إغلاق القائمة المنسدلة عند النقر خارجها
            document.addEventListener('click', function(e) {
                if (!profileDropdownToggle.contains(e.target)) {
                    const dropdown = profileDropdownToggle.closest('.dropdown');
                    if (dropdown && dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                        if (dropdownMenu) {
                            dropdownMenu.style.display = 'none';
                        }
                    }
                }
            });
        }
    }

    // تفعيل القوائم الفرعية في الشريط الجانبي
    const sidebarDropdowns = document.querySelectorAll('.sidebar-dropdown > a');
    sidebarDropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('click', function(e) {
            e.preventDefault();
            
            // إغلاق القوائم الفرعية المفتوحة الأخرى
            const activeDropdowns = document.querySelectorAll('.sidebar-dropdown.active');
            activeDropdowns.forEach(function(active) {
                if (active !== dropdown.parentElement) {
                    active.classList.remove('active');
                    if (active.querySelector('.sidebar-submenu')) {
                        active.querySelector('.sidebar-submenu').style.display = 'none';
                    }
                }
            });
            
            // تبديل حالة القائمة الحالية
            dropdown.parentElement.classList.toggle('active');
            const submenu = dropdown.nextElementSibling;
            if (submenu) {
                if (getComputedStyle(submenu).display === 'block') {
                    submenu.style.display = 'none';
                } else {
                    submenu.style.display = 'block';
                }
            }
        });
    });
    
    // تطبيق الأسلوب المباشر على جميع القوائم الفرعية لضمان عملها
    document.querySelectorAll('.sidebar-submenu').forEach(function(submenu) {
        submenu.style.display = 'none';
    });

    // تفعيل الرابط الحالي في الشريط الجانبي
    const activateSidebar = function() {
        const current = window.location.pathname;
        const sidebarLinks = document.querySelectorAll('#sidebar a');
        
        sidebarLinks.forEach(function(link) {
            if (link.getAttribute('href') && link.getAttribute('href') !== '#' && current.includes(link.getAttribute('href'))) {
                link.parentElement.classList.add('active');
                
                // تفعيل القائمة الأم إذا كان الرابط في قائمة فرعية
                const parentDropdown = link.closest('.sidebar-submenu');
                if (parentDropdown) {
                    parentDropdown.style.display = 'block';
                    const parentLi = parentDropdown.parentElement;
                    if (parentLi) {
                        parentLi.classList.add('active');
                    }
                }
            }
        });
    };
    
    activateSidebar();
});