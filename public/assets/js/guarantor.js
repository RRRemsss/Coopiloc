// document.addEventListener('DOMContentLoaded', function() {
//     const hasGuarantorYes = document.getElementById('hasGuarantor_1'); // Id for "Oui"
//     const hasGuarantorNo = document.getElementById('hasGuarantor_0'); // Id for "Non"
//     const guarantorTypeSection = document.getElementById('guarantorTypeSection');
//     const guarantorTypeParticulier = document.getElementById('lease_party_guarantorType_particulier'); // Id for "Particulier"
//     const guarantorTypeSociete = document.getElementById('lease_party_guarantorType_societe'); // Id for "Société/Autre"

//     const guarantorCompanyNameSection = document.getElementById('guarantorCompanyNameSection');
//     const guarantorDetailsSection = document.getElementById('guarantorDetailsSection');
//     const guarantorIdentityDocumentsSection = document.getElementById('guarantorIdentityDocumentsSection');
//     const guarantorContactSection = document.getElementById('guarantorContactSection');
//     const guarantorAddressSection = document.getElementById('guarantorAddressSection');
//     const guarantorPrivateCommentSection = document.getElementById('guarantorPrivateCommentSection');

//     // Function to toggle visibility of guarantorTypeSection and corresponding sections
//     function toggleGuarantorTypeSection() {
//         if (hasGuarantorYes.checked) {
//             guarantorTypeSection.classList.remove('hidden-focusable');
//             // Pre-check Particulier
//             guarantorTypeParticulier.checked = true;
//             showSections(['guarantorDetailsSection', 'guarantorIdentityDocumentsSection', 'guarantorContactSection', 'guarantorAddressSection', 'guarantorPrivateCommentSection']);
//             hideSections(['guarantorCompanyNameSection']);
//         } else {
//             guarantorTypeSection.classList.add('hidden-focusable');
//             hideSections(['guarantorDetailsSection', 'guarantorIdentityDocumentsSection', 'guarantorCompanyNameSection', 'guarantorContactSection', 'guarantorAddressSection', 'guarantorPrivateCommentSection']);
//         }
//     }

//     // Function to toggle visibility of sections based on guarantor type
//     function toggleGuarantorSections() {
//         if (guarantorTypeParticulier && guarantorTypeParticulier.checked) {
//             showSections(['guarantorDetailsSection', 'guarantorIdentityDocumentsSection', 'guarantorContactSection', 'guarantorAddressSection', 'guarantorPrivateCommentSection']);
//             hideSections(['guarantorCompanyNameSection']);
//         } else if (guarantorTypeSociete && guarantorTypeSociete.checked) {
//             showSections(['guarantorCompanyNameSection', 'guarantorContactSection', 'guarantorAddressSection', 'guarantorPrivateCommentSection']);
//             hideSections(['guarantorDetailsSection', 'guarantorIdentityDocumentsSection']);
//         }
//     }

//     // Helper functions to show and hide sections
//     function showSections(sectionIds) {
//         sectionIds.forEach(function(id) {
//             const section = document.getElementById(id);
//             if (section) {
//                 section.style.visibility = 'visible';
//                 section.style.position = 'relative';
//             }
//         });
//     }

//     function hideSections(sectionIds) {
//         sectionIds.forEach(function(id) {
//             const section = document.getElementById(id);
//             if (section) {
//                 section.style.visibility = 'hidden';
//                 section.style.position = 'absolute';
//             }
//         });
//     }

//     // Add event listeners to radio buttons
//     if (hasGuarantorYes && hasGuarantorNo) {
//         hasGuarantorYes.addEventListener('change', toggleGuarantorTypeSection);
//         hasGuarantorNo.addEventListener('change', toggleGuarantorTypeSection);

//         if (guarantorTypeParticulier) {
//             guarantorTypeParticulier.addEventListener('change', toggleGuarantorSections);
//         }
//         if (guarantorTypeSociete) {
//             guarantorTypeSociete.addEventListener('change', toggleGuarantorSections);
//         }

//         // Initial call to set the correct visibility on page load
//         toggleGuarantorTypeSection();

//         // Handle form submission to ensure all fields are focusable if invalid
//         document.querySelector('form').addEventListener('submit', function(event) {
//             if (!this.checkValidity()) {
//                 event.preventDefault();
//                 // Show guarantorTypeSection if guarantorType is invalid
//                 if (!document.querySelector('[name="lease_party[guarantorType]"]').validity.valid) {
//                     guarantorTypeSection.classList.remove('hidden-focusable');
//                 }
//                 // Show relevant sections if there are invalid fields within them
//                 const invalidElements = this.querySelectorAll(':invalid');
//                 invalidElements.forEach(function(element) {
//                     const section = element.closest('.section-form');
//                     if (section) {
//                         section.style.visibility = 'visible';
//                         section.style.position = 'relative';
//                     }
//                 });
//             }
//         });
//     } else {
//         console.error('The guarantor radio buttons are not found in the DOM.');
//     }
// });
