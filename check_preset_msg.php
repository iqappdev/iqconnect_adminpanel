<?php

include('db.php');
$sql1="SELECT * FROM default_preset_msg";
$result_set=mysqli_query($con,$sql1);

$jsonData = array();
while ($array = mysqli_fetch_row($result_set)) {
    $jsonData[] = $array;
}
echo json_encode($jsonData);

?>