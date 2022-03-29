<?php
include 'db.php';

$msg_id = $_POST['msg_id'];
$title = $_POST['title'];

$sql2 = "UPDATE default_preset_msg SET status='$title' WHERE msg_id=$msg_id";  
$con->query($sql2);

?>