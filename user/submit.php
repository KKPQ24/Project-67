<?php
require '../condb.php';
require '../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

session_start();

// Check if the user is logged in
if (!isset($_SESSION['Loginsuccess']) || $_SESSION['Loginsuccess'] != 1) {
    header("Location: ../index.php");
    exit();
}

// Retrieve session variables
$i = $_SESSION['file_count'];
$tid = $_SESSION['tid'];
$uid = $_SESSION['uid'];

// Check if the issue already exists for the user and tid
$sql = "SELECT * FROM issue WHERE tid = $tid AND uid = $uid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<script>
        alert('คุณเคยส่งคำร้องนี้แล้วกรุณารอจนดำเนินการเสร็จสิ้นหรือยกเลิกอันเดิมก่อน');
        window.location.href = 'index.php';
    </script>";
    exit();
}

// Prepare the current date
$dau = (new DateTime())->format('Y-m-d');

function makefile($file, $dau)
{
    $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $newFileName = 'temp_' . $dau . '_' . uniqid() . '.' . $fileExtension;
    $targetDir = "../uploads/";

    // Ensure the target directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $targetFile = $targetDir . $newFileName;

    // Check if the file type is allowed
    if ($fileExtension !== 'pdf') {
        echo "Sorry, only PDF files are allowed.";
        return [null, 0];
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return [$targetFile, 1];
    } else {
        error_log("Error moving uploaded file: " . $file["tmp_name"] . " to " . $targetFile);
        echo "Sorry, there was an error moving your uploaded file.";
        return [null, 0];
    }
}


function mergePdfs($filePaths, $outputPath)
{
    $pdf = new Fpdi();

    foreach ($filePaths as $file) {
        try {
            $pageCount = $pdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $tplId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                $pdf->useTemplate($tplId);
            }
        } catch (Exception $e) {
            echo "Error processing file: " . $file . ". Error: " . $e->getMessage();
            continue;
        }
    }
    $pdf->Output('F', $outputPath);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $files = [];
    for ($j = 1; $j <= $i; $j++) {
        if (isset($_FILES['file' . $j]) && $_FILES['file' . $j]['error'] == 0) {
            $files[$j] = $_FILES['file' . $j];
        } else {
            // If a file was not uploaded or an error occurred, skip it and continue
            continue;
        }
    }

    $uploadedFiles = [];

    foreach ($files as $index => $file) {
        if (is_array($file)) {
            list($targetFile, $uploadOk) = makefile($file, $dau);

            if ($uploadOk == 0) {
                // Skip this file if it was not uploaded successfully
                continue;
            } else {
                $uploadedFiles[] = $targetFile;
            }
        } else {
            echo "Invalid file data.";
            exit();
        }
    }

    // Debug: Check if files were uploaded
    if (empty($uploadedFiles)) {
        echo "No files were uploaded.";
        exit();
    } else {
        echo "Files uploaded successfully: " . implode(", ", $uploadedFiles) . "<br>";
    }

    if (!empty($uploadedFiles)) {
        $mergedPdfPath = "../uploads/document_" . $uid . "_" . (new DateTime())->format('Ymd-Hi') . ".pdf";
        mergePdfs($uploadedFiles, $mergedPdfPath);

        // Debug: Check if merge was successful
        if (file_exists($mergedPdfPath)) {
            echo "Merged PDF created successfully: $mergedPdfPath<br>";
        } else {
            echo "Failed to create merged PDF.";
            exit();
        }

        $sql = "INSERT INTO issue (tid, uid, issue_date, sid, file) 
                VALUES ('$tid', '$uid', '$dau', 1, '$mergedPdfPath')";

        if ($conn->query($sql) === TRUE) {
            $selecttitle = $conn->query("SELECT * FROM title WHERE tid = $tid");
            if ($selecttitle->num_rows > 0) {
                $title = $selecttitle->fetch_assoc();
                $count = $title['count'];
                $count++;
                $conn->query("UPDATE title SET count = $count WHERE tid = $tid");
            } else {
                echo "No record found with tid = $tid";
            }

            echo "Record updated successfully in the database.<br>";

            // Delete the temporary uploaded files after merging
            foreach ($uploadedFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            header("Location: index.php");
            exit();
        } else {
            echo "Sorry, there was an error updating your merged PDF record: " . $conn->error;
            exit();
        }
    } else {
        $sql = "INSERT INTO issue (tid, uid, issue_date, sid) 
                VALUES ('$tid', '$uid', '$dau', 1)";
        $conn->query($sql);
        $selecttitle = $conn->query("SELECT * FROM title WHERE tid = $tid");
        if ($selecttitle->num_rows > 0) {
            $title = $selecttitle->fetch_assoc();
            $count = $title['count'];
            $count++;
            $conn->query("UPDATE title SET count = $count WHERE tid = $tid");
        } else {
            echo "No record found with tid = $tid";
        }

        header("Location: index.php");
        exit();
    }
}

$conn->close();
?>
