<?php
    if (!defined('CONFIRM_MODIFY_MODAL_INCLUDED')) {
        define('CONFIRM_MODIFY_MODAL_INCLUDED', true);
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var forms = document.querySelectorAll('form[data-confirm-modify="true"]');
    forms.forEach(function(form) {
        if (form.dataset.confirmModifyReady === 'true') {
            return;
        }

        form.dataset.confirmModifyReady = 'true';
        form.addEventListener('submit', function(e) {
            if (!confirm('Voulez-vous modifier ?')) {
                e.preventDefault();
                return false;
            }
        });
    });
});
</script>
<?php } ?>
