<?php
include 'db.php';

$channel_id = $_POST['channel_id'];

$sql1 = "SELECT * FROM channel WHERE cl_id='$channel_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$show_link=$row1['show_link'];

if($show_link=='0')
{
    $display='1';
}
else
{
	$display='0';
}

$sql_update = "UPDATE channel SET show_link='$display' WHERE cl_id='$channel_id'";  
$con->query($sql_update);


?>