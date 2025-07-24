document.addEventListener('DOMContentLoaded', function() {
  // Mobile toggle functionality
  const toggler = document.querySelector('.navbar-toggler');
  const navbarCollapse = document.querySelector('.navbar-collapse');
  
  if (toggler && navbarCollapse) {
    toggler.addEventListener('click', function() {
      navbarCollapse.classList.toggle('show');
      
      // Animate the toggle icon
      this.classList.toggle('open');
    });
  }
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown')) {
      const openDropdowns = document.querySelectorAll('.dropdown.show');
      openDropdowns.forEach(dropdown => {
        dropdown.classList.remove('show');
      });
    }
  });
  
  // Mobile dropdown functionality
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
  dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', function(e) {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        const dropdown = this.closest('.dropdown');
        dropdown.classList.toggle('show');
        
        // Close other dropdowns
        document.querySelectorAll('.dropdown.show').forEach(item => {
          if (item !== dropdown) {
            item.classList.remove('show');
          }
        });
      }
    });
  });
  
  // Set active link based on current page
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
  
  navLinks.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('active');
      
      // Keep parent dropdown open if this is a dropdown item
      const dropdownItem = link.closest('.dropdown-menu');
      if (dropdownItem) {
        dropdownItem.closest('.dropdown').classList.add('show');
      }
    }
  });
});