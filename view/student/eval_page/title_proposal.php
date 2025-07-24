<?php
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchUserController.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/fetchDocumentsController.php';
require $_SERVER['DOCUMENT_ROOT'] . './controllers/viewFileController.php';
require $_SERVER['DOCUMENT_ROOT'] . './actions/verify-users.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/view-pdf.css">
    <title>STUDENT | TITLE PROPOSAL</title>
</head>
<body>
    
<div class="navbar" id="navbar">
    <div class="logo">
        <img src="../../assets/img/kld-logo.png" alt="" class="kld-logo">
        <b><h4 style="font-weight: 600;">IMACS STUDENT / Title Proposal</h4></b>
    </div>
    <div class="nav-links">
      <a href="/student-home" class="nav-link">Home</a>
      <a href="/student-upload" class="nav-link">Upload</a>
      <a href="/student-documents" class="nav-link">Documents</a>
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
        
            <div div class="comment">
                <h2>Rationale</h2>
                    <center><h4>Comments, Suggestions, and Revisions</h4></center>
                    <p>Click on the buttons to open the collapsible content.</p>

                <div class="acc-maincon">
                <button class="accordion">TITLE</button>
                    <div class="panel">
                        <div class="comment-section">
                            <div>       
                            <p><strong>COMMENTS</strong></p>
                            <textarea placeholder="Type Something here...." required></textarea>
                            <p></p>
                            </div> 

                            <div>       
                            <p><strong>SUGGESTIONS</strong></p>
                            <textarea placeholder="Type Something here...." required></textarea>
                            <p></p>
                            </div> 

                            <div>       
                            <p><strong>REVISIONS</strong></p>
                            <textarea placeholder="Type Something here...." required></textarea>
                            <p></p>
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="acc-maincon">
                <button class="accordion">VERSION</button>
                    <div class="panel">
                        <div class="comment-section">
                            <div>       
                            <p><strong>COMMENTS</strong></p>
                            <textarea placeholder="Type Something here...." required></textarea>
                            <p></p>
                            </div> 

                            <div>       
                            <p><strong>SUGGESTIONS</strong></p>
                            <textarea placeholder="Type Something here...." required></textarea>
                            <p></p>
                            </div> 

                            <div>       
                            <p><strong>REVISIONS</strong></p>
                            <textarea placeholder="Type Something here...." required></textarea>
                            <p></p>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>

                
                
            </div>
        </div>
<script>
    var acc1 = document.getElementsByClassName("accordion");
    var acc2 = document.getElementsByClassName("accordion2");
    var i, j;

    // Loop for first accordion group
    for (i = 0; i < acc1.length; i++) {
        acc1[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }

    // Loop for second accordion group
    for (j = 0; j < acc2.length; j++) {
        acc2[j].addEventListener("click", function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
</script>
        
    </div>
</div>
</body>
</html>

