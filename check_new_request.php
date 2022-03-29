<?php

include('db.php');

$sql3 = "SELECT * FROM waiting_reporter";
$result3 = $con->query($sql3);
$total = $result3->num_rows;

echo json_encode($total);

?>