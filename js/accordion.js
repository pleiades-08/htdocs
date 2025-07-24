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


// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var openBtn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
var closeBtn = document.getElementsByClassName("close-button")[0];

// Get the form elements
var commentsInput = document.getElementById("commentsInput");
var suggestionsInput = document.getElementById("suggestionsInput");
var revisionsInput = document.getElementById("revisionsInput");
var remarksSelect = document.getElementById("remarks"); // Get the select element

// Get the elements within the modal where feedback will be displayed
var modalComments = document.getElementById("modalComments");
var modalSuggestions = document.getElementById("modalSuggestions");
var modalRevisions = document.getElementById("modalRevisions");
var modalStatus = document.getElementById("modalStatus"); // New element for status

// Get the form itself to attach a submit listener
var feedbackForm = document.getElementById("feedbackForm");

// When the user clicks the "Submit" button (which now opens the modal)
openBtn.onclick = function(event) {
  // Prevent the form from submitting immediately
  // No need for event.preventDefault() here as the button type is "button"

  // Populate the modal with current form values
  modalComments.textContent = commentsInput.value || "No comments entered.";
  modalSuggestions.textContent = suggestionsInput.value || "No suggestions entered.";
  modalRevisions.textContent = revisionsInput.value || "No revisions required.";
  modalStatus.textContent = remarksSelect.options[remarksSelect.selectedIndex].text; // Get the displayed text of the selected option

  modal.style.display = "flex"; // Make it visible (but still transparent)
  // Use a tiny timeout to allow the browser to render display:flex before applying opacity/transform
  setTimeout(() => {
    modal.classList.add("modal-open"); // Trigger the CSS animation
  }, 10); // A small delay, 0ms often works too
}

// Function to close the modal with animation
function closeModal() {
  modal.classList.remove("modal-open"); // Trigger the CSS reverse animation
  // Listen for the end of the transition
  modal.addEventListener('transitionend', function handler() {
    modal.style.display = "none"; // Hide it completely after animation
    modal.removeEventListener('transitionend', handler); // Remove the listener
  }, { once: true }); // Ensure the listener runs only once
}

// When the user clicks on <span> (x), close the modal
closeBtn.onclick = function() {
  closeModal();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    closeModal();
  }
}

// The actual form submission will now happen when the user clicks the "Confirm and Submit" button inside the modal
// This button is of type "submit" and is part of the form, so it will trigger the form submission.