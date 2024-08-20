document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.querySelector('.startDate');
    const durationInput = document.querySelector('.duration');
    const endDateInput = document.querySelector('.endDate');

    if (startDateInput && durationInput && endDateInput) {
        function updateEndDate() {
            const startDate = new Date(startDateInput.value);
            let durationInMonths = 0;

            switch (durationInput.value) {
                case '1 an':
                    durationInMonths = 12;
                    break;
                case '3 ans':
                    durationInMonths = 36;
                    break;
                case '9 mois':
                    durationInMonths = 9;
                    break;
                case '9 ans':
                    durationInMonths = 108;
                    break;
                default:
                    durationInMonths = 0;
            }

            if (durationInMonths > 0) {
                startDate.setMonth(startDate.getMonth() + durationInMonths);
                endDateInput.value = startDate.toISOString().split('T')[0];
            } else {
                endDateInput.value = '';
            }
        }

        startDateInput.addEventListener('change', updateEndDate);
        durationInput.addEventListener('change', updateEndDate);
    } else {
        console.error('One or more input elements are not found  in durationRent.');
    }
});

