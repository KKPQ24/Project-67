<?php
 session_start();
 $name = $_SESSION['name'];
 $uid = $_SESSION['uid'];
 $idcard = $_SESSION['idcard'];
 $telephone = $_SESSION['telephone'];

 if($_SESSION['Loginsuccess'] != 1 ){
    header("Location:../index.php");
}

?>
<link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Thasadith:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<style>
        body, .navbar, .nav-link {
    font-family: "K2D", sans-serif;
    }
     body {
        font-family: "K2D", sans-serif;
        margin: 0;
        padding: 0;
        background-color: #074173;
        color: white;
    }

    .navbar {
        background-color: #1679AB;
        padding: 10px;
        display: flex;
        align-items: center; /* Center items vertically */
        justify-content: space-between; /* Distribute items evenly */
        font-size: 20px;
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
<link rel="icon" href="../img/Photoroom.png">
<nav class="navbar navbar-expand-lg navbar-dark">
              <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <img src="../img/Photoroom.png" alt="edit icon" class="home">
                        </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="form.php">
                        <img src="../img/file-earmark-arrow-up-fill.svg" alt="edit icon" class="icon">
                        ยื่นคำร้องที่ต้องการ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="trackform.php">
                        <img src="../img/doc.svg" alt="track icon" class="icon">
                        ติดตามคำร้องที่ยื่น
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="history.php">
                        <img src="../img/clock-history.svg" alt="track icon" class="icon">
                        ประวัติการยื่นคำร้อง
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="setting.php">
                        <img src="../img/person-square.svg" alt="privacy icon" class="icon">
                        ข้อมูลส่วนตัว
                    </a>
                </li>
            </ul>
</nav>