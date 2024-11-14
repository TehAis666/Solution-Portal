<?php
require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// Instantiate Dompdf
$dompdf = new Dompdf();

// Function to generate chart HTML
function generateChartRow($charts)
{
    $html = '<div class="chart-container">';
    foreach ($charts as $image) {
        if ($image) {
            $html .= '
            <div class="chart-item">
                <img src="' . htmlspecialchars($image) . '" alt="Chart" class="chart-img"/>
            </div>';
        }
    }
    $html .= '</div>';
    return $html;
}

// Get chart images from POST data
$charts = [
    $_POST['reportsChartImage'] ?? '',
    $_POST['stakedBarChartImage'] ?? '',
    $_POST['sectorChartImage'] ?? '',
    $_POST['horizontalBarChartImage'] ?? '',
    $_POST['barChartImage'] ?? '',
    $_POST['bidTypesBarChartImage'] ?? '',
    $_POST['pipelinesBarChartImage'] ?? ''
];

// Get the total revenue and clean it
$totalRevenue = $_POST['totalRevenue'] ?? '0';
$totalRevenue = preg_replace('/[^0-9.]/', '', $totalRevenue); // Remove non-numeric characters
$totalRevenueFormatted = number_format((float)$totalRevenue, 0); // Format the cleaned value

// Get total bids and status counts
$totalBidsStats = $_POST['totalBids'] ?? 0;
$totalWIP = $_POST['totalWIP'] ?? 0;
$totalSubmitted = $_POST['totalSubmitted'] ?? 0;
$totalDropped = $_POST['totalDropped'] ?? 0;

// Decode the market sector data
$marketSectorData = json_decode($_POST['marketSectorData'] ?? '[]', true);
$totalBids = json_decode($_POST['totalBidsData']);
$totalRevenues = json_decode($_POST['totalRevenueData']);
$months = json_decode($_POST['monthsData']);

// Decode the bidTypesDatas and pipelinesDatas
$bidTypesDatas = json_decode($_POST['bidTypesDatas'] ?? '[]', true);
$pipelinesDatas = json_decode($_POST['pipelinesDatas'] ?? '[]', true);

// Define the categories for Bid Types and Pipelines
$bidTypesLabels = ['RFQ', 'Tender', 'Quotation', 'RFP', 'RFI', 'Upstream', 'Strategic Proposal', 'Strategic Initiative'];
$pipelinesLabels = ['Unknown', 'Loss', 'Close', 'KIV', 'Intro', 'Clarification'];

// Decode the solutions data passed via POST (assuming it's passed as JSON)
$solutionsData = json_decode($_POST['solutionsData'] ?? '[]', true);

// Build a market sector table
$marketSectorTable = '<table class="stats-table">
    <tr>
        <th>Market Sector</th>
        <th>Value</th>
    </tr>';
foreach ($marketSectorData as $data) {
    $marketSectorTable .= '
    <tr>
        <td>' . htmlspecialchars($data['name']) . '</td>
        <td>' . htmlspecialchars($data['value']) . '</td>
    </tr>';
}
$marketSectorTable .= '</table>';


// Build a months, total bids, and revenue table
$monthsRevenueTable = '<table class="stats-table">
    <tr>
        <th>Month</th>
        <th>Total Bids</th>
        <th>Revenue (Mil)</th>
    </tr>';

// Assuming $months, $totalBids, and $totalRevenue are arrays with months, bid counts, and revenue data
foreach ($months as $index => $month) {
    $bids = isset($totalBids[$index]) ? $totalBids[$index] : 0; // Handle case if no bids data
    $revenue = isset($totalRevenues[$index]) ? $totalRevenues[$index] : 0; // Handle case if no revenue data

    // Add a row for each month with its corresponding bids and revenue
    $monthsRevenueTable .= '
    <tr>
        <td>' . htmlspecialchars($month) . '</td>
        <td>' . htmlspecialchars($bids) . '</td>
        <td>' . htmlspecialchars($revenue) . '</td>
    </tr>';
}

$monthsRevenueTable .= '</table>';

// Build a bid types table
$bidTypesTable = '<table class="stats-table">
    <tr>
        <th>Bid Type</th>
        <th>Total Bids</th>
    </tr>';
foreach ($bidTypesDatas as $index => $count) {
    $bidTypesTable .= '
    <tr>
        <td>' . htmlspecialchars($bidTypesLabels[$index]) . '</td>
        <td>' . htmlspecialchars($count) . '</td>
    </tr>';
}
$bidTypesTable .= '</table>';

// Build a pipelines table
$pipelinesTable = '<table class="stats-table">
    <tr>
        <th>Pipeline Status</th>
        <th>Total Bids</th>
    </tr>';
foreach ($pipelinesDatas as $index => $count) {
    $pipelinesTable .= '
    <tr>
        <td>' . htmlspecialchars($pipelinesLabels[$index]) . '</td>
        <td>' . htmlspecialchars($count) . '</td>
    </tr>';
}
$pipelinesTable .= '</table>';

// Decode the solutions data passed via POST (assuming it's passed as JSON)
$solutionsData = json_decode($_POST['solutionsData'] ?? '[]', true);

// Build a solutions data table
$solutionsDataTable = '<table class="stats-table">
    <tr>
        <th>Solution</th>
        <th>Value</th>
    </tr>';
foreach ($solutionsData as $solution => $value) {
    $solutionsDataTable .= '
    <tr>
        <td>' . htmlspecialchars($solution) . '</td>
        <td>' . htmlspecialchars($value) . '</td>
    </tr>';
}
$solutionsDataTable .= '</table>';

