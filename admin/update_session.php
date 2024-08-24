<?php
session_start();

if (isset($_POST['totalfile'])) {
    $_SESSION['totalfile'] = $_POST['totalfile'];
}

if (isset($_POST['totalfee'])) {
    $_SESSION['totalfee'] = $_POST['totalfee'];
}

if (isset($_POST['totalcaution'])) {
    $_SESSION['totalcaution'] = $_POST['totalcaution'];
}

if (isset($_POST['totalnote'])) {
    $_SESSION['totalnote'] = $_POST['totalnote'];
}

header("Location: tables.php");
exit();
?>