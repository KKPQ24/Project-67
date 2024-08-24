<?php
require 'condb.php';
require 'bootstrap.html';
require 'logo.php';
session_start();
$error_message = '';
$success_message = '';
$redirect_url = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['idcard']) && !empty($_POST['password'])) {
        $idcard = $_POST['idcard'];
        $password = $_POST['password'];

        // Use prepared statements to prevent SQL injection
        $stmtUser = $conn->prepare("SELECT * FROM users WHERE idcard = ?");
        $stmtUser->bind_param('s', $idcard);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        
        $stmtAdmin = $conn->prepare("SELECT * FROM employee WHERE idcard = ?");
        $stmtAdmin->bind_param('s', $idcard);
        $stmtAdmin->execute();
        $resultAdmin = $stmtAdmin->get_result();

        if ($resultUser->num_rows > 0) {
            $row = $resultUser->fetch_assoc();

            if ($row && ($row['password'] == $password || $row['bday'] == $password)) {
                // Set session variables for regular users
                $_SESSION['name'] = $row['name'];
                $_SESSION['uid'] = $row['uid'];
                $_SESSION['idcard'] = $row['idcard'];
                $_SESSION['telephone'] = $row['telephone'];
                $_SESSION['address'] = $row['Address'];
                $_SESSION['province'] = $row['province_id'];
                $_SESSION['district'] = $row['district_id'];
                $_SESSION['subdistrict'] = $row['subdistrict_id'];

                if ($row['role_id'] == '1') {
                    $success_message = "Login successful.";
                    $_SESSION['Loginsuccess'] = 1;
                    $redirect_url = "user/index.php";
                }
            } else {
                $error_message = "Please check ID-card and password.";
            }
        } elseif ($resultAdmin->num_rows > 0) {
            $row = $resultAdmin->fetch_assoc();

            if ($row && $row['password'] == $password) {
                $_SESSION['name'] = $row['Emp_name'];
                $_SESSION['uid'] = $row['Emp_id'];
                $_SESSION['idcard'] = $row['idcard'];
                $_SESSION['telephone'] = $row['telephone'];
                $_SESSION['address'] = $row['Address'];
                $_SESSION['province'] = $row['province_id'];
                $_SESSION['district'] = $row['district_id'];
                $_SESSION['subdistrict'] = $row['subdistrict_id'];

                if ($row['role'] == '1') {
                    $success_message = "Login successful.";
                    $_SESSION['Loginsuccess'] = 3;
                    $redirect_url = "admin/index.php";
                } else {
                    $success_message = "Login successful.";
                    $_SESSION['Loginsuccess'] = 2;
                    $redirect_url = "admin/index.php";
                }
            } else {
                $error_message = "Please check ID-card and password.";
            }
        } else {
            $error_message = "Please check ID-card and password.";
        }

        // Close the statements
        $stmtUser->close();
        $stmtAdmin->close();
    } else {
        $error_message = "Please fill in ID-card and password.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100vh;
            margin: 0;
            background: #174380;
            
        }
        form img {
            display: block;
            margin: 0 auto;
            width: 170px;
            height: auto; 
            background-color: white; 
            padding: 1px;
            border-radius: 50%;
            border: 2px solid white; 
        }
        form p {
            text-align: center;
        }
        form input[type="text"],
        form input[type="password"],
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #45a049;
        }
        p {
            color: white;
        }
        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <img class="mb-4" src="img/Photoroom.png" alt="" width="72" height="57">
        <input type="text" name="idcard" id="idcard" required placeholder="ID Card">
        <p>Password หากล็อคอินครั้งแรกใส่วันเกิด</p>
        <input type="password" name="password" placeholder="00-00-0000" id="password" required>
        <a href="regis.php">สมัครสมาชิก</a>
        <input type="submit" name="submit" value="Login">
    </form>

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
</body>
</html>

