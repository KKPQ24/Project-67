<?php
require '../condb.php';

//   if($_SESSION['Loginsuccess'] != 2 ){
//     header("Location:../index.php");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="./img/Photoroom.png">
  <title>
    DashboardAdmin
  </title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <style>
    .card-footer {
      background-color: #f8f9fa;
      border-top: none;
      padding: 0.75rem;
    }

    .card-footer a {
      font-weight: bold;
      color: #000;
    }

    .card-footer a:hover {
      text-decoration: underline;
    }

    .card-footer svg {
      width: 1em;
      height: 1em;
    }
    .chartjs-tooltip {
      background: rgba(0, 0, 0, 0.8); /* สีพื้นหลังของ tooltip */
      color: #fff; /* สีของข้อความใน tooltip */
      border-radius: 4px; /* มุมของ tooltip */
      padding: 10px; /* การเว้นระยะภายในของ tooltip */
      font-size: 12px; /* ขนาดของข้อความ */
      pointer-events: none; /* ป้องกันไม่ให้ tooltip รับคลิก */
      position: absolute; /* ตำแหน่งของ tooltip */
      transform: translate(-50%, 0); /* การเคลื่อนที่ของ tooltip */
    }
    .chartjs-tooltip::before {
      content: ''; /* สร้างลูกศรที่ปลายของ tooltip */
      position: absolute;
      top: 100%; /* วางลูกศรที่ด้านล่างของ tooltip */
      left: 50%; /* กึ่งกลางด้านล่างของ tooltip */
      margin-left: -5px; /* ขยับลูกศรไปที่กลาง */
      border-width: 5px; /* ขนาดของลูกศร */
      border-style: solid;
      border-color: rgba(0, 0, 0, 0.8) transparent transparent transparent; /* สีของลูกศร */
    }

  </style>
  <?php require 'aside.php'; ?>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <!-- <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
        </nav> -->
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?php echo $_SESSION['name'] ?></span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">คำร้องที่กำลังตรวจสอบ</p>
                    <h5 class="font-weight-bolder">
                      <?php
                      $result = $conn->query("SELECT COUNT(issue_id) as total FROM issue WHERE sid = '1'");
                      $row = $result->fetch_assoc();
                      echo $row['total']
                      ?>
                    </h5>

                    <div class="card-footer d-flex align-items-center justify-content-between bg-white p-2 mt-2 rounded">
                      <a class="small text-black stretched-link" href="waiting.php">รายละเอียด</a>
                    </div>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">คำร้องที่กำลังดำเนินงาน</p>
                    <h5 class="font-weight-bolder">
                      <?php
                      $result = $conn->query("SELECT COUNT(i.issue_id) as total FROM issue i, statuss s WHERE i.sid = s.sid AND i.sid = 3;");
                      $row = $result->fetch_assoc();
                      echo $row['total']
                      ?>
                    </h5>
                    <div class="card-footer d-flex align-items-center justify-content-between bg-white p-2 mt-2 rounded">
                      <a class="small text-black stretched-link" href="working.php">รายละเอียด</a>
                    </div>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">คำร้องที่ถูกตีกลับ</p>
                    <h5 class="font-weight-bolder">
                      <?php
                      $result = $conn->query("SELECT COUNT(i.issue_id) as total FROM issue i, statuss s WHERE i.sid = s.sid AND (i.sid = 2 OR i.sid = 4);");
                      $row = $result->fetch_assoc();
                      echo $row['total']
                      ?>
                    </h5>
                    <div class="card-footer d-flex align-items-center justify-content-between bg-white p-2 mt-2 rounded">
                      <a class="small text-black stretched-link" href="formback.php">รายละเอียด</a>
                    </div>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">คำร้องดำเนินงานเสร็จสิ้น</p>
                    <h5 class="font-weight-bolder">
                      <?php
                      $result = $conn->query("SELECT COUNT(h.issue_id) as total FROM history h where status = 1");
                      $row = $result->fetch_assoc();
                      echo $row['total']
                      ?>
                    </h5>
                    <div class="card-footer d-flex align-items-center justify-content-between bg-white p-2 mt-2 rounded">
                      <a class="small text-black stretched-link" href="finishform.php">รายละเอียด</a>
                    </div>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <?php
$result = $conn->query("SELECT title, count FROM title ORDER BY count DESC LIMIT 3;");

$labels = [];
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['title'];
        $data[] = $row['count'];
    }
}

