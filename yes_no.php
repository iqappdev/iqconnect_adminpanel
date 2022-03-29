<?php
include 'db.php';

$channel_id = $_POST['channel_id'];

$sql1 = "SELECT * FROM channel WHERE cl_id='$channel_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$push_notification=$row1['push_notification'];

if($push_notification=='0')
{
    $display='1';
}
else
{
	$display='0';
}

$sql_update = "UPDATE channel SET push_notification='$display' WHERE cl_id='$channel_id'";  
$con->query($sql_update);


?>