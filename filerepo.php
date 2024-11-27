<?php include_once 'controller/handler/session.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Dashboard</title>
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

        /* Dropzone styling overrides */
        #myDropzone {
            border: 2px dashed #888;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.7);
            /* Light transparent background */
            padding: 30px;
            color: #333;
        }

        #myDropzone .dz-message {
            font-size: 1.2em;
            color: #888;
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
                            <!-- Flex container for breadcrumb and buttons -->
                            <div class="d-flex align-items-center" style="margin-bottom: 20px;">
                                <!-- Breadcrumb with margin -->
                                <div class="folderpath flex-grow-1" style="margin-top: 10px; margin-bottom: 10px;">
                                    <nav>
                                        <ol class="breadcrumb" style="margin-top: 0;">
                                            <li class="breadcrumb-item"><a href="#" onclick="goHome()">Home</a></li>
                                            <!-- Folder name(s) dynamically inserted here -->
                                        </ol>
                                    </nav>
                                </div>

                                <!-- Buttons Container with custom spacing -->
                                <button
                                    class="btn btn-success btn-sm rounded-pill me-2"
                                    style="margin-top: 10px;"
                                    title="Create a new folder"
                                    data-bs-target="#folderModal"
                                    data-bs-toggle="modal">
                                    <i class="ri-folder-add-fill"></i>
                                </button>

                                <button
                                    id="addFileBtn"
                                    class="btn btn-primary btn-sm rounded-pill"
                                    style="margin-top: 10px; display: none;"
                                    title="Add new file"
                                    onclick="showDropzoneModal()">
                                    <i class="ri-file-add-fill"></i> Add New File
                                </button>
                            </div>

                            <!-- Main Table -->
                            <table id="folderTable" class="foldertable table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>No. of files</th>
                                        <th>Created By</th>
                                        <th>Date Uploaded</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
                        <button type="submit" form="folderForm" class="btn btn-primary rounded-pill">Create Folder</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="dropzoneModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h3>Upload Files</h3>
                <form id="myDropzone" class="dropzone" action="controller/uploadFile.php">
                    <div class="dz-message">Drag files here or click to upload</div>
                </form>
                <button onclick="hideDropzoneModal()" class="btn btn-secondary rounded">Cancel</button>
                <!-- Upload button to trigger AJAX upload -->
                <button id="uploadButton" class="btn btn-primary rounded">Upload</button>
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
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Bootstrap Integration JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <!-- tooltips Toggle -->
    <script>
        // Global variable to track if we are in "folder view" or "file view"
        let isFolderView = true;
        let currentFolderID = null; // Store the currently selected folder ID
        let breadcrumb = ['Home']; // Start breadcrumb with Home

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

        // Define populateTable function in the global scope, outside of $(document).ready()
        function populateTable(folders) {
            const table = $('#folderTable').DataTable(); // Get reference to the table

            table.clear(); // Clear existing data

            if (isFolderView) {
                // Render folder view (default)
                folders.forEach(function(folder) {
                    const rowNode = table.row.add([
                        `
                <button class="btn btn-primary btn-sm toggle-breakdown pill-btn">
                    <i class="ri-add-fill"></i>
                </button>
                <i class="ri-folder-open-fill folder-icon"></i> ${folder.folderName}
            `, 'N/A', // Placeholder for number of files
                        folder.CreatedBy || 'N/A',
                        folder.DateCreated || 'N/A'
                    ]).node();

                    $(rowNode).data('folderDetails', folder); // Store folder details in the row
                    $(rowNode).data('folderID', folder.folderID); // Store folderID in the row
                });
            } else {
                // If we are in file view, we would populate with files data
                folders.forEach(function(file) {
                    table.row.add([
                        file.fileName, // File name
                        file.uploadedBy || 'N/A', // Uploaded By
                        file.dateUploaded || 'N/A' // Date uploaded
                    ]).node();
                });
            }

            table.draw(); // Redraw the table after adding new rows
            updateBreadcrumb(); // Update breadcrumb
        }

        // Update breadcrumb display
        function updateBreadcrumb() {
            const breadcrumbContainer = $('.breadcrumb'); // Select the breadcrumb container
            breadcrumbContainer.empty(); // Clear current breadcrumb

            // Add Home as the first item
            breadcrumbContainer.append('<li class="breadcrumb-item"><a href="#" onclick="goHome()">Home</a></li>');

            // Loop through the breadcrumb array and add each item as a breadcrumb
            breadcrumb.slice(1).forEach((item, index) => {
                breadcrumbContainer.append(`<li class="breadcrumb-item ${index === breadcrumb.length - 1 ? 'active' : ''}">${item}</li>`);
            });
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

            // Format the breakdown details
            function formatBreakdown(data) {
                return `
        <div>
            <p class="text-muted" style="font-size: 0.75rem;">
                Agency Name: ${data.CustName || 'N/A'}
            </p>
            <p class="text-muted" style="font-size: 0.75rem;">
                Scope: ${data.HMS_Scope || 'N/A'}
            </p>
            <p class="text-muted" style="font-size: 0.75rem;">
                Tender Proposal: ${data.Tender_Proposal || 'N/A'}
            </p>

            <!-- Eye icon to switch to file view -->
            <button class="btn btn-link btn-sm text-secondary view-files" onclick="viewFiles('${data.folderID}', '${data.folderName}')">
                <i class="ri-eye-line" style="font-size: 1.2rem;"></i>
            </button>

            <!-- Edit Button -->
            <button class="btn btn-link btn-sm text-secondary edit-folder" onclick="editFolder('${data.folderName}')">
                <i class="ri-edit-fill" style="font-size: 1.2rem;"></i>
            </button>

            <!-- Delete Button -->
            <button class="btn btn-link btn-sm text-secondary delete-folder" onclick="deleteFolder('${data.folderName}')">
                <i class="ri-delete-bin-fill" style="font-size: 1.2rem;"></i>
            </button>
        </div>
    `;
            }

            fetchFolders(); // Fetch folder data when the page loads
        });

        // Function to show Dropzone modal and initialize Dropzone if needed
        function showDropzoneModal() {
            const dropzoneModal = document.getElementById('dropzoneModal');
            dropzoneModal.style.display = 'flex';

            if (!Dropzone.instances.length) { // Prevent duplicate initialization
                const myDropzone = new Dropzone("#myDropzone", {
                    paramName: "files[]", // Name of file parameter
                    maxFilesize: 5, // Max file size in MB
                    addRemoveLinks: true, // Allow file removal
                    dictDefaultMessage: "Drag files here or click to upload",
                    autoProcessQueue: false, // Disable automatic submission to allow AJAX upload

                    // Event listener for successful file add
                    success: function(file, response) {
                        // You can handle the success here, but we'll do it via AJAX
                    },

                    // Error handling for failed uploads
                    error: function(file, errorMessage) {
                        alert('Error uploading file: ' + errorMessage);
                    }
                });

                // You can manually handle the file upload here with AJAX
                document.getElementById('uploadButton').addEventListener('click', function() {
                    uploadFilesWithAjax();
                });
            }
        }

        // Function to hide Dropzone modal
        function hideDropzoneModal() {
            const dropzoneModal = document.getElementById('dropzoneModal');
            dropzoneModal.style.display = 'none';
        }

        // Function to control Add File button visibility
        function toggleAddFileButton(show) {
            const addFileBtn = document.getElementById('addFileBtn');
            addFileBtn.style.display = show ? 'inline-block' : 'none';
        }

        // Function to upload files using AJAX
        function uploadFilesWithAjax() {
            const myDropzone = Dropzone.forElement("#myDropzone"); // Get Dropzone instance

            // Create FormData object for AJAX submission
            const formData = new FormData();
            const files = myDropzone.files; // Get all files in the Dropzone instance

            // Append each file to the FormData object
            files.forEach(function(file) {
                formData.append('files[]', file);
            });

            // Append the folderID to the FormData
            formData.append('folderID', currentFolderID); // currentFolderID should be defined elsewhere in your code

            // Send the files using AJAX
            $.ajax({
                url: 'controller/uploadFile.php', // Your backend controller that handles the upload
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const data = JSON.parse(response); // Assuming the response is JSON
                    if (data.success) {
                        alert("Files uploaded successfully!");
                        hideDropzoneModal(); // Close the modal
                        openFolder(currentFolderID); // Refresh the folder view
                    } else {
                        alert(data.message || "File upload failed.");
                    }
                },
                error: function() {
                    alert("Error occurred during file upload.");
                }
            });
        }

        // Upload file function
        function uploadFile(folderID) {
            const dropzoneModal = document.getElementById('dropzoneModal');
            const files = document.getElementById('fileInput').files;
            const formData = new FormData();

            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }

            formData.append('folderID', folderID); // Pass folderID with the request

            $.ajax({
                url: 'controller/uploadFile.php', // Update with your controller's path
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert('File(s) uploaded successfully!');
                        hideDropzoneModal(); // Hide the modal
                        openFolder(folderID); // Refresh the folder
                    } else {
                        alert(response.message || 'File upload failed.');
                    }
                },
                error: function() {
                    alert('Error occurred during file upload.');
                }
            });
        }

        // Example usage in openFolder() function
        function openFolder(folderID, folderName) {
            console.log('Opening folder with ID:', folderID);

            $.ajax({
                url: 'controller/fetchFolderContents.php',
                method: 'GET',
                data: {
                    folderID: folderID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateFolderContents(response.data);
                        toggleAddFileButton(true); // Show Add File button
                    } else {
                        alert(response.message || 'Failed to load folder contents.');
                    }
                },
                error: function() {
                    alert('Error fetching folder contents.');
                }
            });

            breadcrumb.push(folderName);
            updateBreadcrumb();
        }

        // Function to populate the files inside the folder
        function populateFolderContents(files) {
            const table = $('#folderTable').DataTable();
            table.clear(); // Clear the folder table

            // Add the files to the table
            files.forEach(function(file) {
                table.row.add([
                    file.fileName, // File name
                    file.uploadedBy || 'N/A', // Uploaded By
                    file.dateUploaded || 'N/A' // Date uploaded
                ]).node();
            });

            table.draw(); // Redraw the table after adding new rows
            breadcrumb.push('Files'); // Add 'Files' to the breadcrumb trail when viewing files
            updateBreadcrumb(); // Update breadcrumb display
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

        // View files for the selected folder
        function viewFiles(folderID, folderName) {
            currentFolderID = folderID; // Store the selected folder ID
            isFolderView = false; // Switch to file view
            openFolder(folderID, folderName); // Open folder and fetch its files
            breadcrumb.push(folderName); // Add the folder to breadcrumb when viewing its files
        }

        // Go back to Home (reset breadcrumb)
        function goHome() {
            breadcrumb = ['Home']; // Reset breadcrumb to just 'Home'
            isFolderView = true; // Ensure we are in folder view
            fetchFolders(); // Fetch the top-level folders
            updateBreadcrumb(); // Update breadcrumb
        }

        // Toggle view between folder and file view
        function toggleView() {
            if (isFolderView) {
                fetchFolders(); // Fetch folders again
            } else {
                openFolder(currentFolderID, breadcrumb[breadcrumb.length - 1]); // Open the current folder's files again
            }
        }


        document.addEventListener('DOMContentLoaded', function() {
            let selectedBidID = ''; // Global variable to store the selected BidID

            // Initialize tooltips for all elements with the `title` attribute
            document.querySelectorAll('[title]').forEach(function(el) {
                new bootstrap.Tooltip(el);
            });

            const searchInput = document.getElementById('relatedProposalSearch');
            const dropdown = document.getElementById('relatedProposalDropdown');
            let currentIndex = -1; // Keeps track of the currently selected (focused) option

            // Event listener for search input
            searchInput.addEventListener('input', function() {
                const query = searchInput.value.trim();

                if (query.length > 0) {
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
                    // Clear dropdown when query is empty
                    dropdown.innerHTML = '';
                    dropdown.classList.remove('show');
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
                items.forEach((i) => i.classList.remove('highlight'));
                item.classList.add('highlight');
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
                        const previewSection = document.getElementById('proposalPreview');
                        previewSection.classList.remove('d-none'); // Show if hidden
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

            // Handle form submission with AJAX
            const folderForm = document.getElementById('folderForm');
            folderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(folderForm);
                formData.append('relatedProposalId', selectedBidID); // Add the selected BidID to the form data

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'controller/createfolder.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        const response = JSON.parse(xhr.responseText);
                        if (xhr.status === 200 && response.success) {
                            alert(response.message);
                            // Hide modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('folderModal'));
                            modal.hide();
                            // Reset the form
                            folderForm.reset();

                            // Ensure the backdrop is removed (in case modal doesn't do it automatically)
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                            }
                            // Refresh the table by fetching new data
                            fetchFolders(); // This will fetch and repopulate the table with new data
                        } else {
                            alert(response.message); // Show detailed error message
                        }
                    }
                };
                xhr.send(formData);
            });
        });
    </script>


    <script>
    </script>
</body>

</html>