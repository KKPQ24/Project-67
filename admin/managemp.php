<?php
 require '../condb.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <title>New</title>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php 
//   require 'aside.php'; 
   ?>
   <div class="container">
    <form action="" class="" enctype="multipart/form-data" method="post">
            <input type="file" name="excel" required value="">
            <button class="btn btn-primary-outline" type="submit" name="import">Import</button>
        </form>
   </div>
   <table border="1">
    <thead>
        <tr>
            <td>Emp_id </td>
            <td>Emp_name</td>
            <td>idcard</td>
            <td>password</td>
            <td>bday</td>
            <td>telephone</td>
            <td>email</td>
            <td>Address</td>
            <td>province_id </td>
            <td>district_id </td>
            <td>subdistrict_id </td>
            <td>การดำเนินงาน </td>
        </tr>
    </thead>
    <tbody>
    <?php
        $result = $conn->query("SELECT * FROM employee");
        if($result || $result->num_rows > 0){
            while($row = $result -> fetch_assoc()){
    ?>
        <tr>
            <td><?php echo $row['Emp_id']?> </td>
            <td><?php echo $row['Emp_name']?></td>
            <td><?php echo $row['idcard']?></td>
            <td><?php echo $row['password']?></td>
            <td><?php echo $row['bday']?></td>
            <td><?php echo $row['telephone']?></td>
            <td><?php echo $row['email']?></td>
            <td><?php echo $row['Address']?></td>
            <td><?php echo $row['province_id']?> </td>
            <td><?php echo $row['district_id']?> </td>
            <td><?php echo $row['subdistrict_id']?> </td>
            <td><a href="<?php echo $_SERVER['PHP_SELF'] . '?emp_id=' . $row['Emp_id']; ?>">ลบพนักงาน</a></td>
            </tr>
    <?php
            }
        }
    ?>
    </tbody>
   </table>

   <?php
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['emp_id'])){
    $emp_id = intval($_GET['emp_id']); // Ensuring it's an integer to avoid SQL injection
    $conn->query("DELETE FROM employee WHERE Emp_id = $emp_id");

    if($conn->affected_rows > 0){
        echo "Employee with Emp_id $emp_id has been deleted successfully.";
        echo "<script>document.location.href = 'managemp.php';</script>";
    } else {
        echo "No employee found with Emp_id $emp_id.";
    }
}

    if(isset($_POST['import'])){
        $fileName = $_FILES['excel']['name'];
        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));
    
        $newFileName = date("Y-m-dhi") . "." . $fileExtension;
    
        $targetDirectory = "excel/" . $newFileName;
        if (move_uploaded_file($_FILES['excel']["tmp_name"], $targetDirectory)) {
            error_reporting(0);
            ini_set('display_errors', 0);
    
            require "excelReader/excel_reader2.php";
            require "excelReader/SpreadsheetReader.php";
    
            try {
                $reader = new SpreadsheetReader($targetDirectory);
                foreach ($reader as $key => $row) {
                    $Emp_id = $row[0];
                    $Emp_name = $row[1];
                    $idcard = $row[2];
                    $password = $row[3];
                    $bday = $row[4];
                    $telephone = $row[5];
                    $email = $row[6];
                    $Address = $row[7];
                    $province_id = $row[8];
                    $district_id = $row[9];
                    $subdistrict_id = $row[10];
                    $role = 0; // Assuming role is 0
  
                    if(empty($Emp_id) || empty($Emp_name) || empty($idcard) || empty($password) || empty($bday) || empty($telephone) || empty($email) || empty($Address) || empty($province_id) || empty($district_id) || empty($subdistrict_id)){
                        echo "One or more fields are empty. Skipping this row.<br>";
                        continue;
                    }
                
                    $sql = "INSERT INTO employee (Emp_id, Emp_name, idcard, password, bday, telephone, email, Address, province_id, district_id, subdistrict_id, role) 
                            VALUES ('$Emp_id', '$Emp_name', '$idcard', '$password', '$bday', '$telephone', '$email', '$Address', '$province_id', '$district_id', '$subdistrict_id', $role)";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "Record inserted successfully.<br>";
                    } else {
                        echo "Error inserting record: " . $conn->error . "<br>";
                    }
                }
                
    
                echo "<script>alert('Import success');</script>";
            } catch (Exception $e) {
                echo "Error reading Excel file: " . $e->getMessage();
            }
        } else {
            echo "Failed to upload file.";
        }
        echo "<script>document.location.href = '';</script>";
    }
   ?>
</body>
</html>