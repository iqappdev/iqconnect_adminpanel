<?php

include('db.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql1="select * from user where user_id='".$username."'";
if($result_set=mysqli_query($con,$sql1))
{
	$row=mysqli_fetch_row($result_set);
	if(($username==$row[1])&&($password==$row[2]))
	{
		session_start();
		$_SESSION['userid'] = $username;
 		echo '<script type="text/javascript">'; 
		echo 'window.location.href = "channel_list.php";';
		echo '</script>';
 	}
 	else
 	{
 		echo '<script type="text/javascript">'; 
		echo 'alert("Username or Password is Wrong");'; 
		echo 'window.location.href = "index.php";';
		echo '</script>';
 	}

}
else
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Connection Issue");'; 
	echo 'window.location.href = "index.php";';
	echo '</script>';
}

?>