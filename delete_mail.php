<?php
include 'db.php';

$msg_id = $_POST['msg_id'];

$sql1 ="DELETE FROM messages WHERE id='".$msg_id."'";
$con->query($sql1);

?>