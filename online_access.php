<?php
include 'db.php';

$channel_id = $_POST['channel_id'];

$sql1 = "SELECT * FROM channel WHERE cl_id='$channel_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$online_access=$row1['online_access'];

if($online_access==0)
{
	$online_access_value=1;
}
else
{
	$online_access_value=0;
}

$sql6 = "UPDATE channel SET online_access='$online_access_value' WHERE cl_id='$channel_id'";  
$con->query($sql6);

?>