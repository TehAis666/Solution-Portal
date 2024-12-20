<?php
include_once 'controller/handler/session.php';
include_once 'controller/calculateSumSolution.php';
include_once 'controller/calculateMarketSector.php';
include_once 'controller/calculateInfraSolution.php';
include_once 'controller/calculatebidType.php';
include_once 'controller/calculatereport.php';
include_once 'controller/fetchYear.php';
include_once 'controller/viewStatus.php';

// Convert the counts to a JSON string for JavaScript
$bidCountsJson = json_encode($bidCounts);

// Convert the counts array to a JSON string
$solutionCountsJson = json_encode($solutionBusinessUnitCounts);

?>

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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet" />

  <!-- Custom Styles -->
  <style>
    /* Adjust form input boxes */
    .form-control,
    .form-select {
      border-radius: 20px;
      height: 28px;
      font-size: 0.8rem;
      padding: 0.2rem 0.5rem;
      margin: 0;
      /* Ensure no margin */
    }

    /* Smaller Card (less padding) */
    .filtering {
      border-radius: 10px;
      padding: 8px 12px;
      min-height: 50px;
      font-size: 0.8rem;
    }

    /* Compact Rounded Buttons */
    .btn {
      border-radius: 20px;
      padding: 0.2rem 0.8rem;
      font-size: 0.8rem;
      margin: 0;
      /* Remove margin */
      white-space: nowrap;
      /* Prevent wrapping */
    }

    /* Reduce spacing between form-group elements */
    .form-group {
      display: flex;
      align-items: center;
      margin-bottom: 0;
      margin-right: 5px;
      /* Reduce space between input fields */
      gap: 4px;
      /* Reduce gap between label and input */
    }

    /* Align labels to the left and adjust label spacing */
    .form-group label {
      margin-right: 5px;
      margin-bottom: 0;
      width: 60px;
      /* Adjust width to reduce space */
      font-size: 0.8rem;
      white-space: nowrap;
    }

    /* Reduce padding and margin between input fields */
    .row.g-2 {
      gap: 0.5rem;
      /* Reduce the gap between columns */
    }

    /* Ensure Filter and Export buttons stay on the same line */
    .col-md-2.d-flex {
      padding-left: 0;
      /* Remove left padding */
      gap: 4px;
      /* Reduce space between buttons */
      white-space: nowrap;
      /* Prevent wrapping */
    }

    /* Ensure no margins around the card */
    .card-body {
      padding: 8px 12px;
    }

    /* Reduce padding inside the card */
    .card.filtering {
      margin-bottom: 15px;
    }

    /* Modal Styling */
    .modal-content {
      text-align: center;
      padding: 40px;
      border-radius: 15px;
      background: linear-gradient(145deg, #f0f0f0, #ffffff);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-body {
      font-size: 22px;
      font-weight: bold;
      color: #333;
    }

    /* Icon styling */
    .greeting-icon {
      margin-bottom: 20px;
    }

    #greetingIcon {
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
    }

    /* SVG Animation */
    .sun,
    .cloud-sun,
    .moon {
      width: 64px;
      height: 64px;
    }

    .sun {
      animation: rotate 3s infinite linear;
    }

    @keyframes rotate {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    .moon,
    .cloud-sun {
      animation: move 2s infinite ease-in-out;
    }

    @keyframes move {
      0% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-10px);
      }

      100% {
        transform: translateY(0);
      }
    }

    /* Fade-in animation for modal content */
    .fade-in {
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    /* Additional animation for the user's name */
    .slide-in {
      animation: slideIn 1s ease-in;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
  </style>
</head>

<body>
  <?php include 'layouts/navbar.php' ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Bid Management Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
      <!-- Responsive Filter Card -->
      <div class="card filtering shadow-sm">
        <div class="filter">
          <a
            class="icon"
            href="#"
            data-bs-toggle="dropdown"
            style="font-size: 18px">
            <i class="bi bi-three-dots"></i>
          </a>
          <ul
            class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6 style="font-size: 12px">Action</h6>
            </li>
            <li>
              <a class="dropdown-item" href="#" style="font-size: 12px" id="resetAllCharts">Reset</a>
            </li>
          </ul>
        </div>
        <div class="card-body pb-0">
          <form action="#" id="filterForm">
            <div class="row g-2">
              <!-- Year Dropdown with label to the left -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="year">Year:</label>
                  <select id="year" name="year" class="form-select">
                    <option value="">Select Year</option>
                    <?php
                    // Get the selected year from the GET parameters
                    $selectedYear = isset($_GET['year']) ? $_GET['year'] : '';

                    // Generate dropdown options dynamically
                    foreach ($years as $year) {
                      // Check if the current year is the selected year
                      $selected = ($year == $selectedYear) ? 'selected' : '';
                      echo "<option value=\"$year\" $selected>$year</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <!-- Start Date Picker with label to the left -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="startDate">Start Date:</label>
                  <input type="date" id="startDate" name="startDate" class="form-control">
                </div>
              </div>

              <!-- End Date Picker with label to the left -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="endDate">End Date:</label>
                  <input type="date" id="endDate" name="endDate" class="form-control">
                </div>
              </div>

              <!-- Filter Button -->
              <div class="col-md-2 d-flex align-items-center justify-content">
                <button type="submit" class="btn btn-primary">Filter</button>
                <!-- <button type="button" class="btn btn-light">Export to PDF</button> -->
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="row" id="Statuscontainer">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <!-- Bids Card -->
            <div class="col">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Total Bids</h5>

                  <div class="d-flex align-items-center">
                    <div
                      class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="totalBids"><?php echo $totalBids; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">
                    Total Bids Revenue
                  </h5>

                  <div class="d-flex align-items-center">
                    <div
                      class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="totalRevenue">RM <?php echo number_format($totalRevenue ?? 0, 0); ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Revenue Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card" style="padding: 10px">
                <div class="card-body" style="padding: 10px">
                  <h5 class="card-title" style="font-size: 14px">
                    Total Bids <span style="font-size: 12px">/ Month</span>
                  </h5>

                  <!-- Line Chart -->
                  <div id="reportsChart" style="height: 270px" class="echart"></div>

                  <!-- End Line Chart -->
                </div>
              </div>
            </div>
            <!-- End Reports -->

            <!-- Infra Solution -->
            <div class="col-12">
              <div
                class="card recent-sales overflow-auto"
                style="padding: 10px">
                <div class="card-body" style="padding: 10px">
                  <h5 class="card-title" style="font-size: 14px">
                    Infra Solution
                  </h5>
                  <!-- Stacked Bar Chart -->
                  <canvas
                    id="stakedBarChart"
                    style="max-height: 310px"></canvas>
                </div>
              </div>
            </div>
            <!-- Infra Solution Ends -->
          </div>
        </div>
        <!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- Start Status Columns -->
          <div class="card" style="max-width: 600px">

            <div class="card-body pb-0">
              <h5 class="card-title" style="font-size: 14px">
                Status
              </h5>

              <table class="table table-hover" style="font-size: 12px">
                <thead>
                  <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Total of Bids</th>
                  </tr>
                </thead>
                <tbody>
                  <tr data-status="WIP">
                    <td>WIP</td>
                    <td id="totalWIP"><?php echo $statusData['WIP']; ?></td>
                  </tr>
                  <tr data-status="Submitted">
                    <td>Submitted</td>
                    <td id="totalSubmitted"><?php echo $statusData['Submitted']; ?></td>
                  </tr>
                  <tr data-status="Dropped">
                    <td>Dropped</td>
                    <td id="totalDropped"><?php echo $statusData['Dropped']; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- End Status Columns -->

          <!-- Start Bids Sector -->

          <div class="card" style="max-width: 600px">

            <div class="card-body pb-0">
              <h5 class="card-title" style="font-size: 14px">
                Bids By Market Sector

              </h5>

              <div
                id="sectorChart"
                style="min-height: 250px"
                class="echart"></div>

            </div>
          </div>
          <!-- End Bid Sector Column -->

          <!-- Sector Chart Section -->
          <div class="card" style="max-width: 600px">


            <div class="card-body pb-0">
              <!-- Sector Bar Chart -->
              <div
                id="horizontalBarChart"
                style="min-height: 200px"
                class="echart"></div>

            </div>
          </div>
          <!-- End Sector Chart Section -->

          <!-- Company Total Section -->
          <div class="card" style="max-width: 600px">
            <!-- Increased width for better spacing -->


            <div class="card-body pb-0">
              <!-- Bar Chart -->
              <canvas id="barChart" style="max-height: 400px"></canvas>
              <!-- End Bar Chart -->
            </div>
          </div>
          <!-- End Company Total Section -->
        </div>
        <!-- End Right side columns -->
      </div>

      <!-- Responsive Bid Types and Pipelines -->
      <div class="card top-selling overflow-auto">


        <div class="card-body pb-0">
          <h5 class="card-title">
            Bid Types and Pipelines
          </h5>

          <!-- Responsive container for Bid Types and Pipelines Bar Charts -->
          <div class="chart-container">
            <!-- Bid Types Bar Chart -->
            <div id="bidTypesBarChart" class="echart"></div>

            <!-- Pipelines Bar Chart -->
            <div id="pipelinesBarChart" class="echart"></div>
          </div>
        </div>
      </div>
      <!-- End Responsive Bid Types and Pipelines -->

      <!-- Modal HTML for Greeting -->
      <div class="modal fade" id="greetingModal" tabindex="-1" aria-labelledby="greetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <!-- SVG Icon will change based on greeting -->
              <div id="greetingIcon"></div>
              <p id="greetingMessage" class="fade-in"></p>
              <p class="slide-in"><?php echo $userData['name']; ?></p> <!-- Display the user's name -->
            </div>
          </div>
        </div>
      </div>
    </section>
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
    class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- HorizontalBarChart and StackedBarChart -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Store the currently selected label
      let currentSelectedLabel = null;
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      let selectedStatus = ''; // Holds the selected status for filtering
      let lastClickedSector = null; // Tracks the last clicked sector

      // Store last selected sector to allow deselection on repeated clicks
      let lastSelectedSector = null;
      // Store the currently selected label
      let currentSelectedLabel = null;

      // Store last selected Bid Type to allow deselection on repeated clicks
      let selectedBidType = null;

      // Store last selected Pipeline to allow deselection on repeated clicks
      let selectedPipeline = null;

      // Store last selected month year to allow deselection on repeated clicks
      let selectedMonthYear = null;

      // Store last selected Solution to allow deselection on repeated clicks
      let lastSelectedSolution = null;

      // Store date, startDate,endDate
      // let date = '';
      // let startDate = '';
      // let endDate = '';

      // Get the JSON-encoded data from PHP
      var bidTypesCounts = <?php echo $bidTypesJson; ?>;
      var pipelineCounts = <?php echo $pipelineCountsJson; ?>;

      // Data for Bid Types Chart
      var bidTypesData = [
        bidTypesCounts['RFQ'],
        bidTypesCounts['Tender'],
        bidTypesCounts['Quotation'],
        bidTypesCounts['RFP'],
        bidTypesCounts['RFI'],
        bidTypesCounts['Upstream']
      ];

      //Report Data
      var months = <?php echo $monthsJson; ?>;
      var totalBids = <?php echo $totalBidsJson; ?>;
      var totalRevenue = <?php echo $totalRevenueJson; ?>;

      const bidCounts = <?php echo $bidCountsJson; ?>;

      // Initialize charts
      var pieChart = echarts.init(document.querySelector("#sectorChart"));
      var barChart = echarts.init(document.querySelector("#horizontalBarChart"));

      var pieOption = {
        tooltip: {
          trigger: "item"
        },
        legend: {
          top: "5%",
          left: "center",
          itemGap: 5,
          textStyle: {
            fontSize: 10
          }
        },
        series: [{
          name: "Bids",
          type: "pie",
          radius: ["30%", "60%"],
          label: {
            show: false
          },
          data: [{
              value: bidCounts["TMG (Private Sector)"],
              name: "TMG (Private Sector)"
            },
            {
              value: bidCounts["TMG (Public Sector)"],
              name: "TMG (Public Sector)"
            },
            {
              value: bidCounts["NMG"],
              name: "NMG"
            },
            {
              value: bidCounts["IMG"],
              name: "IMG"
            },
            {
              value: bidCounts["Channel"],
              name: "Channel"
            },
          ],
        }],
      };

      var barOption = {
        tooltip: {
          trigger: "axis",
          axisPointer: {
            type: "shadow"
          }
        },
        grid: {
          left: "5%",
          right: "5%",
          bottom: "5%",
          top: "10%",
          containLabel: true
        },
        xAxis: {
          type: "value",
          boundaryGap: [0, 0.01],
          axisLabel: {
            fontSize: 10
          }
        },
        yAxis: {
          type: "category",
          data: ["TMG (Private Sector)", "TMG (Public Sector)", "NMG", "IMG", "Channel"],
          axisLabel: {
            fontSize: 10
          },
        },
        series: [{
          name: "Bids",
          type: "bar",
          data: [
            bidCounts["TMG (Private Sector)"],
            bidCounts["TMG (Public Sector)"],
            bidCounts["NMG"],
            bidCounts["IMG"],
            bidCounts["Channel"]
          ],
          barWidth: "40%",
          itemStyle: {
            color: "#3398DB"
          },
          label: {
            show: false
          },
        }],
      };

      pieChart.setOption(pieOption);
      barChart.setOption(barOption);

      // Initialize ECharts instance
      const reportsChart = echarts.init(document.querySelector("#reportsChart"));

      const option = {
        tooltip: {
          trigger: 'axis',
          formatter: function(params) {
            let tooltip = `${params[0].name}<br/>`;
            params.forEach(param => {
              if (param.seriesName === 'Total Bids Revenue') {
                const value = param.value >= 1 ? `${param.value}M` : `${param.value * 1000}K`;
                tooltip += `${param.seriesName}: ${value}<br/>`;
              } else {
                tooltip += `${param.seriesName}: ${param.value}<br/>`;
              }
            });
            return tooltip;
          }
        },
        legend: {
          data: ['Number of Bids', 'Total Bids Revenue']
        },
        xAxis: {
          type: 'category',
          data: months,
        },
        yAxis: [{
            type: 'value',
            name: 'Number of Bids',
            min: 0,
            max: 60,
            interval: 15,
            axisLabel: {
              formatter: '{value}',
            }
          },
          {
            type: 'value',
            name: 'Total Revenue (Mil)',
            min: 0,
            interval: 50,
            position: 'right',
            axisLabel: {
              formatter: function(value) {
                return value >= 1 ? `${value}M` : `${value * 1000}K`;
              }
            }
          }
        ],
        series: [{
            name: 'Number of Bids',
            type: 'line',
            data: totalBids.map(val => parseInt(val)),
            areaStyle: {},
            smooth: true,
            color: '#4154f1',
          },
          {
            name: 'Total Bids Revenue',
            type: 'line',
            data: totalRevenue,
            smooth: true,
            yAxisIndex: 1,
            lineStyle: {
              type: 'dashed',
              color: '#ff771d',
            },
          }
        ]
      };

      reportsChart.setOption(option);

      // Call the function to fetch data when the page loads
      fetchBidPipelineData(null, null, null, null, null, null);

      // Initialize Bid Types Bar Chart with default data before making AJAX call
      const bidTypesBarChart = echarts.init(document.querySelector("#bidTypesBarChart"));

      bidTypesBarChart.setOption({
        title: {
          text: "Bid Types",
          left: "center",
          textStyle: {
            fontSize: 14
          },
        },
        tooltip: {
          trigger: "axis",
          axisPointer: {
            type: "shadow"
          },
        },
        grid: {
          left: "5%",
          right: "5%",
          bottom: "5%",
          top: "15%",
          containLabel: true,
        },
        xAxis: {
          type: "value",
          axisLabel: {
            fontSize: 10
          },
        },
        yAxis: {
          type: "category",
          data: ["RFQ", "Tender", "Quotation", "RFP", "RFI", "Upstream", "Strategic Proposal", "Strategic Initiative"],
          axisLabel: {
            fontSize: 10
          },
        },
        series: [{
          name: "Bid Types",
          type: "bar",
          data: [], // Start with empty data
          color: "#4668E6",
          barWidth: "50%",
        }],
      });

      // Format data for Pipelines Bar Chart
      var pipelinesData = [
        pipelineCounts['Unknown'],
        pipelineCounts['Loss'],
        pipelineCounts['Close'],
        pipelineCounts['KIV'],
        pipelineCounts['Intro'],
        pipelineCounts['Clarification']
      ];

      // Initialize Pipelines Bar Chart with default data
      const pipelinesBarChart = echarts.init(document.querySelector("#pipelinesBarChart"));
      pipelinesBarChart.setOption({
        title: {
          text: "Pipelines",
          left: "center",
          textStyle: {
            fontSize: 14
          },
        },
        tooltip: {
          trigger: "axis",
          axisPointer: {
            type: "shadow"
          },
        },
        grid: {
          left: "5%",
          right: "5%",
          bottom: "5%",
          top: "15%",
          containLabel: true,
        },
        xAxis: {
          type: "value",
          axisLabel: {
            fontSize: 10
          },
        },
        yAxis: {
          type: "category",
          data: ["Unknown", "Loss", "Close", "KIV", "Intro", "Clarification"],
          axisLabel: {
            fontSize: 10
          },
        },
        series: [{
          name: "Pipelines",
          type: "bar",
          data: pipelinesData,
          color: "#4668E6",
          barWidth: "50%",
        }],
      });

      // Bar Chart Code
      const barSumChart = new Chart(document.querySelector("#barChart"), {
        type: "bar",
        data: {
          labels: ["PaduNet", "Secure-X", "AwanHeiTech", "i-Sentrix", "Mix Solution"], // Labels
          datasets: [{
            label: "Bid Value", // Chart label
            data: [
              <?php echo $paduNetTotal; ?>, // PaduNet
              <?php echo $secureXTotal; ?>, // Secure-X
              <?php echo $awanHeiTechTotal; ?>, // AwanHeiTech
              <?php echo $iSentrixTotal; ?>, // i-Sentrix
              <?php echo $mixSolutionTotal; ?> // Mix Solution
            ],
            backgroundColor: "#4668E6", // Background color
            borderColor: "#4668E6", // Border color
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  if (value >= 1000000) {
                    return (value / 1000000).toFixed(2) + "M"; // Display in millions
                  } else if (value >= 1000) {
                    return (value / 1000).toFixed(1) + "K"; // Display in thousands
                  } else {
                    return value; // Display as is if less than 1000
                  }
                }
              }
            },
            x: {
              ticks: {
                autoSkip: false,
                maxRotation: 0,
                minRotation: 0
              },
              barPercentage: 0.4,
              categoryPercentage: 0.6
            }
          },
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            tooltip: {
              callbacks: {
                label: function(context) {
                  let value = context.raw;
                  if (value >= 1000000) {
                    return context.dataset.label + ": " + (value / 1000000).toFixed(2) + "M";
                  } else if (value >= 1000) {
                    return context.dataset.label + ": " + (value / 1000).toFixed(1) + "K";
                  } else {
                    return context.dataset.label + ": " + value;
                  }
                }
              }
            },
            legend: {
              display: true,
              position: "top"
            }
          }
        }
      });

      // Stacked Bar Chart Code
      var solutionBusinessUnitCounts = <?php echo $solutionCountsJson; ?>;
      var labels = ["PaduNet", "Secure-X", "AwanHeiTech", "i-Sentrix", "Mix Solution"]; // Same labels as bar chart

      // Create dataset for Mix Solution with breakdown information
      var datasets = [{
          label: "Channel",
          data: [
            solutionBusinessUnitCounts['PaduNet']['Channel'],
            solutionBusinessUnitCounts['SecureX']['Channel'],
            solutionBusinessUnitCounts['AwanHeiTech']['Channel'],
            solutionBusinessUnitCounts['iSentrix']['Channel'],
            solutionBusinessUnitCounts['MixSolution']['Channel']['AwanHeiTech'] +
            solutionBusinessUnitCounts['MixSolution']['Channel']['SecureX'] +
            solutionBusinessUnitCounts['MixSolution']['Channel']['PaduNet'] +
            solutionBusinessUnitCounts['MixSolution']['Channel']['iSentrix'] // Sum of all for MixSolution
          ],
          backgroundColor: "#6CC3DF" // Color for Channel
        },
        {
          label: "IMG",
          data: [
            solutionBusinessUnitCounts['PaduNet']['IMG'],
            solutionBusinessUnitCounts['SecureX']['IMG'],
            solutionBusinessUnitCounts['AwanHeiTech']['IMG'],
            solutionBusinessUnitCounts['iSentrix']['IMG'],
            solutionBusinessUnitCounts['MixSolution']['IMG']['AwanHeiTech'] +
            solutionBusinessUnitCounts['MixSolution']['IMG']['SecureX'] +
            solutionBusinessUnitCounts['MixSolution']['IMG']['PaduNet'] +
            solutionBusinessUnitCounts['MixSolution']['IMG']['iSentrix'] // Sum of all for MixSolution
          ],
          backgroundColor: "#FF6B6B" // Color for IMG
        },
        {
          label: "NMG",
          data: [
            solutionBusinessUnitCounts['PaduNet']['NMG'],
            solutionBusinessUnitCounts['SecureX']['NMG'],
            solutionBusinessUnitCounts['AwanHeiTech']['NMG'],
            solutionBusinessUnitCounts['iSentrix']['NMG'],
            solutionBusinessUnitCounts['MixSolution']['NMG']['AwanHeiTech'] +
            solutionBusinessUnitCounts['MixSolution']['NMG']['SecureX'] +
            solutionBusinessUnitCounts['MixSolution']['NMG']['PaduNet'] +
            solutionBusinessUnitCounts['MixSolution']['NMG']['iSentrix'] // Sum of all for MixSolution
          ],
          backgroundColor: "#F9D266" // Color for NMG
        },
        {
          label: "TMG (Private Sector)",
          data: [
            solutionBusinessUnitCounts['PaduNet']['TMG (Private Sector)'],
            solutionBusinessUnitCounts['SecureX']['TMG (Private Sector)'],
            solutionBusinessUnitCounts['AwanHeiTech']['TMG (Private Sector)'],
            solutionBusinessUnitCounts['iSentrix']['TMG (Private Sector)'],
            solutionBusinessUnitCounts['MixSolution']['TMG (Private Sector)']['AwanHeiTech'] +
            solutionBusinessUnitCounts['MixSolution']['TMG (Private Sector)']['SecureX'] +
            solutionBusinessUnitCounts['MixSolution']['TMG (Private Sector)']['PaduNet'] +
            solutionBusinessUnitCounts['MixSolution']['TMG (Private Sector)']['iSentrix'] // Sum of all for MixSolution
          ],
          backgroundColor: "#4668E6" // Color for TMG (Private Sector)
        },
        {
          label: "TMG (Public Sector)",
          data: [
            solutionBusinessUnitCounts['PaduNet']['TMG (Public Sector)'],
            solutionBusinessUnitCounts['SecureX']['TMG (Public Sector)'],
            solutionBusinessUnitCounts['AwanHeiTech']['TMG (Public Sector)'],
            solutionBusinessUnitCounts['iSentrix']['TMG (Public Sector)'],
            solutionBusinessUnitCounts['MixSolution']['TMG (Public Sector)']['AwanHeiTech'] +
            solutionBusinessUnitCounts['MixSolution']['TMG (Public Sector)']['SecureX'] +
            solutionBusinessUnitCounts['MixSolution']['TMG (Public Sector)']['PaduNet'] +
            solutionBusinessUnitCounts['MixSolution']['TMG (Public Sector)']['iSentrix'] // Sum of all for MixSolution
          ],
          backgroundColor: "#7EC968" // Color for TMG (Public Sector)
        }
      ];

      // Create a custom tooltip callback function to show the breakdown of "Mix Solution" when hovered
      const customTooltips = {
        callbacks: {
          label: function(tooltipItem) {
            // Check if the tooltip item corresponds to "Mix Solution"
            if (tooltipItem.label === 'Mix Solution') {
              const businessUnit = tooltipItem.dataset.label; // Get the business unit label (e.g., "NMG", "TMG (Public Sector)")
              const counts = solutionBusinessUnitCounts['MixSolution'][businessUnit]; // Get breakdown for this business unit

              // Format the tooltip text to display individual solution counts
              let breakdownText = `${businessUnit}:\n`;
              breakdownText += `AwanHeiTech: ${counts['AwanHeiTech']} | `;
              breakdownText += `Secure-X: ${counts['SecureX']} | `;
              breakdownText += `PaduNet: ${counts['PaduNet']} | `;
              breakdownText += `i-Sentrix: ${counts['iSentrix']}`;

              return breakdownText; // Return the formatted breakdown
            }

            // Default label for non-Mix Solution entries
            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
          }
        }
      };

      // Initialize the stacked bar chart with custom tooltip logic
      const stackedBarChart = new Chart(document.querySelector("#stakedBarChart"), {
        type: "bar",
        data: {
          labels: labels, // Solution labels for each stack
          datasets: datasets // Data for each business unit per solution
        },
        options: {
          plugins: {
            title: {
              display: false, // Hiding the chart title to save space
            },
            legend: {
              onClick: (e) => e.stopPropagation() // Disable hiding behavior on label click
            },
            tooltip: customTooltips // Use the custom tooltip callback for detailed breakdown
          },
          responsive: true,
          scales: {
            x: {
              stacked: true, // Enable stacking on X-axis
            },
            y: {
              stacked: true, // Enable stacking on Y-axis
              beginAtZero: true, // Start Y-axis at 0
            },
          },
        },
      });


      // Define the unified function for making all fetch calls
      function fetchDataForAllSections(status, sector, bidType, pipeline, monthYear, solution, year, startDate, endDate) {
        fetchStatus(status, sector, bidType, pipeline, monthYear, solution, year, startDate, endDate);
        fetchMarketSectorData(status, sector, bidType, pipeline, monthYear, solution, year, startDate, endDate);
        fetchReportData(status, sector, bidType, pipeline, monthYear, solution, year, startDate, endDate);
        fetchBidPipelineData(status, sector, bidType, pipeline, monthYear, solution, year, startDate, endDate);
        fetchSumSolution(status, sector, bidType, pipeline, monthYear, solution, year, startDate, endDate);
        fetchInfraSolution(status, sector, bidType, pipeline, monthYear, solution, year, startDate, endDate);
        fetchBidStatus(status, sector, bidType, pipeline, monthYear, solution, year, startDate, endDate);
      }

      // Global variables for filter values
      let year, startDate, endDate;

      // Select the filter form
      const filterForm = document.getElementById('filterForm');

      // Listen for form submission (if necessary)
      filterForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent page reload

        // Capture values from the form
        year = document.getElementById('year').value;
        startDate = document.getElementById('startDate').value;
        endDate = document.getElementById('endDate').value;

        // Log captured values to the console
        //console.log("Year:", year);
        //console.log("Start Date:", startDate);
        //console.log("End Date:", endDate);

        // Call the unified function with the captured values
        fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
      });

      // Function for handling row click event
      const rows = document.querySelectorAll('.table-hover tbody tr');
      rows.forEach(row => {
        row.addEventListener('click', () => {
          const status = row.getAttribute('data-status');

          if (selectedStatus === status) {
            selectedStatus = '';
            row.classList.remove('table-active');
          } else {
            rows.forEach(r => r.classList.remove('table-active'));
            row.classList.add('table-active');
            selectedStatus = status;
          }

          // Use the unified fetch function with the global filter values
          fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
        });
      });

      // Function to handle sector selection
      function filterSector() {
        pieChart.on('click', function(params) {
          if (params.seriesType === 'pie') {
            lastSelectedSector = (lastSelectedSector === params.name) ? null : params.name;

            fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
          }
        });

        barChart.on('click', function(params) {
          if (params.seriesType === 'bar') {
            lastSelectedSector = (lastSelectedSector === params.name) ? null : params.name;

            fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
          }
        });

        stackedBarChart.options.plugins.legend = {
          onClick: function(e, legendItem) {
            const clickedLabel = legendItem.text;

            lastSelectedSector = (lastSelectedSector === clickedLabel) ? null : clickedLabel;

            fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
          },
        };
        stackedBarChart.update();
      }

      // Function to handle bid type selection
      function filterBidType() {
        bidTypesBarChart.on('click', function(params) {
          if (params.seriesType === 'bar') {
            selectedBidType = (selectedBidType === params.name) ? null : params.name;

            fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
          }
        });
      }

      // Function to handle pipeline selection
      function filterPipeline() {
        pipelinesBarChart.on('click', function(params) {
          if (params.seriesType === 'bar') {
            selectedPipeline = (selectedPipeline === params.name) ? null : params.name;

            fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
          }
        });
      }

      // Function to handle month-year selection
      function filterMonthYear() {
        reportsChart.on('click', function(params) {
          if (params.seriesType === 'line' || params.seriesType === 'bar') {
            selectedMonthYear = (selectedMonthYear === params.name) ? null : params.name;

            fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
          }
        });
      }

      // Function to handle solution selection
      function filterSolution() {
        document.querySelector("#stakedBarChart").onclick = function(evt) {
          const activePoints = stackedBarChart.getElementsAtEventForMode(evt, 'nearest', {
            intersect: true
          }, true);
          if (activePoints.length) {
            const {
              index
            } = activePoints[0];
            const label = stackedBarChart.data.labels[index];

            lastSelectedSolution = (lastSelectedSolution === label) ? null : label;

            fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
          }
        };

        document.querySelector("#barChart").onclick = function(evt) {
          const activePoints = barSumChart.getElementsAtEventForMode(evt, 'nearest', {
            intersect: true
          }, true);
          if (activePoints.length) {
            const {
              index
            } = activePoints[0];
            const label = barSumChart.data.labels[index];

            lastSelectedSolution = (lastSelectedSolution === label) ? null : label;

            fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
          }
        };
      }

      // Reset button event listener
      document.getElementById('resetAllCharts').addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior

        // Reset all filter variables to null or empty strings
        selectedStatus = '';
        lastSelectedSector = null;
        selectedBidType = null;
        selectedPipeline = null;
        selectedMonthYear = null;
        lastSelectedSolution = null;
        year = '';
        startDate = '';
        endDate = '';

        // Remove active highlight from all rows
        const rows = document.querySelectorAll('.table-hover tbody tr');
        rows.forEach(row => row.classList.remove('table-active'));

        // Call the unified fetch function with null values to reset all charts
        fetchDataForAllSections(selectedStatus, lastSelectedSector, selectedBidType, selectedPipeline, selectedMonthYear, lastSelectedSolution, year, startDate, endDate);
      });

      // Initialize all event handlers
      filterSector();
      filterBidType();
      filterPipeline();
      filterMonthYear();
      filterSolution();

      function fetchMarketSectorData(status, sector, bidtype, ppline, monthYear, solutionn, year, startDate, endDate) {
        // Set sector to an empty string if it is null
        if (sector === null) {
          sector = ''; // Convert null to an empty string
        }

        // Set bidtype to an empty string if it is null
        if (bidtype === null) {
          bidtype = ''; // Convert null to an empty string
        }

        // Set pipeline to an empty string if it is null
        if (ppline === null) {
          ppline = ''; // Convert null to an empty string
        }

        // Set monthYear to an empty string if it is null
        if (monthYear === null) {
          monthYear = ''; // Convert null to an empty string
        }

        // Set solution to an empty string if it is null
        if (solutionn === null) {
          solutionn = ''; // Convert null to an empty string
        }

        //     console.log("AJAX Data being sent:", {
        //     status: status,
        //     sector: sector,
        //     bidtype: bidtype,
        //     ppline: ppline,
        //     monthYear: monthYear,
        //     solutionn: solutionn
        // });

        $.ajax({
          url: 'controller/updateMarketSector.php',
          method: 'GET',
          data: {
            status: status,
            sector: sector, // Include the sector in the request
            bidtype: bidtype, // Include the bidtype in the request
            ppline: ppline, // Include the pipeline in the request
            monthYear: monthYear, // Include the monthYear in the request
            solutionn: solutionn, // Include the solution in the request
            year: year,
            startDate: startDate,
            endDate: endDate
          },
          dataType: 'json',
          success: function(response) {
            // Log the response for debugging
            //console.log("Market Sector:", response); 

            // Convert response data into the format needed for the charts
            const pieData = Object.keys(response).map(key => ({
              value: parseInt(response[key]), // Convert string to integer
              name: key
            }));

            const barData = Object.keys(response).map(key => parseInt(response[key]));

            // Update pie chart data
            pieOption.series[0].data = pieData;
            pieChart.setOption(pieOption);

            // Update bar chart data
            barOption.series[0].data = barData;
            barChart.setOption(barOption);
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
      }

      function fetchReportData(status, sector, bidtype, ppline, monthYear, solutionn, year, startDate, endDate) {

        // Set sector to an empty string if it is null
        if (sector === null) {
          sector = ''; // Convert null to an empty string
        }

        // Set bidtype to an empty string if it is null
        if (bidtype === null) {
          bidtype = ''; // Convert null to an empty string
        }

        // Set pipeline to an empty string if it is null
        if (ppline === null) {
          ppline = ''; // Convert null to an empty string
        }

        // Set monthYear to an empty string if it is null
        if (monthYear === null) {
          monthYear = ''; // Convert null to an empty string
        }

        // Set solution to an empty string if it is null
        if (solutionn === null) {
          solutionn = ''; // Convert null to an empty string
        }

        // Debug: Log the values of status and sector
        //console.log("Status:", status);
        //console.log("Sector:", sector);

        $.ajax({
          url: 'controller/updateReport.php',
          method: 'GET',
          data: {
            status: status,
            sector: sector, // Include the sector in the request
            bidtype: bidtype, // Include the bidtype in the request
            ppline: ppline,
            monthYear: monthYear, // Include the monthYear in the request
            solutionn: solutionn, // Include the solution in the request
            year: year,
            startDate: startDate,
            endDate: endDate
          },
          dataType: 'json', // Assuming your response is in JSON format
          success: function(response) {
            //console.log("Fetched Data:", response); // Debug

            // Assume the response contains totalBids and totalRevenue arrays
            const totalBids = response.totalBids; // Update this line based on your actual response structure
            const totalRevenue = response.totalRevenue; // Update this line based on your actual response structure
            const months = response.months;

            // Update the ECharts option with new data
            reportsChart.setOption({
              xAxis: {
                data: months // Update the xAxis data with the new months
              },
              series: [{
                  name: 'Number of Bids',
                  data: totalBids.map(val => parseInt(val)), // Ensure bids are integers
                },
                {
                  name: 'Total Bids Revenue',
                  data: totalRevenue,
                }
              ]
            });
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
      }

      function fetchBidPipelineData(status, sector, bidtype, ppline, monthYear, solutionn, year, startDate, endDate) {
        // Set sector to an empty string if it is null
        if (sector === null) {
          sector = ''; // Convert null to an empty string
        }
        // Set bidtype to an empty string if it is null
        if (bidtype === null) {
          bidtype = ''; // Convert null to an empty string
        }
        // Set pipeline to an empty string if it is null
        if (ppline === null) {
          ppline = ''; // Convert null to an empty string
        }
        // Set monthYear to an empty string if it is null
        if (monthYear === null) {
          monthYear = ''; // Convert null to an empty string
        }
        // Set solution to an empty string if it is null
        if (solutionn === null) {
          solutionn = ''; // Convert null to an empty string
        }
        $.ajax({
          url: 'controller/updatebidType.php',
          method: 'GET',
          data: {
            status: status,
            sector: sector, // Include the sector in the request
            bidtype: bidtype, // Include the bidtype in the request
            ppline: ppline,
            monthYear: monthYear, // Include the monthYear in the request
            solutionn: solutionn, // Include the solution in the request
            year: year,
            startDate: startDate,
            endDate: endDate
          },
          dataType: 'json',
          success: function(response) {
            // console.log("Fetched Data:", response); // Debug

            // Format data for Bid Types Bar Chart from the fetched response
            const bidTypesData = [
              parseInt(response.bidTypesCounts['RFQ'] || 0),
              parseInt(response.bidTypesCounts['Tender'] || 0),
              parseInt(response.bidTypesCounts['Quotation'] || 0),
              parseInt(response.bidTypesCounts['RFP'] || 0),
              parseInt(response.bidTypesCounts['RFI'] || 0),
              parseInt(response.bidTypesCounts['Upstream'] || 0),
              parseInt(response.bidTypesCounts['Strategic Proposal'] || 0),
              parseInt(response.bidTypesCounts['Strategic Initiative'] || 0)
            ];

            // Update Bid Types Bar Chart
            bidTypesBarChart.setOption({
              series: [{
                data: bidTypesData
              }]
            });

            // Format data for Pipelines Bar Chart from the fetched response
            const pipelinesData = [
              parseInt(response.pipelineCounts['Unknown'] || 0),
              parseInt(response.pipelineCounts['Loss'] || 0),
              parseInt(response.pipelineCounts['Close'] || 0),
              parseInt(response.pipelineCounts['KIV'] || 0),
              parseInt(response.pipelineCounts['Intro'] || 0),
              parseInt(response.pipelineCounts['Clarification'] || 0)
            ];

            // Update Pipelines Bar Chart
            pipelinesBarChart.setOption({
              series: [{
                data: pipelinesData
              }]
            });
            //console.log("Bid Types Data:", bidTypesData);
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
      }

      function fetchSumSolution(status, sector, bidtype, ppline, monthYear, solutionn, year, startDate, endDate) {

        if (sector === null) {
          sector = ''; // Convert null to an empty string
        }

        // Set bidtype to an empty string if it is null
        if (bidtype === null) {
          bidtype = ''; // Convert null to an empty string
        }

        // Set pipeline to an empty string if it is null
        if (ppline === null) {
          ppline = ''; // Convert null to an empty string
        }

        // Set monthYear to an empty string if it is null
        if (monthYear === null) {
          monthYear = ''; // Convert null to an empty string
        }

        // Set solution to an empty string if it is null
        if (solutionn === null) {
          solutionn = ''; // Convert null to an empty string
        }


        $.ajax({
          url: 'controller/updateSumSolution.php',
          method: 'GET',
          data: {
            status: status,
            sector: sector, // Include sector in the request
            bidtype: bidtype,
            ppline: ppline,
            monthYear: monthYear, // Include the monthYear in the request
            solutionn: solutionn, // Include the solution in the request
            year: year,
            startDate: startDate,
            endDate: endDate
          },
          dataType: 'json',
          success: function(response) {
            // console.log("Fetched Data:", response); debug

            // Update the chart's data with the response values
            barSumChart.data.datasets[0].data = [
              response.PaduNet || 0, // Use fallback value of 0 if response is undefined
              response.SecureX || 0,
              response.AwanHeiTech || 0,
              response.iSentrix || 0,
              response.MixSolution || 0
            ];

            // Refresh the chart to reflect the new data
            barSumChart.update();
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
      }
      // Function to fetch InfraSolution data
      function fetchInfraSolution(status, sector, bidtype, ppline, monthYear, solutionn, year, startDate, endDate) {

        if (sector === null) {
          sector = ''; // Convert null to an empty string
        }

        // Set bidtype to an empty string if it is null
        if (bidtype === null) {
          bidtype = ''; // Convert null to an empty string
        }

        // Set pipeline to an empty string if it is null
        if (ppline === null) {
          ppline = ''; // Convert null to an empty string
        }

        // Set monthYear to an empty string if it is null
        if (monthYear === null) {
          monthYear = ''; // Convert null to an empty string
        }

        // Set solution to an empty string if it is null
        if (solutionn === null) {
          solutionn = ''; // Convert null to an empty string
        }

        //console.log("Sector", solutionn); 

        $.ajax({
          url: 'controller/updateInfraSolution.php',
          method: 'GET',
          data: {
            status: status,
            sector: sector,
            bidtype: bidtype, // Include the bidtype in the request
            ppline: ppline,
            monthYear: monthYear, // Include the monthYear in the request
            solutionn: solutionn, // Include the solution in the request
            year: year,
            startDate: startDate,
            endDate: endDate
          },
          dataType: 'json',
          success: function(response) {
            //console.log("Infra Solution:", response);

            // Extract solution counts from the response
             // Extract solution counts from the response
      var solutionCounts = response.solutionBusinessUnitCounts;

      // Prepare datasets for the chart, with summed values for MixSolution
      const datasets = [{
          label: "Channel",
          data: [
            solutionCounts['PaduNet']['Channel'],
            solutionCounts['SecureX']['Channel'],
            solutionCounts['AwanHeiTech']['Channel'],
            solutionCounts['iSentrix']['Channel'],
            // Sum of each sub-solution within MixSolution for "Channel"
            solutionCounts['MixSolution']['Channel']['AwanHeiTech'] +
            solutionCounts['MixSolution']['Channel']['SecureX'] +
            solutionCounts['MixSolution']['Channel']['PaduNet'] +
            solutionCounts['MixSolution']['Channel']['iSentrix']
          ],
          backgroundColor: "#6CC3DF"
        },
        {
          label: "IMG",
          data: [
            solutionCounts['PaduNet']['IMG'],
            solutionCounts['SecureX']['IMG'],
            solutionCounts['AwanHeiTech']['IMG'],
            solutionCounts['iSentrix']['IMG'],
            // Sum of each sub-solution within MixSolution for "IMG"
            solutionCounts['MixSolution']['IMG']['AwanHeiTech'] +
            solutionCounts['MixSolution']['IMG']['SecureX'] +
            solutionCounts['MixSolution']['IMG']['PaduNet'] +
            solutionCounts['MixSolution']['IMG']['iSentrix']
          ],
          backgroundColor: "#FF6B6B"
        },
        {
          label: "NMG",
          data: [
            solutionCounts['PaduNet']['NMG'],
            solutionCounts['SecureX']['NMG'],
            solutionCounts['AwanHeiTech']['NMG'],
            solutionCounts['iSentrix']['NMG'],
            // Sum of each sub-solution within MixSolution for "NMG"
            solutionCounts['MixSolution']['NMG']['AwanHeiTech'] +
            solutionCounts['MixSolution']['NMG']['SecureX'] +
            solutionCounts['MixSolution']['NMG']['PaduNet'] +
            solutionCounts['MixSolution']['NMG']['iSentrix']
          ],
          backgroundColor: "#F9D266"
        },
        {
          label: "TMG (Private Sector)",
          data: [
            solutionCounts['PaduNet']['TMG (Private Sector)'],
            solutionCounts['SecureX']['TMG (Private Sector)'],
            solutionCounts['AwanHeiTech']['TMG (Private Sector)'],
            solutionCounts['iSentrix']['TMG (Private Sector)'],
            // Sum of each sub-solution within MixSolution for "TMG (Private Sector)"
            solutionCounts['MixSolution']['TMG (Private Sector)']['AwanHeiTech'] +
            solutionCounts['MixSolution']['TMG (Private Sector)']['SecureX'] +
            solutionCounts['MixSolution']['TMG (Private Sector)']['PaduNet'] +
            solutionCounts['MixSolution']['TMG (Private Sector)']['iSentrix']
          ],
          backgroundColor: "#4668E6"
        },
        {
          label: "TMG (Public Sector)",
          data: [
            solutionCounts['PaduNet']['TMG (Public Sector)'],
            solutionCounts['SecureX']['TMG (Public Sector)'],
            solutionCounts['AwanHeiTech']['TMG (Public Sector)'],
            solutionCounts['iSentrix']['TMG (Public Sector)'],
            // Sum of each sub-solution within MixSolution for "TMG (Public Sector)"
            solutionCounts['MixSolution']['TMG (Public Sector)']['AwanHeiTech'] +
            solutionCounts['MixSolution']['TMG (Public Sector)']['SecureX'] +
            solutionCounts['MixSolution']['TMG (Public Sector)']['PaduNet'] +
            solutionCounts['MixSolution']['TMG (Public Sector)']['iSentrix']
          ],
          backgroundColor: "#7EC968"
        }
      ];

      // Update the chart with the new datasets
      stackedBarChart.data.datasets = datasets;
      stackedBarChart.update(); // Refresh the chart to display the new data
    },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
          }
        });
      }

      function animateValue(element, start, end, duration, format = false) {
        const range = end - start;
        const increment = range / (duration / 10); // Calculate the increment per step
        let current = start;
        const stepTime = Math.abs(Math.floor(duration / range));

        // Function to format the number with commas and RM symbol
        function formatNumber(value) {
          return format ? 'RM ' + value.toLocaleString() : value.toLocaleString(); // Format with 'RM' and thousand separator
        }

        function step() {
          current += increment;
          if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            current = end; // Stop when target is reached
          }
          element.text(formatNumber(Math.floor(current))); // Update element with formatted value
          if (current !== end) {
            requestAnimationFrame(step); // Continue the animation until target is reached
          }
        }
        requestAnimationFrame(step);
      }

      function fetchStatus(status, sector, bidtype, ppline, monthYear, solutionn, year, startDate, endDate) {

        if (sector === null) {
          sector = ''; // Convert null to an empty string
        }

        // Set bidtype to an empty string if it is null
        if (bidtype === null) {
          bidtype = ''; // Convert null to an empty string
        }

        // Set pipeline to an empty string if it is null
        if (ppline === null) {
          ppline = ''; // Convert null to an empty string
        }

        // Set monthYear to an empty string if it is null
        if (monthYear === null) {
          monthYear = ''; // Convert null to an empty string
        }

        // Set solution to an empty string if it is null
        if (solutionn === null) {
          solutionn = ''; // Convert null to an empty string
        }

        $.ajax({
          url: 'controller/updateStatus.php', // path
          method: 'GET',
          data: {
            status: status,
            sector: sector,
            bidtype: bidtype, // Include the bidtype in the request
            ppline: ppline,
            monthYear: monthYear,
            solutionn: solutionn, // Include the solution in the request
            year: year,
            startDate: startDate,
            endDate: endDate
          },
          success: function(response) {
            //console.log("Total Bids and Money:", response);
            // Get new values from response
            const newTotalBids = parseInt($(response).filter('#totalBids').text().replace(/[^0-9]/g, ''), 10);
            const newTotalRevenue = parseInt($(response).filter('#totalRevenue').text().replace(/[^0-9]/g, ''), 10);

            // Get current values (ensure they're formatted correctly)
            const currentTotalBids = parseInt($('#totalBids').text().replace(/[^0-9]/g, ''), 10);
            const currentTotalRevenue = parseInt($('#totalRevenue').text().replace(/[^0-9]/g, ''), 10);

            // Animate Total Bids with a simple animation (no currency format)
            animateValue($('#totalBids'), currentTotalBids, newTotalBids, 1000); // 1000ms duration

            // Animate Total Bids Revenue with the formatted value
            animateValue($('#totalRevenue'), currentTotalRevenue, newTotalRevenue, 1000, true); // 1000ms duration with formatting
          },
          error: function(xhr, status, error) {
            console.error('Error fetching filtered data:', error);
          }
        });
      }

      function fetchBidStatus(status, sector, bidtype, ppline, monthYear, solutionn, year, startDate, endDate) {
        if (sector === null) sector = '';
        if (bidtype === null) bidtype = '';
        if (ppline === null) ppline = '';
        if (monthYear === null) monthYear = '';
        if (solutionn === null) solutionn = '';

        $.ajax({
          url: 'controller/updateBidStatus.php',
          method: 'GET',
          data: {
            status: status,
            sector: sector,
            bidtype: bidtype,
            ppline: ppline,
            monthYear: monthYear,
            solutionn: solutionn,
            year: year,
            startDate: startDate,
            endDate: endDate
          },
          success: function(response) {
            //console.log("Status:", response); // This will be a JSON object

            const newWIP = parseInt(response.WIP, 10);
            const newSubmitted = parseInt(response.Submitted, 10);
            const newDropped = parseInt(response.Dropped, 10);

            // Get current values (ensure they're formatted correctly)
            const currentWIP = parseInt($('#totalWIP').text().replace(/[^0-9]/g, ''), 10);
            const currentSubmitted = parseInt($('#totalSubmitted').text().replace(/[^0-9]/g, ''), 10);
            const currentDropped = parseInt($('#totalDropped').text().replace(/[^0-9]/g, ''), 10);

            // Animate WIP
            animateValue($('#totalWIP'), currentWIP, newWIP, 1000); // 1000ms duration

            // Animate Submitted
            animateValue($('#totalSubmitted'), currentSubmitted, newSubmitted, 1000); // 1000ms duration

            // Animate Dropped
            animateValue($('#totalDropped'), currentDropped, newDropped, 1000); // 1000ms duration
        },
          error: function(xhr, status, error) {
            console.error('Error fetching filtered data:', error);
          }
        });
      }


    });
  </script>

  <script>
    window.onload = function() {
      // Check for success login session
      <?php if (isset($_SESSION['login_success'])): ?>
        const greetingModal = new bootstrap.Modal(document.getElementById('greetingModal'));

        // Get the current time
        let currentHour = new Date().getHours();
        let greetingMessage = '';
        let svgIcon = '';

        // Determine the greeting based on the time
        if (currentHour < 12) {
          greetingMessage = 'Good Morning';
          svgIcon = `<svg class="sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <circle cx="12" cy="12" r="5" fill="#FFD700"/>
                              <g stroke="#FFD700" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="4"/>
                                <line x1="12" y1="20" x2="12" y2="23"/>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                                <line x1="1" y1="12" x2="4" y2="12"/>
                                <line x1="20" y1="12" x2="23" y2="12"/>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                              </g>
                            </svg>`;
        } else if (currentHour >= 12 && currentHour < 17) {
          greetingMessage = 'Good Afternoon';
          svgIcon = `<svg class="cloud-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <circle cx="6" cy="6" r="4" fill="#FFD700"/>
                              <path d="M17 16a5 5 0 1 0-8 4H4a4 4 0 1 1 0-8c0-.3.02-.59.07-.88A6 6 0 1 1 17 16z" fill="#B0C4DE"/>
                            </svg>`;
        } else {
          greetingMessage = 'Good Evening';
          svgIcon = `<svg class="moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 1 0 9.79 9.79z" fill="#B0C4DE"/>
                            </svg>`;
        }

        // Display the greeting message and SVG icon
        document.getElementById('greetingMessage').textContent = greetingMessage;
        document.getElementById('greetingIcon').innerHTML = svgIcon;

        // Show the modal
        greetingModal.show();

        <?php unset($_SESSION['login_success']); // Clear the session variable to prevent the modal from showing again 
        ?>
      <?php endif; ?>
    };
  </script>

</body>

</html>