$otherResult = $conn->query("SELECT SUM(count) AS count FROM title WHERE title NOT IN ( SELECT title FROM ( SELECT title FROM title ORDER BY count DESC LIMIT 3 ) AS top_titles );");

if ($otherResult->num_rows > 0) {
    $row = $otherResult->fetch_assoc();
    $labels[] = 'อื่นๆ';
    $data[] = $row['count'];
}
?>
      <!-- ส่วนของกราฟ -->
  <div class="container-fluid py-4">
  <div class="row">
    <div class="col-lg-6 mb-lg-0 mb-4">
      <div class="card z-index-2 h-100">
        <div class="card-header pb-0 pt-3 bg-transparent">
          <h6 class="text-capitalize">สถิติการยื่นคำร้อง</h6>
          <p class="text-sm mb-0">
            <i class="fa fa-arrow-up text-success"></i>
            <span class="font-weight-bold">การยื่น</span> ต่อเดือน
          </p>
        </div>
        
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 mb-lg-0 mb-4">
      <div class="card">
        <div class="card-header pb-0 p-3">
          <h6 class="mb-2">สถิตคำร้องที่ถูกยื่นมากที่สุด</h6>
        </div>
        <div class="card-body p-3">
          <canvas id="pieChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
      <div class="row mt-2">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card ">
            <div class="card-header pb-0 p-3">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">คำร้องที่ต้องดำเนินการโดยด่วย (ระยะเวลาเหลือน้อยกว่า 20% ของที่กำหนดไว้)</h6>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center ">
                <thead>

                </thead>
                <tbody>
                  <?php
                  $alertissue = $conn->query("SELECT ss.issue_id,  ss.sid,t.title, u.name, ss.issue_date, 
                                                ((DATEDIFF(DATE_ADD(ss.issue_date, INTERVAL CAST(t.timespan AS UNSIGNED) DAY), CURDATE()) * 100.0) / 
                                                CAST(t.timespan AS UNSIGNED)) AS timespan_percentage, 
                                                (DATEDIFF(DATE_ADD(ss.issue_date, INTERVAL CAST(t.timespan AS UNSIGNED) DAY), CURDATE())) AS timespan, 
                                                ss.file, s.status 
                                            FROM issue ss 
                                            JOIN title t ON ss.tid = t.tid 
                                            JOIN users u ON ss.uid = u.uid 
                                            JOIN statuss s ON ss.sid = s.sid 
                                            HAVING timespan_percentage <= 20
                                            ORDER BY 
                                                timespan_percentage ASC, 
                                                ss.issue_id ASC;
                  ");
                  if ($alertissue->num_rows > 0) {
                    while ($alert = $alertissue->fetch_assoc()) {
                      $issue_id = $alert['issue_id'];
                  ?>
                      <tr>
                        <td class="w-30">
                          <div class="d-flex px-2 py-1 align-items-center">
                            <div>
                              <i class="fs-2 bi bi-exclamation-circle text-danger"></i>
                            </div>
                            <div class="ms-4">
                              <p class="text-xs font-weight-bo  ld mb-0">ชื่อคำร้อง :</p>
                              <h6 class="text-sm mb-0"><?php echo $alert['title'] ?></h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="text-center">
                            <p class="text-xs font-weight-bold mb-0">สถานะ :</p>
                            <h6 class="text-sm mb-0"><?php echo $alert['status'] ?></h6>
                          </div>
                        </td>
                        <td>
                          <div class="text-center">
                            <p class="text-xs font-weight-bold mb-0">โดย :</p>
                            <h6 class="text-sm mb-0"><?php echo $alert['name'] ?></h6>
                          </div>
                        </td>
                        <td>
                          <div class="text-center">
                            <p class="text-xs font-weight-bold mb-0">ระยะเวลาที่เหลือ :</p>
                            <h6 class="text-sm mb-0"><?php echo $alert['timespan'] ?> วัน</h6>
                          </div>
                        </td>
                        <td>
                          <div class="text-center">
                            <p class="text-xs font-weight-bold mb-0">วันที่ยื่น:</p>
                            <h6 class="text-sm mb-0"><?php echo $alert['issue_date'] ?></h6>
                          </div>
                        </td>
                        <td class="align-middle text-sm">
                          <div class="col text-center">
                            <p class="text-xs font-weight-bold mb-0">การดำเนินการ:</p>
                            <?php
                            $link = '';
                            if ($alert['sid'] == 1) {
                              $link = 'waiting.php';
                            } else if ($alert['sid'] == 2) {
                            } else if ($alert['sid'] == 3) {
                              $link = 'working.php';
                            } else if ($alert['sid'] == 4) {
                            } else if ($alert['sid'] == 5) {
                            }
                            ?>
                            <a href="<?php echo $link ?>">ตรวจสอบ</a>
                          </div>
                        </td>
                      </tr>
                    <?php
                    }
                  } else {
                    ?>
                    <tr>
                      <td class="text-center">
                        <div class="container bg-muted pb-7 mt-7">
                          <h3 class="text-center">ขณะนี้ไม่มีคำร้องที่ต้องดำเนินการโดยด่วน</h3>
                        </div>
                      </td>
                    </tr>

                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header pb-0 p-3" >
              <h6 class="mb-0 pb-2"> 3 อันดับคำร้องที่ถูกยื่นมากที่สุด</h6>
            </div>
            <div class="card-body p-3"style="border-top: 1px solid black;">
              <ul class="list-group">
                <?php
                  $result = $conn -> query("SELECT * FROM title ORDER BY count DESC LIMIT 3;");
                  if($result -> num_rows > 0){
                    while($row = $result -> fetch_assoc()){
                ?>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                    <i class="ni ni-trophy text-success opacity-10"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm"><?php echo $row['title']?></h6>
                      <span class="text-l">จำนวนของการยิ่น (รอบ) : <span class="font-weight-bold"><?php echo $row['count']?></span></span>
                    </div>
                  </div>
                </li>
                
                <?php }} ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <?php
$linechart = $conn->query("SELECT * FROM line_graph");

$month_year = [];
$submitted = [];
$successful = [];

if ($linechart->num_rows > 0) {
    while ($rowchart = $linechart->fetch_assoc()) {
        $month_year[] = $rowchart['month_year'];
        $submitted[] = $rowchart['total_submittedissue_thismonth'];
        $successful[] = $rowchart['total_finishissue_thismonth'];
    }
}
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Function to fetch data
    async function fetchData() {
      try {
        const response = await fetch('/api/requests-this-week'); // Your API endpoint
        const data = await response.json();
        return data;
      } catch (error) {
        console.error('Error fetching data:', error);
        // Example data with varying values for visual difference
        return { 
          submitted: <?php echo json_encode($submitted); ?>, // Sample data for submitted requests
          successful: <?php echo json_encode($successful); ?> // Sample data for successful requests
        };
      }
    }

    // Function to initialize and update the chart
    async function updateChart() {
      const data = await fetchData();
      
      var ctx1 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
      gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
      gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');

      new Chart(ctx1, {
        type: "line",
        data: {
          labels: <?php echo json_encode($month_year); ?>, // Adjust labels as needed
          datasets: [{
            label: "คำร้องที่ยืน",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#5e72e4",
            backgroundColor: gradientStroke1,
            borderWidth: 3,
            fill: true,
            data: data.submitted, // Replace with actual data for each day
            maxBarThickness: 6
          }, {
            label: "คำร้องที่เสร็จสิ้น",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#ff6347",
            backgroundColor: gradientStroke1,
            borderWidth: 3,
            fill: true,
            data: data.successful, // Replace with actual data for each day
            maxBarThickness: 6
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true, // Set to true to show legend
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#fbfbfb',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#000',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }

    updateChart();
  });
</script>

  <script> 
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

<script>
   const ctx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
          data: <?php echo json_encode($data); ?>,
          backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
          borderColor: "#fff",
          borderWidth: 3 // ความหนาของขอบ
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // ให้กราฟไม่รักษาสัดส่วนเดิม
        plugins: {
          legend: {
            position: 'bottom', // เปลี่ยนตำแหน่ง legend
            labels: {
              boxWidth: 10, // ขนาดของกล่องสีใน legend
              padding: 15, // ระยะห่างระหว่างข้อความและกล่องสี
              font: {
                size: 15, // ขนาดของข้อความใน legend
              }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)', // สีพื้นหลังของ tooltip
            titleColor: '#fff', // สีของหัวข้อใน tooltip
            bodyColor: '#fff', // สีของเนื้อหาภายใน tooltip
            callbacks: {
              label: function(tooltipItem) {
                let value = tooltipItem.raw || 0;
                return tooltipItem.label + ': ' + value + ' รอบ';
              }
            }
          }
        },
        layout: {
          padding: {
            top: 10,
            bottom: 10 
          }
        }
      }
    });
</script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>