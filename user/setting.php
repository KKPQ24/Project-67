<?php
require 'navbar.php';
require '../condb.php';

$uid = $_SESSION['uid'];

$response = array('status' => '', 'message' => '');
$error_message = '';
$success_message = '';
$redirect_url = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect POST data
    $name = $_POST['name'] ?? '';
    $idcard = $_POST['idcard'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $email = $_POST['email'] ?? '';
    $bday = $_POST['bday'] ?? '';
    $province = $_POST['province'] ?? '';
    $district = $_POST['district'] ?? '';
    $subdistrict = $_POST['subdistrict'] ?? '';
    $address = $_POST['address'] ?? '';

    // Prepare the SQL query
    $sql = "UPDATE users SET name = '$name', idcard = '$idcard', telephone = '$telephone', email = '$email', bday = '$bday', 
            province_id = (SELECT id FROM provinces WHERE pname_th = '$province'),
            district_id = (SELECT id FROM district WHERE dname_th = '$district'),
            subdistrict_id = (SELECT id FROM subdistrict WHERE sdname_th = '$subdistrict'),
            Address = '$address'
            WHERE uid = $uid";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Update Success: ' . htmlspecialchars($bday) . '"); window.location.href="index.php";</script>';
    } else {
        echo '<script>alert("Update Failed: ' . htmlspecialchars($conn->error) . '");</script>';
    }
    exit;
}
?>

