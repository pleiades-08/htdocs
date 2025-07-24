document.addEventListener('DOMContentLoaded', function() {
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
  
  dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', function() {
      const parentItem = this.closest('.menu-item');
      parentItem.classList.toggle('active');
      
      // Close other open dropdowns
      if (parentItem.classList.contains('active')) {
        document.querySelectorAll('.menu-item.active').forEach(item => {
          if (item !== parentItem) {
            item.classList.remove('active');
          }
        });
      }
    });
  });
  
  // Set active menu item based on current URL
  const currentPath = window.location.pathname;
  const menuLinks = document.querySelectorAll('.menu-link, .dropdown-link');
  
  menuLinks.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('active');
      
      // Open parent dropdown if this is a dropdown item
      const dropdownItem = link.closest('.has-dropdown');
      if (dropdownItem) {
        dropdownItem.classList.add('active');
      }
    }
  });
});

