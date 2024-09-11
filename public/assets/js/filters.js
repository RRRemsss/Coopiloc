document.addEventListener('DOMContentLoaded', function() {
    console.log('Inline script loaded');

    var form = document.getElementById('filter-form');
    var propertyFilter = document.getElementById('filter-property');
    var statusFilter = document.getElementById('filter-status');
    
    if (!form || !propertyFilter || !statusFilter) {
        console.error('Form or filter elements not found');
        return;
    }

    function submitForm() {
        console.log('Submitting form');
        form.submit();
    }

    propertyFilter.addEventListener('change', submitForm);
    statusFilter.addEventListener('change', submitForm);
});