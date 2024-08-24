<?php
require '../condb.php';
session_start();
if($_SESSION['Loginsuccess'] != 1 ){
    header("Location:../index.php");
}
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uid = $_SESSION['uid'];
    $name = $_POST['name'];
    $idcard = $_POST['idcard'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $bday = $_POST['bday'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, idcard = ?, telephone = ?, email = ?, bday = ? WHERE uid = ?");
    $stmt->bind_param("sssssi", $name, $idcard, $telephone, $email, $bday, $uid);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
    }

    $stmt->close();
}
$conn->close();
?>
