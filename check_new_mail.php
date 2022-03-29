<?php

include('db.php');

$sql3 = "SELECT * FROM messages where status='NOT_OPEN'";
$result3 = $con->query($sql3);
$total = $result3->num_rows;

echo json_encode($total);

?>