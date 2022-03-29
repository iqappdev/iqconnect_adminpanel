<?php

include 'db.php';
include 'remote_db.php';

$channel_id = $_POST['cl_id'];

$sql1 = "SELECT * FROM channel_app WHERE cl_id='$channel_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$iqlive_subscription=$row1['iqlive_subscription'];
// echo $iqlive_subscription;

if($iqlive_subscription=='0')
{
    $display='1';


    $sql_del41 = "SELECT * FROM channel WHERE cl_id='".$channel_id."'";
    $result_del41 = $con->query($sql_del41);
    $row_del41 = $result_del41->fetch_assoc();
    $job_id41=$row_del41['job_id'];

    $sql_del2 = "SELECT * FROM channel_reporter WHERE cl_id='".$channel_id."'";
    $result_del2 = $con->query($sql_del2);
    $row_del2 = $result_del2->fetch_assoc();
    $job_id_reporter=$row_del2['job_id'];

    $sql_del1 ="DELETE FROM channel WHERE cl_id='".$channel_id."'";
	$con->query($sql_del1);
	$sql_del2 ="DELETE FROM stream WHERE cl_id='".$channel_id."'";
	$con->query($sql_del2);
    $sql_del3 ="DELETE FROM template_msg WHERE cl_id='".$channel_id."'";
    $con->query($sql_del3);
    $sql_del4 ="DELETE FROM jobs WHERE id='".$job_id41."'";
    $con1->query($sql_del4);

    $sql1 ="DELETE FROM channel_reporter WHERE cl_id='".$channel_id."'";
    $con->query($sql1);
    $sql2 ="DELETE FROM reporter_stream WHERE cl_id='".$channel_id."'";
    $con->query($sql2);
    $sql3 ="DELETE FROM reporter_preset_msg WHERE cl_id='".$channel_id."'";
    $sql_del42 ="DELETE FROM jobs WHERE id='".$job_id_reporter."'";
    $con1->query($sql_del4);
}
else
{
    $display='0';

    $sql2 = "SELECT * FROM settings where type='customer_stream'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $stream_link = $row2['value'];

    $sql2 = "SELECT * FROM settings where type='customer_playback'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $playback_url = $row2['value'];
    $playback_url = $playback_url.$channel_id;

    $sql2 = "SELECT * FROM settings where type='customer_ftp'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $customer_ip = $row2['ip'];
    $customer_port = $row2['port'];
    $customer_user = $row2['username'];
    $customer_pwd = $row2['password'];
    
    $sql1 = "SELECT * FROM channel_app where cl_id='".$channel_id."'";
    $result1 = $con->query($sql1);
    $row1 = $result1->fetch_assoc();
    $channel_name = $row1['channel_name'];
	$password = $channel_id;
	$stream_count = 4;
	$logo=$row1['logo'];

	$sql ="INSERT INTO channel(cl_id, channel_name, status, logo, password, stream_link, online_access, purchase, ftp_count, playback_url, ftp_ip, ftp_port, ftp_user, ftp_pwd) VALUES('$channel_id','$channel_name','Online','$logo','$password', '$stream_link', '0', 'NOT_LICENSED', '5', '$playback_url','$customer_ip','$customer_port','$customer_user','$customer_pwd')";
    $con->query($sql);
    $job_name = $channel_id."customer";

    $sql_remote ="INSERT INTO jobs(name, node_id, assigned_group_id, is_active, command, status_gui, failed_attempts_max) VALUES('$job_name','1','1','1','ffmpeg', 'stopped', '0')";
    $con1->query($sql_remote);
    $last_id_update = $con1->insert_id;

    $sql_update = "UPDATE channel SET job_id='$last_id_update' WHERE cl_id='$channel_id'";  
    $con->query($sql_update);

    for($i=1;$i<=$stream_count;$i++)
    {
    	$stream_link_change=$stream_link.$i;
        $sql1 ="INSERT INTO stream(cl_id, stream_link, checking) VALUES('$channel_id','$stream_link_change','disabled')";
        $con->query($sql1);
        $last_id = $con->insert_id;
        $sql2 = "UPDATE stream SET stream_id='$last_id' WHERE id=$last_id";  
        $con->query($sql2);
	}

	$sql3 = "SELECT * FROM default_preset_msg where status='Enable'";
    $result3 = $con->query($sql3);
    if ($result3->num_rows > 0)
    {
    // output data of each row
    	while($row3 = $result3->fetch_assoc())
        {
        	$msg = $row3['preset_msg'];
            $sql4 = "INSERT INTO template_msg(message, cl_id, status) VALUES ( '$msg', '$channel_id', 'Enable')";
            $con->query($sql4);
		}
	}
}

$sql2 = "UPDATE channel_app SET iqlive_subscription='$display' WHERE cl_id='".$channel_id."'"; 
$con->query($sql2);

?>