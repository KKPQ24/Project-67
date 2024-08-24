<?php
require '../condb.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = $conn->real_escape_string($_POST['title']);
    $duration = $conn->real_escape_string($_POST['duration']);
    
    // Arrays to store dynamic form data
    $files = [];
    $input = [];
    $mandatory = [];
    $status = [];
    $targetDir = "../downloadfile/"; // File upload directory
    
    $fee = [];
    for ($j = 1; $j <= $_SESSION['totalfee']; $j++) {
        if (isset($_POST['fee' . $j])) {
            $fee[$j] = $conn->real_escape_string($_POST['fee' . $j]);
        }
    }

    $note = [];
    for ($j = 1; $j <= $_SESSION['totalnote']; $j++) {
        if (isset($_POST['note' . $j])) {
            $note[$j] = $conn->real_escape_string($_POST['note' . $j]);
        }
    }

    $caution = [];
    for ($j = 1; $j <= $_SESSION['totalcaution']; $j++) {
        if (isset($_POST['caution' . $j])) {
            $caution[$j] = $conn->real_escape_string($_POST['caution' . $j]);
        }
    }



    // Check if the title already exists
    $result = $conn->query("SELECT * FROM title WHERE title = '$name'");
    if ($result && $result->num_rows > 0) {
        echo "<script>alert('รายการคำร้องนี้มีอยู่ในระบบแล้ว');</script>";
    } else {
        // Insert new title
        if ($conn->query("INSERT INTO title (title, timespan) VALUES('$name', '$duration')")) {
            $tid = $conn->insert_id;
                $conn->query("INSERT INTO title_status (tid, sid) VALUES($tid, 1)");
                $conn->query("INSERT INTO title_status (tid, sid) VALUES($tid, 2)");
                $conn->query("INSERT INTO title_status (tid, sid) VALUES($tid, 3)");
                $conn->query("INSERT INTO title_status (tid, sid) VALUES($tid, 4)");
                $conn->query("INSERT INTO title_status (tid, sid) VALUES($tid, 5)");


            // Insert cautions
            foreach ($caution as $i => $cautionValue) {
                if ($conn->query("INSERT INTO caution (caution) VALUES('$cautionValue')")) {
                    $lastid = $conn->insert_id;
                    $conn->query("INSERT INTO title_caution (tid, cid) VALUES('$tid', '$lastid')");
                }
            }

            // Insert notes
            foreach ($note as $i => $noteValue) {
                if ($conn->query("INSERT INTO note (note) VALUES('$noteValue')")) {
                    $lastid = $conn->insert_id;
                    $conn->query("INSERT INTO title_note (tid, nid) VALUES('$tid', '$lastid')");
                }
            }

            // Insert fees
            foreach ($fee as $i => $feeValue) {
                if ($conn->query("INSERT INTO fee (fee) VALUES('$feeValue')")) {
                    $lastid = $conn->insert_id;
                    $conn->query("INSERT INTO title_fee (tid, fid) VALUES('$tid', $lastid)");
                }
            }



            // Handle file uploads
            if (isset($_SESSION['totalfile']) && $_SESSION['totalfile'] > 0) {
                for ($j = 1; $j <= $_SESSION['totalfile']; $j++) {
                    // Check if file is uploaded
                    if (isset($_FILES['file' . $j]) && $_FILES['file' . $j]['error'] === UPLOAD_ERR_OK) {
                        $files[$j] = $_FILES['file' . $j];
                        // Generate new file name
                        $newFileName = 'เอกสาร_' . $_POST['input' . $j] . '_' . (new DateTime())->format('Hi') . '.' . pathinfo($files[$j]['name'], PATHINFO_EXTENSION);
                        $filePath = $targetDir . $newFileName;
            
                        // Try to move the uploaded file to the target directory
                        if (move_uploaded_file($files[$j]['tmp_name'], $filePath)) {
                    
                            $inputName = $conn->real_escape_string($_POST['input' . $j]);
                            $mandatoryValue = $conn->real_escape_string($_POST['mandatory' . $j]);
                            if (isset($_POST['status' . $j])) {
                                $statusValue = $_POST['status' . $j];
                            } else $statusValue = NULL;

                            if (isset($_POST['status2' . $j])) {
                                $status2Value = $_POST['status2' . $j];
                            } else $status2Value = NULL;

                            $statusInsert = $statusValue . $status2Value;
                    
                            $sql = "INSERT INTO files (file_name, filepath, status, mandatory) VALUES ('$inputName', '$filePath', '$statusInsert', '$mandatoryValue')";
                            $result = $conn->query($sql);
                    
                            if ($result) {
                                $lastId = $conn->insert_id;
                                $conn->query("INSERT INTO title_file (tid, file_id) VALUES($tid, $lastId)");
                            } else {
                                echo "Error inserting file metadata into database: " . $conn->error . "<br>";
                            }
                        } else {
                            echo "Error moving uploaded file: " . $files[$j]['name'] . "<br>";
                        }
                    } else {
                        $inputName = isset($_POST['input' . $j]) ? $conn->real_escape_string($_POST['input' . $j]) : '';
                        $mandatoryValue = isset($_POST['mandatory' . $j]) ? $conn->real_escape_string($_POST['mandatory' . $j]) : '';
                        if (isset($_POST['status' . $j])) {
                            $statusValue = $_POST['status' . $j];
                        } else $statusValue = NULL;

                        if (isset($_POST['status2' . $j])) {
                            $status2Value = $_POST['status2' . $j];
                        } else $status2Value = NULL;

                        $statusInsert = $statusValue . $status2Value;
                
                        $sql = "INSERT INTO files (file_name, filepath, status, mandatory) VALUES ('$inputName', '$filePath', '$statusInsert', '$mandatoryValue')";
                        $result = $conn->query($sql);
                    
                        if ($result) {
                            $lastId = $conn->insert_id;
                            $conn->query("INSERT INTO title_file (tid, file_id) VALUES($tid, $lastId)");
                        } else {
                            echo "Error inserting file metadata into database: " . $conn->error . "<br>";
                        }
                    }
                }
            } else {
                echo "No files to upload. Please ensure the session has 'totalfile' set.";
            }



            // Success message
            echo "<script>alert('รายการคำร้องถูกเพิ่มเรียบร้อยแล้ว');</script>";
            header("Location: tables.php");
        } else {
            echo "<script>alert('การเพิ่มรายการคำร้องล้มเหลว');</script>";
        }
    }
}

$conn->close();
?>