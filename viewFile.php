<?php include_once 'controller/handler/session.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>File Repository</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link
        href="assets/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
        rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- DataTables Bootstrap Integration CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />



    <!--New Css Added-->
    <style>
        /* Make the body scrollable */
        body {
            overflow-y: auto;
            /* Enables vertical scrolling if content overflows */
            height: 100vh;
            /* Ensures the body takes up full height */
        }

        /* Table Styles */
        table.foldertable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Table Header */
        table.foldertable thead {
            white-space: nowrap;
            /* Prevent text wrapping in header */
            color: #333;
            /* Darker text color */
        }

        /* Remove Striped Rows (No Background for Rows) */
        table.foldertable tbody tr {
            background-color: transparent;
            /* No background for rows */
        }

        /* Table Content Styling */
        table.foldertable .item-name {
            font-size: 12px;
            /* Smaller font for table content */
            font-weight: bold;
            /* Making name bold */
            margin-left: 8px;
            vertical-align: middle;
        }

        /* Icon Styling - Remix Icons */
        .folder-icon,
        .file-icon {
            color: #6c757d;
            /* Bootstrap secondary color */
            font-size: 14px;
            /* Slightly smaller icon size */
        }

        /* Style for the First Column */
        table.foldertable td:first-child {
            font-weight: bold;
            width: 50%;
            /* Allocate 50% of table width to the first column */
            word-wrap: break-word;
            /* Handle long text gracefully */
        }

        /* Style for the Second Column */
        table.foldertable td:nth-child(2) {
            width: 5%;
            /* Allocate 30% of table width to the second column */
            text-align: center;
            /* Center align the text */
        }

        /* Style for Other Columns */
        table.foldertable td:nth-child(3) {
            width: 25%;
            word-wrap: nowrap;
            /* Handle long text gracefully */
        }

        /* Style for Other Columns */
        table.foldertable td:nth-child(4) {
            width: 25%;
            word-wrap: nowrap;
            /* Handle long text gracefully */
        }

        /* Responsive Enhancements */
        @media (max-width: 768px) {

            table.foldertable td,
            table.foldertable th {
                font-size: 12px;
                /* Smaller font for smaller screens */
            }
        }



        /* DropDown Style*/
        /* Style for the dropdown */
        #relatedProposalDropdown {
            max-height: 200px;
            /* Set a max height for scrollable content */
            overflow-y: auto;
            /* Enable vertical scrolling if needed */
            border: 1px solid #ddd;
            /* Border around the dropdown */
            border-radius: 4px;
            background-color: #fff;
            padding: 0;
            margin: 0;
            list-style-type: none;
            position: absolute;
            /* Absolute positioning for dropdown */
            z-index: 1000;
            display: none;
            /* Initially hidden */
        }

        /* Style for each dropdown item */
        #relatedProposalDropdown li {
            padding: 10px 15px;
            /* Spacing inside the item */
            cursor: pointer;
            /* Pointer cursor for interactivity */
            transition: background-color 0.2s ease-in-out;
        }

        #relatedProposalDropdown li.highlight {
            background-color: #e0f7fa;
            /* Light blue highlight */
        }

        /* Highlighted item on hover */
        #relatedProposalDropdown li:hover {
            background-color: #e0f7fa;
            /* Light blue highlight */
        }

        /* Highlighted item on focus (keyboard navigation) */
        #relatedProposalDropdown li:focus {
            background-color: #e0f7fa;
            /* Same light blue highlight */
            outline: none;
        }

        /* Dropdown visibility */
        #relatedProposalDropdown.show {
            display: block;
            /* Show dropdown when active */
        }

        .pill-btn {
            border-radius: 50rem;
            /* Make the button pill-shaped */
            margin-right: 10px;
            /* Add space to the right of the button */
            height: 15px;
            /* Set a small but appropriate height */
            width: 15px;
            /* Set a small but appropriate width */
            padding: 0;
            /* Remove padding to control the size more precisely */
            text-align: center;
            /* Horizontally center the icon */
            line-height: 10px;
            /* Vertically center the icon by matching line-height to the button height */
            border: 2px solid white;
            /* Create a small white region between the button and the shadow */
            box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.2);
            /* Apply shadow with a slight blur */
        }

        .pill-btn i {
            font-size: 10px;
            /* Adjust icon size to fit in the 15px button */
            vertical-align: middle;
            /* Ensure the icon is vertically aligned in the middle */
            font-weight: bold;
        }

        .small-preview {
            font-size: 0.75rem;
            /* Smaller font size */
            line-height: 1.2;
            /* Adjust line height for compactness */
            color: var(--bs-secondary);
            /* Use Bootstrap secondary color */
        }

        .small-preview h6 {
            font-size: 0.85rem;
            /* Slightly larger for the heading */
            margin-bottom: 0.5rem;
            /* Reduce space below heading */
        }

        .small-preview p {
            margin-bottom: 0.3rem;
            /* Compact spacing between lines */
        }

        .small-preview p span {
            font-weight: normal;
            /* Make the details (span) less bold */
        }

        /* Styling for each paragraph with a line */
        p.text-muted {
            border-bottom: 1px solid #ddd;
            /* Light gray line */
            padding-bottom: 5px;
            /* Optional space below text */
            margin-bottom: 5px;
            /* Optional space between paragraphs */
        }

        /* Hover effect for the buttons */
        .view-files:hover i,
        .edit-folder:hover i,
        .delete-folder:hover i {
            color: #495057;
            /* Change to Bootstrap's primary gray */
            transform: scale(1.1);
            /* Slightly enlarge the icon */
            transition: all 0.3s ease;
            /* Smooth transition for hover effect */
        }

        /* Optional: you can adjust the color for text hover as well */
        .view-files,
        .edit-folder,
        .delete-folder {
            text-decoration: none;
            /* Remove underline on hover */
        }

        /* Transparent modal overlay */
        #dropzoneModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparent black overlay */
            backdrop-filter: blur(10px);
            /* Blurs the background */
            z-index: 1050;
        }

        /* Modal content styling */
        #dropzoneModal .modal-content {
            background: rgba(255, 255, 255, 0.85);
            /* Semi-transparent white */
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-out;
        }

        /* Button styling */
        #dropzoneModal button {
            margin-top: 20px;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .table-dropzone {
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out;
            border: 2px dashed transparent;
            /* Dashed border, initially invisible */
        }

        .table-dropzone.dragover {
            border-color: #007bff;
            /* Show dashed border when dragging files */
            background-color: rgba(255, 255, 255, 0.6);
        }

        .table-dropzone::before,
        .table-dropzone::after {
            content: "";
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1rem;
            color: #007bff;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }

        .table-dropzone::before {
            top: 40%;
        }

        .table-dropzone::after {
            top: 60%;
        }

        .table-dropzone.dragover::before,
        .table-dropzone.dragover::after {
            opacity: 1;
        }

        .table-dropzone.dragover::after {
            content: "Drop the files here";
            /* Display the message */
            font-size: 1.5rem;
            top: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            color: #007bff;
        }

        .table-dropzone-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            z-index: 10;
        }

        .table-dropzone.dragover .table-dropzone-overlay {
            display: block;
        }

        .main-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 11;
        }

        /* Container for breakdown rows */
        .breakdown-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Each row inside the breakdown */
        .breakdown-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            /* Gray line */
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        /* Remove border-bottom for the last row */
        .breakdown-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        /* Text styling for breakdown labels */
        .breakdown-label {
            font-size: 0.85rem;
            font-weight: bold;
            color: #555;
            margin: 0;
        }

        /* Optional: Span styling for values */
        .breakdown-label span {
            font-weight: normal;
            color: #333;
        }

        /* Buttons Row Styling */
        .btn.edit-folder,
        .btn.delete-folder,
        .btn.authorize-access {
            font-size: 1.2rem;
            color: #6c757d;
            /* Default button color */
            padding: 0;
            background: none;
            /* Ensure no background is applied */
            border: none;
            /* Remove default button border */
            cursor: pointer;
            /* Show pointer cursor on hover */
        }

        .btn.edit-folder:hover,
        .btn.delete-folder:hover,
        .btn.authorize-access:hover {
            color: #495057;
            /* Darker color on hover */
            text-decoration: none;
            /* Prevent link underline */
        }

        /* Icon Size */
        .fs-4 {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <?php include_once 'layouts/navbar.php' ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Folder List</h1>

        </div>
        <!-- End Page Title -->

        <!-- File -->
        <section class="section dashboard">

            <!-- Data Table -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <!-- Hidden file input to trigger the file dialog -->
                            <input type="file" id="fileInput" style="display: none;" />
                            <!-- Flex container for breadcrumb and buttons -->
                            <div class="d-flex align-items-center" style="margin-bottom: 20px;">
                                <!-- Breadcrumb with margin -->
                                <div class="folderpath flex-grow-1" style="margin-top: 10px; margin-bottom: 10px;">
                                    <nav>
                                        <ol class="breadcrumb" style="margin-top: 0;">
                                            <!-- Folder name(s) dynamically inserted here -->
                                        </ol>
                                    </nav>
                                </div>
                                <!-- Buttons Container with custom spacing -->
                                <button
                                    class="btn btn-primary btn-sm rounded-pill me-2"
                                    style="margin-top: 10px;"
                                    title="Go Back"
                                    onclick="goBack()">
                                    <i class="ri-arrow-left-line"></i>
                                </button>

                            </div>

                            <div id="tableDropzone" class="table-dropzone">
                                <div class="table-dropzone-overlay">
                                    <div class="main-text">Drop the files here</div>
                                </div>
                                <table id="folderTable" class="foldertable table table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>No. of files</th>
                                            <th>Created By</th>
                                            <th>Date Uploaded</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Data Table -->

        <!-- Modal -->
        <div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="folderModalLabel">Create New Folder</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="folderForm">
                            <div class="mb-3">
                                <label for="folderName" class="form-label">Folder Name</label>
                                <input type="text" class="form-control" id="folderName" name="folderName" placeholder="Enter folder name" required>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="relatedProposalSearch" class="form-label">Related Proposal</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="relatedProposalSearch"
                                    placeholder="Search proposals..."
                                    autocomplete="off" />
                                <ul class="dropdown-menu w-100" id="relatedProposalDropdown"></ul>
                            </div>
                            <div id="proposalPreview" class="mt-3 small-preview text-secondary d-none">
                                <h6>Preview</h6>
                                <p><strong>Company/Agency Name:</strong> <span id="previewCustName"></span></p>
                                <p><strong>Scope:</strong> <span id="previewScope"></span></p>
                                <p><strong>Tender Proposal:</strong> <span id="previewTender"></span></p>
                                <p><strong>Solution:</strong> <span id="previewSolutions"></span></p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="folderForm" class="btn btn-primary rounded-pill" id="submitButton">Create Folder</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for PDF Preview -->
        <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filePreviewModalLabel">File Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Container for PDF preview -->
                        <div id="pdf-viewer" style="text-align: center;">
                            <canvas id="pdf-canvas" style="width: 100%; height: auto;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Apiz</span></strong>. All Rights Reserved
        </div>
        <div class="credits">Designed by <a href="#">Alif</a></div>
    </footer>
    <!-- End Footer -->

    <a
        href="#"
        class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Bootstrap Integration JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- tooltips Toggle -->
    <script>
        let isFolderView = true;
        let currentFolderID = null;
        let currentfolderName = '';
        let breadcrumb = [];

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

        function fetchFolders() {
            $.ajax({
                url: 'controller/fetchFolders.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateTable(response.data);
                    } else {
                        alert(response.message || 'No folders found');
                    }
                }
            });
        }

        function populateTable(folders) {
            const table = $('#folderTable').DataTable();
            table.clear();

            folders.forEach(function(folder) {
                const rowNode = table.row.add([
                    `<button class="btn btn-primary btn-sm toggle-breakdown pill-btn">
                    <i class="ri-add-fill"></i>
                </button>
                <i class="ri-folder-open-fill folder-icon"></i> ${folder.folderName}`,
                    folder.fileCount || '0',
                    folder.CreatedBy || 'N/A',
                    folder.DateCreated || 'N/A',
                    `<button class="btn btn-link btn-sm text-secondary view-files" onclick="openFolder('${folder.folderID}', '${folder.folderName}')">
                    <i class="ri-eye-line" style="font-size: 1.2rem;"></i>
                </button>`
                ]).node();

                $(rowNode).data('folderDetails', folder);
                $(rowNode).data('folderID', folder.folderID);

                $(rowNode).dblclick(function() {
                    openFolder(folder.folderID, folder.folderName);
                });
            });

            table.draw();
            updateBreadcrumb();
        }

        function updateBreadcrumb() {
            const breadcrumbContainer = $('.breadcrumb');
            breadcrumbContainer.empty();

            breadcrumb.forEach((item, index) => {
                if (index === breadcrumb.length - 1) {
                    breadcrumbContainer.append(`<li class="breadcrumb-item active">${item.name}</li>`);
                } else {
                    breadcrumbContainer.append(`<li class="breadcrumb-item"><a href="#" onclick="navigateToFolder(${index})">${item.name}</a></li>`);
                }
            });
        }

        $(document).ready(function() {
            $('#folderTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }]
            });

            fetchFolders();
        });

        function openFolder(folderID, folderName) {
            currentFolderID = folderID;
            currentfolderName = folderName;

            // Avoid adding the Home breadcrumb
            if (!breadcrumb.length || breadcrumb[breadcrumb.length - 1].id !== folderID) {
                breadcrumb.push({
                    name: folderName,
                    id: folderID
                });
            }

            $.ajax({
                url: 'controller/fetchFolderContents.php',
                method: 'GET',
                data: {
                    folderID: folderID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateFolderContents(response.data.folders, response.data.files);
                    } else {
                        alert(response.message || 'Failed to load folder contents.');
                        displayNoFilesMessage();
                    }
                },
                error: function() {
                    alert('Error fetching folder contents.');
                }
            });

            updateBreadcrumb();
        }

        function populateFolderContents(folders, files) {
            const table = $('#folderTable').DataTable();
            table.clear();

            folders.forEach(function(folder) {
                const rowNode = table.row.add([
                    `<button class="btn btn-primary btn-sm toggle-breakdown pill-btn">
                    <i class="ri-add-fill"></i>
                </button>
                <i class="ri-folder-open-fill folder-icon"></i> ${folder.folderName}`,
                    `${folder.itemCount || 0}`,
                    folder.CreatedBy || 'N/A',
                    folder.DateCreated || 'N/A',
                    `<button class="btn btn-link btn-sm text-secondary view-files" onclick="openFolder('${folder.folderID}', '${folder.folderName}')">
                    <i class="ri-eye-line" style="font-size: 1.2rem;"></i>
                </button>`
                ]).node();

                $(rowNode).data('folderDetails', folder);
                $(rowNode).data('folderID', folder.folderID);

                $(rowNode).dblclick(function() {
                    openFolder(folder.folderID, folder.folderName);
                });
            });

            files.forEach(function(file) {
                const rowNode = table.row.add([
                    `<i class="ri-file-text-line file-icon"></i> ${file.fileName}`,
                    '',
                    file.uploadedBy || 'N/A',
                    file.dateUploaded || 'N/A',
                    ''
                ]).node();

                $(rowNode).data('FileID', file.FileID);

                $(rowNode).click(function() {
                    previewPDF(file.FileID);
                });
            });

            table.draw();
            updateBreadcrumb();
        }

        function previewPDF(fileID) {
            $.ajax({
                url: 'controller/filepreview.php',
                method: 'POST',
                data: {
                    fileID: fileID
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        const fileUrl = data.fileUrl;
                        const fileType = data.fileType;

                        if (fileType === 'application/pdf') {
                            const viewerUrl = `pdfviewer/web/viewer.html?file=${encodeURIComponent(fileUrl)}`;
                            window.open(viewerUrl, '_blank');
                        } else if (fileType.startsWith('image/')) {
                            window.open(fileUrl, '_blank');
                        } else if (
                            fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                            fileType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation' ||
                            fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        ) {
                            const userResponse = confirm(
                                "This document cannot be viewed in the browser. Would you like to download it?"
                            );
                            if (userResponse) {
                                window.location.href = fileUrl;
                            }
                        } else {
                            window.open(fileUrl, '_blank');
                        }
                    } else {
                        alert('Error loading file preview.');
                    }
                },
                error: function() {
                    alert('An error occurred while loading the preview.');
                }
            });
        }

        function displayNoFilesMessage() {
            const table = $('#folderTable').DataTable();
            table.clear();

            table.row.add([
                'No files in this folder',
                '',
                '',
                ''
            ]).node();

            table.draw();
        }

        function goHome() {
            breadcrumb = [{
                name: 'Home',
                id: null
            }];
            isFolderView = true;
            fetchFolders();
            updateBreadcrumb();
            currentFolderID = null;
        }

        function navigateToFolder(index) {
            const targetFolder = breadcrumb[index];
            breadcrumb = breadcrumb.slice(0, index + 1);

            if (targetFolder.id === null) {
                goHome();
            } else {
                openFolder(targetFolder.id, targetFolder.name);
            }
        }

        $(document).ready(function() {
            const table = $('#folderTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                "bDestroy": true
            });

            // Add toggle breakdown functionality (only the button click works)
            $('#folderTable tbody').on('click', '.toggle-breakdown', function() {
                const tr = $(this).closest('tr');
                const row = table.row(tr);
                const button = $(this);
                const folderDetails = $(tr).data('folderDetails'); // Retrieve stored data

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    button.removeClass('btn-danger').addClass('btn-primary');
                    button.find('i').removeClass('ri-close-fill').addClass('ri-add-fill');
                } else {
                    row.child(formatBreakdown(folderDetails)).show();
                    tr.addClass('shown');
                    button.removeClass('btn-primary').addClass('btn-danger');
                    button.find('i').removeClass('ri-add-fill').addClass('ri-close-fill');
                }
            });

            function formatBreakdown(data) {
                let breakdownDetails;

                if (!data.BidID) {
                    breakdownDetails = `
                <div class="breakdown-row">
                    <p class="breakdown-label">Standalone Folder</p>
                </div>`;
                } else {
                    breakdownDetails = `
                <div class="breakdown-row">
                    <p class="breakdown-label">Agency Name: <span>${data.CustName || 'N/A'}</span></p>
                </div>
                <div class="breakdown-row">
                    <p class="breakdown-label">Scope: <span>${data.HMS_Scope || 'N/A'}</span></p>
                </div>
                <div class="breakdown-row">
                    <p class="breakdown-label">Tender Proposal: <span>${data.Tender_Proposal || 'N/A'}</span></p>
                </div>`;
                }

                breakdownDetails += `
            <div class="breakdown-row">
                <p class="breakdown-label">Last Updated At: <span>${data.datelastupdate || 'N/A'}</span></p>
            </div>`;

                return `
            <div class="breakdown-container p-3">
                ${breakdownDetails}
            </div>
        `;
            }


            fetchFolders(); // Fetch folder data when the page loads
        });

        window.onload = function() {
            // Check sessionStorage for folder data and call openFolder if available
            const sessionFolderID = sessionStorage.getItem('sessionfolderID');
            const sessionFolderName = sessionStorage.getItem('sessionfolderName');

            if (sessionFolderID && sessionFolderName) {
                // Automatically open the folder if the data exists in sessionStorage
                openFolder(sessionFolderID, sessionFolderName);
            }
        };
    </script>

    <script>
        // JavaScript function to go back in the browser history
        function goBack() {
            window.history.back();
        }
    </script>

</body>

</html>