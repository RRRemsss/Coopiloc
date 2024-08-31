document.addEventListener('DOMContentLoaded', function() {
    const hasGuarantorYes = document.getElementById('hasGuarantor_1'); // Id for "Oui"
    const hasGuarantorNo = document.getElementById('hasGuarantor_0'); // Id for "Non"
    const guarantorTypeSection = document.getElementById('guarantorTypeSection');
    const guarantorTypeParticulier = document.getElementById('guarantorType_particulier'); // Id for "Particulier"
    const guarantorTypeSociete = document.getElementById('guarantorType_company'); // Id for "Société/Autre"

    const guarantorIdentitySection = document.getElementById('guarantorIdentitySection');
    const guarantorDetailsSection = document.getElementById('guarantorDetailSection');
    const guarantorIdentityLeasePartysSection = document.getElementById('guarantorIdentityLeasePartySection');
    const guarantorContactSection = document.getElementById('guarantorContactSection');
    const guarantorAddressSection = document.getElementById('guarantorAddressSection');
    const guarantorCompanyNameSection = document.getElementById('guarantorCompanyNameSection');
    const guarantorUploadZoneSection = document.getElementById('guarantorUploadZoneSection');

    // Function to toggle visibility of guarantorTypeSection and corresponding sections
    function toggleGuarantorTypeSection() {
        if (hasGuarantorYes.checked) {
            guarantorTypeSection.classList.remove('hidden-focusable');
            guarantorUploadZoneSection.classList.remove('hidden-focusable');
            // Ensure no type is pre-checked
            guarantorTypeParticulier.checked = false;
            guarantorTypeSociete.checked = false;
            hideAllGuarantorSections();
        } else {
            guarantorTypeSection.classList.add('hidden-focusable');
            guarantorUploadZoneSection.classList.add('hidden-focusable');
            hideAllGuarantorSections();
        }
    }

    // Function to toggle visibility of sections based on guarantor type
    function toggleGuarantorSections() {
        if (guarantorTypeParticulier && guarantorTypeParticulier.checked) {
            showSections(['guarantorIdentitySection', 'guarantorDetailSection', 'guarantorIdentityLeasePartySection', 'guarantorContactSection', 'guarantorAddressSection', 'guarantorUploadZoneSection']);
            hideSections(['guarantorCompanyNameSection']);
        } else if (guarantorTypeSociete && guarantorTypeSociete.checked) {
            showSections(['guarantorCompanyNameSection', 'guarantorContactSection', 'guarantorAddressSection', 'guarantorUploadZoneSection']);
            hideSections(['guarantorIdentitySection', 'guarantorDetailSection', 'guarantorIdentityLeasePartySection']);
        }
    }

    // Helper functions to show and hide sections
    function showSections(sectionIds) {
        sectionIds.forEach(function(id) {
            const section = document.getElementById(id);
            if (section) {
                section.classList.remove('hidden-focusable');
            }
        });
    }

    function hideSections(sectionIds) {
        sectionIds.forEach(function(id) {
            const section = document.getElementById(id);
            if (section) {
                section.classList.add('hidden-focusable');
            }
        });
    }

    function hideAllGuarantorSections() {
        hideSections(['guarantorIdentitySection', 'guarantorDetailSection', 'guarantorIdentityLeasePartySection', 'guarantorCompanyNameSection', 'guarantorContactSection', 'guarantorAddressSection', 'guarantorUploadZoneSection']);
    }

    // Add event listeners to radio buttons
    if (hasGuarantorYes && hasGuarantorNo) {
        hasGuarantorYes.addEventListener('change', toggleGuarantorTypeSection);
        hasGuarantorNo.addEventListener('change', toggleGuarantorTypeSection);

        if (guarantorTypeParticulier) {
            guarantorTypeParticulier.addEventListener('change', toggleGuarantorSections);
        }
        if (guarantorTypeSociete) {
            guarantorTypeSociete.addEventListener('change', toggleGuarantorSections);
        }

        // Initial call to set the correct visibility on page load
        toggleGuarantorTypeSection();

        // Handle form submission to ensure all fields are focusable if invalid
        document.querySelector('form').addEventListener('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                // Show guarantorTypeSection if guarantorType is invalid
                if (!document.querySelector('[name="guarantor[guarantorType]"]').validity.valid) {
                    guarantorTypeSection.classList.remove('hidden-focusable');
                }
                // Show relevant sections if there are invalid fields within them
                const invalidElements = this.querySelectorAll(':invalid');
                invalidElements.forEach(function(element) {
                    const section = element.closest('.section-form');
                    if (section) {
                        section.classList.remove('hidden-focusable');
                    }
                });
            }
        });
    } else {
        console.error('The guarantor radio buttons are not found in the DOM.');
    }
});
