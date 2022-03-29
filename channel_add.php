<?php

include 'db.php';
include 'remote_db.php';

$channel_name = $_POST['channel_name'];
$username = strtolower($channel_name);
$username = str_replace(' ', '', $username);
$password = $username;
$channel_mail = $_POST['channel_mail'];
$stream_count = $_POST['stream_count'];
$stream_link = $_POST['stream_link'];
$preset_msg = $_POST['preset_msg'];
$playback_url = $_POST['playback_url'];
$ftp_ip = $_POST['ftp_ip'];
$ftp_port = $_POST['ftp_port'];
$ftp_user = $_POST['ftp_user'];
$ftp_pwd = $_POST['ftp_pwd'];
$job_name = $username."customer";

$path = $_FILES['fileToUpload']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);

$target_dir = __DIR__ . "/channel/";
$target_file = $target_dir.$username.'.'.$ext;
$uploadOk = 1;

$logo = 'http://'.$_SERVER['HTTP_HOST']."/channel/".$username.'.'.$ext;


// $logo = "http://admin.iqsat.net

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// // Check file size
// if ($_FILES["fileToUpload"]["size"] > 500000) {
//     echo "Sorry, your file is too large.";
//     $uploadOk = 0;
// }


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) 
{
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
}
else 
{
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
    {
        chmod($target_file, 0777);
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        $sql ="INSERT INTO channel(cl_id, channel_name, channel_mail, status, logo, password, stream_link, online_access, purchase, ftp_count, playback_url, ftp_ip, ftp_port, ftp_user, ftp_pwd) VALUES('$username','$channel_name','$channel_mail','Online','$logo','$password', '$stream_link', '0', 'NOT_LICENSED', '5', '$playback_url', '$ftp_ip', '$ftp_port', '$ftp_user', '$ftp_pwd')";
        $con->query($sql);
        
        $sql_remote ="INSERT INTO jobs(name, node_id, assigned_group_id, is_active, command, status_gui, failed_attempts_max) VALUES('$job_name','1','1','1','ffmpeg', 'stopped', '0')";
        $con1->query($sql_remote);
        $last_id_update = $con1->insert_id;

        $sql_update = "UPDATE channel SET job_id='$last_id_update' WHERE cl_id='$username'";  
        $con->query($sql_update);

        for($i=1;$i<=$stream_count;$i++)
        {
            $stream_link_change=$stream_link.$i;
            $sql1 ="INSERT INTO stream(cl_id, stream_link, checking) VALUES('$username','$stream_link_change','disabled')";
            $con->query($sql1);
            $last_id = $con->insert_id;

            $sql2 = "UPDATE stream SET stream_id='$last_id' WHERE id=$last_id";  
            $con->query($sql2);

        }

        if($preset_msg=='yes')
        {
            $sql3 = "SELECT * FROM default_preset_msg where status='Enable'";
            $result3 = $con->query($sql3);
            if ($result3->num_rows > 0)
            {
            // output data of each row
                while($row3 = $result3->fetch_assoc())
                {
                    $msg = $row3['preset_msg'];
                    $sql4 = "INSERT INTO template_msg(message, cl_id, status) VALUES ( '$msg', '$username', 'Enable')";
                    $con->query($sql4);
                }
            }
        }
    }
    else
    {
        echo "Sorry, there was an error uploading your file.";
    }
}


header("Location: channel_list.php");

?>