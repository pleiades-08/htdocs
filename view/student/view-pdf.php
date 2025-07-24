<?php

require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchUserController.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchDocumentsController.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/viewFileController.php';

$file = $_GET['file_name'] ?? null;
$progress = $_GET['progress'] ?? null;

if (!$file || !$progress) {
    die("Missing required parameters.");
}

// Use $file and $progress safely in your logic (e.g., load PDF, display data)
echo "<h2>Viewing: " . htmlspecialchars($file) . "</h2>";
echo "<p>Progress: " . htmlspecialchars($progress) . "</p>";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/view-pdf.css">
    <title>STUDENT | View Documents</title>
</head>
<body>
    
<div class="navbar" id="navbar">
    <div class="logo">
        <img src="../../assets/img/kld-logo.png" alt="" class="kld-logo">
        <b><h4 style="font-weight: 600;">IMACS STUDENT / <?= htmlspecialchars($progress) ?></h4></b>
    </div>
    <div class="nav-links">
      <a href="../../router/router.php?page=student-home" class="nav-link">Home</a>
      <a href="../../router/router.php?page=student-upload" class="nav-link">Upload</a>
      <a href="../../router/router.php?page=student-documents" class="nav-link">Documents</a>
        <img src="../../assets/img/profile.png" alt="" class="nav-logo">
    </div>
</div>

<div class="content">

    <div class="content-page">
        <div class="col-md-3"></div>
 
    <center><h2 style="margin: 10px 0px 10px 0px">Student Documents</h2></center>
    <hr>
    <div class="pdf-section">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>

        
        
        <script>
            const url = '<?= htmlspecialchars($filepath) ?>';

            const pdfjsLib = window['pdfjs-dist/build/pdf'];
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.worker.min.js';

            const container = document.createElement('div');
            container.id = 'pdf-container';
            document.body.querySelector('.pdf-section').prepend(container); // Adjust selector as needed

            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                const numPages = pdf.numPages;

                // Render each page
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
        
        <div class="comment">
            <form action="">
                <center><h4>Comments, Suggestions, and Revisions</h4></center>
                <div class="accordion">
                    <div class="accordion-item">
                        <input type="radio" id="section1" name="accordion" />
                        <label for="section1" class="accordion-header">
                        <label class="accordion-title">Comment Sections</label>
                        <div class="accordion-icon">
                            <svg
                            viewBox="0 0 16 16"
                            fill="none"
                            height="16"
                            width="16"
                            xmlns="http://www.w3.org/2000/svg"
                            >
                            <path
                                d="M4.293 5.293a1 1 0 0 1 1.414 0L8 7.586l2.293-2.293a1 1 0 0 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z"
                                fill="currentColor"
                            ></path>
                            </svg>
                        </div>
                        </label>
                        <div class="comment-section">
                        <p><strong>Chapter 1</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 2</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 3</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 4</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 5</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <input checked="" type="radio" id="section2" name="accordion" />
                        <label for="section2" class="accordion-header">
                        <label class="accordion-title">Suggestions Section</label>
                        <div class="accordion-icon">
                            <svg
                            viewBox="0 0 16 16"
                            fill="none"
                            height="16"
                            width="16"
                            xmlns="http://www.w3.org/2000/svg"
                            >
                            <path
                                d="M4.293 5.293a1 1 0 0 1 1.414 0L8 7.586l2.293-2.293a1 1 0 0 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z"
                                fill="currentColor"
                            ></path>
                            </svg>
                        </div>
                        </label>
                        <div class="comment-section">
                        <p><strong>Chapter 1</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 2</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 3</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 4</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 5</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <input type="radio" id="section3" name="accordion" />
                        <label for="section3" class="accordion-header">
                        <label class="accordion-title">Revisions Section</label>
                        <div class="accordion-icon">
                            <svg
                            viewBox="0 0 16 16"
                            fill="none"
                            height="16"
                            width="16"
                            xmlns="http://www.w3.org/2000/svg"
                            >
                            <path
                                d="M4.293 5.293a1 1 0 0 1 1.414 0L8 7.586l2.293-2.293a1 1 0 0 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z"
                                fill="currentColor"
                            ></path>
                            </svg>
                        </div>
                        </label>
                        <div class="comment-section">
                        <p><strong>Chapter 1</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 2</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 3</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 4</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        <p><strong>Chapter 5</strong></p>
                        <textarea placeholder="Type Something here...." required></textarea>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <input type="radio" id="section4" name="accordion" />
                        <label for="section4" class="accordion-header">
                        <label class="accordion-title">Versions</label>
                        <div class="accordion-icon">
                            <svg
                            viewBox="0 0 16 16"
                            fill="none"
                            height="16"
                            width="16"
                            xmlns="http://www.w3.org/2000/svg"
                            >
                            <path
                                d="M4.293 5.293a1 1 0 0 1 1.414 0L8 7.586l2.293-2.293a1 1 0 0 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414z"
                                fill="currentColor"
                            ></path>
                            </svg>
                        </div>
                        </label>
                        <div class="comment-section">
                        <table class="table table-striped table-hover mb-4" style="width: 98%; margin: 0 auto;">
                            <tr>
                                <th scope="col">File Name</th>
                                <th scope="col">Date Uploaded</th>
                            </tr>

                            <?php if ($documents): ?>
                                <?php foreach ($documents as $row): ?>
                                    <tr>
                                        
                                        <td><?= htmlspecialchars($row['file_name']) ?></td>
                                        <td><?= $row['uploaded_at'] ?></td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align:center;">No documents found.</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                        <?php
                        exit();
                        ?>
                        </div>
                    </div>
                </div>
            
                
            </form>

            

            </div>
        </div>

        
    </div>
</div>
</body>
</html>

