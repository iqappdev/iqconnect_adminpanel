<?php

include('db.php');
$sql1="SELECT * FROM channel order by channel_name";
$result_set=mysqli_query($con,$sql1);

$jsonData = array();
while ($array = mysqli_fetch_row($result_set)) {
    $jsonData[] = $array;
}
echo json_encode($jsonData);

?>