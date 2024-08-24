<?php
session_start();
require 'condb.php';

$idNum = $_POST['idcard'];
$name = $_POST['name'];
$tel = $_POST['tel'];
$bday = $_POST['bday'];
$email = $_POST['email'];
$province = $_POST['province_id'];
$district = $_POST['amphure_id'];
$subdistrict = $_POST['district_id'];
$address = $_POST['address'];


$sql = "SELECT * FROM users WHERE idcard = '$idNum'";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    echo "<script>alert('User already exists'); window.location.href = 'index.php';</script>";
} else {
    // Insert new user
    $sql = "INSERT INTO `users` (`uid`, `name`, `idcard`, `telephone`, `email`, `bday`, `password`, `province_id`, `district_id`, `subdistrict_id`, `Address`, `role_id`) VALUES (NULL, '$name', '$idNum', '$tel', '$email', '$bday', '$bday', $province, $district, $subdistrict, '$address', 1);";    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Register Successfully'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>