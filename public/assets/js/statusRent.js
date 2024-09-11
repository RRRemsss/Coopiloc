document.addEventListener('DOMContentLoaded', function() {
    var selects = document.querySelectorAll('.form-select');

    selects.forEach(function(select) {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});