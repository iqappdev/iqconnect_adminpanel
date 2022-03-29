<?php
include 'db.php';

$cl_id=$_POST['cl_id'];
$output = '';

$output .='<table id="bootstrap-data-table1" class="table table-striped table-bordered">
				<thead>
                	<tr>
                    	<th>Reporter Name</th>
                        <th>Email ID</th>
                        <th>Channel Name</th>
                        <th>Location</th>
                        <th>Stream Start Time</th>
                        <th>Stream End Time</th>
                        <th>Live Start Time</th>
                        <th>Live End Time</th>
                    </tr>
				</thead>
				<tbody>';

if($cl_id!='0')
{
$sql1 = "SELECT * FROM reporter_history WHERE cl_id='".$cl_id."' ORDER BY STR_TO_DATE(stream_start,'%d-%m-%Y %h:%i:%s') DESC";

}
else
{
$sql1 = "SELECT * FROM reporter_history ORDER BY STR_TO_DATE(stream_start,'%d-%m-%Y %h:%i:%s') DESC";
}
$result1 = $con->query($sql1);
if ($result1->num_rows > 0) 
{
// output data of each row
	while($row1 = $result1->fetch_assoc())
    {

$output .= '<tr>
			<td>'.$row1["username"].'</td>
			<td>'.$row1["email"].'</td>
			<td>'.$row1["cl_id"].'</td>
			<td>'.$row1["location"].'</td>
			<td>'.$row1["stream_start"].'</td>
			<td>'.$row1["stream_end"].'</td>
			<td>'.$row1["live_start"].'</td>
			<td>'.$row1["live_end"].'</td>
			</tr>';
    }
}

$output .='</tbody>
           </table>

    <script type="text/javascript">
        $(document).ready(function() {
			$("#bootstrap-data-table1").DataTable({
                aaSorting: [],
	        	lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
    		});
   		});
    </script>';



 echo $output;

?>