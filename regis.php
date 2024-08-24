<?php
include('condb.php');
require 'bootstrap.html';
$sql = "SELECT * FROM provinces";
$query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #174380;
            font-family: Arial, sans-serif;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            width: 100%;
        }
        .container img {
            display: block;
            margin: 0 auto 20px;
            width: 150px;
            height: auto;
            border-radius: 50%;
            border: 2px solid #333;
            background-color: #fff;
            padding: 2px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        
        input[type=text], input[type=date], textarea, select, input[type=tel], input[type=email] {
            width: calc(100% - 24px);
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
            text-transform: uppercase;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        p {
            font-size: 14px;
            color: #333;
            margin-top: 10px;
            text-align: center;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
            color: #388e3c;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .form-group {
            flex: 1;
            min-width: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="regiswork.php" method="post">
            <img src="img/Photoroom.png" alt="Logo">
            <input type="text" name="idcard" required placeholder="บัตรประชาชน">
            <input type="text" name="name" required placeholder="ชื่อ-นามสกุล">
            <input type="tel" name="tel" required placeholder="เบอร์โทรศัพท์">
            <input type="date" name="bday" required placeholder="Birth day">
            <input type="email" name="email" placeholder="อีเมล์">
            <div class="form-row">
                <div class="form-group">
                    <label for="province">จังหวัด</label>
                    <select name="province_id" id="province">
                        <option value="">เลือกจังหวัด</option>
                        <?php while($result = mysqli_fetch_assoc($query)): ?>
                            <option value="<?= $result['id'] ?>"><?= $result['pname_th'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amphure">อำเภอ</label>
                    <select name="amphure_id" id="amphure">
                        <option value="">เลือกอำเภอ</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="district">ตำบล</label>
                    <select name="district_id" id="district">
                        <option value="">เลือกตำบล</option>
                    </select>
                </div>
            </div>
            <textarea rows="3" required name="address" placeholder="ที่อยู๋"></textarea>
            <input type="submit" name="submit" value="สมัครสมาชิก">
            <p>มีสมาชิกอยู่แล้ว? <a href="index.php">เข้าสู่ระบบ</a></p>
        </form>
    </div>

    <script src="assets/jquery.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>
<?php
mysqli_close($conn);
?>
