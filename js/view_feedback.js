// view previous comments in the database
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
        dataType: 'json', // Expect JSON
        success: function(data) {
            console.log(data);
            if (Array.isArray(data) && data.length > 0) {
                let commentsHTML = '';
                let suggestionsHTML = '';
                let revisionsHTML = '';
                let remarksHTML = '';

                data.forEach(entry => {
                    commentsHTML += `<p>${entry.comments}</p>`;
                    suggestionsHTML += `<p>${entry.suggestions}</p>`;
                    revisionsHTML += `<p>${entry.required_revisions}</p>`;

                    let statusClass = '';
                    let displayText = entry.remarks;

                    if (entry.remarks === 'approved') {
                        statusClass = 'badge bg-success';
                        displayText = 'Approved';
                    } 
                    else if (entry.remarks === 'approved-minor') {
                        statusClass = 'badge bg-warning text-dark';
                        displayText = 'Approved (Minor Revision)';
                    } 
                    else if (entry.remarks === 'approved-major') {
                        statusClass = 'badge bg-warning text-dark';
                        displayText = 'Approved (Major Revision)';
                    } 
                    else if (entry.remarks === 'retitle') {
                        statusClass = 'badge bg-info text-dark';
                        displayText = 'Retitle';
                    } 
                    else if (entry.remarks === 'declined') {
                        statusClass = 'badge bg-danger';
                        displayText = 'Declined';
                    } 
                    else {
                        statusClass = 'badge bg-secondary';
                        displayText = entry.remarks;
                    }

                    remarksHTML += `<span class="${statusClass}">${displayText}</span><br>`;
                });

                $('#commentsTd').html(commentsHTML);
                $('#suggestionsTd').html(suggestionsHTML);
                $('#revisionsTd').html(revisionsHTML);
                $('#remarksTd').html(remarksHTML);

            } else {
                $('#commentsTd').html('No comments.');
                $('#suggestionsTd').html('No suggestions.');
                $('#revisionsTd').html('No revisions.');
                $('#remarksTd').html('No remarks');
            }
        },


        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}
