<?php
include 'db.php';

$channel_id = $_POST['cl_id'];

$sql1 = "SELECT * FROM channel WHERE cl_id='$channel_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$status=$row1['status'];

if($status=='Online')
{
    $display='Offline';
}
else
{
    $display='Online';
}

$sql2 = "UPDATE channel SET status='$display' WHERE cl_id='$channel_id'";  
if($con->query($sql2)==TRUE)
{
	echo "Updated";
}
else
{
	echo "Not Updated";
}

?>