<?php if (!empty($error_message) || !empty($success_message)) : ?>
    <script>
        <?php if (!empty($error_message)) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo htmlspecialchars($error_message); ?>'
            });
        <?php elseif (!empty($success_message)) : ?>
            Swal.fire({
                icon: 'success',
                title: 'ยินดีต้องรับเข้าสู่ระบบ',
                text: '<?php echo htmlspecialchars($success_message); ?>',
                timer: 1700,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '<?php echo $redirect_url; ?>';
            });
        <?php endif; ?>
    </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ที่ว่าการอำเภอสัตหีบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
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

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-control,
        .btn-outline-success,
        .btn-outline-danger,
        .btn-light {
            border-radius: 0.375rem;
        }

        .btn-group {
            margin-top: 15px;
        }

        .swal2-confirm {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .swal2-cancel {
            background-color: #f44336;
            color: white;
            border: none;
        }
        .navbar {
        background-color: #1679AB;
        padding: 10px;
        display: flex;
        align-items: center; /* Center items vertically */
        justify-content: space-between; /* Distribute items evenly */
        font-size: 20px;
        }

    </style>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <div class="container">
        <?php
        $sql = "SELECT * FROM users WHERE uid = $uid";
        if($result = $conn->query($sql)){
            $row = $result->fetch_assoc();
        }
        ?>
        <div class="profile-header text-center mb-4">
            <h3>ข้อมูลส่วนตัว</h3>
        </div>

        <form id="profile-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="name">ชื่อ-นามสกุล :</label>
                <input type="text" class="form-control" value="<?php echo $row['name'] ?>" id="name" name="name" disa>
            </div>
            <div class="form-group">
                <label for="idcard">รหัสบัตรประชาชน :</label>
                <input type="text" class="form-control" value="<?php echo $row['idcard'] ?>" id="idcard" name="idcard">
            </div>
            <div class="form-group">
                <label for="telephone">เบอร์โทรศัพท์ :</label>
                <input type="text" class="form-control" value="<?php echo $row['telephone'] ?>" id="telephone" name="telephone">
            </div>
            <div class="form-group">
                <label for="email">อีเมล์ :</label>
                <input type="text" class="form-control" value="<?php echo $row['email'] ?>" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="bday">วัน/เดือน/ปีเกิด :</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['bday']); ?>" id="bday" name="bday" disabled>
                <a href="#" class="btn btn-outline-warning mt-2" id="edit-bday">แก้ไขวัน/เดือน/ปีเกิด</a>
            </div>
            <?php
            $sql = "SELECT  p.pname_th ,  d.dname_th  , sd.sdname_th , sd.zip_code 
                        FROM provinces p, district d, subdistrict sd, users u 
                        WHERE u.province_id = p.id AND u.district_id = d.id AND u.subdistrict_id = sd.id AND u.uid = $uid;";
            $result = $conn->query($sql);
            $address = $result->fetch_assoc();
            ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-3">
                        <label for="province-form">จังหวัด :</label>
                        <input type="text" class="form-control" value="<?php echo $address['pname_th']; ?>" id="province-form" name="province_display" disabled>
                        <input type="hidden" value="<?php echo $address['pname_th']; ?>" id="province_hidden" name="province">
                    </div>
                    <div class="col-3">
                        <label for="district-form">อำเภอ :</label>
                        <input type="text" class="form-control" value="<?php echo $address['dname_th']; ?>" id="district-form" name="district_display" disabled>
                        <input type="hidden" value="<?php echo $address['dname_th']; ?>" id="district_hidden" name="district">
                    </div>
                    <div class="col-3">
                        <label for="subdistrict-form">ตำบล :</label>
                        <input type="text" class="form-control" value="<?php echo $address['sdname_th']; ?>" id="subdistrict-form" name="subdistrict_display" disabled>
                        <input type="hidden" value="<?php echo $address['sdname_th']; ?>" id="subdistrict_hidden" name="subdistrict">
                    </div>
                    <div class="col-3">
                        <label for="zipcode">รหัสไปรษณีย์ :</label>
                        <input type="text" class="form-control" value="<?php echo $address['zip_code']; ?>" id="zipcode-form" name="zipcode_display" disabled>
                        <input type="hidden" value="<?php echo $address['zip_code']; ?>" id="zipcode_hidden" name="zipcode">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-3">
                        <label for="address">บ้านเลขที่ :</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['Address']); ?>" id="address-form" name="address_display" disabled>
                        <input type="hidden" value="<?php echo htmlspecialchars($row['Address']); ?>" id="address_hidden" name="address">
                    </div>
                    <div class="col-3">
                        <label for="addressgroup-form">หมู่ที่ :</label>
                        <input type="text" class="form-control" value="<?php echo $row['Addressgroup']; ?>" id="addressgroup-form" name="addressgroup_display" disabled>
                        <input type="hidden" value="<?php echo $row['Addressgroup']; ?>" id="addressgroup_hidden" name="addressgroup">
                    </div>
                    <div class="col-3">
                        <label for="lane-form">ตรอก/ซอย :</label>
                        <input type="text" class="form-control" value="<?php echo $row['lane']; ?>" id="lane-form" name="lane_display" disabled>
                        <input type="hidden" value="<?php echo $row['lane']; ?>" id="lane_hidden" name="lane">
                    </div>
                    <div class="col-3">
                        <label for="road-form">ถนน :</label>
                        <input type="text" class="form-control" value="<?php echo $row['road']; ?>" id="road-form" name="road_display" disabled>
                        <input type="hidden" value="<?php echo $row['road']; ?>" id="road_hidden" name="road">
                    </div>
                </div>

            </div>
            <div class="btn-group">
            <a href="#" class="btn btn-primary" style="border: lightgray 2px solid;" id="edit-address">
            <i class="bi bi-pencil"></i> <!-- Edit icon -->
            แก้ไขที่อยู่</a>
            <a href="#" class="btn btn-primary" style="border: lightgray 2px solid;" id="change-password">
            <i class="bi bi-lock"></i> <!-- Lock icon -->
            แก้ไขรหัสผ่าน</a>
            </div>
        <div class="btn-group">
            <input type="submit" class="btn btn-success" value="บันทึก" style="border: lightgray 2px solid;">
            <a href="index.php" class="btn btn-danger" style="border: lightgray 2px solid;">
                <i class="bi bi-x-circle"></i>
                ยกเลิก
            </a>
        </div>

        </form>
    </div>

    <!-- Edit Birthday Modal -->
    <div class="modal fade" id="editBdayModal" tabindex="-1" aria-labelledby="editBdayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBdayModalLabel">แก้ไขวัน/เดือน/ปีเกิด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bday-form">
                    <div class="form-group">
                        <label for="modal-bday">วัน/เดือน/ปีเกิด:</label>
                        <input type="date" class="form-control" id="modal-bday" name="bday" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> ปิด
                </button>
                <button type="button" class="btn btn-primary" id="save-bday">
                    <i class="bi bi-check-circle"></i> บันทึก
                </button>
            </div>
        </div>
    </div>
