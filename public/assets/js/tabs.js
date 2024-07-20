document.addEventListener('DOMContentLoaded', (event) => {
    const navLinks = document.querySelectorAll('#navTabs .nav-link');
  
    navLinks.forEach(link => {
      link.addEventListener('click', function() {
        // Remove active class from all links
        navLinks.forEach(nav => nav.classList.remove('active'));
        // Add active class to the clicked link
        this.classList.add('active');
      });
    });
  });