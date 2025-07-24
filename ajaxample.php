<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Evaluation System</title>
    <style>
        .evalcon {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: Arial, sans-serif;
        }
        
        .evalcon h4 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: #f9f9f9;
            border-radius: 4px;
            overflow: hidden;
        }
        
        th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            width: 150px;
        }
        
        td {
            padding: 12px;
            border-left: 1px solid #ddd;
            min-height: 50px;
            vertical-align: top;
        }
        
        .loading {
            color: #666;
            font-style: italic;
        }
        
        .error {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        
        .no-data {
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="evalcon evalcon2">
        <h4>Previous evaluation</h4>
        <select id="history" name="capstone_type">
            <option value="Title Proposal">Title Proposal</option>
            <option value="Capstone 1">Capstone 1</option>
            <option value="Capstone 2">Capstone 2</option>
        </select>

        <table>
            <tr>
                <th>Comments:</th>
                <td id="commentsTd" class="loading">Loading...</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Suggestions:</th>
                <td id="suggestionsTd" class="loading">Loading...</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Revisions:</th>
                <td id="revisionsTd" class="loading">Loading...</td>
            </tr>
        </table>
    </div>

    <script>
        // Configuration - Update these values according to your setup
        const CONFIG = {
            apiEndpoint: 'get_evaluation.php', // Your PHP script URL
            fileName: 'sample_document.pdf', // This should come from your application context
            evaluationType: 'Title Proposal' // Default evaluation type
        };

        // Function to fetch evaluation data
        async function fetchEvaluationData(evaluationType = null) {
            const commentsEl = document.getElementById('commentsTd');
            const suggestionsEl = document.getElementById('suggestionsTd');
            const revisionsEl = document.getElementById('revisionsTd');
            
            // Show loading state
            commentsEl.innerHTML = '<span class="loading">Loading...</span>';
            suggestionsEl.innerHTML = '<span class="loading">Loading...</span>';
            revisionsEl.innerHTML = '<span class="loading">Loading...</span>';

            try {
                const requestData = {
                    fileName: CONFIG.fileName,
                    evaluationType: evaluationType || CONFIG.evaluationType
                };

                const response = await fetch(CONFIG.apiEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    // Update the UI with the fetched data
                    commentsEl.innerHTML = data.evaluation.comments || '<span class="no-data">No comments available</span>';
                    suggestionsEl.innerHTML = data.evaluation.suggestions || '<span class="no-data">No suggestions available</span>';
                    revisionsEl.innerHTML = data.evaluation.required_revisions || '<span class="no-data">No revisions required</span>';
                } else {
                    throw new Error(data.message || 'Failed to fetch evaluation data');
                }

            } catch (error) {
                console.error('Error fetching evaluation data:', error);
                
                const errorMessage = `<span class="error">Error: ${error.message}</span>`;
                commentsEl.innerHTML = errorMessage;
                suggestionsEl.innerHTML = errorMessage;
                revisionsEl.innerHTML = errorMessage;
            }
        }

        // Event listener for dropdown change
        document.getElementById('history').addEventListener('change', function() {
            const selectedType = this.value;
            fetchEvaluationData(selectedType);
        });

        // Load initial data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetchEvaluationData();
        });

        // Optional: Function to update fileName dynamically
        function updateFileName(newFileName) {
            CONFIG.fileName = newFileName;
            const currentType = document.getElementById('history').value;
            fetchEvaluationData(currentType);
        }

        // Optional: Function to refresh current data
        function refreshEvaluationData() {
            const currentType = document.getElementById('history').value;
            fetchEvaluationData(currentType);
        }
    </script>
</body>
</html>