<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/viewFileController.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchVersions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchTeam.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchReviewer.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/view-pdf.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>IMACS | Title Proposal</title>
</head>
<body>
    

<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>
<br>

<main class="flex-grow-1 p-4" style="width: 1600px; overflow-x: hidden;">
    <div class="content-page">
        <center><h2 style="margin: 10px 0px 10px 0px">Capstone Document Evaluation</h2></center>
        <hr>
        <div class="pdf-section">
        <!-- Bootstrap Placeholder for PDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
            <script>
                const pdfjsLib = window['pdfjs-dist/build/pdf'];
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.worker.min.js';

                const container = document.createElement('div');
                container.id = 'pdf-container';
                document.body.querySelector('.pdf-section').prepend(container);

                function renderPDF(url) {
                    // Clear previous renders
                    container.innerHTML = '';

                    pdfjsLib.getDocument(url).promise.then(function(pdf) {
                        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                            pdf.getPage(pageNumber).then(function(page) {
                                const scale = 1.20;
                                const viewport = page.getViewport({ scale: scale });

                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                container.appendChild(canvas);

                                const renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext);
                            });
                        }
                    });
                }

                // Automatically render the first document (if exists)
                <?php if (!empty($versions)): ?>
                    renderPDF('<?= htmlspecialchars($versions[0]['file_path']) ?>');
                <?php endif; ?>

                // Event delegation for dynamically loaded buttons
                document.addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('view-pdf-btn')) {
                        e.preventDefault();
                        const filePath = e.target.getAttribute('data-file');
                        renderPDF(filePath);
                    }
                });
            </script>

            <div class="comment-sections">
                <form method="POST" id="feedbackForm"> 
                <div id="feedbackMessage"></div>
                    <div class="evalcon">
                        <center><h4 id="evalhead">Comments, Suggestions and Revisions</h4></center>
                        <button class="accordion chapter" type="button">
                            <h3>Rationale</h3> <span class="chevron">&#x25BC;</span>
                        </button>
                        <div class="panel chapter-content" >
                            <button class="accordion nested" type="button"><h3>Comments</h3> <span class="chevron">&#x25BC;</span></button>
                            <div class="nested-panel">
                                <textarea name="comments" id="commentsInput" placeholder="Add comment for Rationale..."></textarea>
                            </div>

                            <button class="accordion nested" type="button"><h3>Suggestions</h3> <span class="chevron">&#x25BC;</span></button>
                            <div class="nested-panel">
                                <textarea name="suggestions" id="suggestionsInput" placeholder="Add suggestions for Rationale..."></textarea>
                            </div>

                            <button class="accordion nested" type="button"><h3>Revisions</h3> <span class="chevron">&#x25BC;</span></button>
                            <div class="nested-panel">
                                <textarea name="required_revisions" id="revisionsInput" placeholder="Add revisions for Rationale..."></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="chapter_no" id="chapter_no" value="Proposal">
                    </div>

                    <div class="evalcon evalbtn">
                        <label for="status"><h3>Status: </h3></label>
                        <div class="buttons">
                            <select id="remarks" name="remarks">
                                <option value="approved">Approved</option>
                                <option value="approved-minor">Approved with Minor Revision</option>
                                <option value="approved-major">Approved with Major Revision</option>
                                <option value="retitle">Retitle</option>
                                <option value="declined">Declined</option>
                            </select>
                                <input type="hidden" name="fileName" id="filename" value="<?= htmlspecialchars($fileName ?? 'N/A') ?>">
                                <input type="hidden" name="document_id" id="documentId" value="<?= htmlspecialchars($document_id ?? '') ?>">
                                <input type="hidden" name="user_id" id="reviewerId" value="<?= htmlspecialchars($reviewer_id ?? '') ?>">

                                <button id="openModalBtn" class="evalbtns btnctm" type="button">Submit</button>
                                <button class="evalbtns btnctm2" type="button"><a href="/imacs-documents">Cancel</a></button>
                        </div>
                    </div>

                    <div id="myModal" class="modal">
                        <div class="modal-content">
                        <span class="close-button">&times;</span>
                        <h2>Review Your Feedback</h2>
                        <hr style="border: 0; height: 2px; background: #74c476; margin: 20px 0;">
                        <div id="ModalfeedbackMessage"></div>
                        <br>
                        <h4>Comments:</h4>
                        <p id="modalComments"></p> <h4>Suggestions:</h4>
                        <p id="modalSuggestions"></p> <h4>Revisions:</h4>
                        <p id="modalRevisions"></p> <h4>Status:</h4>
                        <p id="modalStatus"></p> 
                        <button class="evalbtns btnctm" type="button" id="confirmSubmit">Confirm and Submit</button>
                        </div>
                    </div>

                </form>        
            <!-- Previous Evaluation Section with AJAX -->
                <div class="evalcon evalcon2">
                    <h4>Previous Evaluation</h4>
                    <hr style="border: 0; height: 2px; background: #74c476; margin: 20px 0;">

                    <!-- Placeholder while loading comment history -->
                    <div id="comment-history-placeholder" class="placeholder-glow mb-3">
                        <p class="placeholder col-12 placeholder-lg"></p>
                        <p class="placeholder col-12 placeholder-lg"></p>
                        <p class="placeholder col-12 placeholder-lg"></p>
                    </div>

                    <div id="actual-comment-history" style="display: none;">
                        <p class="text-sm text-gray-500 mt-4"><strong>Document: </strong><span id="fileNameDisplay"><?= htmlspecialchars($fileName ?? 'N/A') ?></span></p>
                        <select id="history" name="history_chapter" onchange="showEval(this.value)">
                            <option value="">-- Select Evaluation Type --</option>
                            <option value="Proposal">Title Proposal</option>
                            <option value="Capstone 1">Capstone 1</option>
                            <option value="Capstone 2">Capstone 2</option>
                        </select>

                        
                        <table id="results">
                            <tr>
                                <th>Comments:</th>
                                <td id="commentsTd" class="loading">Select an evaluation type to view details.</td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th>Suggestions:</th>
                                <td id="suggestionsTd" class="loading">Select an evaluation type to view details.</td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th>Revisions:</th>
                                <td id="revisionsTd" class="loading">Select an evaluation type to view details.</td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th>Status:</th>
                                <td id="remarksTd" class="loading">
                                    Select an evaluation type to view details.
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="evalcon evalcon2">
                <h4>Team information:</h4>
                    <hr style="border: 0; height: 2px; background: #74c476; margin: 20px 0;">
                    <div class="container-t">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                        <?php if ($user_is_on_team): ?>
                            <!-- Example Row 1 -->
                            <div class="table-row">
                                <div class="header-cell">Title:</div>
                                <div class="data-cell">
                                    <?= htmlspecialchars($teamData['capstone_title']) ?>
                                </div>
                            </div>

                            <!-- Example Row 2 -->
                            <div class="table-row">
                                <div class="header-cell">Adviser:</div>
                                <div class="data-cell"><?= htmlspecialchars($teamData['adviser_name']) ?></div>
                            </div>

                            <!-- Example Row 3 -->
                            <div class="table-row">
                                <div class="header-cell">Technical:</div>
                                <div class="data-cell"><?= htmlspecialchars($teamData['technical_name']) ?></div>
                            </div>

                            <!-- Example Row 4 -->
                            <div class="table-row">
                                <div class="header-cell">Chairman:</div>
                                <div class="data-cell"><?= htmlspecialchars($teamData['chairman_name']) ?></div>
                            </div>

                            <!-- Example Row 5 -->
                            <div class="table-row">
                                <div class="header-cell">Major Discipline:</div>
                                <div class="data-cell"><?= htmlspecialchars($teamData['major_name']) ?></div>
                            </div>

                            <!-- Example Row 6 -->
                            <div class="table-row">
                                <div class="header-cell">Minor Discipline:</div>
                                <div class="data-cell"><?= htmlspecialchars($teamData['minor_name']) ?></div>
                            </div>

                            <!-- Example Row 7 -->
                            <div class="table-row">
                                <div class="header-cell">Panelist:</div>
                                <div class="data-cell"><?= htmlspecialchars($teamData['panelist_name']) ?></div>
                            </div>

                            <!-- Example Row for Team Members (using a list inside data cell) -->
                            <div class="table-row">
                                <div class="header-cell">Team Members:</div>
                                <div class="data-cell">
                                    <ul class="team-members-list">
                                    <?php 
                                    // Ensure 'members' key exists and is not null before exploding
                                    $members = !empty($teamData['members']) ? explode(', ', $teamData['members']) : [];
                                    if (!empty($members)) {
                                        foreach ($members as $member) {
                                            echo '<li>' . htmlspecialchars(trim($member)) . '</li>';
                                        }
                                    } else {
                                        echo '<li>No members found for this team.</li>';
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Example Row 8 (if you need another single piece of data) -->
                            <div class="table-row">
                                <div class="header-cell">Project Status:</div>
                                <div class="data-cell">In Progress</div>
                            </div>

                            <div class="table-title">VERSIONS </div>

                            <?php if (empty($versions)): ?>
                                <div class="alert alert-info">No documents uploaded yet.</div>
                            <?php else: ?>
                                <div class="list-group">
                                    <?php foreach ($versions as $doc): ?>
                                        <div class="list-group-item document-card mb-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <span class="file-icon">
                                                        <?php if (strpos($doc['file_type'], 'pdf') !== false): ?>
                                                            📄
                                                        <?php elseif (strpos($doc['file_type'], 'word') !== false): ?>
                                                            📝
                                                        <?php else: ?>
                                                            📁
                                                        <?php endif; ?>
                                                    </span>
                                                    <div>
                                                        <h6><?= htmlspecialchars($doc['document_name']) ?></h6>
                                                        <small class="text-muted">
                                                            Uploaded: <?= date('M d, Y h:i A', strtotime($doc['created_at'])) ?>
                                                            | Size: <?= round($doc['file_size'] / 1024 / 1024, 2) ?>MB
                                                            | Status: <span class="badge bg-<?= 
                                                                $doc['status'] === 'Approved' ? 'success' : 
                                                                ($doc['status'] === 'Rejected' ? 'danger' : 'warning') 
                                                            ?>"><?= $doc['status'] ?></span>
                                                        </small>
                                                    </div>
                                                </div>
                                                <button 
                                                    class="btn btn-sm btn-outline-primary view-pdf-btn" 
                                                    data-file="<?= htmlspecialchars($doc['file_path']) ?>">
                                                    VIEW
                                                </button>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <!-- Message displayed if user is not on a team -->
                            <div class="alert alert-info mt-4">
                                You are not currently assigned to any team. Please contact your administrator to be added to a team.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</main>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="/js/insert_feedback.js"></script>
<script src="/js/view_feedback.js"></script>
<script src="/js/modal.js"></script>
<script src="/js/view_team.js"></script>
<script src="/js/accordion.js"></script>
<script>
    // Simulate loading delay (adjust to actual AJAX call timing)
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('comment-history-placeholder').style.display = 'none';
            document.getElementById('actual-comment-history').style.display = 'block';
        }, 1000); // 1 second delay
    });
</script>
        
</body>
</html>