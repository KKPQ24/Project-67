<?php
require '../condb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>Argon Dashboard 2 by Creative Tim</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php require 'aside.php'; ?>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h4 class="text-uppercase font-weight-bolder">จัดรายการคำร้อง</h4>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table table-striped table-bordered table-hover">
                  <thead class="bg-light">
                    <tr>
                      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">ลำดับ</th>
                      <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">ชื่อคำร้อง</th>
                      <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">จัดการรายการ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM title");
                    if ($result->num_rows > 0) {
                      while ($row =  $result->fetch_assoc()) {
                        echo '
                        <tr>
                          <td class="text-center align-middle">' . $row["tid"] . '</td>
                          <td class="align-middle">'. $row["title"] .'</td>
                          <td class="text-center align-middle">
                                      <div class="d-flex justify-content-center">
                                        <a href="edit.php?tid=' . $row["tid"] . '" class="btn btn-warning btn-sm mx-1">
                                          <i class="bi bi-pencil-square"></i> แก้ไข
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm mx-1" onclick="deleteData(' . $row["tid"] . ')">
                                          <i class="bi bi-trash"></i> ลบรายการ
                                        </button>
                                      </div>
                                    </td>
                        </tr>
                      ';
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    function deleteData(id) {
        // SweetAlert confirmation dialog
        Swal.fire({
            title: 'คุณต้องการจะลบคำร้องนี้ใช่ไหม?',
            text: "คุณจะไม่สามารถย้อนกลับสิ่งนี้ได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยันการลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX call to delete the data
                $.ajax({
                    url: 'deletetitle.php',  
                    type: 'POST',
                    data: { recordId: id },
                    success: function(response) {
                        if(response.includes('success')) {
                            // Show SweetAlert on successful deletion
                            Swal.fire(
                                'Deleted!',
                                'รายการของคุณถูกลบแล้ว.',
                                'success'
                            ).then(() => {
                                // Reload the page after the SweetAlert is closed
                                location.reload();
                            });
                        } else {
                            // Handle failed deletion
                            Swal.fire(
                                'Error!',
                                'เกิดข้อผิดพลาดในการลบข้อมูล.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        Swal.fire(
                            'Error!',
                            'An error occurred: ' + xhr.responseText,
                            'error'
                        );
                    }
                });
            }
        });
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
