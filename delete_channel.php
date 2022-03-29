<?php
include 'db.php';
include 'remote_db.php';

list($absolute_path) = get_included_files();
$path=substr($absolute_path, 0, strrpos( $absolute_path, '/') );

$channel_id = $_POST['channel_id'];

$sql1 = "SELECT * FROM channel WHERE cl_id='$channel_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$logo=$row1['logo'];

$sql_del1 = "SELECT * FROM channel WHERE cl_id='$channel_id'";
$result_del1 = $con->query($sql_del1);
$row_del1 = $result_del1->fetch_assoc();
$job_id_channel=$row_del1['job_id'];

$sql_del2 = "SELECT * FROM channel_reporter WHERE cl_id='$channel_id'";
$result_del2 = $con->query($sql_del2);
$row_del2 = $result_del2->fetch_assoc();
$job_id_reporter=$row_del2['job_id'];


$pos=strrpos($logo,"/");
$val=substr($logo, $pos);

$sql1 ="DELETE FROM channel WHERE cl_id='".$channel_id."'";
$con->query($sql1);

@unlink($path.'/channel/'.$val);

$sql2 ="DELETE FROM stream WHERE cl_id='".$channel_id."'";
$con->query($sql2);

$sql3 ="DELETE FROM template_msg WHERE cl_id='".$channel_id."'";
$con->query($sql3);

$sql_del41 ="DELETE FROM jobs WHERE id='".$job_id_channel."'";
$con1->query($sql_del41);


$sql1 ="DELETE FROM channel_reporter WHERE cl_id='".$channel_id."'";
$con->query($sql1);

$sql2 ="DELETE FROM reporter_stream WHERE cl_id='".$channel_id."'";
$con->query($sql2);

$sql3 ="DELETE FROM reporter_preset_msg WHERE channel_id='".$channel_id."'";
$con->query($sql3);

$sql_del42 ="DELETE FROM jobs WHERE id='".$job_id_reporter."'";
$con1->query($sql_del42);
?>