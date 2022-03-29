<?php
include 'db.php';

$channel_name = $_POST['channel_name'];
$channel_id = $_POST['channel_id'];
$channel_mail = $_POST['channel_mail'];
$youtube_channel_id = $_POST['youtube_channel_id'];
$live_stream_link = $_POST['live_stream_link'];
$fb_url = $_POST['fb_url_edit'];
$twitter = $_POST['twitter_edit'];

// Check if image file is a actual image or fake image
if (empty($_FILES['fileToUpload_edit']['name']))
{
    $img='0';
}
else
{
  $img='1';
}


if($img=='1')
{
    $path = $_FILES['fileToUpload_edit']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    $target_dir = __DIR__ . "/channel/";
    $target_file = $target_dir.$channel_id.'.'.$ext;
    $uploadOk = 1;

    $logo = 'http://'.$_SERVER['HTTP_HOST']."/channel/".$channel_id.'.'.$ext;

    $sql_logo = "UPDATE channel_app SET logo='".$logo."' WHERE cl_id='".$channel_id."'";
    $con->query($sql_logo);

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload_edit"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // // Check file size
    // if ($_FILES["fileToUpload_edit"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["fileToUpload_edit"]["tmp_name"], $target_file))
        {
            chmod($target_file, 0777);
            echo "The file ". basename( $_FILES["fileToUpload_edit"]["name"]). " has been uploaded.";
        }
    }
}

$sql1 = "UPDATE channel_app SET channel_name='".$channel_name."', channel_mail='".$channel_mail."', youtube_channel_id='".$youtube_channel_id."', live_stream_link='".$live_stream_link."', fb_url='".$fb_url."', twitter='".$twitter."' WHERE cl_id='".$channel_id."'";
$con->query($sql1);

header("Location: channel_app.php");


?>