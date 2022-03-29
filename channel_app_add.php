<?php
include 'db.php';

$channel_name = $_POST['channel_name'];
$channel_mail = $_POST['channel_mail'];
$username = strtolower($channel_name);
$username = str_replace(' ', '', $username);
$live_stream_link_add = $_POST['live_stream_link_add'];
$youtube_channel_id = $_POST['youtube_channel_id'];
$fb_url = $_POST['fb_url'];
$twitter = $_POST['twitter'];


$path = $_FILES['fileToUpload_add']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);

$target_dir = __DIR__ . "/channel/";
$target_file = $target_dir.$username.'.'.$ext;
$uploadOk = 1;

$logo = 'http://'.$_SERVER['HTTP_HOST']."/channel/".$username.'.'.$ext;

        $sql ="INSERT INTO channel_app(channel_name, cl_id, channel_mail, live_stream_link, youtube_channel_id, fb_url, twitter, iqlive_subscription, logo) VALUES('$channel_name','$username','$channel_mail','$live_stream_link_add','$youtube_channel_id','$fb_url','$twitter','1', '$logo')";
        $con->query($sql);
        
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload_add"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// // Check file size
// if ($_FILES["fileToUpload_add"]["size"] > 500000) {
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
    if (move_uploaded_file($_FILES["fileToUpload_add"]["tmp_name"], $target_file))
    {
        chmod($target_file, 0777);
        echo "The file ". basename( $_FILES["fileToUpload_add"]["name"]). " has been uploaded.";
    }
    else
    {
        echo "Sorry, there was an error uploading your file.";
    }
}

header("Location: channel_app.php");

?>