 document.querySelectorAll('.accordion').forEach(button => {
    button.addEventListener('click', () => {
      const panel = button.nextElementSibling;
      const chevron = button.querySelector('.chevron');

      // Add display early to allow transition
      if (!panel.classList.contains('show')) {
        panel.classList.add('show');
        requestAnimationFrame(() => panel.classList.add('open'));
      } else {
        panel.classList.remove('open');
        panel.addEventListener('transitionend', () => {
          panel.classList.remove('show');
        }, { once: true });
      }

      button.classList.toggle('active');
      if (chevron) chevron.classList.toggle('rotate');
    });
  });



// The actual form submission will now happen when the user clicks the "Confirm and Submit" button inside the modal
// This button is of type "submit" and is part of the form, so it will trigger the form submission.