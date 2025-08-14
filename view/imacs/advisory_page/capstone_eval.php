<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/actions/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchTeam.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/component.css">
    <title>Document</title>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/components/sidebar.php'; ?>
    <main class="flex-grow-1 p-4">
        <div class="content-page ">
            <a href="/imacs-capstone_teams"><h2 class="mb-4">Your Advised Team</h2></a>

            <div class="student-team">
                <div class="container-t">
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
                            <?php unset($_SESSION['success']); ?>
                            <?php endif; ?>
                    
                    <div class="teams">
                        <?php if ($user_is_on_team): ?>
                            <div class="table-title">Team Details</div>
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
                            <div class="data-cell"><?= htmlspecialchars($teamData['capstone_type']) ?></div>
                        </div>
                    </div>

                        
                </div>

                <div class="team-docs">
                    <div class="table-title">Previously uploaded Documents</div>
                    <?php if (empty($documents)): ?>
                        <div class="alert alert-info">No documents uploaded yet.</div>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach ($documents as $doc): ?>
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
                                            <a href="/controllers/fetchLocationController.php?
                                            id=<?= urlencode($fetch['user_id']) ?>&
                                            td=<?= urlencode($_GET['td']) ?>" class="btn btn-sm btn-info">
                                                View
                                            </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php else: ?>
                    <!-- Message displayed if user is not on a team -->
                    <div class="alert alert-info mt-4">
                        You are not currently assigned to any team. Please contact your administrator to be added to a team.
                    </div>
                <?php endif; ?>
                
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="ratio ratio-16x9">
                                    <div class="pdf-section">
                                        <!-- PDF Viewer Section -->
                                        <div class="pdf-section mb-4">
                                            <div id="loading-spinner" class="text-center my-3" style="display:none;">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <div>Loading PDF...</div>
                                            </div>
                                            <div id="pdf-viewer-container">

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
                                                                    const scale = 1.30;
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
                                                    <?php if (!empty($documents)): ?>
                                                        renderPDF('<?= htmlspecialchars($documents[0]['file_path']) ?>');
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

                                            </div>
                                        </div>

                                        <!-- Comment Section -->
                                        <div class="comment-section mt-4">
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

                                                            <button class="evalbtns btnctm" type="button" id="confirmSubmit">Submit</button>
                                                            <button class="evalbtns btnctm2" type="button"><a href="/imacs-capstone_eval?td=<?= htmlspecialchars($teamData['team_id'] ?? '') ?>">Cancel</a></button>
                                                    </div>
                                                </div>
                                                <div class="evalcon evalcon2" style="margin: 30px 0 30px 0;">
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
                                                                <td id="remarksTD" class="loading">Select an evaluation type to view details.</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/accordion.js"></script>
    <script src="/js/insert_feedback.js"></script>
    <script>
    // Simulate loading delay (adjust to actual AJAX call timing)
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('comment-history-placeholder').style.display = 'none';
            document.getElementById('actual-comment-history').style.display = 'block';
        }, 3000); // 1 second delay
    });
</script>
</body>
</html>