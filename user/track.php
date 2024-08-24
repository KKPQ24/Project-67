<?php
require '../condb.php';
require 'navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $issue_id = isset($_POST['issue_id']) ? $_POST['issue_id'] : null;
} else {
    echo "Invalid request method";
}

$sql = "SELECT i.sid , s.status , i.issue_date , t.title ,t.tid , i.comment , i.file,
    (SELECT DATEDIFF(DATE_ADD(ss.issue_date, INTERVAL t.timespan DAY), CURDATE()) 
        FROM title t ,issue ss 
        WHERE t.tid = ss.tid AND ss.issue_id = $issue_id ) 
    AS timespan
    FROM issue i , statuss s , title t WHERE i.sid = s.sid AND i.tid = t.tid AND i.issue_id = '$issue_id';";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="icon" href="../img/Photoroom.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Noto Sans Thai', Arial, Helvetica, sans-serif;
        }

        .icon {
            width: 35px;
            height: auto;
            padding: 1px;
        }

        .home {
            display: block;
            margin: 0 auto;
            width: 97px;
            height: auto;
            background-color: white;
            padding: 1px;
            border-radius: 60%;
            border: 2px solid white;
        }

        .main-bg {
            background-color: #EAEDF1;
        }

        .my-card {
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            border-radius: 10px;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .p-5 {
            padding: 3rem !important;
        }

        .fw-bold {
            font-weight: bold !important;
        }

        .d-flex {
            display: flex !important;
        }

        .flex-lg-row {
            flex-direction: row !important;
        }

        .flex-column {
            flex-direction: column !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .column-gap-5 {
            column-gap: 3rem !important;
        }

        .row-gap-3 {
            row-gap: 1rem !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-1 {
            margin-bottom: 0.25rem !important;
        }

        .text-center {
            text-align: center !important;
        }

        .fs-2 {
            font-size: 2rem !important;
        }

        .fs-5 {
            font-size: 1.25rem !important;
        }

        .progress {
            height: 1rem;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .progress-bar {
            background-color: green;
        }

        .progress-responsive-hide {
            display: none;
        }

        .progress-responsive-show {
            display: block;
        }

        .card {
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .alert-info {
            color: #084298;
            background-color: #cff4fc;
            border-color: #b6effb;
        }

        .alert-info h3 {
            margin: 0;
            padding: 0;
            font-weight: bolder;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .text-primary {
            color: #007bff !important;
        }

        .text-end {
            text-align: end !important;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-maintheme {
            background-color: #242729;
            color: #feffff;
            border-radius: 5px;
            border: 1px solid #242729;
            text-decoration: none;
            transition: .5s;
        }

        .btn-maintheme:hover {
            background-color: #feffff;
            color: #242729;
            border: 1px solid #242729;
            border-radius: 5px;
        }

        @media (max-width: 992px) {
            .progress-responsive-hide {
                display: block;
            }

            .progress-responsive-show {
                display: none;
            }

            .column-gap-5 {
                column-gap: 1rem !important;

            }

            .row-gap-3 {
                row-gap: 0.5rem !important;
            }

            .p-5 {
                padding: 1.5rem !important;
            }
        }
    </style>
</head>

<body class="main-bg">
    <div class="mt-4 my-card p-5">
        <h3 class="fw-bold"><?php echo $row['title'] ?></h3>
        <div class="d-flex flex-lg-row flex-column align-items-center column-gap-5 row-gap-3">
            <div>
                <p class="m-0 p-0"><b>ชื่อ-นามสกุล : </b> <?php echo htmlspecialchars($name); ?></p>
                <p class="m-0 p-0"><b>วันที่ยื่นคำร้อง : </b> <?php echo htmlspecialchars($row['issue_date']); ?></p>
                <p class="m-0 p-0"><b>ระยะเวลาที่เหลือ : </b> <?php echo htmlspecialchars($row['timespan']); ?> วัน</p>
                <p class="m-0 p-0"><b>สถานะ : </b>
                    <b class="text-warning">
                        <?php if ($row['comment'] != NULL): ?>
                            <?php echo htmlspecialchars($row['status']); ?>
                            <button class="btn btn-danger" onclick="showCommentForm('<?php echo addslashes($row['comment']); ?>', <?php echo $row['sid']; ?>)">ดูเหตุผล</button>
                        <?php else: ?>
                            <?php echo htmlspecialchars($row['status']); ?>
                        <?php endif; ?>
                    </b>
                </p>
            </div>
        </div>
        <!-- Progress Bar -->
        <div class="mt-5">
            <div class="d-flex align-items-start justify-content-around mb-1">
                <div class="row">
                </div>
                <?php
                $tid = $row['tid'];

                $resultstatus = $conn->query("SELECT s.sid, s.status FROM statuss s JOIN title_status ts ON ts.sid = s.sid WHERE ts.tid = $tid");

                $total = $conn->query("SELECT COUNT(sid) as max FROM title_status WHERE tid = $tid");

                $max_status = $total->fetch_assoc();

                $ssid = $row['sid'];

                $resultnum = $conn->query("WITH RankedStatuses AS ( 
                              SELECT sid, ROW_NUMBER() OVER (ORDER BY sid) AS row_num 
                              FROM title_status 
                              WHERE tid = $tid 
                           ) 
                           SELECT row_num 
                           FROM RankedStatuses 
                           WHERE sid = $ssid");
                $rownum = $resultnum->fetch_assoc();

                $sid = $rownum['row_num'];
                $percentage = ($sid / $max_status['max']) * 100;
                $percentage = min($percentage, 100);
                $showbtnfix = '';
                while ($status = $resultstatus->fetch_assoc()) { ?>
                    <div class="col-1">
                        <div class="text-center">
                            <?php
                            // Logic for status 2
                            if ($status['sid'] == 2) {
                                if ($row['sid'] > 2) {
                                    $logo = '<i class="fs-2 bi-check-circle-fill text-success"></i>';
                                } elseif ($row['sid'] == 2) {
                                    $showbtnfix = '<a href="cancleform.php?issue_id=' . $issue_id . '" id="cancelBTN" class="btn btn-warning">ยกเลิกคำร้อง</a>';
                                    $logo = '<i class="fs-2 bi-x-circle-fill text-danger"></i>';
                                } else {
                                    $logo = '<i class="fs-2 bi bi-dash-circle-fill text-muted"></i>';
                                }
                            }
                            // Logic for status 5
                            else if ($status['sid'] == 4) {
                                if ($row['sid'] > 4) {
                                    $logo = '<i class="fs-2 bi-check-circle-fill text-success"></i>';
                                } elseif ($row['sid'] == 4) {
                                    $showbtnfix = '<a href="#" onclick="showCommentForm(' . addslashes($row['comment']) .','. $row['sid'] .' ) " id="fixBtn" class="btn btn-warning">แก้ไขตำร้อง</a>';
                                    $logo = '<i class="fs-2 bi-x-circle-fill text-danger"></i>';
                                } else {
                                    $logo = '<i class="fs-2 bi bi-dash-circle-fill text-muted"></i>';
                                }
                            }
                            // Logic for other statuses
                            else {
                                $color = ($status['sid'] <= $row['sid']) ? "success" : "muted";
                                $lok = ($status['sid'] <= $row['sid']) ? "bi bi-check-circle-fill text-" : "bi bi-dash-circle-fill text-";
                                $logo = '<i class="fs-2 ' . $lok . $color . '"></i>';
                            }

                            echo $logo;
                            ?>
                            <p class="m-0 p-0 fw-bold progress-responsive-show">
                                <?php echo $status['status'] . '<br>' . $showbtnfix;
                                $showbtnfix = ''; ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="progress" role="progressbar" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: <?php echo $percentage; ?>%; background-color: green;"></div>
            </div>
        </div>

        <br>
        <!-- Buttons -->
        <div class="text-end btn-group-lg">
            <a href="cancleform.php?issue_id='<?php echo $issue_id ?>'" id="cancelBTN-static" class="btn btn-danger">ยกเลิกคำร้อง</a>
            <a href="index.php" class="btn btn-maintheme">ย้อนกลับ</a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="commentText" class="form-control" readonly></textarea>
                    <div class="container text-denter justify-content-center mt-5">
                        <a class="btn btn-outline-secondary" Target="_blank" href="<?php echo $row['file'] ?>">ดูเอกสารของฉัน</a>
                        <p class="mt-2">แนบไฟล์ใหม่(PDF เท่านั้น)</p>
                        <form action="fixform.php" method="POST" enctype="multipart/form-data" class="needs-validation mt-2" novalidate>
                            <?php
                            $sql = "SELECT f.file_name, f.status , f.mandatory 
                        FROM files f
                        JOIN title_file tf ON tf.file_id = f.file_id
                        WHERE tf.tid = '$tid'";
                            $result = $conn->query($sql);
                            $i = 0;
                            while ($fileRow = $result->fetch_assoc()) {
                                $i++;
                                if ($fileRow['mandatory'] == 1) {
                                    $requirestatus = "required";
                                    $showrequire = "";
                                } else {
                                    $requirestatus = "";
                                    $showrequire = "<span class='bg-warning text-dark rounded p-1 '>ไม่บังคับ</span>";
                                }
                                if (strpos($fileRow['status'], '3') === false) {
                                    echo '<li class="list-group-item">';
                                    echo '<h5 class="my-0">' . $i . '. ' . htmlspecialchars($fileRow['file_name']) . ' </h5>';
                                    echo '<input class="form-control form-control-sm" type="file" id="file' . $i . '" name="file' . $i . '" accept=".pdf" ' . $requirestatus . '>';
                                    echo '<h5 class="mt-2">' . $showrequire . '</h5>';
                                    echo '</li>';
                                } else {
                                    $status3 = '<span class="bg-danger text-light rounded p-1">กรณีนิติบุคคล</span>';
                                    echo '<li class="list-group-item">';
                                    echo '<h5 class="my-0">' . $i . '. ' . htmlspecialchars($fileRow['file_name']) . ' </h5>';
                                    echo '<input class="form-control form-control-sm" type="file" id="file' . $i . '" name="file' . $i . '" accept=".pdf" ' . $requirestatus . '>';
                                    echo '<h5 class="mt-2">' . $showrequire . ' ' . $status3 . '</h5>';
                                    echo '</li>';
                                }
                            }
                            $_SESSION['file_count'] = $i;
                            $_SESSION['issue'] = $issue_id;
                            ?>
                            </ul>
                            <div class="col-12 mt-3">
                                <input class="w-100 btn btn-success btn-lg" type="submit" value="ยืนยัน">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    function attachCancelEvent(buttonId, issueId) {
        document.getElementById(buttonId).addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link action

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to cancel your issue?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'cancleform.php';

                    // Create hidden input to hold the issue_id
                    var issueIdInput = document.createElement('input');
                    issueIdInput.type = 'hidden';
                    issueIdInput.name = 'issue_id';
                    issueIdInput.value = issueId;
                    form.appendChild(issueIdInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    }

    attachCancelEvent('cancelBTN', '<?php echo $issue_id; ?>');

    attachCancelEvent('cancelBTN-static', '<?php echo $issue_id; ?>');

    function showCommentForm(commentText, statusId) {
        $('#commentText').val(commentText);
        if (statusId == 2) {
            $('#commentModalLabel').text("เหตุผลที่คำร้องไม่ถูกรับ");
        } else {
            $('#commentModalLabel').text("จุดที่ต้องดำเนินการแก้ไข");
        }
        $('#commentModal').modal('show');
    }

    function attachCancelEvent(buttonId, issueId) {
        $('#' + buttonId).on('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to cancel your issue?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('<form method="POST" action="cancleform.php"></form>');
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'issue_id',
                        value: issueId
                    }).appendTo(form);
                    $('body').append(form);
                    form.submit();
                }
            });
        });
    }

    $(document).ready(function() {
        attachCancelEvent('cancelBTN', '<?php echo $issue_id; ?>');
        attachCancelEvent('cancelBTN-static', '<?php echo $issue_id; ?>');
    });
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('submissionForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Validate file inputs
                const fileInputs = form.querySelectorAll('input[type="file"]');
                let hasErrors = false;
                let allFilesAttached = true;

                fileInputs.forEach(input => {
                    if (input.hasAttribute('required') && !input.files.length) {
                        allFilesAttached = false;
                        input.classList.add('is-invalid'); // Add Bootstrap invalid class
                    } else {
                        input.classList.remove(
                            'is-invalid'); // Remove Bootstrap invalid class if file is attached
                    }
                });

                if (!allFilesAttached) {
                    hasErrors = true;
                    Swal.fire({
                        title: 'ข้อมูลไม่สมบูรณ์!',
                        text: 'กรุณาแนบไฟล์ที่จำเป็นทั้งหมดก่อนส่งคำร้อง.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'ตกลง'
                    });
                } else {
                    // Show SweetAlert2 confirmation dialog if no errors
                    Swal.fire({
                        title: 'ยืนยันการส่งคำร้อง',
                        text: "คุณแน่ใจหรือไม่ว่าต้องการส่งคำร้องนี้?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'สำเร็จ!',
                                text: 'คำร้องของคุณได้ถูกส่งเรียบร้อยแล้ว.',
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                form.submit(); // Submit form after success alert
                            });
                        }
                    });
                }
            });
        });
    </script>

</html>