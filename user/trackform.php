<?php
require '../bootstrap.html';
require '../condb.php';
session_start();
if($_SESSION['Loginsuccess'] != 1 ){
    header("Location:../index.php");
}
$uid = $_SESSION['uid'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ที่ว่าการอำเภอสัตหีบ</title>
    <link rel="icon" href="../img/Photoroom.png">

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100vh;
            margin: 0;
            background: #f0f0f0; /* Light gray background */
            font-family: Arial, sans-serif; /* Default font family */
        }
        .container {
            text-align: center;
            margin-top: 20px; /* Adjust top margin */
        }
        img.logo {
            display: block;
            margin: 0 auto; /* Center the image */
            width: 250px; /* Larger width */
            height: auto;
            border-radius: 50%;
            border: 2px solid #fff;
            background-color: #fff; /* White background */
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="index.php">
            <img class="logo mb-4" src="../img/Photoroom.png" alt="Logo">
        </a>
        <br>
        <form action="track.php" method="post" enctype="multipart/form-data">
            <select class="selectpicker w-50" name="issue_id" id="issue_id" required>
                <option value="">หัวข้อคำร้อง</option>
                <?php
                $sql = "SELECT t.title , i.issue_date , i.issue_id FROM issue i , title t where i.tid = t.tid AND uid = $uid;";
                $result = $conn ->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['issue_id'], ENT_QUOTES, 'UTF-8') . '">'
                            . htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8') . " ของวันที่ "
                            . htmlspecialchars($row["issue_date"], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                }
                ?>
            </select>
            <br>
            <br>
            <button type="submit" class="btn btn-secondary w-50">ยืนยัน</button>
        </form>



    </div>


</body>

</html>