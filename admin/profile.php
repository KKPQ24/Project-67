<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>Argon Dashboard 2 by Creative Tim</title>
  
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>
<?php require 'aside.php'; ?>
<body class="g-sidenav-show   bg-gray-100">
  
  <main class="main-content position-relative border-radius-lg">
  <div class="d-flex justify-content-center">
  <div class="card shadow-lg mx-10 mt-4">
    <div class="card-body p-4">
      <div class="row gx-4">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            <img src="https://rms.tatc.ac.th/files/importpicstd/01/66309010031.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
          </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-10">
            <h5 class="mb-1">ธรรมธร บรรดาศักดิ์</h5>
            <p class="mb-0 font-weight-bold text-sm">ผู้ดูแล</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <div class="container-fluid py-4 mx-12">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">แก้ไขข้อมูล</p>
                <button class="btn btn-primary btn-sm ms-auto">ยืนยันการแก้ไข</button>
              </div>
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm">ข้อมูลส่วนตัว</p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username" class="form-control-label">Username</label>
                    <input class="form-control" type="text" id="username" value="teennnnn">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="form-control-label">password</label>
                    <input class="form-control" type="password" id="email" value="1234567">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first-name" class="form-control-label">รหัสบัตรประชาชน</label>
                    <input class="form-control" type="text" id="ID" value="12134844511115">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last-name" class="form-control-label">ชื่อ-นามสกุล</label>
                    <input class="form-control" type="text" id="name" value="ธรรมธร บรรดาศักดิ์">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last-name" class="form-control-label">E-mail</label>
                    <input class="form-control" type="text" id="name" value="66309010031@tatc.ac.th">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last-name" class="form-control-label">เบอร์โทรศัพท์</label>
                    <input class="form-control" type="number" id="name" value="06456545451">
                  </div>
                </div>
              </div>
              <hr class="horizontal dark">
              <p class="text-uppercase text-sm">ที่อยู่ติดต่อ</p>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="address" class="form-control-label">ที่อยู่</label>
                    <input class="form-control" type="text" id="address" value="54-154">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="city" class="form-control-label">จังหวัด</label>
                    <input class="form-control" type="text" id="city" value="ชลบุรี">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="country" class="form-control-label">อำเภอ</label>
                    <input class="form-control" type="text" id="country" value="สัตหีบ">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="postal-code" class="form-control-label">ตำบล</label>
                    <input class="form-control" type="text" id="postal-code" value="สัตหีบ">
                  </div>
                </div>
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
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = { damping: '0.5' };
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
