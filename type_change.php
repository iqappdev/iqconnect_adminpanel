<?php
include 'db.php';

$channel_id = $_POST['channel_id'];

$sql1 = "SELECT * FROM channel_reporter WHERE cl_id='".$channel_id."'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$type=$row1['type'];

if($type=='FIFO')
{
    $display='ASSIGN';
}
else
{
    $display='FIFO';
}

$sql2 = "UPDATE channel_reporter SET type='".$display."' WHERE cl_id='".$channel_id."'";  
if($con->query($sql2)==TRUE)
{
	echo "Updated";
}
else
{
	echo "Not Updated";
}

?>