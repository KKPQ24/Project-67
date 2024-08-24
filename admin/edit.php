<?php
require '../condb.php';

$tid = $_GET['tid'];

$result = $conn->query("SELECT * FROM title Where tid = $tid");
$title = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize inputs
  $name = $conn->real_escape_string($_POST['title']);
  $duration = $conn->real_escape_string($_POST['duration']);
  
  // Arrays to store dynamic form data
  $files = [];
  $input = [];
  $mandatory = [];
  $status = [];
  $targetDir = "../downloadfile/"; // File upload directory
  
  $fee = [];
  for ($j = 1; $j <= $_SESSION['totalfee']; $j++) {
      if (isset($_POST['fee' . $j])) {
          $fee[$j] = $conn->real_escape_string($_POST['fee' . $j]);
      }
  }

  $note = [];
  for ($j = 1; $j <= $_SESSION['totalnote']; $j++) {
      if (isset($_POST['note' . $j])) {
          $note[$j] = $conn->real_escape_string($_POST['note' . $j]);
      }
  }

  $caution = [];
  for ($j = 1; $j <= $_SESSION['totalcaution']; $j++) {
      if (isset($_POST['caution' . $j])) {
          $caution[$j] = $conn->real_escape_string($_POST['caution' . $j]);
      }
  }

  // Check if the title already exists
  $result = $conn->query("SELECT * FROM title WHERE title = '$name'");
  if ($result && $result->num_rows > 0) {
      echo "<script>alert('รายการคำร้องนี้มีอยู่ในระบบแล้ว');</script>";
  } else {
      // Insert new title
      if ($conn->query("UPDATE title SET title = $name ,  timespan = $duration)")) {
          $tid = $conn->insert_id;
          $sql = "SELECT";

          // Insert cautions
          foreach ($caution as $i => $cautionValue) {
              if ($conn->query("UPDATE caution SET caution  = ('$cautionValue')")) {
                  $lastid = $conn->insert_id;
              }
          }

          // Insert notes
          foreach ($note as $i => $noteValue) {
              if ($conn->query("UPDATE INTO note (note) VALUES('$noteValue')")) {
                  $lastid = $conn->insert_id;              }
          }

          // Insert fees
          foreach ($fee as $i => $feeValue) {
              if ($conn->query("INSERT INTO fee (fee) VALUES('$feeValue')")) {
                  $lastid = $conn->insert_id;              }
          }



          // Handle file uploads
          if (isset($_SESSION['totalfile']) && $_SESSION['totalfile'] > 0) {
              for ($j = 1; $j <= $_SESSION['totalfile']; $j++) {
                  // Check if file is uploaded
                  if (isset($_FILES['file' . $j]) && $_FILES['file' . $j]['error'] === UPLOAD_ERR_OK) {
                      $files[$j] = $_FILES['file' . $j];
                      // Generate new file name
                      $newFileName = 'เอกสาร_' . $_POST['input' . $j] . '_' . (new DateTime())->format('Hi') . '.' . pathinfo($files[$j]['name'], PATHINFO_EXTENSION);
                      $filePath = $targetDir . $newFileName;
          
                      // Try to move the uploaded file to the target directory
                      if (move_uploaded_file($files[$j]['tmp_name'], $filePath)) {
                  
                          $inputName = $conn->real_escape_string($_POST['input' . $j]);
                          $mandatoryValue = $conn->real_escape_string($_POST['mandatory' . $j]);
                          if (isset($_POST['status' . $j])) {
                              $statusValue = $_POST['status' . $j];
                          } else $statusValue = NULL;

                          if (isset($_POST['status2' . $j])) {
                              $status2Value = $_POST['status2' . $j];
                          } else $status2Value = NULL;

                          $statusInsert = $statusValue . $status2Value;
                  
                          $sql = "UPDATE files (file_name, filepath, status, mandatory) VALUES ('$inputName', '$filePath', '$statusInsert', '$mandatoryValue')";
                          $result = $conn->query($sql);
                      } else {
                          echo "Error moving uploaded file: " . $files[$j]['name'] . "<br>";
                      }
                  } else {
                      $inputName = isset($_POST['input' . $j]) ? $conn->real_escape_string($_POST['input' . $j]) : '';
                      $mandatoryValue = isset($_POST['mandatory' . $j]) ? $conn->real_escape_string($_POST['mandatory' . $j]) : '';
                      if (isset($_POST['status' . $j])) {
                          $statusValue = $_POST['status' . $j];
                      } else $statusValue = NULL;

                      if (isset($_POST['status2' . $j])) {
                          $status2Value = $_POST['status2' . $j];
                      } else $status2Value = NULL;

                      $statusInsert = $statusValue . $status2Value;
              
                      $sql = "UPDATE files (file_name, filepath, status, mandatory) VALUES ('$inputName', '$filePath', '$statusInsert', '$mandatoryValue')";
                      $result = $conn->query($sql);
            
                  }
              }
          } else {
              echo "No files to upload. Please ensure the session has 'totalfile' set.";
          }
          // Success message
          echo "<script>alert('รายการคำร้องถูกแก้ไขเรียบร้อยแล้ว');</script>";
          header("Location: billing.php");
      } else {
          echo "<script>alert('การเพิ่มรายการคำร้องล้มเหลว');</script>";
      }
  }
}
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
            <h6>แก้ไขรายการคำร้อง</h6>
          </div>

          <div class="card-body px-0 pt-0 pb-2">
            <!-- Start of the form -->
            <form id="request-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="needs-validation mt-2" novalidate>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="title" class="form-control-label">ชื่อรายการคำร้อง</label>
                            <input class="form-control" type="text" id="title" name="title" value="<?php echo $title['title']; ?>">
                          </div>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-12">
                          <br>
                          <?php
                          $resultstep = $conn->query("SELECT COUNT(file_id) as count FROM title_file WHERE tid = $tid;");
                          $rowstep = $resultstep->fetch_assoc();
                          $fileCount = $rowstep['count'];
                          ?>
                          <label for="step-file" class="form-control-label text-2xl">จำนวน <span class="text-danger"><?php echo $fileCount; ?></span> เอกสารที่ต้องใช้</label>
                        </div>
                      </div>
                      <div class="row" id="file-input-container">
                        <?php
                        $result = $conn->query("SELECT ts.file_id, f.file_name,f.status , f.mandatory FROM title_file ts JOIN files f ON ts.file_id = f.file_id WHERE ts.tid = $tid");

                        if ($result->num_rows > 0) {
                          $i = 0;
                          while ($row = $result->fetch_assoc()) {
                            $i++;
                            $checkstatus3 = "";
                            $checkmandatory = "";
                            $checkstatus2 = "";

                          if (strpos($row['status'], '3') !== false) {
                              $checkstatus3 = "checked";
                          }
                          if (strpos($row['status'], '2') !== false) {
                              $checkstatus2 = "checked";
                          }
                          if ($row['mandatory'] == 1) {
                              $checkmandatory = "checked";                                
                          } else {
                              $checkmandatory = "";
                          }

                        ?>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="file" class="form-control-label">เอกสารที่ <?php echo $i; ?></label>
                                <div class="row">
                                  <div class="col-6">
                                  <div class="col-md-6">
                                  <input class="form-control" type="text" id="file" name="file" value="<?php echo $row['file_name']; ?>" style="width: 100%;" />
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="form-control-label">ตัวเลือกสำหรับเอกสารที่ <?php echo $i; ?></label>
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mandatory<?php echo $i; ?>" <?php echo $checkmandatory ?> id="radio-<?php echo $i; ?>-1" value="1">
                                            <label class="form-check-label" for="radio-<?php echo $i; ?>-1">เอกสารที่ต้องแนบ</label>
                                          </div>
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mandatory<?php echo $i; ?>" <?php echo $checkmandatory ?> id="radio-<?php echo $i; ?>-4" value="0">
                                            <label class="form-check-label" for="radio-<?php echo $i; ?>-4">เอกสารที่ไม่บังคับ</label>
                                          </div>
                                          <label class="form-control-label">ตัวเลือกสำหรับเอกสารที่ <?php echo $i; ?></label>
                                          <div class="form-check">
                                          <input class="form-check-input" type="checkbox" name="status<?php echo $i; ?>" <?php echo $checkstatus2 ?>  id="checkbox-<?php echo $i; ?>" value="2" onchange="checkFileInput(<?php echo $i; ?>)">
                                          <label class="form-check-label" for="checkbox-<?php echo $i; ?>">เอกสารที่ต้องโหลดไปเขียน</label>
                                          </div>
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="status2<?php echo $i; ?>" <?php echo $checkstatus3 ?>  id="radio-<?php echo $i; ?>-3" value="3">
                                            <label class="form-check-label" for="radio-<?php echo $i; ?>-3">เอกสารเพิ่มเติม กรณีนิติบุคคล</label>
                                          </div>
                                          <div id="file-input-<?php echo $i; ?>" class="mt-3" style="display: none;">
                                            <label for="file-<?php echo $i; ?>" class="form-control-label">อัพโหลดไฟล์สำหรับเอกสารที่ <?php echo $i; ?> ไฟล์ PDF เท่านั้น</label>
                                            <input class="form-control" type="file" id="file-<?php echo $i; ?>" name="file<?php echo $i; ?>" accept=".pdf">
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-6 mt-2">
                                    <button class="btn btn-dark" onclick="DelInput()">ลบ</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <?php
                          }
                        }
                        ?>
                        <button class="btn btn-dark" style="width: 150px; font-size: 12px; padding: 10px;"onclick="AddFile()">เพิ่ม</button>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-12">
                          <br>
                          <?php
                          $resultstep = $conn->query("SELECT COUNT(fid) as count FROM title_fee WHERE tid = $tid;");
                          $rowstep = $resultstep->fetch_assoc();
                          $feeCount = $rowstep['count'];
                          ?>
                          <label for="step-fee" class="form-control-label text-2xl">จำนวน <span class="text-danger"><?php echo $feeCount; ?></span> ค่าธรรมเนียม</label>
                        </div>
                      </div>
                      <div class="row" id="fee-input-container">
                        <?php
                        $result = $conn->query("SELECT ts.fid, f.fee FROM title_fee ts JOIN fee f ON ts.fid = f.fid WHERE ts.tid = $tid");

                        if ($result->num_rows > 0) {
                          $i = 0;
                          while ($row = $result->fetch_assoc()) {
                            $i++;
                        ?>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="note" class="form-control-label">ค่าธรรมเนียมที่ <?php echo $i; ?></label>
                                <div class="row">
                                  <div class="col-6">
                                    <input class="form-control" type="text" id="note" name="note" value="<?php echo $row['fee']; ?>" style="width: 100%;" />
                                  </div>
                                  <div class="col-6 mt-2">
                                    <button class="btn btn-dark" onclick="DelInput()">ลบ</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <?php
                          }
                        }
                        ?>
                        <button class="btn btn-dark" style="width: 150px; font-size: 12px; padding: 10px;" onclick="AddFee()">เพิ่ม</button>
                      </div>

                      <div class="row mb-3">
                        <div class="col-md-12">
                          <br>
                          <?php
                          $resultstep = $conn->query("SELECT COUNT(nid) as count FROM title_note WHERE tid = $tid;");
                          $rowstep = $resultstep->fetch_assoc();
                          $noteCount = $rowstep['count'];
                          ?>
                          <label for="step-note" class="form-control-label text-2xl">จำนวน <span class="text-danger"><?php echo $noteCount; ?></span> หมายเหตุ</label>
                        </div>
                      </div>
                      <div class="row" id="note-input-container">
                        <?php
                        $result = $conn->query("SELECT ts.nid, n.note FROM title_note ts JOIN note n ON ts.nid = n.nid WHERE ts.tid = $tid");

                        if ($result->num_rows > 0) {
                          $i = 0;
                          while ($row = $result->fetch_assoc()) {
                            $i++;
                        ?>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="note" class="form-control-label">หมายเหตุที่ <?php echo $i; ?></label>
                                <div class="row">
                                  <div class="col-6">
                                    <input class="form-control" type="text" id="note" name="note" value="<?php echo $row['note']; ?>" style="width: 100%;" />
                                  </div>
                                  <div class="col-6 mt-2">
                                    <button class="btn btn-dark" onclick="DelInput()">ลบ</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <?php
                          }
                        }
                        ?>
                        <button class="btn btn-dark" style="width: 150px; font-size: 12px; padding: 10px;" onclick="AddNote()">เพิ่ม</button>
                      </div>



                      <div class="row mb-3">
                        <div class="col-md-12">
                          <br>
                          <?php
                          $resultstep = $conn->query("SELECT COUNT(cid) as count FROM title_caution WHERE tid = $tid;");
                          $rowstep = $resultstep->fetch_assoc();
                          $cautionCount = $rowstep['count'];
                          ?>
                          <label for="step-caution" class="form-control-label text-2xl">จำนวน <span class="text-danger"><?php echo $cautionCount; ?></span> คำเตือน</label>
                        </div>
                      </div>

                      <div class="row" id="caution-input-container">
                        <?php
                        $result = $conn->query("SELECT ts.cid, c.caution FROM title_caution ts JOIN caution c ON ts.cid = c.cid WHERE ts.tid = $tid");

                        if ($result->num_rows > 0) {
                          $i = 0;
                          while ($row = $result->fetch_assoc()) {
                            $i++;
                        ?>
                            <div class="col-md-12 mb-2">
                              <div class="form-group">
                                <label for="caution" class="form-control-label">คำเตือนที่ <?php echo $i; ?></label>
                                <div class="row">
                                  <div class="col-6">
                                    <input class="form-control" type="text" id="caution" name="caution" value="<?php echo $row['caution']; ?>" style="width: 100%;" />
                                  </div>
                                  <div class="col-6 mt-2">
                                    <button class="btn btn-dark" onclick="DelInput()">ลบ</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <?php
                          }
                        }
                        ?>
                        <div class="col-md-12 mt-2">
                          <button class="btn btn-dark" style="width: 150px; font-size: 12px; padding: 10px;" onclick="AddCaution()">เพิ่ม</button>
                        </div>
                      </div>


                      <div class="row mb-3">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="duration" class="form-control-label">ระยะเวลา</label>
                            <div style="display: flex; align-items: center;">
                              <input class="form-control" type="text" id="duration" name="duration" value="<?php echo $title['timespan']; ?>" style="width: auto; display: inline-block;">
                              <label style="margin-left: 8px; margin-bottom: 0;">วัน</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-danger btn-sm me-2" onclick="clearForm()">เคลียร์ข้อมูล</button>
                        <button type="submit" class="btn btn-primary btn-sm" onclick="confirmSubmission(event)">ยืนยันการแก้ไขข้อมูลข้อมูล</button>
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

    function confirmSubmission(event) {
      event.preventDefault(); // ป้องกันการส่งฟอร์ม

      Swal.fire({
        title: 'ยืนยันการเเก้ไขข้อมูล?',
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

    function clearForm() {
      document.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
      document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
      document.querySelectorAll('input[type="file"]').forEach(input => input.value = '');
      document.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => input.checked = false);
      document.getElementById('input-container').innerHTML = '';
      document.getElementById('fee-input-container').innerHTML = '';
      document.getElementById('note-input-container').innerHTML = '';
      document.getElementById('caution-input-container').innerHTML = '';

      Swal.fire(
        'ข้อมูลถูกเคลียร์!',
        'ข้อมูลทั้งหมดถูกล้างเรียบร้อยแล้ว.',
        'success'
      );
    }
    
    var fileCounter = 1; // เริ่มต้นการนับที่ 1

function AddFile(event) {
    event.preventDefault();
    
    var fileInputContainer = document.getElementById('file-input-container');

    var newFileInput = `
        <div class="col-md-12 file-item">
            <div class="form-group">
                <label for="file" class="form-control-label">เอกสารที่ ${fileCounter}</label>
                <div class="row">
                    <div class="col-6">
                        <input class="form-control" type="text" id="file${fileCounter}" name="file${fileCounter}" value="" style="width: 100%;" />
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-control-label">ตัวเลือกสำหรับเอกสารที่ ${fileCounter}</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mandatory${fileCounter}" id="radio-${fileCounter}-1" value="1">
                                <label class="form-check-label" for="radio-${fileCounter}-1">เอกสารที่ต้องแนบ</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mandatory${fileCounter}" id="radio-${fileCounter}-4" value="0">
                                <label class="form-check-label" for="radio-${fileCounter}-4">เอกสารที่ไม่บังคับ</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status${fileCounter}" id="checkbox-${fileCounter}" value="2" onchange="checkFileInput(${fileCounter})">
                                <label class="form-check-label" for="checkbox-${fileCounter}">เอกสารที่ต้องโหลดไปเขียน</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status2${fileCounter}" id="checkbox2-${fileCounter}" value="3">
                                <label class="form-check-label" for="checkbox2-${fileCounter}">เอกสารเพิ่มเติม กรณีนิติบุคคล</label>
                            </div>
                            <div id="file-input-${fileCounter}" class="mt-3" style="display: none;">
                                <label for="file-${fileCounter}" class="form-control-label">อัพโหลดไฟล์สำหรับเอกสารที่ ${fileCounter} ไฟล์ PDF เท่านั้น</label>
                                <input class="form-control" type="file" id="file-${fileCounter}" name="file${fileCounter}" accept=".pdf">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mt-2">
                        <button class="btn btn-dark" onclick="DelInput(event, this)">ลบ</button>
                    </div>
                </div>
            </div>
        </div>`;

    fileInputContainer.insertAdjacentHTML('beforeend', newFileInput);

    // Increment fileCounter and update labels
    fileCounter = updateFileCounter();
}

function DelInput(event, button) {
    event.preventDefault();
    
    var fileInputContainer = document.getElementById('file-input-container');
    var itemToRemove = button.closest('.file-item');
    fileInputContainer.removeChild(itemToRemove);

    // Update fileCounter after deletion
    fileCounter = updateFileCounter();
}

function updateFileCounter() {
    var fileItems = document.querySelectorAll('#file-input-container .file-item');
    var count = 1;
    fileItems.forEach(item => {
        var label = item.querySelector('.form-control-label');
        label.textContent = `เอกสารที่ ${count}`;
        count++;
    });
    return count; // Return the next available number
}


// Function to add fee inputs
// Initialize a counter variable for fee inputs
var feeCounter = 1;

function AddFee() {
    event.preventDefault();
    
    var feeInputContainer = document.getElementById('fee-input-container');

    var newFeeInput = `
        <div class="col-md-12">
            <div class="form-group">
                <label for="fee" class="form-control-label">ค่าธรรมเนียมเพิ่มเติมที่ ${feeCounter}</label> <!-- Start numbering from 1 -->
                <div class="row">
                    <div class="col-6">
                        <input class="form-control" type="text" id="fee${feeCounter}" name="fee${feeCounter}" value="">
                    </div>
                    <div class="col-6">
                        <button class="btn btn-dark" onclick="DelInput(event, this)">ลบ</button>
                    </div>
                </div>
            </div>
        </div>`;

    feeInputContainer.insertAdjacentHTML('beforeend', newFeeInput);
    
    feeCounter++;
}


// Function to add note inputs
var noteCounter = 1;
function AddNote() {
    event.preventDefault();
    
    var noteInputContainer = document.getElementById('note-input-container');

    var newNoteInput = `
        <div class="col-md-12">
            <div class="form-group">
                <label for="note" class="form-control-label">หมายเหตุเพิ่มเติมที่ ${noteCounter}</label>
                <div class="row">
                    <div class="col-6">
                        <input class="form-control" type="text" id="note${noteCounter}" name="note${noteCounter}" value="" style="width: 100%;" />
                    </div>
                    <div class="col-6 mt-2">
                        <button class="btn btn-dark" onclick="DelInput(event, this)">ลบ</button>
                    </div>
                </div>
            </div>
        </div>`;

    noteInputContainer.insertAdjacentHTML('beforeend', newNoteInput);
    noteCounter++;
}

// Function to add caution inputs
var cautionCounter = 1;
function AddCaution() {
    event.preventDefault();
    
    var cautionInputContainer = document.getElementById('caution-input-container');

    var newCautionInput = `
        <div class="col-md-12 mb-2">
            <div class="form-group">
                <label for="caution" class="form-control-label">คำเตือนเพิ่มเติมที่ ${cautionCounter}</label>
                <div class="row">
                    <div class="col-6">
                        <input class="form-control" type="text" id="caution${cautionCounter}" name="caution${cautionCounter}" value="" style="width: 100%;" />
                    </div>
                    <div class="col-6 mt-2">
                        <button class="btn btn-dark" onclick="DelInput(event, this)">ลบ</button>
                    </div>
                </div>
            </div>
        </div>`;

    cautionInputContainer.insertAdjacentHTML('beforeend', newCautionInput);
    cautionCounter++;
}

function DelInput(event, button) {
    // Prevent default form submission
    event.preventDefault();

    // Remove the input field container
    var inputGroup = button.closest('.col-md-12');
    inputGroup.remove();
}

function checkFileInput(index) {
    var checkbox = document.getElementById('checkbox-' + index);
    var fileInputDiv = document.getElementById('fileInput-' + index);
    
    if (checkbox.checked) {
        fileInputDiv.style.display = 'block';
    } else {
        fileInputDiv.style.display = 'none';
    }
}
  </script>

</body>

</html> 