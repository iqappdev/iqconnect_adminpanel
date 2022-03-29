<?php
include 'db.php';

$channel_id = $_POST['channel_id'];
$stream_count = $_POST['stream_count'];
$reporter_count_total = $_POST['reporter_count_total'];
$changed_stream_link = $_POST['stream_link'];
$reporter_playback_url = $_POST['reporter_playback_url'];
$reporter_job_id = $_POST['reporter_job_id'];
$ftp_ip = $_POST['ftp_ip'];
$ftp_port = $_POST['ftp_port'];
$ftp_user = $_POST['ftp_user'];
$ftp_pwd = $_POST['ftp_pwd'];
$news_feed = $_POST['news_feed'];
$is_watermark_edit = $_POST['is_watermark_edit'];



if($is_watermark_edit==0)
{
  // Check if image file is a actual image or fake image
  if (empty($_FILES['watermark_edit']['name']))
  {
      $img='0';
  }
  else
  {
    $img='1';
  }


  if($img=='1')
  {
    $path = $_FILES['watermark_edit']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    $target_dir = __DIR__ ."/channel_watermark/";
    $target_file = $target_dir.$channel_id.'.'.$ext;
    $uploadOk = 1;

    $logo = 'http://'.$_SERVER['HTTP_HOST']."/channel_watermark/".$channel_id.'.'.$ext;


    $sql_logo = "UPDATE channel_reporter SET watermark_logo='".$logo."',watermark_status='0' WHERE cl_id='".$channel_id."'";
    $con->query($sql_logo);

    $check = getimagesize($_FILES["watermark_edit"]["tmp_name"]);
    if($check !== false)
    {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    }
    else
    {
      echo "File is not an image.";
      $uploadOk = 0;
    }


    // // Check file size
    // if ($_FILES["watermark_edit"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["watermark_edit"]["tmp_name"], $target_file))
        {
            chmod($target_file, 0777);
            echo "The file ". basename( $_FILES["watermark_edit"]["name"]). " has been uploaded.";
        }
    }

  }


}
else
{

    $sql_logo = "UPDATE channel_reporter SET watermark_logo=' ',watermark_status='1' WHERE cl_id='".$channel_id."'";
    $con->query($sql_logo);
}
















$sql1 = "SELECT * FROM channel_reporter where cl_id='".$channel_id."'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();
$total = $row1['stream_count'];


$sql3 = "UPDATE channel_reporter SET stream_link='".$changed_stream_link."', stream_count='".$stream_count."', reporter_count_total='".$reporter_count_total."', playback_url='".$reporter_playback_url."', job_id='".$reporter_job_id."', ftp_ip='".$ftp_ip."', ftp_port='".$ftp_port."', ftp_user='".$ftp_user."', ftp_pwd='".$ftp_pwd."', news_feed='".$news_feed."' WHERE cl_id='".$channel_id."'";
$con->query($sql3);

if($stream_count>4)
{
  if($total<$stream_count)
  {
    //add
    for($i=$total+1;$i<=$stream_count;$i++)
    {
      $sql1 ="INSERT INTO reporter_stream(cl_id, checking) VALUES('$channel_id','disabled')";
      $con->query($sql1);
      $last_id = $con->insert_id;

      $sql2 = "UPDATE reporter_stream SET stream_id='$last_id' WHERE id=$last_id";  
      $con->query($sql2);      
    }
  }
  else if($total>$stream_count)
  {
    //delete
    $count_val=$total-$stream_count;

    for($i=0;$i<$count_val;$i++)
    {
      $sql1 ="DELETE FROM reporter_stream WHERE cl_id='".$channel_id."' order by stream_id desc limit 1";
      $con->query($sql1);
    }
  }
  header("Location: channel_list.php");
}
else
{
  header("Location: channel_list.php");
}

?>