<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../condb.php';
session_start();

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uid = $_SESSION['uid'];
    $cpass = $_POST['current_password'];
    $npass = $_POST['new_password'];

    $stmt = $conn->prepare("SELECT password, bday FROM users WHERE uid = ?");
    if (!$stmt) {
        $response = ['status' => 'error', 'message'];
        echo json_encode($response);
        exit();
    }
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $stringbday = (string) $user['bday'];
        // Verify current password
        if ($cpass == $user['password'] || $cpass == $stringbday) {
            // Prepare and execute statement to update password
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE uid = ?");
            if (!$stmt) {
                $response = ['status' => 'error', 'message' => 'Prepare statement failed: ' . $conn->error];
                echo json_encode($response);
                exit();
            }
            $stmt->bind_param("si", $npass, $uid);

            if ($stmt->execute()) {
                $response = ['status' => 'success'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to update password: ' . $stmt->error];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Current password is incorrect'];
        }
    }
    $stmt->close();
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method'];
}

$conn->close();
echo json_encode($response);
?>