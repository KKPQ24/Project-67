<?php
require 'navbar.php';

require '../bootstrap.html';
require '../condb.php';

if ($_SERVER["REQUEST_METHOD"] == 'GET' && isset($_GET['uid']) && isset($_GET['status'])) {
    $uid = $_GET['uid'];
    $status = $_GET['status'];
    
    if ($status == 1 || $status == 0) {
        $result = $conn->query("DELETE FROM history WHERE uid = $uid AND status = $status");
        if ($result) {
            echo '<script>alert("Delete success")</script>';
        }
    }
}


?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #074173;
            color: black;
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


        .container {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 85%; /* Ensure container can expand */
        }

        table {
            background-color: white;
            color: #074173;
            margin-top: 20px; 
            width: 100%; /* Ensure table spans full width */
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #074173;
            padding: 15px; 
            text-align: center;
            font-size: 18px;
        }

        th {
            background-color: #1679AB;
            color: black;
            font-size: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 36px;
        }

        h5 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container {
            text-align: right;
            margin-bottom: 10px;
        }

        .search-input {
            width: 300px;
            padding: 5px;
            margin-right: 10px;
        }

        .btn-search {
            padding: 10px 20px;
            background-color: #1679AB;
            color: white;
            border: 1px solid #1679AB; 
            border-radius: 5px;
            transition: all 0.3s ease; 
        }

        .btn-search:hover {
            background-color: #125682;
            border-color: #125682; 
            color: white;
            text-decoration: none;
        }

        .btn-search:focus {
            outline: none;
            box-shadow: 0 0 0 2px #125682;
        }

    </style>
</head>
<body>
    

    <h1 class="text-light">ประวัติการยื่นคำร้อง</h1>
    <h5 class="text-light">ของ <?php echo $name; ?></h5>

    <div class="container">
    <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?uid=<?php echo $uid; ?>&status=1" >Delete</a>
    <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="ค้นหา...">
            <button class="btn btn-primary btn-search" onclick="searchTable()">ค้นหา</button>
        </div>
        <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th scope="col">ลำดับที่</th>
                    <th scope="col">รายการคำร้อง</th>
                    <th scope="col">ไฟล์ที่ยื่น</th>
                    <th scope="col">วันที่ทำรายการสำเร็จ</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $i = 0;
                $sql = "SELECT t.title ,h.filepath, h.completion_date FROM history h , users u , title t Where h.uid = '$uid' AND h.uid = u.uid AND h.tid = t.tid AND status = 1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    $i++;
                ?>    
                <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><?php echo $row['title'] ?></td>
                    <td><a href="<?php echo $row['filepath'] ?>">ดูไฟล์ของฉัน</a></td>
                    <td><?php echo $row['completion_date'] ?></td>
                </tr>
            <?php  }} ?>
            </tbody>
        </table>
    </div>

    <div class="container">
    <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?uid=<?php echo $uid; ?>&status=0" class="btn btn-outline-danger">Delete</a>
    <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="ค้นหา...">
            <button class="btn btn-primary btn-search" onclick="searchTable()">ค้นหา</button>
        </div>
        <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th scope="col">ลำดับที่</th>
                    <th scope="col">รายการคำร้อง</th>
                    <th scope="col">ไฟล์ที่ยื่น</th>
                    <th scope="col">วันที่ทำรายการสำเร็จ</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $i = 0;
                $sql = "SELECT t.title ,h.filepath, h.completion_date FROM history h , users u , title t Where h.uid = '$uid' AND h.uid = u.uid AND h.tid = t.tid AND status = 0";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    $i++;
                ?>    
                <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td><?php echo $row['title'] ?></td>
                    <td><a href="<?php echo $row['filepath'] ?>">ดูไฟล์ของฉัน</a></td>
                    <td><?php echo $row['completion_date'] ?></td>
                </tr>
            <?php  }} ?>
            </tbody>
        </table>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>