<?php
require '../condb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $issue_id = $_POST['issue_id'];
    
    $result = $conn->query("SELECT * FROM issue WHERE issue_id = $issue_id");
    if ($row = $result->fetch_assoc()) {
        $tid = $row['tid'];
        $uid = $row['uid'];
        $issue_date = $row['issue_date'];
        $comment = $row['comment'];
        $file = $row['file'];
        $completion_date= (new DateTime())->format('Y-m-d');
        $file = $row['file'];
        // if ($file && file_exists($file)) {
        //     unlink($file);
        // }
    }

    $result = $conn->query("DELETE FROM issue WHERE issue_id = $issue_id");
    if ($result) {
        echo "
        <script>
            alert('ยกเลิกคำร้องเสร็จสิ้น');
            window.location.href = 'trackform.php';
        </script>
        ";
    }
}
?>
