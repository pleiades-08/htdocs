<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/verify-users.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchUserController.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/viewFileController.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchReviewer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchTeamgroup.php';
require $_SERVER['DOCUMENT_ROOT'] . '/controllers/fetchVersions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/view-pdf.css">
    <title>IMACS | Title Proposal</title>
</head>
<body>
    
<div class="navbar" id="navbar">
    <div class="logo">
        <img src="../../assets/img/kld-logo.png" alt="" class="kld-logo">
        <b><h4 style="font-weight: 600;">IMACS Faculty | Title Proposal</h4></b>
    </div>
    <div class="nav-links">
        <a href="/imacs-home" class="nav-link">Home</a>
        <a href="/imacs-upload.php" class="nav-link">Upload</a>
        <a href="/imacs-documents" class="nav-link">Documents</a>
        <img src="../../assets/img/profile.png" alt="" class="nav-logo">
    </div>
</div>

<div class="content">
    <div class="content-page">
        <div class="col-md-3"></div>
        <center><h2 style="margin: 10px 0px 10px 0px">Capstone Document Evaluation</h2></center>
        <hr>
        <div class="pdf-section">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
                    
            <script>
                const url = '<?= htmlspecialchars($file_path) ?>';

                const pdfjsLib = window['pdfjs-dist/build/pdf'];
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.worker.min.js';

                const container = document.createElement('div');
                container.id = 'pdf-container';
                document.body.querySelector('.pdf-section').prepend(container);

                pdfjsLib.getDocument(url).promise.then(function(pdf) {
                    const numPages = pdf.numPages;

                    for (let pageNumber = 1; pageNumber <= numPages; pageNumber++) {
                        pdf.getPage(pageNumber).then(function(page) {
                            const scale = 1.2;
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
                <div class="evalcon evalcon2" style="margin: 30px 0 30px 0;">
                    <h4>Previous Evaluation</h4>
                    <hr style="border: 0; height: 2px; background: #74c476; margin: 20px 0;">
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
                </div>

                <div class="evalcon evalcon2" style="margin: 30px 0 30px 0;">
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

                        <?php else: ?>
                            <!-- Message displayed if user is not on a team -->
                            <div class="alert alert-info mt-4">
                                You are not currently assigned to any team. Please contact your administrator to be added to a team.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="evalcon" style="margin: 30px 0 30px 0;">
                    <h4>Versions</h4>
                    <hr style="border: 0; height: 2px; background: #74c476; margin: 20px 0;">

                    <table class="table table-striped table-hover mb-4" style="width: 100%;" id="data_table">
                        <thead>
                            <tr>
                                <th style="padding: 6px;">Title</th>
                                <th style="padding: 6px;">Version</th>
                                <th style="padding: 6px;">Date Uploaded</th>                    
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($versions)): ?>
                                <?php foreach ($versions as $doc): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($doc['document_name']) ?></td>
                                        <td><?= htmlspecialchars($doc['version']) ?></td>
                                        <td><?= date('F d, Y', strtotime($doc['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">No documents found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../../../js/insert_feedback.js"></script>
<script src="../../../js/view_feedback.js"></script>
<script src="../../../js/modal.js"></script>
<script src="../../../js/accordion.js"></script>
        
</body>
</html>