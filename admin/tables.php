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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <title>New</title>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php require 'aside.php'; ?>

  <main class="main-content position-relative border-radius-lg">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>เพิ่มรายการคำร้องเพิ่มเติม</h6>
          </div>

          <div class="card-body px-0 pt-0 pb-2">
            <!-- Start of the form -->
            <form id="request-form" action="addtitle.php" method="post" enctype="multipart/form-data" class="needs-validation mt-2" novalidate>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="title" class="form-control-label">ชื่อคำร้องที่ต้องการจะเพิ่ม</label>
                            <input class="form-control" type="text" id="title" name="title" value="">
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="request-count" class="form-control-label">จำนวนเอกสารที่ต้องใช้</label>
                            <input class="form-control" type="number" id="request-count" name="request-count" oninput="showInputs()" min="0" max="50" placeholder="กรอกจำนวนเอกสาร">
                          </div>
                        </div>
                      </div>
                      <div class="row" id="input-container">
                        <!-- ฟิลด์อินพุตจะถูกเพิ่มที่นี่ตามตัวเลือก -->
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="fee-count" class="form-control-label">ค่าธรรมเนียมที่มี</label>
                            <input class="form-control" type="number" id="fee-count" name="fee-count" oninput="showFeeInputs()" min="0" max="50" placeholder="กรอกจำนวนค่าธรรมเนียม">
                          </div>
                        </div>
                      </div>

                      <div class="row" id="fee-input-container">
                        <!-- Input fields for fees will be added here dynamically -->
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="note-count" class="form-control-label">หมายเหตุ</label>
                            <input class="form-control" type="number" id="note-count" name="note-count" oninput="shownoteInputs()" min="0" max="50" placeholder="กรอกจำนวนหมายเหตุ">
                          </div>
                        </div>
                      </div>

                      <div class="row" id="note-input-container">
                        <!-- Input fields for note will be added here dynamically -->
                      </div>


                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="caution-count" class="form-control-label">คำเตือน</label>
                            <input class="form-control" type="number" id="caution-count" name="caution-count" oninput="showcautionInputs()" min="0" max="50" placeholder="กรอกจำนวนคำเตือน">
                          </div>
                        </div>
                      </div>

                      <div class="row" id="caution-input-container">
                        <!-- Input fields for caution will be added here dynamically -->
                      </div>


                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="duration" class="form-control-label">ระยะเวลา</label>
                            <div style="display: flex; align-items: center;">
                              <input class="form-control" type="text" id="duration" name="duration" value="" style="width: auto; display: inline-block;">
                              <label style="margin-left: 8px; margin-bottom: 0;">วัน</label>
                            </div>
                            <br>

                      <div class="d-flex align-items-center mt-3">
                        <button type="submit" class="btn btn-primary btn-sm ms-auto" onclick="confirmSubmission(event)">ยืนยันการเพิ่มข้อมูล</button>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </form>
            <!-- End of the form -->

          </div>
        </div> <!-- Close card -->
      </div> <!-- Close row -->
    </div> <!-- Close container-fluid -->
  </main>

  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    function showInputs() {
  var inputBox = document.getElementById('request-count');
  var selectedValue = Math.min(inputBox.value, 50);
  inputBox.value = selectedValue;
  var inputContainer = document.getElementById('input-container');

  // Clear existing input fields
  inputContainer.innerHTML = '';

  // Add input fields based on the entered value
  for (var i = 1; i <= selectedValue; i++) {
    var inputDiv = document.createElement('div');
    inputDiv.className = 'row mb-3';
    inputDiv.innerHTML = `
      <div class="col-md-6">
        <div class="form-group">
          <label for="input-${i}" class="form-control-label">เอกสารที่ ${i}</label>
          <input class="form-control" type="text" id="input-${i}" name="input${i}" placeholder="กรอกชื่อเอกสารที่ ${i}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label class="form-control-label">ตัวเลือกสำหรับเอกสารที่ ${i}</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mandatory${i}" id="radio-${i}-1" value="1" onchange="checkFileInput(${i})">
            <label class="form-check-label" for="radio-${i}-1">เอกสารที่ต้องแนบ</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="mandatory${i}" id="radio-${i}-4" value="0" onchange="checkFileInput(${i})">
            <label class="form-check-label" for="radio-${i}-4">เอกสารที่ไม่บังคับ</label>
          </div>
          <label class="form-control-label">ตัวเลือกสำหรับเอกสารที่ ${i}</label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="status${i}" id="radio-${i}-2" value="2" onchange="checkFileInput(${i})">
            <label class="form-check-label" for="radio-${i}-2">เอกสารที่ต้องโหลดไปเขียน</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="status2${i}" id="radio-${i}-3" value="3" onchange="checkFileInput(${i})">
            <label class="form-check-label" for="radio-${i}-3">เอกสารเพิ่มเติม กรณีนิติบุคคล</label>
          </div>
          <div id="file-input-${i}" class="mt-3" style="display: none;">
            <label for="file-${i}" class="form-control-label">อัพโหลดไฟล์สำหรับเอกสารที่ ${i} ไฟล์ PDF เท่านั้น</label>
            <input class="form-control" type="file" id="file-${i}" name="file${i}" accept=".pdf">
          </div>
        </div>
      </div>
    `;
    inputContainer.appendChild(inputDiv);
  }

  $.ajax({
    url: 'update_session.php',
    method: 'POST',
    data: { totalfile: selectedValue },
    success: function(response) {
      console.log('Session updated successfully:', response);
    },
    error: function(xhr, status, error) {
      console.error('Failed to update session:', error);
    }
  });
}

    function showFeeInputs() {
      var inputBox = document.getElementById('fee-count');
      var selectedValue = Math.min(inputBox.value, 50);
      inputBox.value = selectedValue; 
      var selectedValue = inputBox.value;
      var feeInputContainer = document.getElementById('fee-input-container');

      feeInputContainer.innerHTML = '';

      // Add input fields based on the entered value
      var i = 1;
      for (i = 1; i <= selectedValue; i++) {
        var feeDiv = document.createElement('div');
        feeDiv.className = 'row mb-3';
        feeDiv.innerHTML = `
          <div class="col-md-6">
            <div class="form-group">
              <label for="fee-${i}" class="form-control-label">ค่าธรรมเนียมที่ ${i}</label>
              <input class="form-control" type="text" id="fee-${i}" name="fee${i}" placeholder="กรอกค่าธรรมเนียมที่ ${i}">
            </div>
          </div>
        `;
        feeInputContainer.appendChild(feeDiv);
      }$.ajax({
        url: 'update_session.php',
        method: 'POST',
        data: { totalfee: selectedValue },
        success: function(response) {
        }
      });
    }



    function shownoteInputs() {
      var inputBox = document.getElementById('note-count');
      var selectedValue = Math.min(inputBox.value, 50);
      inputBox.value = selectedValue; 
      var selectedValue = inputBox.value;
      var noteInputContainer = document.getElementById('note-input-container');

      // Clear existing input fields
      noteInputContainer.innerHTML = '';

      // Add input fields based on the entered value
      var i = 1;
      for (i = 1; i <= selectedValue; i++) {
        var noteDiv = document.createElement('div');
        noteDiv.className = 'row mb-3';
        noteDiv.innerHTML = `
          <div class="col-md-6">
            <div class="form-group">
              <label for="note-${i}" class="form-control-label">หมายเหตุที่ ${i}</label>
              <input class="form-control" type="text" id="note-${i}" name="note${i}" placeholder="กรอกหมายเหตุที่ ${i}">
            </div>
          </div>
        `;
        noteInputContainer.appendChild(noteDiv);
      }$.ajax({
        url: 'update_session.php',
        method: 'POST',
        data: { totalnote: selectedValue },
        success: function(response) {
        }
      });
    }

    function showcautionInputs() {
      var inputBox = document.getElementById('caution-count');
      var selectedValue = Math.min(inputBox.value, 50);
      inputBox.value = selectedValue; 
      var selectedValue = inputBox.value;
      var cautionInputContainer = document.getElementById('caution-input-container');

      // Clear existing input fields
      cautionInputContainer.innerHTML = '';

      // Add input fields based on the entered value
      var i = 1;
      for (i = 1; i <= selectedValue; i++) {
        var cautionDiv = document.createElement('div');
        cautionDiv.className = 'row mb-3';
        cautionDiv.innerHTML = `
          <div class="col-md-6">
            <div class="form-group">
              <label for="caution-${i}" class="form-control-label">คำเตือนที่ ${i}</label>
              <input class="form-control" type="text" id="caution-${i}" name="caution${i}" placeholder="กรอกคำเตือนที่ ${i}">
            </div>
          </div>
        `;
        cautionInputContainer.appendChild(cautionDiv);
      }$.ajax({
        url: 'update_session.php',
        method: 'POST',
        data: { totalcaution: selectedValue },
        success: function(response) {
          console.log("Sent data success");
        }
      });
    }

    function checkFileInput(index) {
      var fileInputDiv = document.getElementById('file-input-' + index);
      var radioButtons = document.getElementsByName('status' + index);

      // Hide the file input by default
      fileInputDiv.style.display = 'none';

      // Show the file input if the correct radio button is checked
      radioButtons.forEach(function(radio) {
        if (radio.checked && radio.value === '2') {
          fileInputDiv.style.display = 'block';
        }
      });
    }



    function confirmSubmission(event) {
      event.preventDefault(); // ป้องกันการส่งฟอร์ม

      Swal.fire({
        title: 'ยืนยันการเพิ่มข้อมูล?',
        text: "คุณต้องการบันทึกข้อมูลนี้หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, บันทึกข้อมูล!',
        cancelButtonText: 'ยกเลิก',
        allowOutsideClick: true, // ให้สามารถคลิกด้านนอกป๊อปอัปได้
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'บันทึกข้อมูลแล้ว!',
            'ข้อมูลของคุณถูกบันทึกเรียบร้อยแล้ว.',
            'success'
          ).then(() => {
            // ส่งฟอร์มหลังจากยืนยัน
            document.getElementById('request-form').submit();
            // window.location.href = 'index.php';
          });
        }
      });
    }

  </script>
</body>
</html>