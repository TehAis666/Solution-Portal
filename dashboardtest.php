<?php
include_once 'controller/calculateSumSolution.php';
include_once 'controller/calculateMarketSector.php';
include_once 'controller/calculateInfraSolution.php';
include_once 'controller/calculatebidType.php';
include_once 'controller/calculatereport.php';
include_once 'controller/viewStatus.php';

// Convert the counts to a JSON string for JavaScript
$bidCountsJson = json_encode($bidCounts);

// Convert the counts array to a JSON string
$solutionCountsJson = json_encode($solutionBusinessUnitCounts);

// Debugging: Check JSON outputs
echo $monthsJson; // Temporary debug statement
echo $totalBidsJson; // Temporary debug statement
echo $totalRevenueJson; // Temporary debug statement
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
</head>

<body>

  <?php include 'layouts/navbar.php' ?>
  <?php include 'layouts/sidebar.php' ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Bid Management Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <!-- Bids Card -->
            <div class="col">
              <div class="card info-card sales-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul
                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">Month</a></li>
                    <li><a class="dropdown-item" href="#">Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Total Bids <span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <div
                      class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $totalBids; ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col">
              <div class="card info-card revenue-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul
                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">Month</a></li>
                    <li><a class="dropdown-item" href="#">Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">
                    Total Bids Revenue <span>| Month</span>
                  </h5>

                  <div class="d-flex align-items-center">
                    <div
                      class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>RM <?php echo number_format($totalRevenue, 0); ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Revenue Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card" style="padding: 10px">
                <div class="filter">
                  <a
                    class="icon"
                    href="#"
                    data-bs-toggle="dropdown"
                    style="font-size: 12px">
                    <i class="bi bi-three-dots"></i>
                  </a>
                  <ul
                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6 style="font-size: 12px">Filter</h6>
                    </li>
                    <li>
                      <a
                        class="dropdown-item"
                        href="#"
                        style="font-size: 12px">Today</a>
                    </li>
                    <li>
                      <a
                        class="dropdown-item"
                        href="#"
                        style="font-size: 12px">Month</a>
                    </li>
                    <li>
                      <a
                        class="dropdown-item"
                        href="#"
                        style="font-size: 12px">Year</a>
                    </li>
                  </ul>
                </div>

                <div class="card-body" style="padding: 10px">
                  <h5 class="card-title" style="font-size: 14px">
                    Total Bids <span style="font-size: 12px">/ Month</span>
                  </h5>

                  <!-- Line Chart -->
                  <div id="reportsChart" style="height: 250px"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      // Get the JSON-encoded data from PHP
                      var months = <?php echo $monthsJson; ?>;
                      var totalBids = <?php echo $totalBidsJson; ?>;
                      var totalRevenue = <?php echo $totalRevenueJson; ?>;

                      // Line chart using ApexCharts
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                            name: "Number of Bids",
                            data: totalBids.map(function(val) {
                              return parseInt(val);
                            }), // Ensure bids are integers
                            type: "area",
                          },
                          {
                            name: "Total Revenue of Bids",
                            data: totalRevenue,
                            type: "line",
                          },
                        ],
                        chart: {
                          height: 250,
                          type: "line",
                          toolbar: {
                            show: false,
                          },
                        },
                        markers: {
                          size: 4, // Smaller markers
                        },
                        stroke: {
                          curve: "smooth",
                          width: 2, // Thinner lines
                          dashArray: [0, 5], // Solid line for bids, dashed for revenue
                        },
                        colors: ["#4154f1", "#ff771d"], // Blue for bids, orange for revenue
                        xaxis: {
                          categories: months, // Month names
                        },
                        yaxis: [{
                            title: {
                              text: "Number of Bids",
                            },
                            min: 0,
                            tickAmount: 5, // Adjusted for better visualization
                            labels: {
                              formatter: function(val) {
                                return parseInt(val); // Convert to integer
                              }
                            }
                          },
                          {
                            opposite: true, // Show revenue axis on the right
                            title: {
                              text: "Total Revenue (Mil)",
                            },
                            min: 0,
                            tickAmount: 5, // Adjusted to suit the revenue scale
                            labels: {
                              formatter: function(val) {
                                if (val >= 1) {
                                  return val + "M"; // If 1 million or more, append 'M'
                                } else {
                                  return (val * 1000) + "K"; // If less than 1 million, show in 'K'
                                }
                              }
                            }
                          },
                        ],
                        tooltip: {
                          x: {
                            format: "MMMM", // Format the month
                          },
                          y: {
                            formatter: function(val, opts) {
                              if (opts.seriesIndex === 1) { // For the revenue series
                                if (val >= 1) {
                                  return val + "M"; // If 1 million or more, append 'M'
                                } else {
                                  return (val * 1000) + "K"; // If less than 1 million, show in 'K'
                                }
                              } else {
                                return val; // Return number of bids as is
                              }
                            }
                          }
                        },
                        fill: {
                          type: "solid",
                          opacity: [0.3, 1], // Reduced opacity for area
                        },
                      }).render();
                    });
                  </script>


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
                <div class="filter">
                  <a
                    class="icon"
                    href="#"
                    data-bs-toggle="dropdown"
                    style="font-size: 12px">
                    <i class="bi bi-three-dots"></i>
                  </a>
                  <ul
                    class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6 style="font-size: 12px">Filter</h6>
                    </li>
                    <li>
                      <a
                        class="dropdown-item"
                        href="#"
                        style="font-size: 12px">Today</a>
                    </li>
                    <li>
                      <a
                        class="dropdown-item"
                        href="#"
                        style="font-size: 12px">Month</a>
                    </li>
                    <li>
                      <a
                        class="dropdown-item"
                        href="#"
                        style="font-size: 12px">Year</a>
                    </li>
                  </ul>
                </div>

                <div class="card-body" style="padding: 10px">
                  <h5 class="card-title" style="font-size: 14px">
                    Infra Solution
                    <span style="font-size: 12px">| Today</span>
                  </h5>

                  <!-- Stacked Bar Chart -->
                  <canvas id="stakedBarChart" style="max-height: 280px"></canvas>
                  <script>
                    // Get the JSON-encoded data from PHP
                    var solutionCounts = <?php echo $solutionCountsJson; ?>;

                    // Labels for the chart
                    var labels = ["PaduNet", "Secure-X", "AwanHeiTech", "i-Sentrix", "Mix Solution"];

                    // Prepare dataset for the stacked bar chart
                    var datasets = [{
                        label: "Channel",
                        data: [
                          solutionCounts['PaduNet']['Channel'],
                          solutionCounts['SecureX']['Channel'],
                          solutionCounts['AwanHeiTech']['Channel'],
                          solutionCounts['iSentrix']['Channel'],
                          solutionCounts['MixSolution']['Channel']
                        ],
                        backgroundColor: "#6CC3DF" // Color for Channel
                      },
                      {
                        label: "IMG",
                        data: [
                          solutionCounts['PaduNet']['IMG'],
                          solutionCounts['SecureX']['IMG'],
                          solutionCounts['AwanHeiTech']['IMG'],
                          solutionCounts['iSentrix']['IMG'],
                          solutionCounts['MixSolution']['IMG']
                        ],
                        backgroundColor: "#FF6B6B" // Color for IMG
                      },
                      {
                        label: "NMG",
                        data: [
                          solutionCounts['PaduNet']['NMG'],
                          solutionCounts['SecureX']['NMG'],
                          solutionCounts['AwanHeiTech']['NMG'],
                          solutionCounts['iSentrix']['NMG'],
                          solutionCounts['MixSolution']['NMG']
                        ],
                        backgroundColor: "#F9D266" // Color for NMG
                      },
                      {
                        label: "TMG (Private Sector)",
                        data: [
                          solutionCounts['PaduNet']['TMG (Private Sector)'],
                          solutionCounts['SecureX']['TMG (Private Sector)'],
                          solutionCounts['AwanHeiTech']['TMG (Private Sector)'],
                          solutionCounts['iSentrix']['TMG (Private Sector)'],
                          solutionCounts['MixSolution']['TMG (Private Sector)']
                        ],
                        backgroundColor: "#4668E6" // Color for TMG (Private Sector)
                      },
                      {
                        label: "TMG (Public Sector)",
                        data: [
                          solutionCounts['PaduNet']['TMG (Public Sector)'],
                          solutionCounts['SecureX']['TMG (Public Sector)'],
                          solutionCounts['AwanHeiTech']['TMG (Public Sector)'],
                          solutionCounts['iSentrix']['TMG (Public Sector)'],
                          solutionCounts['MixSolution']['TMG (Public Sector)']
                        ],
                        backgroundColor: "#7EC968" // Color for TMG (Public Sector)
                      }
                    ];

                    // Code to generate the chart
                    document.addEventListener("DOMContentLoaded", () => {
                      new Chart(document.querySelector("#stakedBarChart"), {
                        type: "bar",
                        data: {
                          labels: labels, // Labels for the solutions
                          datasets: datasets // Data for each business sector per solution
                        },
                        options: {
                          plugins: {
                            title: {
                              display: false, // Hiding the chart title to save space
                            },
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
                    });
                  </script>
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
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6 style="font-size: 12px">Filter</h6>
                </li>
                <li>
                  <a class="dropdown-item" href="#" style="font-size: 12px">Today</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#" style="font-size: 12px">Month</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#" style="font-size: 12px">Year</a>
                </li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title" style="font-size: 14px">
                Status <span style="font-size: 12px">| Today</span>
              </h5>

              <table class="table tables-general" style="font-size: 12px">
                <thead>
                  <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Total of Bids</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>WIP</td>
                    <td><?php echo $statusData['WIP']; ?></td>
                  </tr>
                  <tr>
                    <td>Submitted</td>
                    <td><?php echo $statusData['Submitted']; ?></td>
                  </tr>
                  <tr>
                    <td>Dropped</td>
                    <td><?php echo $statusData['Dropped']; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- End Status Columns -->

          <!-- Start Bids Sector -->

          <div class="card" style="max-width: 600px">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">Month</a></li>
                <li><a class="dropdown-item" href="#">Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title" style="font-size: 14px">
                Bids By Market Sector
                <span style="font-size: 12px">| Today</span>
              </h5>

              <div
                id="sectorChart"
                style="min-height: 250px"
                class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  // Parse the PHP variable directly into a JavaScript variable
                  const bidCounts = <?php echo $bidCountsJson; ?>;

                  var pieChart = echarts.init(document.querySelector("#sectorChart"));

                  var pieOption = {
                    tooltip: {
                      trigger: "item",
                    },
                    legend: {
                      top: "5%",
                      left: "center",
                      itemGap: 5,
                      textStyle: {
                        fontSize: 10,
                      },
                    },
                    series: [{
                      name: "Bids",
                      type: "pie",
                      radius: ["30%", "60%"],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: "center",
                      },
                      emphasis: {
                        itemStyle: {
                          shadowBlur: 10,
                          shadowOffsetX: 0,
                          shadowColor: "rgba(0, 0, 0, 0.5)",
                        },
                        label: {
                          show: true,
                          fontSize: "14",
                          fontWeight: "bold",
                        },
                      },
                      labelLine: {
                        show: false,
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
                    }, ],
                  };

                  // Track the last clicked sector
                  let lastClickedSector = null;

                  // Set initial chart options
                  pieChart.setOption(pieOption);
                  barChart.setOption(barOption);

                  // Add click event to pie chart
                  pieChart.on("click", function(params) {
                    var sectorName = params.name; // Get the clicked sector's name

                    // Toggle between hiding others and resetting all datasets
                    if (lastClickedSector === sectorName) {
                      resetStackedBarChart(); // Reset stacked bar chart
                      resetHorizontalBarChart(); // Reset horizontal bar chart
                      resetPieChart(); // Reset pie chart
                      lastClickedSector = null; // Clear the last clicked sector
                    } else {
                      updateStackedBarChart(sectorName); // Show only the clicked sector in stacked bar chart
                      updateHorizontalBarChart(sectorName); // Highlight corresponding sector in horizontal bar chart
                      updatePieChart(sectorName); // Highlight corresponding sector in pie chart
                      lastClickedSector = sectorName; // Set the last clicked sector
                    }
                  });

                  // Function to show only the dataset that corresponds to the clicked sector in stacked bar chart
                  function updateStackedBarChart(sectorName) {
                    const chart = Chart.getChart("stakedBarChart"); // Get the stacked bar chart instance

                    // Update the visibility of each dataset in the stacked bar chart
                    chart.data.datasets.forEach(function(dataset) {
                      dataset.hidden = dataset.label !== sectorName; // Show only the clicked sector
                    });

                    // Re-render the chart to reflect changes
                    chart.update();
                  }

                  // Function to reset the stacked bar chart to show all datasets
                  function resetStackedBarChart() {
                    const chart = Chart.getChart("stakedBarChart"); // Get the stacked bar chart instance

                    // Reset the visibility of all datasets to show them all
                    chart.data.datasets.forEach(function(dataset) {
                      dataset.hidden = false;
                    });

                    // Re-render the chart to reflect changes
                    chart.update();
                  }

                  // Function to update horizontal bar chart by highlighting the clicked sector
                  function updateHorizontalBarChart(sectorName) {
                    // Update the bar chart's itemStyle to highlight only the selected sector
                    barOption.series[0].itemStyle = {
                      color: function(param) {
                        return param.name === sectorName ?
                          "#FF0000" :
                          "#3398DB"; // Red for the highlighted sector, blue for others
                      },
                    };

                    // Update the series label to show the value for the clicked sector
                    barOption.series[0].label = {
                      show: true,
                      formatter: function(param) {
                        return param.name === sectorName ? param.value : ""; // Show value only for the clicked sector
                      },
                    };

                    // Refresh the horizontal bar chart
                    barChart.setOption(barOption);
                  }

                  // Function to reset the horizontal bar chart to its default state
                  function resetHorizontalBarChart() {
                    // Reset the horizontal bar chart's itemStyle to default colors for all sectors
                    barOption.series[0].itemStyle = {
                      color: "#3398DB", // Reset color to blue for all bars
                    };

                    // Hide the labels for all sectors again
                    barOption.series[0].label = {
                      show: false,
                    };

                    // Refresh the horizontal bar chart
                    barChart.setOption(barOption);
                  }

                  // Function to highlight only the clicked sector in the pie chart
                  function updatePieChart(sectorName) {
                    // Update the pie chart's data to hide other sectors
                    pieOption.series[0].data.forEach(function(item) {
                      item.itemStyle = {
                        opacity: item.name === sectorName ? 1 : 0.2, // Highlight clicked sector, fade others
                      };
                    });

                    // Refresh the pie chart to reflect changes
                    pieChart.setOption(pieOption);
                  }

                  // Function to reset the pie chart to its default state
                  function resetPieChart() {
                    // Reset the pie chart's data to show all sectors
                    pieOption.series[0].data.forEach(function(item) {
                      item.itemStyle = {
                        opacity: 1, // Reset opacity for all sectors
                      };
                    });

                    // Refresh the pie chart to reflect changes
                    pieChart.setOption(pieOption);
                  }
                });
              </script>
            </div>
          </div>
          <!-- End Bid Sector Column -->

          <!-- Sector Chart Section -->
          <div class="card" style="max-width: 600px">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <!-- Sector Bar Chart -->
              <div
                id="horizontalBarChart"
                style="min-height: 200px"
                class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {

                  // Use PHP to inject the bidCounts directly into JavaScript
                  var bidCountsJson = {
                    "TMG (Private Sector)": <?php echo $bidCounts["TMG (Private Sector)"]; ?>,
                    "TMG (Public Sector)": <?php echo $bidCounts["TMG (Public Sector)"]; ?>,
                    "NMG": <?php echo $bidCounts["NMG"]; ?>,
                    "IMG": <?php echo $bidCounts["IMG"]; ?>,
                    "Channel": <?php echo $bidCounts["Channel"]; ?>
                  };

                  // Convert the bidCountsJson values to an array
                  var bidCountsArray = [
                    bidCountsJson["TMG (Private Sector)"],
                    bidCountsJson["TMG (Public Sector)"],
                    bidCountsJson["NMG"],
                    bidCountsJson["IMG"],
                    bidCountsJson["Channel"]
                  ];

                  // Initialize horizontal bar chart
                  var barChart = echarts.init(document.querySelector("#horizontalBarChart"));
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
                      },
                    },
                    yAxis: {
                      type: "category",
                      data: [
                        "TMG (Private Sector)",
                        "TMG (Public Sector)",
                        "NMG",
                        "IMG",
                        "Channel"
                      ],
                      axisLabel: {
                        fontSize: 10
                      },
                    },
                    series: [{
                      name: "Bids",
                      type: "bar",
                      data: bidCountsArray, // Use bidCountsArray here
                      barWidth: "40%",
                      itemStyle: {
                        color: "#3398DB"
                      },
                      label: {
                        show: false, // Initially hide the labels
                        position: "insideRight",
                        fontSize: 12,
                        fontWeight: "bold",
                      },
                    }, ],
                  };
                  barChart.setOption(barOption);

                  // Track the last clicked sector
                  let lastClickedSector = null;

                  // Add click event to pie chart
                  pieChart.on("click", function(params) {
                    var sectorName = params.name; // Get the clicked sector's name
                    handleSectorClick(sectorName);
                  });

                  // Add click event to horizontal bar chart
                  barChart.on("click", function(params) {
                    var sectorName = params.name; // Get the clicked sector's name
                    handleSectorClick(sectorName);
                  });

                  function handleSectorClick(sectorName) {
                    // Toggle between hiding others and resetting all datasets
                    if (lastClickedSector === sectorName) {
                      resetCharts(); // Reset all charts
                      lastClickedSector = null; // Clear the last clicked sector
                    } else {
                      updateCharts(sectorName); // Update all charts to reflect the clicked sector
                      lastClickedSector = sectorName; // Set the last clicked sector
                    }
                  }

                  // Function to update all charts by highlighting the clicked sector
                  function updateCharts(sectorName) {
                    updatePieChart(sectorName);
                    updateHorizontalBarChart(sectorName);
                    updateStackedBarChart(sectorName);
                  }

                  // Function to update pie chart by highlighting the clicked sector
                  function updatePieChart(sectorName) {
                    pieOption.series[0].data.forEach(function(item) {
                      item.itemStyle = {
                        opacity: item.name === sectorName ? 1 : 0.2, // Highlight clicked sector, fade others
                      };
                    });
                    pieChart.setOption(pieOption);
                  }

                  // Function to reset the pie chart to its default state
                  function resetPieChart() {
                    pieOption.series[0].data.forEach(function(item) {
                      item.itemStyle = {
                        opacity: 1
                      }; // Reset opacity for all sectors
                    });
                    pieChart.setOption(pieOption);
                  }

                  // Function to update horizontal bar chart by highlighting the clicked sector
                  function updateHorizontalBarChart(sectorName) {
                    // Update the bar chart's itemStyle to highlight only the selected sector
                    barOption.series[0].itemStyle = {
                      color: function(param) {
                        return param.name === sectorName ? "#FF0000" : "#3398DB"; // Red for the highlighted sector, blue for others
                      },
                    };

                    // Update the series label to show the value for the clicked sector
                    barOption.series[0].label = {
                      show: true,
                      formatter: function(param) {
                        return param.name === sectorName ? param.value : ""; // Show value only for the clicked sector
                      },
                    };

                    // Refresh the horizontal bar chart
                    barChart.setOption(barOption);
                  }

                  // Function to reset the horizontal bar chart to its default state
                  function resetHorizontalBarChart() {
                    barOption.series[0].itemStyle = {
                      color: "#3398DB"
                    }; // Reset color to blue for all bars
                    barOption.series[0].label = {
                      show: false
                    }; // Hide the labels for all sectors again
                    barChart.setOption(barOption);
                  }

                  // Function to show only the dataset that corresponds to the clicked sector in stacked bar chart
                  function updateStackedBarChart(sectorName) {
                    const chart = Chart.getChart("stakedBarChart"); // Get the stacked bar chart instance

                    // Update the visibility of each dataset in the stacked bar chart
                    chart.data.datasets.forEach(function(dataset) {
                      dataset.hidden = dataset.label !== sectorName; // Show only the clicked sector
                    });

                    // Re-render the chart to reflect changes
                    chart.update();
                  }

                  // Function to reset the stacked bar chart to show all datasets
                  function resetStackedBarChart() {
                    const chart = Chart.getChart("stakedBarChart"); // Get the stacked bar chart instance

                    // Reset the visibility of all datasets to show them all
                    chart.data.datasets.forEach(function(dataset) {
                      dataset.hidden = false;
                    });

                    // Re-render the chart to reflect changes
                    chart.update();
                  }

                  // Function to reset all charts to their default state
                  function resetCharts() {
                    resetPieChart();
                    resetHorizontalBarChart();
                    resetStackedBarChart();
                  }
                });
              </script>
            </div>
          </div>
          <!-- End Sector Chart Section -->

          <!-- Company Total Section -->
          <div class="card" style="max-width: 600px">
            <!-- Increased width for better spacing -->
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <!-- Bar Chart -->
              <canvas id="barChart" style="max-height: 400px"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector("#barChart"), {
                    type: "bar",
                    data: {
                      labels: ["Mix Solution", "PaduNet", "Secure-X", "AwanHeiTech", "i-Sentrix"], // Labels
                      datasets: [{
                        label: "Bid Value", // Chart label
                        data: [
                          <?php echo $mixSolutionTotal; ?>, // Mix Solution
                          <?php echo $paduNetTotal; ?>, // PaduNet
                          <?php echo $secureXTotal; ?>, // Secure-X
                          <?php echo $awanHeiTechTotal; ?>, // AwanHeiTech
                          <?php echo $iSentrixTotal; ?> // i-Sentrix
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
                            // Dynamically format y-axis labels
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
                });
              </script>
              <!-- End Bar Chart -->
            </div>
          </div>
          <!-- End Company Total Section -->
        </div>
        <!-- End Right side columns -->
      </div>

      <!-- Responsive Bid Types and Pipelines -->
      <div class="card top-selling overflow-auto">
        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div>

        <div class="card-body pb-0">
          <h5 class="card-title">
            Bid Types and Pipelines <span>| Today</span>
          </h5>

          <!-- Responsive container for Bid Types and Pipelines Bar Charts -->
          <div class="chart-container">
            <!-- Bid Types Bar Chart -->
            <div id="bidTypesBarChart"></div>

            <!-- Pipelines Bar Chart -->
            <div id="pipelinesBarChart"></div>
          </div>

          <script>
            document.addEventListener("DOMContentLoaded", () => {
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

              // Bid Types Bar Chart
              echarts
                .init(document.querySelector("#bidTypesBarChart"))
                .setOption({
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
                    }
                  },
                  yAxis: {
                    type: "category",
                    data: ["RFQ", "Tender", "Quotation", "RFP", "RFI", "Upstream"],
                    axisLabel: {
                      fontSize: 10
                    },
                  },
                  series: [{
                    name: "Bid Types",
                    type: "bar",
                    data: bidTypesData,
                    color: "#4668E6",
                    barWidth: "50%",
                  }],
                });

              // Data for Pipelines Chart
              var pipelinesData = [
                pipelineCounts['Unknown'],
                pipelineCounts['Loss'],
                pipelineCounts['Close'],
                pipelineCounts['KIV'],
                pipelineCounts['Intro'],
                pipelineCounts['Clarification']
              ];

              // Pipelines Bar Chart
              echarts
                .init(document.querySelector("#pipelinesBarChart"))
                .setOption({
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
                    }
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
            });
          </script>
        </div>
      </div>
      <!-- End Responsive Bid Types and Pipelines -->
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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>