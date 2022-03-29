<?php
include 'db.php';

$title=$_POST['title_push'];
$msg=$_POST['push_notify_message'];
$channel=$_POST['channel'];
$type=$_POST['type'];

$gcm_token = array();


if($type=='customer')
{
    $push_notification_value=$channel;
    $sql1 = "SELECT * FROM customer where cl_id='$channel' ";
    $result1 = $con->query($sql1);
    if ($result1->num_rows > 0)
    {
        // output data of each row
        while($row1 = $result1->fetch_assoc())
        {
            $device_token=$row1['device_token'];
            array_push($gcm_token, $device_token);
        }
    }

}
else
{
    $push_notification_value="iqlive_reporter";
    $sql1 = "SELECT * FROM reporter where cl_id='$channel' ";
    $result1 = $con->query($sql1);
    if ($result1->num_rows > 0)
    {
        // output data of each row
        while($row1 = $result1->fetch_assoc())
        {
            $device_token=$row1['device_token'];
            array_push($gcm_token, $device_token);
        }
    }
}

$gcm_token = array_unique($gcm_token);
sort($gcm_token);


// 

	$message = array("body" => $msg,"title" => $title, "color" => "#00FFFF", "tag" => "check", "image" => "https://lh5.googleusercontent.com/-jaJK_Y9ZzSI/AAAAAAAAAAI/AAAAAAAAAkM/j5BgzPH8kYM/photo.jpg");
		//Google cloud messaging GCM-API url
    $url = 'https://android.googleapis.com/gcm/send';
    $fields = array(
    	'registration_ids' => $gcm_token,
        'notification' => $message,
	);
	

$sql2 = "SELECT * FROM push_notification where cl_id='$push_notification_value' ";
$result2 = $con->query($sql2);
$row2 = $result2->fetch_assoc();
$server_key=$row2['server_key'];


	// Google Cloud Messaging GCM API Key
	define("GOOGLE_API_KEY", $server_key); 		
    $headers = array(
    	'Authorization: key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );
    
    echo json_encode($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);				
    if ($result === FALSE) {
    	die('Curl failed: ' . curl_error($ch));
	}
    curl_close($ch);
    echo $result;

header("Location:push_notification.php");
?>