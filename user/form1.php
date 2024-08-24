<?php
require 'navbar.php';
require '../bootstrap.html';
require '../condb.php';

$uid = $_SESSION['uid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tid = $_POST['tid'];
}


// Query to get title details
$sql = "SELECT * FROM title WHERE tid = '$tid'";
$result = $conn->query($sql);
$titleRow = $result->fetch_assoc();
$_SESSION['tid'] = $tid;

$sql = "SELECT u.name, u.idcard, u.Address,u.Addressgroup,u.lane,u.road,u.telephone,u.fax,u.email,u.nationality,u.age
        , p.pname_th, d.dname_th, sd.sdname_th, sd.zip_code 
        FROM users u 
        JOIN provinces p ON u.province_id = p.id
        JOIN district d ON u.district_id = d.id
        JOIN subdistrict sd ON u.subdistrict_id = sd.id
        WHERE u.uid = '$uid'";
$result = $conn->query($sql);
$userRow = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ที่ว่าการอำเภอสัตหีบ</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Thasadith:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "K2D", sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #1679AB;
            padding: 15px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-nav {
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        .container {
            padding: 20px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-container h4 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 12px;
            font-size: 1rem;
        }

        .btn-success {
            font-size: 1.2rem;
            padding: 12px 20px;
            border-radius: 8px;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .list-group-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .note-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .note-section h2 {
            margin-bottom: 15px;
            color: #333;
        }

        .note-section p {
            margin-bottom: 15px;
            color: #555;
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

        .popup-btn-container {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .popup-btn {
            margin-left: 10px;
        }

        .btn-custom {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            padding: 8px 12px;
            border: 2px solid #007bff;
            border-radius: 5px;
            background-color: #ffffff;
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn-custom:hover {
            background-color: #007bff;
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .btn-group {
            display: flex;
            align-items: center;
        }

        .btn-group .btn-custom {
            margin: 0 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mb-4">
            <h1>หัวข้อคำร้อง: <?php echo htmlspecialchars($titleRow['title']); ?></h1>
        </div>

        <div class="form-container">
            <h4 class="text-center">รายละเอียดสำหรับการยื่นคำร้อง</h4>
            <div class="btn-group popup-btn-container ml-3">
                <a class="btn-custom" data-toggle="modal" data-target="#noteModal">หมายเหตุ</a>
                <a class="btn-custom" data-toggle="modal" data-target="#cautionModal">คำเตือน</a>
                <a class="btn-custom" data-toggle="modal" data-target="#feeModal">ค่าธรรมเนียม</a>
            </div>
            <div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">ชื่อนามสกุล</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" id="name" value="<?php echo htmlspecialchars($userRow['name']); ?>">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">สัญชาติ</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" id="region" placeholder="สัญชาติ" value="<?php echo $userRow['nationality'] ?>">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">อายุ</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" id="age" placeholder="อายุ" value="<?php echo $userRow['age'] ?>">

                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">เลขบัตรประจำตัวประชาชน</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" id="idcard" name="idcard" value="<?php echo htmlspecialchars($userRow['idcard']); ?>">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="address" class="form-label">บ้านเลขที่</label>
                            <input type="text" class="form-control" id="address" value="<?php echo htmlspecialchars($userRow['Address']); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="name" class="form-label">หมู่ที่</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" name="group" id="group" placeholder="หมู่ที่" value="<?php echo htmlspecialchars($userRow['Addressgroup']); ?>">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="name" class="form-label">ตรอก/ซอย</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" name="lane" id="lane" placeholder="ตรอก/ซอย (หากไม่มีไม่ต้องใส่)" value="<?php echo htmlspecialchars($userRow['lane']); ?>">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="name" class="form-label">ถนน</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control" name="road" id="road" placeholder="ถนน (หากไม่มีไม่ต้องใส่)" value="<?php echo htmlspecialchars($userRow['road']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="district" class="form-label">ตำบล</label>
                            <input type="text" class="form-control" id="district" name="district" value="<?php echo htmlspecialchars($userRow['sdname_th']); ?>" disabled>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="amphure" class="form-label">อำเภอ</label>
                            <input type="text" class="form-control" id="amphure" name="amphure" value="<?php echo htmlspecialchars($userRow['dname_th']); ?>" disabled>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="province" class="form-label">จังหวัด</label>
                            <input type="text" class="form-control" id="province" name="province" value="<?php echo htmlspecialchars($userRow['pname_th']); ?>" disabled>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="postalCode" class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" class="form-control" id="postalCode" name="postalCode" value="<?php echo htmlspecialchars($userRow['zip_code']); ?>" disabled>
                        </div>
                    </div>
            </div>
            <hr class="my-4">
            <div class="col-12">
                <h4 class="text-center">เอกสารที่จำเป็นต้องยื่น (แนบไฟล์ PDF เท่านั้น) </h4>
                <a class="btn-custom" data-toggle="modal" data-target="#download">ดาวน์โหลดเอกสารเปล่าได้ที่นี้</a>
                <form id="submissionForm" action="submit.php" method="post" enctype="multipart/form-data" class="needs-validation mt-2">
                    <ul class="list-group">
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
                                $showrequire = " (ถ้ามี) ";
                            }
                            if (strpos($fileRow['status'], '3') === false) {
                                if($fileRow['mandatory'] == 1){
                                    echo '<li class="list-group-item">';
                                    echo '<h5 class="my-0">' . $i . '. ' . htmlspecialchars($fileRow['file_name']) .'</h5>';
                                    echo '<input class="form-control form-control-sm" type="file" id="file' . $i . '" name="file' . $i . '" accept=".pdf" required />';
                                    echo '</li>';
                                } else {
                                    echo '<li class="list-group-item">';
                                    echo '<h5 class="my-0">' . $i . '. ' . htmlspecialchars($fileRow['file_name']) .' (ถ้ามี)</h5>';
                                    echo '<input class="form-control form-control-sm" type="file" id="file' . $i . '" name="file' . $i . '" accept=".pdf" />';
                                    echo '</li>';
                                }
                            } else {
                                if($fileRow['mandatory'] == 1){
                                    echo '<li class="list-group-item">';
                                    echo '<h5 class="my-0">' . $i . '. ' . htmlspecialchars($fileRow['file_name']) .'</h5>';
                                    echo '<input class="form-control form-control-sm" type="file" id="file' . $i . '" name="file' . $i . '" accept=".pdf" required />';
                                    echo '<h5 class="mt-2"><span class="bg-danger text-light rounded p-1">กรณีนิติบุคคล</span></h5>';
                                    echo '</li>';
                                } else {
                                    echo '<li class="list-group-item">';
                                    echo '<h5 class="my-0">' . $i . '. ' . htmlspecialchars($fileRow['file_name']) .' (ถ้ามี)</h5>';
                                    echo '<input class="form-control form-control-sm" type="file" id="file' . $i . '" name="file' . $i . '" accept=".pdf" />';
                                    echo '<h5 class="mt-2"><span class="bg-danger text-light rounded p-1">กรณีนิติบุคคล</span></h5>';
                                    echo '</li>';
                                }
                            }
                        }
                        $_SESSION['file_count'] = $i;
                        ?>
                    </ul>

                    <div class="col-12 mt-3">
                        <input class="w-100 btn btn-success btn-lg" type="submit" value="ยืนยัน">
                    </div>
                </form>
            </div>
        </div> <!-- div form container -->

        <div class="note-section mt-4">
            <div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="noteModalLabel">หมายเหตุ</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php
                            $sql = "SELECT n.note FROM title t, note n ,title_note tn WHERE tn.tid = t.tid AND tn.nid = n.nid AND t.tid = '$tid'";
                            $result = $conn->query($sql);
                            $i = 0;
                            while ($note = $result->fetch_assoc()) {
                                $i++;
                                echo '<p>' . $i . '. ' . htmlspecialchars($note['note']) . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cautionModal" tabindex="-1" role="dialog" aria-labelledby="cautionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cautionModalLabel">คำเตือน!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $sql = "SELECT n.note FROM title t JOIN title_caution tc ON tc.tid = t.tid JOIN note n ON tc.cid = n.nid WHERE t.tid = '$tid'";
                        $result = $conn->query($sql);
                        $i = 0;
                        while ($caution = $result->fetch_assoc()) {
                            $i++;
                            echo '<p>' . $i . '. ' . $caution['note'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="feeModal" tabindex="-1" role="dialog" aria-labelledby="feeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feeModalLabel">ค่าธรรมเนียม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $sql = "SELECT f.fee FROM title t, fee f ,title_fee tf WHERE tf.tid = t.tid AND tf.fid = f.fid AND t.tid = '$tid'";
                        $result = $conn->query($sql);
                        $i = 0;
                        while ($fee = $result->fetch_assoc()) {
                            $i++;
                            echo '<p>' . $i . '. ' . htmlspecialchars($fee['fee']) . '</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="download" tabindex="-1" role="dialog" aria-labelledby="cautionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cautionModalLabel">เอกสารเปล่าที่ดาวน์โหลดได้<p>ดาวน์โหลดเอกสารมากรอกและนำส่งในระบบ</p>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $sql = "SELECT f.filepath , f.file_name FROM title t , title_file tf , files f WHERE tf.tid = t.tid AND tf.file_id = f.file_id AND t.tid = $tid AND f.status LIKE '%2%';";
                        $result = $conn->query($sql);
                        while ($file = $result->fetch_assoc()) {
                            echo  '<a href="' . $file['filepath'] . '"  target="_blank" >เอกสาร' . $file['file_name'] . '</a><br>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('submissionForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Validate file inputs
            const fileInputs = form.querySelectorAll('input[type="file"]');
            let hasErrors = false;
            let missingFiles = [];

            fileInputs.forEach(input => {
                if (input.hasAttribute('required') && !input.files.length) {
                    hasErrors = true;
                    missingFiles.push(input.closest('li').querySelector('h5').textContent.trim());
                    input.classList.add('is-invalid'); // Add Bootstrap invalid class
                } else {
                    input.classList.remove('is-invalid'); // Remove Bootstrap invalid class if file is attached
                }
            });

            if (hasErrors) {
                Swal.fire({
                    title: 'ข้อมูลไม่สมบูรณ์!',
                    text: 'กรุณาแนบไฟล์ที่จำเป็นต่อไปนี้: \n' + missingFiles.join(', '),
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
<script src="assets/jquery.min.js"></script>
<script src="assets/script.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>