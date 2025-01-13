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
                                    class="btn btn-success btn-sm rounded-pill me-2"
                                    style="margin-top: 10px;"
                                    title="Create new folder"
                                    data-bs-target="#folderModal"
                                    data-bs-toggle="modal">
                                    <i class="ri-folder-add-fill"></i>
                                </button>

                                <!-- Button that triggers file selection (only visible based on conditions) -->
                                <button
                                    id="addFileBtn"
                                    class="btn btn-primary btn-sm rounded-pill"
                                    style="margin-top: 10px; display: none;"
                                    title="Upload File"
                                    onclick="triggerFileInput()">
                                    <i class="ri-file-add-fill"></i>
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
        // Global variable to track if we are in "folder view" or "file view"
        let isFolderView = true;
        let currentFolderID = null; // Store the currently selected folder ID
        let currentfolderName = '';
        let tmpfolderid = null;
        let tmpfolderName = '';
        let breadcrumb = []; // Start breadcrumb with Home
        const loggedInUserID = <?php echo json_encode($_SESSION['user_id']); ?>;

        // Specify the worker path
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';


        // Define fetchFolders function in the global scope, outside of $(document).ready()
        function fetchFolders() {
            $.ajax({
                url: 'controller/fetchFolders.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateTable(response.data); // Call populateTable on success
                    } else {
                        alert(response.message || 'No folders found');
                    }
                }
            });
        }

        function populateTable(folders) {
            const table = $('#folderTable').DataTable();
            table.clear(); // Clear existing data

            folders.forEach(function(folder) {
                const rowNode = table.row.add([
                    `<button class="btn btn-primary btn-sm toggle-breakdown pill-btn">
                <i class="ri-add-fill"></i>
            </button>
            <i class="ri-folder-open-fill folder-icon"></i> ${folder.folderName}`,
                    folder.fileCount || '0', // Display file count
                    folder.CreatedBy || 'N/A',
                    folder.DateCreated || 'N/A',
                    `<button class="btn btn-link btn-sm text-secondary view-files" onclick="openFolder('${folder.folderID}', '${folder.folderName}')">
                <i class="ri-eye-line" style="font-size: 1.2rem;"></i>
            </button>`
                ]).node();

                $(rowNode).data('folderDetails', folder); // Store folder details in the row
                $(rowNode).data('folderID', folder.folderID); // Store folderID in the row

                // Attach double-click event to open folder content
                $(rowNode).dblclick(function() {
                    const folderID = $(this).data('folderID');
                    const folderName = folder.folderName;

                    // Add the folder name to the breadcrumb before opening the folder
                    breadcrumb.push(folderName);

                    // Open the folder
                    openFolder(folderID, folderName);
                });
            });

            table.draw(); // Redraw the table after adding new rows
            updateBreadcrumb(); // Update breadcrumb
        }

        function updateBreadcrumb() {
            const breadcrumbContainer = $('.breadcrumb');
            breadcrumbContainer.empty(); // Clear current breadcrumb

            let uniqueBreadcrumb = Array.from(new Set(breadcrumb.map(item => item.folderName))); // Get unique folder names

            breadcrumbContainer.append('<li class="breadcrumb-item"><a href="#" onclick="goHome()">Home</a></li>');

            uniqueBreadcrumb.forEach((folderName, index) => {
                if (folderName) { // Only render folderName if it's valid
                    breadcrumbContainer.append(`
                <li class="breadcrumb-item ${index === uniqueBreadcrumb.length - 1 ? 'active' : ''}">
                    <a href="#" onclick="navigateToFolder(${index})">${folderName}</a>
                </li>
            `);
                }
            });
        }

        function navigateToFolder(index) {
            // Update breadcrumb to the selected folder index
            breadcrumb = breadcrumb.slice(0, index + 1); // Slice breadcrumb up to the selected index
            updateBreadcrumb(); // Update breadcrumb UI

            // Get the selected folder information from breadcrumb
            const selectedFolder = breadcrumb[index];

            // Use the folderID from breadcrumb to navigate
            openFolder(selectedFolder.folderID, selectedFolder.folderName);
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
                }]
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

                let buttonsRow = `
            <div class="breakdown-row d-flex justify-content-start">
                <button 
                    class="btn btn-link btn-sm text-secondary edit-folder me-2" 
                    onclick="editFolder('${data.folderID}')"
                >
                    <i class="ri-edit-fill fs-4"></i>
                </button>
                <button 
                    class="btn btn-link btn-sm text-secondary delete-folder me-2" 
                    onclick="deleteFolder('${data.folderID}')"
                >
                    <i class="ri-delete-bin-fill fs-4"></i>
                </button>`;

                // Check if the logged-in user is the folder's creator
                if (parseInt(loggedInUserID) === parseInt(data.staffID)) {
                    buttonsRow += `
                <button 
                    class="btn btn-link btn-sm text-primary authorize-access me-2" 
                    onclick="authorizeAccess('${data.folderID}')"
                >
                    <i class="ri-key-fill fs-4"></i>
                </button>`;
                }

                buttonsRow += `</div>`;

                return `
            <div class="breakdown-container p-3">
                ${breakdownDetails}
                ${buttonsRow}
            </div>
        `;
            }


            fetchFolders(); // Fetch folder data when the page loads

            // Dropzone initialization
            Dropzone.autoDiscover = false;

            const tableDropzone = new Dropzone("#tableDropzone", {
                url: 'controller/uploadFile.php',
                paramName: "file",
                maxFilesize: 5,
                clickable: false,
                addRemoveLinks: true,
                previewsContainer: false,
                acceptedFiles: ".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx",
                autoProcessQueue: true,
                init: function() {
                    const myDropzone = this;

                    this.on("sending", function(file, xhr, formData) {
                        const folderID = currentFolderID || 0;
                        formData.append("folderID", folderID);
                    });

                    this.on("dragenter", function(event) {
                        event.stopPropagation();
                        $("#tableDropzone").addClass("dragover");
                    });

                    this.on("dragleave", function(event) {
                        if (!event.relatedTarget || !event.relatedTarget.closest("#tableDropzone")) {
                            $("#tableDropzone").removeClass("dragover");
                        }
                    });

                    this.on("drop", function() {
                        $("#tableDropzone").removeClass("dragover");
                    });

                    this.on("success", function(file, response) {
                        response = JSON.parse(response);
                        if (response.success) {
                            alert('Your files have been successfully uploaded.');
                            myDropzone.removeFile(file);
                            openFolder(currentFolderID, currentfolderName);
                        } else {
                            alert('Upload failed: ' + response.message);
                            myDropzone.removeFile(file);
                        }
                    });

                    this.on("error", function(file, errorMessage) {
                        alert('Upload error: ' + errorMessage);
                        this.removeFile(file);
                    });
                }
            });

        });

        // Function to control Add File button visibility
        function toggleAddFileButton(show) {
            const addFileBtn = document.getElementById('addFileBtn');
            addFileBtn.style.display = show ? 'inline-block' : 'none';
        }

        function openFolder(folderID, folderName) {
            currentFolderID = folderID; // Update current folder ID
            currentfolderName = folderName;

            // Push both folder name and ID into breadcrumb (internal storage)
            if (breadcrumb[breadcrumb.length - 1]?.folderName !== folderName) {
                breadcrumb.push({
                    folderID: folderID,
                    folderName: folderName
                }); // Store only folderID and folderName
            }

            $.ajax({
                url: 'controller/fetchFolderContents.php',
                method: 'GET',
                data: {
                    folderID: folderID
                }, // Always send the correct folderID here
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateFolderContents(response.data.folders, response.data.files); // Pass both folders and files
                        toggleAddFileButton(true); // Show the "Add File" button
                    } else {
                        alert(response.message || 'Failed to load folder contents.');
                        displayNoFilesMessage(); // Show "No files" message
                    }
                },
                error: function() {
                    alert('Error fetching folder contents.');
                }
            });

            updateBreadcrumb(); // Ensure breadcrumb is updated after navigating
        }

        function populateFolderContents(folders, files) {
            const table = $('#folderTable').DataTable();
            table.clear(); // Clear the table

            // Add subfolders to the table
            folders.forEach(function(folder) {
                const rowNode = table.row.add([
                    `<button class="btn btn-primary btn-sm toggle-breakdown pill-btn">
                <i class="ri-add-fill"></i>
            </button>
            <i class="ri-folder-open-fill folder-icon"></i> ${folder.folderName}`,
                    `${folder.itemCount || 0}`, // Total count
                    folder.CreatedBy || 'N/A',
                    folder.DateCreated || 'N/A',
                    `<button class="btn btn-link btn-sm text-secondary view-files" onclick="openFolder('${folder.folderID}', '${folder.folderName}')">
                <i class="ri-eye-line" style="font-size: 1.2rem;"></i>
            </button>`
                ]).node();

                $(rowNode).data('folderDetails', folder); // Store folder details in the row
                $(rowNode).data('folderID', folder.folderID); // Store folderID in the row

                // Double-click to view folder contents
                $(rowNode).dblclick(function() {
                    const folderID = $(this).data('folderID');
                    const folderName = folder.folderName;
                    openFolder(folderID, folderName); // Open the selected folder
                });
            });

            // Add files to the table
            files.forEach(function(file) {
                const rowNode = table.row.add([
                    `<i class="ri-file-text-line file-icon"></i> ${file.fileName}`, // File icon added here
                    '', // Placeholder for the file count
                    file.uploadedBy || 'N/A',
                    file.dateUploaded || 'N/A',
                    // Add Delete button with ri-delete-bin-fill icon
                    `<button class="btn btn-link btn-sm text-danger delete-file" onclick="deleteFile('${file.FileID}')">
                        <i class="ri-delete-bin-fill" style="font-size: 1.2rem;"></i>
                    </button>`
                ]).node();

                // Store fileID in the row
                $(rowNode).data('FileID', file.FileID);

                // Add click event to trigger preview
                $(rowNode).click(function() {
                    const fileID = $(this).data('FileID'); // Retrieve fileID from the row
                    previewPDF(fileID); // Pass fileID to previewPDF function
                });
            });

            table.draw(); // Redraw the table after adding new rows
            updateBreadcrumb(); // Update breadcrumb display
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
                            // Alert for unsupported file types
                            const userResponse = confirm(
                                "This document cannot be viewed in the browser. Would you like to download it?"
                            );
                            if (userResponse) {
                                window.location.href = fileUrl; // Trigger file download
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


        // Function to display a "No files in this folder" message in the table
        function displayNoFilesMessage() {
            const table = $('#folderTable').DataTable();
            table.clear(); // Clear the current table content

            // Add a message indicating no files in the folder
            table.row.add([
                'No files in this folder', // Placeholder for file name
                '', // Empty for uploaded by
                '' // Empty for date uploaded
            ]).node();

            table.draw(); // Redraw the table after adding the message
        }

        function viewFiles(folderID, folderName) {
            currentFolderID = folderID; // Set current folder ID
            isFolderView = false; // Switch to file view
            openFolder(folderID, folderName);
            breadcrumb.push(folderName); // Update breadcrumb
        }

        // Go back to Home (reset breadcrumb)
        function goHome() {
            breadcrumb = []; // Reset breadcrumb to just 'Home'
            isFolderView = true; // Ensure we are in folder view
            fetchFolders(); // Fetch the top-level folders
            updateBreadcrumb(); // Update breadcrumb UI

            // Hide the "Add New File" button when going to Home
            toggleAddFileButton(false); // Hide the button
            currentFolderID = ''; // Reset the folder ID
        }
        // Toggle view between folder and file view
        function toggleView() {
            if (isFolderView) {
                fetchFolders(); // Fetch folders again
            } else {
                openFolder(currentFolderID, breadcrumb[breadcrumb.length - 1]); // Open the current folder's files again
            }
        }

        // Reference to the hidden file input and the button
        const fileInput = document.getElementById('fileInput');
        const addFileBtn = document.getElementById('addFileBtn');

        // Show or hide the "Add File" button based on folder state
        function toggleAddFileButton(show) {
            addFileBtn.style.display = show ? 'inline-block' : 'none';
        }

        // Trigger file input dialog when the "Add File" button is clicked
        function triggerFileInput() {
            fileInput.click(); // This simulates clicking on the hidden file input
        }

        // Listen for file selection
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0]; // Get the selected file
            if (file) {
                uploadFile(file); // Proceed with the file upload
            }
        });

        // Function to upload the selected file with currentFolderID
        function uploadFile(file) {
            const formData = new FormData();
            formData.append('file', file); // Append the file
            formData.append('folderID', currentFolderID); // Append the current folder ID

            // Perform the AJAX request to upload the file
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'controller/uploadFile.php', true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('File uploaded successfully!');
                        openFolder(currentFolderID, currentfolderName);
                    } else {
                        alert('Error uploading file: ' + response.message);
                    }
                }
            };

            xhr.send(formData); // Send the FormData containing the file and folder ID
        }

        let selectedBidID = ''; // Global variable to store the selected BidID
        const searchInput = document.getElementById('relatedProposalSearch');
        const dropdown = document.getElementById('relatedProposalDropdown');
        const folderModal = document.getElementById('folderModal');
        const previewSection = document.getElementById('proposalPreview');

        // --- Tooltip Initialization ---
        document.querySelectorAll('[title]').forEach(function(el) {
            new bootstrap.Tooltip(el);
        });

        // --- Modal Show/Hide Logic ---
        folderModal.addEventListener('show.bs.modal', function() {
            if (folderModal.getAttribute('data-folder-id')) {
                searchInput.setAttribute('disabled', 'disabled');
                searchInput.placeholder = 'Search disabled due to folder selection';
                previewSection.classList.add('d-none');
                dropdown.classList.remove('show');
            } else {
                searchInput.removeAttribute('disabled');
                searchInput.placeholder = 'Search proposals...';
            }
        });

        folderModal.addEventListener('hide.bs.modal', function() {
            searchInput.value = '';
            dropdown.innerHTML = '';
            dropdown.classList.remove('show');
            previewSection.classList.add('d-none');
            folderModal.removeAttribute('data-folder-id'); // Clear folder ID
        });

        document.getElementById('folderForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const folderID = folderModal.getAttribute('data-folder-id');
            const folderName = document.getElementById('folderName').value.trim();
            const linkedBidID = selectedBidID || null; // Allow null for standalone folders

            // Validate folder name only
            if (!folderName) {
                alert("Folder name cannot be empty.");
                return;
            }

            const isEditMode = folderID && folderID !== '';
            const url = isEditMode ? 'controller/updateFolder' : 'controller/createFolder';
            const params = new URLSearchParams({
                folderID: folderID || '',
                folderName: folderName,
                linkedBidID: linkedBidID || '', // Will be null for standalone folders
                parentID: currentFolderID || '', // Use currentFolderID or root
            }).toString();

            const xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert(isEditMode ? 'Folder updated successfully!' : 'Folder created successfully!');

                            // Check currentFolderID and call appropriate function
                            if (!currentFolderID || currentFolderID === '') {
                                fetchFolders(); // Reload root folder list
                            } else {
                                openFolder(currentFolderID); // Reload current folder
                            }

                            // Close the modal
                            folderModal.style.display = 'none'; // Hide modal (example for CSS modal)
                            folderModal.removeAttribute('data-folder-id'); // Reset modal state

                            // Remove any remaining backdrop (if present)
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.parentNode.removeChild(backdrop);
                            }

                            // Optionally: Reset form fields
                            document.getElementById('folderForm').reset();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    } else {
                        alert("An unexpected error occurred. Please try again.");
                    }
                }
            };
            xhr.send(params);
        });


        folderModal.addEventListener('show.bs.modal', function() {
            if (currentFolderID && currentFolderID !== '') {
                searchInput.setAttribute('disabled', 'disabled'); // Disable the input
                searchInput.placeholder = 'Search disabled due to folder selection'; // Optional placeholder text
                previewSection.classList.add('d-none'); // Hide the preview
                dropdown.classList.remove('show'); // Hide dropdown if visible
            } else {
                searchInput.removeAttribute('disabled'); // Enable the input
                searchInput.placeholder = 'Search proposals...'; // Reset placeholder text
            }
        });

        // Clear the input when the modal is closed
        folderModal.addEventListener('hide.bs.modal', function() {
            searchInput.value = ''; // Clear the input value
            dropdown.innerHTML = ''; // Clear dropdown list
            dropdown.classList.remove('show'); // Hide dropdown
            previewSection.classList.add('d-none'); // Hide preview section
        });

        let currentIndex = -1; // Keeps track of the currently selected (focused) option

        // Show preview when user hovers over the search input
        searchInput.addEventListener('mouseover', function() {
            if (searchInput.value.trim() !== '') {
                previewSection.classList.remove('d-none'); // Show preview if input has value
            }
        });

        // Event listener for search input
        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();

            // Show preview if input is not empty
            if (query.length > 0 && !searchInput.disabled) { // Don't allow searching if input is disabled
                // AJAX request to fetch data
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'controller/fetchproposal', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);

                        // Populate dropdown
                        dropdown.innerHTML = data.map(
                            (proposal) => `<li tabindex="0" data-value="${proposal.BidID}">${proposal.HMS_Scope}</li>`
                        ).join('');
                        dropdown.classList.add('show');
                        currentIndex = -1; // Reset current index when new results are fetched
                    }
                };
                xhr.send(`query=${encodeURIComponent(query)}`);
            } else {
                // Clear dropdown when query is empty or input is disabled
                dropdown.innerHTML = '';
                dropdown.classList.remove('show');
                previewSection.classList.add('d-none'); // Hide preview if input is empty
            }
        });

        // Handle keydown events for navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = dropdown.querySelectorAll('li');

            if (e.key === 'ArrowDown') {
                // Move focus to the next item
                if (currentIndex < items.length - 1) {
                    currentIndex++;
                    focusItem(items[currentIndex]);
                }
            } else if (e.key === 'ArrowUp') {
                // Move focus to the previous item
                if (currentIndex > 0) {
                    currentIndex--;
                    focusItem(items[currentIndex]);
                }
            } else if (e.key === 'Enter') {
                // Select the focused item
                if (currentIndex >= 0) {
                    selectItem(items[currentIndex]);
                }
            }
        });

        // Handle mouse click for selection
        dropdown.addEventListener('click', function(e) {
            if (e.target.tagName === 'LI') {
                selectItem(e.target);
            }
        });

        function focusItem(item) {
            const items = dropdown.querySelectorAll('li');
            items.forEach((i) => i.classList.remove('highlight')); // Remove highlight from all items
            item.classList.add('highlight'); // Add highlight to the current item
        }

        function selectItem(item) {
            selectedBidID = item.getAttribute('data-value'); // Store the BidID globally
            const selectedText = item.textContent;

            // Set input value to selected proposal name
            searchInput.value = selectedText;

            // Hide dropdown
            dropdown.classList.remove('show');

            // Fetch details of the selected proposal using AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'controller/fetchProposalDetails.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);

                    // Populate the preview section with the fetched data
                    document.getElementById('previewCustName').textContent = data.CustName || 'N/A';
                    document.getElementById('previewScope').textContent = data.HMS_Scope || 'N/A';
                    document.getElementById('previewTender').textContent = data.Tender_Proposal || 'N/A';
                    document.getElementById('previewSolutions').textContent = data.Solutions || 'N/A';

                    // Show the preview section
                    previewSection.classList.remove('d-none'); // Show preview if hidden
                }
            };
            xhr.send(`bidID=${encodeURIComponent(selectedBidID)}`);
        }

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && e.target !== searchInput) {
                dropdown.classList.remove('show');
            }
        });

        // Reset selectedBidID if the input is cleared manually
        searchInput.addEventListener('input', function() {
            if (searchInput.value.trim() === '') {
                selectedBidID = ''; // Clear selectedBidID if the search is cleared
                previewSection.classList.add('d-none'); // Hide preview if input is cleared
            }
        });

        function editFolder(folderID) {
            folderModal.setAttribute('data-folder-id', folderID);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'controller/fetchFolderDetails.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);

                    // Populate folder name
                    document.getElementById('folderName').value = data.folderName || '';

                    // Populate related proposal (search input and preview)
                    searchInput.value = data.linkedBidName || ''; // Set proposal name in search input
                    selectedBidID = data.linkedBidID || ''; // Set the proposal ID for internal handling
                    previewSection.classList.toggle('d-none', !data.linkedBidDetails);

                    if (data.linkedBidDetails) {
                        // Populate preview details
                        document.getElementById('previewCustName').textContent = data.linkedBidDetails.CustName || 'N/A';
                        document.getElementById('previewScope').textContent = data.linkedBidDetails.HMS_Scope || 'N/A';
                        document.getElementById('previewTender').textContent = data.linkedBidDetails.Tender_Proposal || 'N/A';
                        document.getElementById('previewSolutions').textContent = data.linkedBidDetails.Solutions || 'N/A';
                    }

                    // Update modal title and submit button
                    const folderModalLabel = document.getElementById('folderModalLabel');
                    const submitButton = document.getElementById('submitButton');
                    if (folderModalLabel) folderModalLabel.textContent = 'Edit Folder';
                    if (submitButton) submitButton.textContent = 'Save Changes';
                }
            };
            xhr.send(`folderID=${encodeURIComponent(folderID)}`);

            // Show modal
            const modal = new bootstrap.Modal(folderModal);
            modal.show();
        }

        folderModal.addEventListener('show.bs.modal', function() {
            const folderID = folderModal.getAttribute('data-folder-id');
            const submitButton = document.getElementById('submitButton');
            const folderModalLabel = document.getElementById('folderModalLabel');
            const folderNameInput = document.getElementById('folderName');

            // If we are opening the modal to create a new folder
            if (!folderID) {
                // Reset for creating a new folder
                if (folderModalLabel) {
                    folderModalLabel.textContent = 'Create New Folder'; // Reset title for new folder
                }

                if (submitButton) {
                    submitButton.textContent = 'Create Folder'; // Reset button text for new folder
                }

                // Clear the folder ID data attribute and form fields
                folderModal.removeAttribute('data-folder-id'); // Ensure folderID is cleared
                folderNameInput.value = ''; // Clear folder name input field
            } else {
                // If it's an edit, update modal title and button text
                if (folderModalLabel) {
                    folderModalLabel.textContent = 'Edit Folder'; // Update title for edit
                }

                if (submitButton) {
                    submitButton.textContent = 'Save Changes'; // Update button text for save
                }
            }
        });

        function authorizeAccess(folderID) {
            // Fetch users from the same sector as the current session
            fetch(`controller/fetchUserSector.php?folderID=${folderID}`, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    let userOptionsCheckboxes = '';
                    data.users.forEach(user => {
                        let isChecked = user.hasAccess ? 'checked' : '';
                        userOptionsCheckboxes += `
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="user-${user.staffID}" value="${user.staffID}" ${isChecked}>
                    <label class="form-check-label" for="user-${user.staffID}">${user.Name}</label>
                </div>
            `;
                    });

                    // Build the modal HTML
                    const modalHTML = `
            <div class="modal fade" id="authorizeAccessModal" tabindex="-1" aria-labelledby="authorizeAccessModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="authorizeAccessModalLabel">Authorize Access</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="authorizeAccessForm">
                                <label for="userSelect" class="form-label mb-3">Authorize Staff:</label>
                                
                                <!-- Custom Multi-select Dropdown -->
                                <div class="custom-multiselect-container">
                                    <div class="dropdown w-100">
                                        <button class="btn btn-secondary w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Select Staff <span id="selectedCount">0</span> selected
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton" style="max-height: 300px; overflow-y: auto;">
                                            ${userOptionsCheckboxes}
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="submitAccess('${folderID}')">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

                    // Insert modal HTML into the body
                    document.body.insertAdjacentHTML('beforeend', modalHTML);

                    // Initialize and show modal
                    const modal = new bootstrap.Modal(document.getElementById('authorizeAccessModal'));
                    modal.show();

                    // Calculate and set initial selected count
                    const initialSelectedCount = document.querySelectorAll('.form-check-input:checked').length;
                    document.getElementById('selectedCount').textContent = initialSelectedCount;

                    // Update selected count dynamically when checkboxes are clicked
                    const checkboxes = document.querySelectorAll('.form-check-input');
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', () => {
                            const selectedCount = document.querySelectorAll('.form-check-input:checked').length;
                            document.getElementById('selectedCount').textContent = selectedCount;
                        });
                    });

                    // Remove modal from the DOM after it's closed
                    document.getElementById('authorizeAccessModal').addEventListener('hidden.bs.modal', function() {
                        document.getElementById('authorizeAccessModal').remove();
                    });
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                });
        }

        function submitAccess(folderID) {
            // Gather selected users
            const checkboxes = document.querySelectorAll('.form-check-input');
            const selectedUsers = Array.from(checkboxes).map(checkbox => ({
                userID: checkbox.value,
                status: checkbox.checked ? 'granted' : 'revoked',
            }));

            // Send the selected users to the server
            fetch('controller/submitAccess.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        folderID,
                        selectedUsers
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal on success
                        const modalElement = document.getElementById('authorizeAccessModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide(); // Programmatically close the modal
                    } else {
                        console.error('Failed to save access:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error submitting access:', error);
                });
        }

        function deleteFile(fileID) {

            // Prevent the event from propagating to the row click event (which triggers preview)
            event.stopPropagation();
            // Show confirmation dialog
            const confirmation = confirm("Are you sure you want to delete this file?");

            if (confirmation) {
                // Proceed with AJAX request to delete the file
                $.ajax({
                    url: 'controller/deleteFile.php', // Make sure to create the controller file
                    method: 'POST',
                    data: {
                        fileID: fileID
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            alert('File deleted successfully');
                            openFolder(currentFolderID);
                        } else {
                            alert('Error deleting file: ' + (data.message || 'Unknown error'));
                        }
                    },
                    error: function() {
                        alert('An error occurred while trying to delete the file.');
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

        });
    </script>


    <script>
    </script>
</body>

</html>