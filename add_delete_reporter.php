<?php
include 'db.php';

$check=$_POST["check"];
$id=$_POST["reporter_id"];

if($check=="add")
{
	$sql1 = "SELECT * FROM waiting_reporter where id='".$id."'";
	$result1 = $con->query($sql1);
	$row1 = $result1->fetch_assoc();
	$channel = $row1['cl_id'];

	$image_name=$row1['photo_url'];
	$dot=strrpos($image_name,'.');
	$ext=substr($image_name,$dot);


	$sql2 = "SELECT * FROM waiting_reporter where cl_id='".$channel."'";
	$result2 = $con->query($sql2);
	$row2 = $result2->fetch_assoc();
	$stream_link = $row2['stream_link'];

	$sql2 = "INSERT INTO reporter(username, last_name, phone, mail, cl_id, status) VALUES ( '".$row1['username']."', '".$row1['last_name']."', '".$row1['phone']."', '".$row1['mail']."', '".$channel."', 'Active')";
	$con->query($sql2);
	$last_id = $con->insert_id;

	$user_id = $channel.'iq0'.$last_id;

	$photo_url='http://'.$_SERVER['HTTP_HOST']."/reporter/".$user_id.$ext;

	$sql2 = "UPDATE reporter SET user_id='".$user_id."', password='".$user_id."',photo_url='".$photo_url."'  WHERE id='".$last_id."'";
	$con->query($sql2);


	$sql3 ="DELETE FROM waiting_reporter WHERE id='".$id."'";
	$con->query($sql3);
	
	list($absolute_path) = get_included_files();
	$path=substr($absolute_path, 0, strrpos( $absolute_path, '/') );

	rename($path."/waiting_reporter/".$image_name, $path."/reporter/".$user_id.$ext);

	echo "Reporter Added to the Database";
}
else
{
	$sql3 ="DELETE FROM waiting_reporter WHERE id='".$id."'";
	$con->query($sql3);
	@unlink($path."/waiting_reporter/".$image_name);

	$sql_reporter = "SELECT * FROM channel_reporter where cl_id='$channel'";
	$result_reporter = $con->query($sql_reporter);
	$row = $result_reporter->fetch_assoc();
	$count=$row['reporter_count_current'];
	$new_count=$count-1;
	$sql2 = "UPDATE channel_reporter SET reporter_count_current='$new_count' WHERE cl_id='$channel'";
    $con->query($sql2);

	echo "Reporter Rejected to Added in the Database";
}

?>