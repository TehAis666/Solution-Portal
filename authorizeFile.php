<?php include_once 'controller/handler/session.php';
?>

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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <!-- DataTables Bootstrap Integration CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">



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
            font-weight: bold;
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

        /* Override margin-left for toggle-status */
        .form-switch .form-check-input.toggle-status {
            margin-left: -2.2em !important;
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

        /* Switch and its label alignment */
        .form-switch .form-check-label {
            font-size: 0.85rem;
            font-weight: bold;
            margin-left: 5px;
        }

        .form-switch .form-check-input {
            cursor: pointer;
        }

        /* Delete button styling */
        .btn.delete-file {
            color: #dc3545;
            font-size: 1.2rem;
        }

        .btn.delete-file:hover {
            color: #bd2130;
        }

        .clickable {
            cursor: pointer;
            transition: transform 0.3s ease, font-size 0.3s ease;
        }

        .clickable:hover {
            transform: scale(1.1);
            /* Scale up by 10% */
            font-size: 52px;
            /* Increase font size slightly */
        }
    </style>
</head>

<body>
    <?php include_once 'layouts/navbar.php' ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>File</h1>

        </div>
        <!-- End Page Title -->

        <!-- File -->
        <section class="section dashboard">
            <div class="row text-center">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-files clickable" style="color: #1e73be; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Files</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-pending clickable" style="color: #26a69a; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Pending</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-accepted clickable" style="color: #039be5; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Accepted</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-rejected clickable" style="color: #e53935; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Rejected</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">File List</h5>
                            <table id="filesStatusTable" class="filesStatusTable table table-striped table-hover" style="width:100%; margin-top:20px; padding-top:10px;">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Uploaded By</th>
                                        <th>Date Uploaded</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
                        <button type="submit" form="folderForm" class="btn btn-primary rounded-pill" id="submitButton">Create Folder</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing File Status -->
        <div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFileModalLabel">Edit File Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editFileForm">
                            <input type="hidden" id="fileID" name="fileID">
                            <div class="mb-3">
                                <label for="fileStatus" class="form-label">Status</label>
                                <!-- Custom toggle switch for status selection -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="fileStatus" role="switch">
                                    <label class="form-check-label" for="fileStatus" id="statusLabel">Accepted</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveFileStatus">Save changes</button>
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

    <!-- JavaScript -->
    <script>
        $(document).ready(function() {
            let currentStatusFilter = ''; // Initialize currentStatusFilter as an empty string

            const table = $('#filesStatusTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all",
                }],
                ajax: {
                    url: 'controller/fetchFiles', // URL to file fetching script
                    type: 'GET',
                    data: function(d) {
                        d.status = currentStatusFilter; // Add current status filter to the AJAX request
                    },
                    dataSrc: 'files', // Assuming the JSON response has a 'files' key with an array of file data
                },
                columns: [{
                        data: 'fileName',
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-primary btn-sm toggle-breakdown pill-btn">
                            <i class="ri-add-fill"></i>
                        </button>
                        <span>${data}</span>
                    `;
                        },
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            let badgeClass = '';
                            switch (data) {
                                case 'pending':
                                    badgeClass = 'badge-warning';
                                    break;
                                case 'accepted':
                                    badgeClass = 'badge-success';
                                    break;
                                case 'rejected':
                                    badgeClass = 'badge-danger';
                                    break;
                                default:
                                    badgeClass = 'badge-secondary';
                            }
                            return `<span class="badge ${badgeClass}">${data}</span>`;
                        },
                    },
                    {
                        data: 'uploadedBy'
                    },
                    {
                        data: 'dateUploaded'
                    },
                ],
            });

            // Function to update the file counters
            function updateFileCounts() {
                $.ajax({
                    url: 'controller/getFileCounts.php', // URL to fetch the file counts
                    method: 'GET',
                    success: function(response) {
                        const data = JSON.parse(response); // Parse the JSON response

                        // Update the counter elements
                        $('.total-files').text(data.totalFiles);
                        $('.total-pending').text(data.totalPending);
                        $('.total-accepted').text(data.totalAccepted);
                        $('.total-rejected').text(data.totalRejected);
                    },
                    error: function() {
                        alert('An error occurred while fetching the file counts.');
                    }
                });
            }

            // Call the function to update the counts on page load
            updateFileCounts();

            // Optionally, you can refresh the counts periodically, e.g., every 30 seconds
            setInterval(updateFileCounts, 30000);

            // Toggle breakdown functionality
            $('#filesStatusTable tbody').on('click', '.toggle-breakdown', function(event) {
                event.stopPropagation(); // Prevent the row click from triggering
                const tr = $(this).closest('tr');
                const row = table.row(tr);
                const button = $(this);
                const fileDetails = row.data(); // Retrieve row data

                if (row.child.isShown()) {
                    // Collapse
                    row.child.hide();
                    tr.removeClass('shown');
                    button.removeClass('btn-danger').addClass('btn-primary');
                    button.find('i').removeClass('ri-close-fill').addClass('ri-add-fill');
                } else {
                    // Expand
                    row.child(formatBreakdown(fileDetails)).show();
                    tr.addClass('shown');
                    button.removeClass('btn-primary').addClass('btn-danger');
                    button.find('i').removeClass('ri-add-fill').addClass('ri-close-fill');
                }
            });

            // Row click event to trigger previewPDF function
            $('#filesStatusTable tbody').on('click', 'tr', function(event) {
                const fileID = table.row(this).data().FileID; // Get the fileID from the row's data
                if (fileID && !$(event.target).hasClass('toggle-breakdown')) {
                    // Only trigger the preview if it's not the breakdown button that was clicked
                    previewPDF(fileID); // Call the function with the fileID
                }
            });

            // Format breakdown details
            function formatBreakdown(data) {
                const isStandalone = data.agencyName === "N/A";

                return `
    <div class="breakdown-container p-3">
        ${isStandalone ? `
            <!-- Case: Standalone Folder -->
            <div class="breakdown-row">
                <p class="breakdown-label">Standalone Folder</p>
            </div>
            <div class="breakdown-row">
                <p class="breakdown-label">Folder Name: <span>${data.folderName || 'N/A'}</span></p>
            </div>
        ` : `
            <!-- Case: File belongs to an agency -->
            <div class="breakdown-row">
                <p class="breakdown-label">Agency Name: <span>${data.agencyName || 'N/A'}</span></p>
            </div>
            <div class="breakdown-row">
                <p class="breakdown-label">Scope: <span>${data.scope || 'N/A'}</span></p>
            </div>
            <div class="breakdown-row">
                <p class="breakdown-label">Tender Proposal: <span>${data.tenderProposal || 'N/A'}</span></p>
            </div>
            <div class="breakdown-row">
                <p class="breakdown-label">Solution: <span>${data.solution || 'N/A'}</span></p>
            </div>
            <div class="breakdown-row">
                <p class="breakdown-label">Folder Name: <span>${data.folderName || 'N/A'}</span></p>
            </div>
        `}

        <!-- Full-width Switch Row -->
        <div class="breakdown-row d-flex justify-content-between align-items-center">
            <p class="mb-0 breakdown-label">Change Status</p>
            <div class="form-check form-switch">
                <input 
                    class="form-check-input toggle-status" 
                    type="checkbox" 
                    role="switch" 
                    data-file-id="${data.FileID}" 
                    ${data.status === 'accepted' ? 'checked' : ''}
                >
                <label class="form-check-label ${data.status === 'accepted' ? 'text-success' : 'text-danger'} mb-0">
                    ${data.status === 'accepted' ? 'Accepted' : 'Rejected'}
                </label>
            </div>
        </div>

        <!-- Delete Button Row -->
        <div class="breakdown-row">
            <button 
                class="btn btn-link btn-sm text-secondary delete-file" 
                onclick="deleteFile(${data.FileID})"
            >
                <i class="ri-delete-bin-fill fs-4"></i>
            </button>
        </div>
    </div>
    `;
            }

            // Event listener for toggle status
            $('#filesStatusTable tbody').on('change', '.toggle-status', function() {
                const fileID = $(this).data('file-id');
                const newStatus = $(this).is(':checked') ? 'accepted' : 'rejected';

                // Update the status on the server
                $.ajax({
                    url: 'controller/updateFileStatus.php',
                    method: 'POST',
                    data: {
                        fileID: fileID,
                        status: newStatus,
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            alert('Status updated successfully!');
                            table.ajax.reload(); // Reload table data
                            updateFileCounts();
                        } else {
                            alert('Error updating status.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while updating the status.');
                    },
                });
            });

            // Function to preview the PDF
            function previewPDF(fileID) {
                $.ajax({
                    url: 'controller/filepreview.php', // Server-side script to handle file preview
                    method: 'POST',
                    data: {
                        fileID: fileID
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            const fileUrl = encodeURIComponent(data.fileUrl); // Encode the file URL
                            const viewerUrl = `pdfviewer/web/viewer.html?file=${fileUrl}`;
                            window.open(viewerUrl, '_blank'); // Open the viewer in a new tab
                        } else {
                            alert('Error loading file preview.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while loading the preview.');
                    },
                });
            }

            // Handle the status click for pending, accepted, or rejected
            $('.total-pending').on('click', function() {
                currentStatusFilter = 'pending'; // Set filter to 'pending'
                table.ajax.reload(); // Reload the table with the new filter
            });

            $('.total-accepted').on('click', function() {
                currentStatusFilter = 'accepted'; // Set filter to 'accepted'
                table.ajax.reload(); // Reload the table with the new filter
            });

            $('.total-rejected').on('click', function() {
                currentStatusFilter = 'rejected'; // Set filter to 'rejected'
                table.ajax.reload(); // Reload the table with the new filter
            });

            // Reset filter when "Total Files" button is clicked
            $('.total-files').on('click', function() {
                currentStatusFilter = ''; // Reset the filter to show all files
                table.ajax.reload(); // Reload the table with the reset filter
            });
        });
    </script>


</body>

</html>