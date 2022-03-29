<?php
include 'db.php';
include 'remote_db.php';

$channel_id = $_POST['channel_id'];

$sql1 = "SELECT * FROM channel WHERE cl_id='$channel_id'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$channel_name=$row1['channel_name'];
$purchase=$row1['purchase'];

$sql_del41 = "SELECT * FROM channel_reporter WHERE cl_id='$channel_id'";
$result_del41 = $con->query($sql_del41);
$row_del41 = $result_del41->fetch_assoc();
$job_id41=$row_del41['job_id'];

if($purchase=='LICENSED')
{
    $display='NOT_LICENSED';
    $sql2 ="DELETE FROM channel_reporter WHERE cl_id='".$channel_id."'";
	$con->query($sql2);
	
	$sql7 ="DELETE FROM reporter_stream WHERE cl_id='".$channel_id."'";
	$con->query($sql7);

    $sql_del4 ="DELETE FROM jobs WHERE id='".$job_id41."'";
    $con1->query($sql_del4);
}
else
{
    $display='LICENSED';
    
    $sql2 = "SELECT * FROM settings where type='reporter_stream'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $stream_link = $row2['value'];

    $sql2 = "SELECT * FROM settings where type='s3'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $s3_id = $row2['ip'];
    $s3_key = $row2['port'];
    $s3_host = $row2['value'];


    $sql2 = "SELECT * FROM settings where type='reporter_playback'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $playback_url = $row2['value'];
    $playback_url = $playback_url.$channel_id;

    $sql2 = "SELECT * FROM settings where type='reporter_ftp'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $reporter_ip = $row2['ip'];
    $reporter_port = $row2['port'];
    $reporter_user = $row2['username'];
    $reporter_pwd = $row2['password'];

    $sql2 = "SELECT * FROM settings where type='news_feed'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $news_feed = $row2['value'];

    $sql3 ="INSERT INTO channel_reporter(cl_id, channel_name, stream_link, stream_count, reporter_count_total, reporter_count_current, playback_url, ftp_ip, ftp_port, ftp_user, ftp_pwd, news_feed, watermark_status, S3_ID, S3_KEY, S3_HOST, is_auth, type) VALUES('".$channel_id."', '".$channel_name."', '".$stream_link."', '4', '10', '0', '".$playback_url."', '".$reporter_ip."', '".$reporter_port."', '".$reporter_user."', '".$reporter_pwd."', '".$news_feed."', '1', '".$s3_id."', '".$s3_key."', '".$s3_host."', '0', 'FIFO')";
    $con->query($sql3);
    $job_name = $channel_id."reporter";


    // $sql_remote ="INSERT INTO jobs(name, node_id, assigned_group_id, is_active, command, status_gui, failed_attempts_max) VALUES('$job_name','1','1','1','ffmpeg', 'stopped', '0')";
    // $con1->query($sql_remote);
    // $last_id_update = $con1->insert_id;

    // $sql_update = "UPDATE channel_reporter SET job_id='$last_id_update' WHERE cl_id='$channel_id'";  
    // $con->query($sql_update);

	for($i=1;$i<=4;$i++)
    {
		$stream_link_change=$stream_link.$channel_id.$i;
        $sql5 ="INSERT INTO reporter_stream(cl_id, stream_link, checking) VALUES('$channel_id', '$stream_link_change', 'disabled')";
        $con->query($sql5);
        $last_id = $con->insert_id;

        $sql6 = "UPDATE reporter_stream SET stream_id='$last_id' WHERE id=$last_id";  
        $con->query($sql6);
	}
}

$sql4 = "UPDATE channel SET purchase='$display' WHERE cl_id='$channel_id'";  
if($con->query($sql4)==TRUE)
{
	echo "Updated";
}
else
{
	echo "Not Updated";
}

?>