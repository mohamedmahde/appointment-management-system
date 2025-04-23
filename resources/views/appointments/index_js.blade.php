<script>
function toggleActionFields(select, id) {
    var scheduleField = document.getElementById('scheduleField' + id);
    var rejectionField = document.getElementById('rejectionReasonField' + id);
    if (!scheduleField || !rejectionField) {
        console.log('Fields not found for id', id);
        return;
    }
    if(select.value === 'schedule') {
        scheduleField.style.display = '';
        rejectionField.style.display = 'none';
        console.log('Show scheduleField', id);
    } else if(select.value === 'reject') {
        scheduleField.style.display = 'none';
        rejectionField.style.display = '';
        console.log('Show rejectionField', id);
    } else {
        scheduleField.style.display = 'none';
        rejectionField.style.display = 'none';
        console.log('Hide all fields', id);
    }
}
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('select[name="action"]').forEach(function(sel) {
        var id = sel.getAttribute('data-id');
        if(id) {
            toggleActionFields(sel, id);
            sel.addEventListener('change', function() {
                toggleActionFields(this, id);
            });
        }
    });
});
    // تحقق قبل الإرسال: إذا كان schedule والتاريخ فارغ أظهر رسالة ولا ترسل النموذج
    document.querySelectorAll('form').forEach(function(form) {
        var actionSel = form.querySelector('select[name="action"]');
        var scheduleInput = form.querySelector('input[name="scheduled_time"]');
        var rejectionInput = form.querySelector('textarea[name="rejection_reason"]');
        if (actionSel) {
            form.addEventListener('submit', function(e) {
                if (actionSel.value === 'schedule' && scheduleInput && !scheduleInput.value) {
                    alert('يجب إدخال التاريخ');
                    scheduleInput.focus();
                    e.preventDefault();
                }
                if (actionSel.value === 'reject' && rejectionInput && !rejectionInput.value.trim()) {
                    alert('يجب إدخال سبب الرفض');
                    rejectionInput.focus();
                    e.preventDefault();
                }
            });
        }
    });
</script>
