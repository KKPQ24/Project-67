<?php
include('condb.php');
$sql = "SELECT * FROM subdistrict WHERE district_id ={$_GET['amphure_id']}";
$query = mysqli_query($conn, $sql);

$json = array();
while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);