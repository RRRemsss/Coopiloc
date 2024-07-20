document.addEventListener('DOMContentLoaded', function () {
  const tabs = document.querySelectorAll('#form-tabs .nav-link');
  const sections = document.querySelectorAll('.form-section');

  tabs.forEach(tab => {
      tab.addEventListener('click', function (e) {
          e.preventDefault();
          
          tabs.forEach(t => t.classList.remove('active'));
          sections.forEach(s => s.classList.add('d-none'));

          this.classList.add('active');
          const target = document.querySelector(this.getAttribute('href'));
          target.classList.remove('d-none');
      });
  });
});