// Generate HTML for the report
$html = '
<!DOCTYPE html>
<html>
<head>
  <style>
    @font-face {
      font-family: "Poppins";
      src: url("path/to/fonts/Poppins-Regular.ttf") format("truetype");
      font-weight: normal;
      font-style: normal;
    }
    body {
      font-family: "Poppins", sans-serif;
      margin: 0;
      padding: 20px;
      color: #333;
      background-color: #f4f4f4;
    }
    h1 {
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      color: #2c3e50;
      margin: 0 0 20px;
    }
    .header, .footer {
      text-align: center;
      font-size: 12px;
      color: #666;
      margin-bottom: 20px;
      padding: 10px;
      background-color: #ecf0f1;
      border-radius: 5px;
    }
    .footer {
      margin-top: 40px;
    }
    .total-bids-revenue {
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      margin-top: 10px;
      background-color: #ffffff;
    }
    .revenue-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      padding: 10px;
    }
    .label {
      font-size: 16px;
      font-weight: bold;
      color: #2c3e50;
      margin: 0;
    }
    .value {
      font-size: 18px;
      font-weight: bold;
      color: #4169e1; /* Corporate blue color */
      margin: 0;
    }
    .separator {
      margin-top: 10px;
      border: 0;
      border-top: 1px solid #ccc; /* Light gray line */
    }
    .stats-table {
      width: 100%;
      margin: 20px 0;
      font-size: 14px;
      border-collapse: collapse; /* Ensures borders between cells */
    }
    .stats-table th, .stats-table td {
      padding: 12px 15px;
      text-align: left;
      border: 1px solid #ccc; /* Adds light border between cells */
    }
    .stats-table th {
      background-color: #2c3e50;
      color: white;
      font-weight: bold;
      text-transform: uppercase;
    }
    .stats-table tr:nth-child(even) {
      background-color: #ecf0f1; /* Light grey for even rows */
    }
    .chart-table {
      width: 100%;
      margin: 20px 0;
      border-collapse: collapse; /* Ensures borders between cells */
    }
    .chart-table td {
      text-align: center;
      padding: 10px;
      border: 1px solid #ccc; /* Adds light border between cells */
    }
    .chart-img {
      width: 100%;
      max-height: 250px;
      display: block;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="header">HeiTech Padu Berhad</div>
  <h1>Bids Data Visualization Report</h1>

  <!-- Total Bids and Revenue Section -->
  <div class="total-bids-revenue">
    <div class="revenue-item">
      <h5 class="label">Total Bids: <span class="value">' . $totalBidsStats . '</span></h5>
      <h5 class="label">Total Revenue: <span class="value">RM ' . $totalRevenueFormatted . '</span></h5>
    </div>
    <hr class="separator">
  </div>

  <!-- Status Section -->
  <table class="stats-table">
    <tr>
      <th>Status</th>
      <th>Total of Bids</th>
    </tr>
    <tr>
      <td>WIP</td>
      <td>' . $totalWIP . '</td>
    </tr>
    <tr>
      <td>Submitted</td>
      <td>' . $totalSubmitted . '</td>
    </tr>
    <tr>
      <td>Dropped</td>
      <td>' . $totalDropped . '</td>
    </tr>
  </table>

  <!-- Market Sector Table Section -->
  <h2>Market Sector Data</h2>
  ' . $marketSectorTable . '

  <!-- Market Sector Table Section -->
  <h2>Month Revenue Data</h2>
  ' . $monthsRevenueTable . '

  <!-- Bid Types Table Section -->
  <h2>Bid Types Data</h2>
  ' . $bidTypesTable . '

  <!-- Pipelines Table Section -->
  <h2>Pipelines Data</h2>
  ' . $pipelinesTable . '

  <!-- Solution Table Section -->
  <h2>Each Solution Sum Data</h2>
  ' . $solutionsDataTable . '


 <!-- Charts Section -->
<table class="chart-table">

    <!-- Second row with two images -->
      <tr>
        <td>' . (isset($charts[3]) ? '<img src="' . htmlspecialchars($charts[3]) . '" alt="Chart" class="chart-img"/>' : '') . '</td>
        <td>' . (isset($charts[2]) ? '<img src="' . htmlspecialchars($charts[2]) . '" alt="Chart" class="chart-img"/>' : '') . '</td>
        <td>' . (isset($charts[4]) ? '<img src="' . htmlspecialchars($charts[4]) . '" alt="Chart" class="chart-img"/>' : '') . '</td>
      </tr>

  <!-- First row with one image spanning three columns -->
  <tr>
    <td colspan="3">' . (isset($charts[0]) ? '<img src="' . htmlspecialchars($charts[0]) . '" alt="Chart" class="chart-img"/>' : '') . '</td>
  </tr>

  <tr>
    <td colspan="3">' . (isset($charts[1]) ? '<img src="' . htmlspecialchars($charts[1]) . '" alt="Chart" class="chart-img"/>' : '') . '</td>
  </tr>
  
  <!-- Third row with three images -->
  <tr>
    <td colspan="3">' . (isset($charts[5]) ? '<img src="' . htmlspecialchars($charts[5]) . '" alt="Chart" class="chart-img"/>' : '') . '</td>
  </tr>

  <tr>
    <td colspan="3">' . (isset($charts[6]) ? '<img src="' . htmlspecialchars($charts[6]) . '" alt="Chart" class="chart-img"/>' : '') . '</td>
  </tr>
</table>

  <div class="footer">Generated on ' . date('F d, Y') . '</div>
</body>
</html>';

// Load HTML into Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output PDF to the browser
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=Corporate_Report.pdf");
echo $dompdf->output();
