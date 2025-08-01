//view previous comments in the database
const documentId = document.getElementById('documentId').value;
const reviewerId = document.getElementById('reviewerId').value;

// Define the showEval function
function showEval(selectedValue) {
    if (!selectedValue) return;

    $.ajax({
        url: '../controllers/fetch_evaluation_data.php',
        method: 'POST',
        data: {
            selectedValue: selectedValue,
            documentId: documentId,
            reviewerId: reviewerId
        },
        dataType: 'json', // <-- tell jQuery to expect JSON
        success: function(data) {
            // Data is an array of objects
            if (Array.isArray(data) && data.length > 0) {
                    let commentsHTML = '';
                    let suggestionsHTML = '';
                    let revisionsHTML = '';

                    data.forEach(entry => {
                    commentsHTML += `<p>${entry.comments}</p>`;
                    suggestionsHTML += `<p>${entry.suggestions}</p>`;
                    revisionsHTML += `<p>${entry.required_revisions}</p>`;
                    });

                    $('#commentsTd').html(commentsHTML);
                    $('#suggestionsTd').html(suggestionsHTML);
                    $('#revisionsTd').html(revisionsHTML);
                } else {
                    $('#commentsTd').html('No comments.');
                    $('#suggestionsTd').html('No suggestions.');
                    $('#revisionsTd').html('No revisions.');
                }
            },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });

}