</div>


    <!-- Edit Address Modal -->
    <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAddressModalLabel">แก้ไขที่อยู่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color: #f44336;">**หมายเหตุ หากไม่เลือกใหม่จะใช้ที่อยู่อันเดิม</p>
                    <form id="address-form">
                    <div class="form-group">
                        <label for="modal-address"><i class="bi bi-house-door"></i> บ้านเลขที่:</label>
                        <input type="text" class="form-control" id="modal-address" name="address">
                    </div>
                    <div class="form-group">
                        <label for="modal-village"><i class="bi bi-building"></i> หมู่ที่:</label>
                        <input type="text" class="form-control" id="modal-village" name="village">
                    </div>
                    <div class="form-group">
                        <label for="modal-alley"><i class="bi bi-signpost"></i> ตรอก/ซอย:</label>
                        <input type="text" class="form-control" id="modal-alley" name="alley">
                    </div>
                    <div class="form-group">
                        <label for="modal-road"><i class="bi bi-signpost-split"></i> ถนน:</label>
                        <input type="text" class="form-control" id="modal-road" name="road">
                    </div>
                    <div class="form-group">
                        <label for="modal-province"><i class="bi bi-geo-alt"></i> จังหวัด:</label>
                        <select class="form-control" id="modal-province" name="province">
                            <option value="">เลือกจังหวัด</option>
                            <?php
                            $sql = "SELECT * FROM provinces";
                            $query = mysqli_query($conn, $sql);
                            while ($result = mysqli_fetch_assoc($query)) : ?>
                                <option value="<?= $result['pname_th'] ?>"><?= $result['pname_th'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modal-district"><i class="bi bi-geo"></i> อำเภอ:</label>
                        <select class="form-control" id="modal-district" name="district">
                            <option value="">เลือกอำเภอ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modal-subdistrict"><i class="bi bi-geo-fill"></i> ตำบล:</label>
                        <select class="form-control" id="modal-subdistrict" name="subdistrict">
                            <option value="">เลือกตำบล</option>
                        </select>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
    <i class="bi bi-x-circle me-2"></i>
    ปิด
</button>
                    <button type="button" class="btn btn-primary" id="save-address">
                    <i class="bi bi-check-circle"></i>
                        บันทึก
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/jquery.min.js"></script>
    <script src="assets/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#edit-bday').click(function(e) {
                e.preventDefault();
                $('#editBdayModal').modal('show');
            });

            $('#save-bday').click(function() {
                var newBday = $('#modal-bday').val();
                if (newBday) {
                    $('#bday').val(newBday);
                    $('#editBdayModal').modal('hide');
                }
            });

            $('#edit-address').click(function(e) {
                e.preventDefault();
                $('#editAddressModal').modal('show');
            });

            $('#save-address').click(function() {
                var province = $('#modal-province').val();
                var district = $('#modal-district').val();
                var subdistrict = $('#modal-subdistrict').val();
                var address = $('#modal-address').val();

                if ((province && district && subdistrict) || address) {
                    if (address) {
                        $('#address_hidden').val(address);
                        $('#address-form').val(address);
                    }

                    if (province && district && subdistrict) {
                        $('#province_hidden').val(province);
                        $('#district_hidden').val(district);
                        $('#subdistrict_hidden').val(subdistrict);

                        // Update the display fields with the text of the selected options
                        $('#province-form').val($('#modal-province option:selected').text());
                        $('#district-form').val($('#modal-district option:selected').text());
                        $('#subdistrict-form').val($('#modal-subdistrict option:selected').text());
                    }

                    $('#editAddressModal').modal('hide');
                }
            });

        });

        $(document).ready(function() {
            $('#change-password').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'แก้ไขรหัสผ่าน',
                    html: `
                        <form id="change-password-form">
                            <div class="mb-3">
                                <label for="current-password" class="form-label">รหัสผ่านเดิม</label>
                                <input type="password" id="current-password" name="current_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="new-password" class="form-label">รหัสผ่านใหม่</label>
                                <input type="password" id="new-password" name="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm-new-password" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" id="confirm-new-password" class="form-control" required>
                            </div>
                        </form>
                    `,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก',
                    showCancelButton: true,
                    preConfirm: () => {
                        const currentPassword = Swal.getPopup().querySelector('#current-password').value;
                        const newPassword = Swal.getPopup().querySelector('#new-password').value;
                        const confirmNewPassword = Swal.getPopup().querySelector('#confirm-new-password').value;

                        if (newPassword !== confirmNewPassword) {
                            Swal.showValidationMessage('รหัสผ่านใหม่และการยืนยันรหัสผ่านไม่ตรงกัน');
                            return false;
                        }

                        return {
                            currentPassword: currentPassword,
                            newPassword: newPassword
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'changepass.php',
                            type: 'POST',
                            data: {
                                current_password: result.value.currentPassword,
                                new_password: result.value.newPassword
                            },
                            success: (response) => {
                                const jsonResponse = JSON.parse(response);
                                if (jsonResponse.status === 'success') {
                                    Swal.fire('สำเร็จ!', 'รหัสผ่านถูกเปลี่ยนเรียบร้อยแล้ว', 'success');
                                } else {
                                    Swal.fire('ข้อผิดพลาด!', 'รหัสผ่านเก่าไม่ถูกต้อง', 'error');
                                }
                            },
                            error: (jqXHR, textStatus, errorThrown) => {
                                Swal.fire('ข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการติดต่อกับเซิร์ฟเวอร์', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <?php mysqli_close($conn); ?>
</body>

</html>