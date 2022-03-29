<?php
include 'db.php';

$channel_name = $_POST['channel_name'];
$password = $_POST['password'];
$channel_id = $_POST['channel_id'];
$channel_mail = $_POST['channel_mail'];
$stream_count = $_POST['stream_count'];
$ftp_count = $_POST['ftp_count'];
$changed_stream_link = $_POST['stream_link'];
$playback_url = $_POST['playback_url'];
$job_id = $_POST['job_id'];
$ftp_ip = $_POST['ftp_ip'];
$ftp_port = $_POST['ftp_port'];
$ftp_user = $_POST['ftp_user'];
$ftp_pwd = $_POST['ftp_pwd'];



// Check if image file is a actual image or fake image
if (empty($_FILES['fileToUpload']['name']))
{
    $img='0';
}
else
{
  $img='1';
}


if($img=='1')
{
  $path = $_FILES['fileToUpload']['name'];
  $ext = pathinfo($path, PATHINFO_EXTENSION);

  $target_dir = __DIR__ ."channel/";
  $target_file = $target_dir.$channel_id.'.'.$ext;
  $uploadOk = 1;

  $logo = 'http://'.$_SERVER['HTTP_HOST']."/channel/".$channel_id.'.'.$ext;


  $sql_logo = "UPDATE channel SET logo='".$logo."' WHERE cl_id='".$channel_id."'";
  $con->query($sql_logo);

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
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
      }
  }

}

$sql1 = "SELECT * FROM stream where cl_id='".$channel_id."' ORDER BY stream_link";
$result1 = $con->query($sql1);
if ($result1->num_rows > 0) 
{
  $i=1;
  // output data of each row
  while($row1 = $result1->fetch_assoc())
  {
    $new_stream=$changed_stream_link.$channel_id.$i;
    $id=$row1['id'];
    $sql3 = "UPDATE stream SET stream_link='".$new_stream."' WHERE id=$id";
    $con->query($sql3);
    $i++;
  }
}

$sql1 = "UPDATE channel SET channel_name='".$channel_name."', password='".$password."', channel_mail='".$channel_mail."', stream_link='".$changed_stream_link."', ftp_count='".$ftp_count."', playback_url='".$playback_url."', job_id='".$job_id."', ftp_ip='".$ftp_ip."', ftp_port='".$ftp_port."', ftp_user='".$ftp_user."', ftp_pwd='".$ftp_pwd."' WHERE cl_id='".$channel_id."'";
$con->query($sql1);

$sql3 = "SELECT * FROM stream where cl_id='".$channel_id."'";
$result3 = $con->query($sql3);
$total = $result3->num_rows;

if($total<$stream_count)
{
    //add
    for($i=$total+1;$i<=$stream_count;$i++)
    {
      $stream_link_change=$changed_stream_link.$channel_id.$i;
      $sql1 ="INSERT INTO stream(cl_id, stream_link, checking) VALUES('$channel_id','$stream_link_change','disabled')";
      $con->query($sql1);
      $last_id = $con->insert_id;

      $sql2 = "UPDATE stream SET stream_id='$last_id' WHERE id=$last_id";  
      $con->query($sql2);      
    }
}
else if($total>$stream_count)
{
    //delete
    $count_val=$total-$stream_count;

    for($i=0;$i<$count_val;$i++)
    {
      $sql1 ="DELETE FROM stream WHERE cl_id='".$channel_id."' order by stream_link desc limit 1";
      $con->query($sql1);
    }
}

header("Location: channel_list.php");


?>