function initTabs() {
  const tabs = document.querySelectorAll('#form-tabs .nav-link');
  const sections = document.querySelectorAll('.form-section');

  if (tabs.length && sections.length) {
      tabs.forEach(tab => {
          tab.addEventListener('click', function (e) {
              e.preventDefault();
              
              tabs.forEach(t => t.classList.remove('active'));
              sections.forEach(s => s.classList.add('d-none'));

              this.classList.add('active');
              const target = document.querySelector(this.getAttribute('href'));
              if (target) {
                  target.classList.remove('d-none');
              }
          });
      });
  }
}

// Function calls when init page
document.addEventListener("DOMContentLoaded", initTabs);

// Function calls when reload page with turbo Function
document.addEventListener('turbo:load', initTabs);