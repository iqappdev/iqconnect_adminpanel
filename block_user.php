<?php
include 'db.php';

$email = $_POST['email'];
$channel_id = $_POST['channel_id'];

$sql1 = "SELECT * FROM customer WHERE email='$email' and cl_id='$channel_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$title=$row1['status'];



if($title=='Blocked')
{
	$status="Active";
}
else
{
	$status="Blocked";
}


$sql2 = "UPDATE customer SET status='$status' WHERE email='$email' and cl_id='$channel_id'";
$con->query($sql2);

?>