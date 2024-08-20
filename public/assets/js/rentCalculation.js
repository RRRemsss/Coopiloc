document.addEventListener('DOMContentLoaded', function() {
    const netRentInput = document.querySelector('.netRent');
    const chargeInput = document.querySelector('.charge');
    const grossRentInput = document.querySelector('.grossRent');

    if (netRentInput && chargeInput && grossRentInput) {
        function updateGrossRent() {
            const netRent = parseFloat(netRentInput.value) || 0;
            const charge = parseFloat(chargeInput.value) || 0;
            const grossRent = netRent + charge;
            grossRentInput.value = grossRent.toFixed(2);
        }

        netRentInput.addEventListener('input', updateGrossRent);
        chargeInput.addEventListener('input', updateGrossRent);
    } else {
        console.error('One or more input elements are not found in rentCalculation.');
    }
});