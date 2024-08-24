<?php
require '../condb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tid = $_POST['recordId'];

    if (isset($tid)) {
        $result = $conn->query('SELECT * FROM issue where tid = $tid');
        if($result){
            echo 'ลบไม่ได้เพราะมีผู้ใช้ยื่นคำร้องนี้อยู่';
        } else {
        $resultStatus = $resultCaution = $resultFee = $resultNote = $resultFiles = false;

        // Delete status
        $result = $conn->query("SELECT * FROM title_status WHERE tid = $tid");
        if ($result && $result->num_rows > 0) {
            $selectid = "";
            while ($row =  $result->fetch_assoc()) {
                $selectid = $row['sid'];
                $conn->query("DELETE FROM title_status WHERE tid = $tid AND sid = $selectid");
                $conn->query("DELETE FROM statuss WHERE sid = $selectid");
            }
            $resultStatus = true;
        }

        // Delete caution
        $result = $conn->query("SELECT * FROM title_caution WHERE tid = $tid");
        if ($result && $result->num_rows > 0) {
            $selectid = "";
            while ($row =  $result->fetch_assoc()) {
                $selectid = $row['cid'];
                $conn->query("DELETE FROM title_caution WHERE tid = $tid AND cid = $selectid");
                $conn->query("DELETE FROM caution WHERE cid = $selectid");
            }
            $resultStatus = true;
        }

        // Delete fee
        $result = $conn->query("SELECT * FROM title_fee WHERE tid = $tid");
        if ($result && $result->num_rows > 0) {
            $selectid = "";
            while ($row =  $result->fetch_assoc()) {
                $selectid = $row['fid'];
                $conn->query("DELETE FROM title_fee WHERE tid = $tid AND fid = $selectid");
                $conn->query("DELETE FROM fee WHERE fid = $selectid");
            }
            $resultFee = true;
        }

        // Delete note
        $result = $conn->query("SELECT * FROM title_note WHERE tid = $tid");
        if ($result && $result->num_rows > 0) {
            $selectid = "";
            while ($row =  $result->fetch_assoc()) {
                $selectid = $row['nid'];
                $conn->query("DELETE FROM title_note WHERE tid = $tid AND nid = $selectid");
                $conn->query("DELETE FROM note WHERE nid = $selectid");
            }
            $resultNote = true;
        }

        // Delete files
        $result = $conn->query("SELECT * FROM title_file WHERE tid = $tid");
        if ($result && $result->num_rows > 0) {
            while ($row =  $result->fetch_assoc()) {
                $selectid = $row['file_id'];
                
                // Fetch the file path
                $resultFilePath = $conn->query("SELECT filepath FROM files WHERE file_id = $selectid");
                if ($resultFilePath && $resultFilePath->num_rows > 0) {
                    while ($fileRow = $resultFilePath->fetch_assoc()) {
                        // Delete the file from the directory
                        if (file_exists($fileRow['filepath'])) {
                            unlink($fileRow['filepath']);
                        }
                    }
                }
                $conn->query("DELETE FROM title_file WHERE tid = $tid AND file_id = $selectid");
                $conn->query("DELETE FROM files WHERE file_id = $selectid");
            }
            $resultFiles = true;
        } else {
            $resultFiles = false;
            echo "No files found for the given tid.";
        }        

        if ($resultStatus || $resultCaution || $resultFee || $resultNote || $resultFiles) {
            $conn->query("DELETE FROM title WHERE tid = $tid");
            echo "success";
        } else {
            echo "No related records found or delete failed.";
        }
    }
    } else {
        echo "Record ID not found";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
