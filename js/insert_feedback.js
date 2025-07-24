//for inserting feedback in the database
$(document).ready(function () {
    $('#confirmSubmit').on('click', function () {
        $.ajax({
            url: '/actions/insert_feedback.php',
            method: 'POST',
            data: $('#feedbackForm').serialize(),
            
            success: function (response) {
                try {
                    const res = JSON.parse(response);

                    if (res.success) {
                        $('#feedbackMessage').html(
                            `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${res.message || 'Feedback submitted successfully!'}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );

                        setTimeout(() => {
                            $('#feedbackMessage').fadeOut();
                        }, 5000);

                        const modal = document.getElementById("myModal");
                        modal.classList.add("fade-out");
                        setTimeout(() => {
                            modal.style.display = "none";
                            modal.classList.remove("fade-out");
                            $('#modalFeedbackMessage').html('').show();
                        }, 300);
                        
                        $('#feedbackForm')[0].reset();

                        // ✅ Clear preview
                        $('#modalComments').text('');
                        $('#modalSuggestions').text('');
                        $('#modalRevisions').text('');
                        $('#modalStatus').text('');
                        }
                    else {
                        // ❌ Show error message
                        $('#feedbackMessage').html(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${res.error || 'Something went wrong.'}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );

                        $('#modalFeedbackMessage').html(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${res.error || 'Something went wrong.'}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );

                        setTimeout(() => {
                            $('#modalFeedbackMessage').fadeOut();
                        }, 3000);
                        
                    }
                } catch (e) {
                    console.log(response);
                    $('#feedbackMessage').html(
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Unexpected response received.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`
                    );
                }
            },
            error: function (xhr) {
                alert('AJAX Error: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    $('#myModal input[type="submit"]').on('click', function () {
        $('#feedbackForm').submit(); // ✅ Simulate normal form submission
    });
});