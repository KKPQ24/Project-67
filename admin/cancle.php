<?php
require('../condb.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['issue_id']) && isset($_POST['comment'])){
        $issue_id = $_POST['issue_id'];
        $comment = $conn->real_escape_string($_POST['comment']); // Escape the comment to prevent SQL injection

        $result = $conn->query("UPDATE issue SET comment = '$comment', sid = 2 WHERE issue_id = $issue_id");
        if($result){
            echo json_encode("Update success");
            header("Location:waiting.php");
            exit();
        } else {
            echo json_encode("Update failed");
        }
    }
}

$conn->close();
?>
