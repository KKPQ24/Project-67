<?php
require 'navbar.php';
require '../bootstrap.html';
require '../condb.php';

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/Photoroom.png">
    <title>ที่ว่าการอำเภอสัตหีบ</title>

    <style>
     body {
    font-family: "K2D", sans-serif;
       margin: 0;
        padding: 0;
        background-color: #074173;
        color: white;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    .profile {
        text-align: center;
    }

    .profile img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        margin-bottom: 20px;
    }

    .profile p {
        margin: 5px 0;
        margin-bottom: 25px;
        font-size: 22px;
    }

    .btn-danger {
        background-color: #FF4444;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 100px;
    }

    .btn-danger:hover {
        background-color: #FF3333;
    }

    .link-underline-light {
        color: white;
        font-size: 22px;
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
    
    .navbar .navbar-nav {
        display: flex;
        align-items: center; /* Center items vertically */
    }

    .navbar-dark .navbar-nav .nav-link {
        color: white;
        margin: 10px; /* Adjust spacing between navbar items */
    }

    .navbar-dark .navbar-nav .nav-link img {
        margin-right: 5px;
    }
</style>

</head>
<body>

<div class="container">
    <div class="profile">
        <img src="../img/Remove-bg.ai_1721096077629.png" alt="user avatar">
        <p>ชื่อผู้ใช้ : <?php echo $_SESSION['name'] ?></p>
        <p>เบอร์โทรศัพท์ : <?php echo $_SESSION['telephone'] ?></p>
    </div>

    <a href="setting.php" class="link-underline-light">แก้ไขข้อมูลส่วนตัว</a>
    <br>
    <a href="../logout.php" class="btn btn-danger">ออกจากระบบ</a>
</div>

<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>