<?php
include 'db.php';

list($absolute_path) = get_included_files();
$path=substr($absolute_path, 0, strrpos( $absolute_path, '/') );

$reporter_id = $_POST['reporter_id'];

$sql1 = "SELECT * FROM reporter WHERE user_id='$reporter_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$logo=$row1['logo'];


$pos=strrpos($logo,"/");
$val=substr($logo, $pos);

$sql1 ="DELETE FROM reporter WHERE user_id='".$reporter_id."'";
$con->query($sql1);

@unlink($path.'/reporter/'.$val);


?>