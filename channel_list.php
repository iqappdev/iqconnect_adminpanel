<?php
include 'db.php';

session_start();
$user=$_SESSION['userid'];
if(!isset($_SESSION['userid']))
{
  require("index.php");
}
else
{

include 'left_panel.php';
?>
<div class="content mt-3">
	<div class="row">
    	<div class="col-md-12">
			<div class="card">
        <div class="card-header">
          <strong class="card-title">Channel List</strong>
        </div>

        <div class="card-body">

					<ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="Customers-tab" data-toggle="tab" href="#Customers" role="tab" aria-controls="Customers" aria-selected="true">Customers</a>
						</li>
            <li class="nav-item">
              <a class="nav-link" id="Reporters-tab" data-toggle="tab" href="#Reporters" role="tab" aria-controls="Reporters" aria-selected="false">Reporters</a>
            </li>
          </ul>

					<div class="tab-content pl-3 p-1" id="myTabContent">
          <div class="tab-pane fade show active" id="Customers" role="tabpanel" aria-labelledby="Customers-tab">
          <br>
			            
			            <table id="bootstrap-data-table" class="table table-striped table-bordered">
			            	<thead>
			                	<tr>
			                    <th>Info</th>
                          <th>Channel Name</th>
			                    <th>Channel ID</th>
			                    <th>Password</th><!-- 
                          <th>Channel Mail</th> -->
			                    <th>Stream Base Link</th>
                          <th><center>Stream Count</center></th>
                          <th><center>FTP Count</center></th>
			                    <th>Status</th>
                          <th>Access</th>
			                    <th><center>Options</center></th>
			                    </tr>
			                </thead>
			             	<tbody>
                        
			                <?php
			                  $chk_id='1';
			                  $sql1 = "SELECT * FROM channel order by channel_name";
			                  $result1 = $con->query($sql1);
			                  if ($result1->num_rows > 0) {
			                  // output data of each row
			                    while($row1 = $result1->fetch_assoc())
			                    {
			                ?>

			                <script id="source" language="javascript" type="text/javascript">

			                window.setInterval(function () 
			                {
			                    $.ajax({
			                        type: 'post',
			                        url: 'check_channel.php',
			                        data:{},
			                        dataType: 'json',
			                        success: function(data)
			                        {
			                            var id=<?php echo $chk_id ?>;
			                            var status=data[id-1][3];
                                  var purchase=data[id-1][8];
                                  var push_notification=data[id-1][9];
                                  var show_hide_link=data[id-1][18];

                  								if(status=='Online')
              	                  {
              	                    $('#on_offline_status<?php echo $chk_id ?>').attr("checked", "checked");
              	                  }
              	                  if(purchase=='LICENSED')
                                  {
                                    $('#reporter_edition_status<?php echo $chk_id ?>').attr("checked", "checked");
                                  }
                                  if(push_notification=='0')
                                  {
                                    $('#push_notification_status<?php echo $chk_id ?>').attr("checked", "checked");
                                  }
                                  if(show_hide_link=='0')
                                  {
                                    $('#show_hide_link_status<?php echo $chk_id ?>').attr("checked", "checked");
                                  }

              										// $("#title_val<?php echo $chk_id ?>").attr('href','#'+channel_id);
              	        	        // $("#title_val2<?php echo $chk_id ?>").attr('href','#'+channel_id);
				    	               }
			                   });
			                },1000); 
			                </script>
	                          
	                        <?php
	                          $sql3 = "SELECT * FROM stream where cl_id='".$row1['cl_id']."'";
	                          $result3 = $con->query($sql3);
	                          $total = $result3->num_rows;

                            if($row1['online_access']==0){
                             $access_value = "Revoke"; }
                             else{
                              $access_value = "Grant"; }

	                        ?>
	                      <tr>
                          <td>
                            <center>
                              <a style="color: blue;" id="info_val<?php echo $chk_id ?>" href="#" data-toggle="modal" data-target="#info<?php echo $row1['cl_id']; ?>" >
                                <i class='fa fa-info-circle' aria-hidden="true"></i>
                              </a>
                            </center>
                          </td>
	                        <td><label><?php echo $row1['channel_name'] ?></label></td>
	                        <td><label><?php echo $row1['cl_id'] ?></label></td>
                          <td><label><?php echo $row1['password'] ?></label></td><!-- 
                          <td><label><?php echo $row1['channel_mail'] ?></label></td> -->
	                        <td><label><?php echo $row1['stream_link'] ?></label></td>
                          <td><center><?php echo $total; ?></center></td>
                          <td><center><?php echo $row1['ftp_count']; ?></center></td>
	                        <td>
	                          <label class="switch switch-text switch-success switch-pill" style="width: 80px;">
	                            <input type="checkbox" id="on_offline_status<?php echo $chk_id ?>" class="status switch-input" onclick="change_status('<?php echo $row1['cl_id'] ?>','<?php echo $chk_id ?>')">
	                            <span data-on="Online" data-off="Offline" class="switch-label" style="background-color: red;"></span>
	                            <span class="switch-handle"></span>
	                          </label>
	                        </td>
                          <td>
                            <a href="#<?php echo $row1['cl_id'] ?>" title="<?php echo $access_value ?>" onclick="access_check('<?php echo $row1['cl_id'] ?>','<?php echo $access_value ?>')" style="color:<?php if($row1['online_access']==0){ echo "green"; }else{ echo "red";} ?>">
                              <center><i id="iconvalue2<?php echo $chk_id ?>" class="fa <?php if($row1['online_access']==0){ echo "fa-check-circle"; }else{ echo "fa-times-circle";} ?>" aria-hidden="true"></i></center>
                            </a><center><label><?php if($row1['online_access']==0){ echo "Granted"; }else{ echo "Revoked";} ?></label></center>
                          </td>
	                        <td>
                            <center>
                              <a style="color: blue;" href="#<?php echo $row1['cl_id'] ?>" id="title_val<?php echo $chk_id ?>" href="#" data-toggle="modal" data-target="#license<?php echo $row1['cl_id']; ?>" >
                                <i id="iconvalue1<?php echo $chk_id ?>" class='fa fa-lock' aria-hidden="true"></i>
                              </a>&nbsp;&nbsp;&nbsp;
                              <a style="color: blue;" title="Edit" href="#" data-toggle="modal" data-target="#myModal<?php echo $row1['cl_id']; ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </a>&nbsp;&nbsp;&nbsp;
	                             <a style="color: blue;" title="Delete" href="#<?php echo $row1['cl_id']; ?>" onclick="delete_channel('<?php echo $row1['cl_id'] ?>')">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                              </a><br>
                              <a href="history.php?channel=<?php echo $row1['cl_id']; ?>&tab=customer" style="color: blue;"> View History</a>
	                          </center>
	                        </td>
	                      </tr>


  <!-- The Modal -->
  <div class="modal fade" id="info<?php echo $row1['cl_id']; ?>">
    <div class="modal-dialog modal-lg" style="max-width: 60%">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Channel Info</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col col-md-6">
                      <img src="<?php echo $row1['logo']; ?>" style="max-width:20%;">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Name</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['channel_name']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel ID</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['cl_id']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Password</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['password']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Mail</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['channel_mail']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Count</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_count']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Stream Base Link</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['stream_link']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Playback URL</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['playback_url']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Job ID</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['job_id']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP IP</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_ip']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Port</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_port']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Username</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_user']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Password</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_pwd']; ?></label>
                    </div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
  </div>



  <!-- The Modal -->
  <div class="modal fade" id="myModal<?php echo $row1['cl_id']; ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Channel</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form action="edit_channel.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="channel_id" value="<?php echo $row1['cl_id']; ?>">
                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Name</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="channel_name" placeholder="Channel Name" class="form-control" value="<?php echo $row1['channel_name']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Logo</label></div>
                    <div class="col-12 col-md-6"><input type="file" id="fileToUpload" name="fileToUpload" class="form-control-file" accept="image/*"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Password</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="password" placeholder="Password" class="form-control" value="<?php echo $row1['password']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Mail</label></div>
                    <div class="col-12 col-md-6"><input type="email" required name="channel_mail" placeholder="Channel Mail" class="form-control" value="<?php echo $row1['channel_mail']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Input Stream Base Link</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="stream_link" placeholder="Stream Link" class="form-control" value="<?php echo $row1['stream_link']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Stream Count</label></div>
                    <div class="col-12 col-md-6"><input type="number" min="4" required name="stream_count" placeholder="Stream Count" class="form-control" value="<?php echo $total; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Count</label></div>
                    <div class="col-12 col-md-6"><input type="number" name="ftp_count" required placeholder="FTP Count" class="form-control" value="<?php echo $row1['ftp_count']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">RTMP Playback URL</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="playback_url" placeholder="RTMP Playback URL" class="form-control" value="<?php echo $row1['playback_url']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Job ID</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="job_id" placeholder="Job URL" class="form-control" value="<?php echo $row1['job_id']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP IP</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="ftp_ip" placeholder="FTP IP" class="form-control" value="<?php echo $row1['ftp_ip']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Port</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="ftp_port" placeholder="FTP Port" class="form-control" value="<?php echo $row1['ftp_port']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Username</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="ftp_user" placeholder="FTP Username" class="form-control" value="<?php echo $row1['ftp_user']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Password</label></div>
                    <div class="col-12 col-md-6"><input type="text" required name="ftp_pwd" placeholder="FTP Password" class="form-control" value="<?php echo $row1['ftp_pwd']; ?>"></div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Change</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>



  <div class="modal fade" id="license<?php echo $row1['cl_id']; ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">License Permission for Channel <?php echo $row1['channel_name']; ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="channel_id" value="<?php echo $row1['cl_id']; ?>">
                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Reporter Version</label></div>
                    <div class="col-12 col-md-4">
                      <label class="switch switch-text switch-success switch-pill" style="width: 80px;">
                        <input type="checkbox" id="reporter_edition_status<?php echo $chk_id ?>" onclick="enable_reporter_edition('<?php echo $row1['cl_id'] ?>')"  class="reporter_edition switch-input">
                        <span data-on="Enable" data-off="Disable" class="switch-label" style="background-color: red;"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Push Notification [Client Portal]</label></div>
                    <div class="col-12 col-md-4">
                      <label class="switch switch-text switch-success switch-pill" style="width: 80px;">
                        <input type="checkbox" id="push_notification_status<?php echo $chk_id ?>" onclick="change_push_notification('<?php echo $row1['cl_id'] ?>')" class="push_notification switch-input">
                        <span data-on="Enable" data-off="Disable" class="switch-label" style="background-color: red;"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Show/Hide Link in Client Portal</label></div>
                    <div class="col-12 col-md-4">
                      <label class="switch switch-text switch-success switch-pill" style="width: 80px;">
                        <input type="checkbox" id="show_hide_link_status<?php echo $chk_id ?>" onclick="show_hide_link('<?php echo $row1['cl_id'] ?>')"  class="show_hide_link switch-input">
                        <span data-on="Yes" data-off="No" class="switch-label" style="background-color: red;"></span>
                        <span class="switch-handle"></span>
                      </label>
                    </div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
  </div>


                        <?php
                          $chk_id=$chk_id+1;
                          }
                        }
                        ?>
                      
                    </tbody>
                  </table>

				</div>
        <div class="tab-pane fade" id="Reporters" role="tabpanel" aria-labelledby="Reporters-tab">
        <br>

                  <table id="bootstrap-data-table1" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Info</th>
                        <th>Channel Name</th>
                        <th>Stream Base Link</th>
                        <th><center>Stream Count</center></th>
                        <th><center>Total Reporters</center></th>
                        <th><center>Current Reporters</center></th>
                        <th><center>Type</center></th>
                        <th><center>Options</center></th>
                      </tr>
                    </thead>
                    <tbody>
                        
                <?php
                  $sql1 = "SELECT * FROM channel_reporter order by channel_name";
                  $result1 = $con->query($sql1);
                  if ($result1->num_rows > 0) {
                  // output data of each row
                    while($row1 = $result1->fetch_assoc())
                    {
                ?>
                          
                      <tr>
                        <td>
                          <center>
                            <a style="color: blue;" id="info_val_reporter<?php echo $chk_id ?>" href="#" data-toggle="modal" data-target="#info_reporter<?php echo $row1['cl_id']; ?>" >
                              <i class='fa fa-info-circle' aria-hidden="true"></i>
                            </a>
                          </center>
                        </td>
                        <td><label><?php echo $row1['channel_name']; ?></label></td>
                        <td><label><?php echo $row1['stream_link']; ?></label></td>
                        <td><center><label><?php echo $row1['stream_count']; ?></label></center></td>
                        <td><center><label><?php echo $row1['reporter_count_total']; ?></label></center></td>
                        <td><center><label><?php echo $row1['reporter_count_current']; ?></label></center></td>
                        <td>
							<label class="switch switch-text switch-success switch-pill" style="width: 80px;">
	                            <input type="checkbox" <?php if($row1['type']=="ASSIGN") echo "checked"; ?> id="type_status<?php echo $chk_id ?>" class="status switch-input" onclick="change_type('<?php echo $row1['cl_id'] ?>','<?php echo $chk_id ?>')">
	                            <span data-on="ASSIGN" data-off="FIFO" class="switch-label" style="background-color: red;"></span>
	                        	<span class="switch-handle"></span>
	                    	</label>
						</td>
                        <td>
                            <center>
                                <a title="Edit" href="#" data-toggle="modal" data-target="#myModal_rep<?php echo $row1['cl_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<br>
                                <a href="history.php?channel=<?php echo $row1['cl_id']; ?>&tab=reporter" style="color: blue;"> View History</a>
                            </center>
                        </td>
                      </tr>


  <!-- The Modal -->
  <div class="modal fade" id="info_reporter<?php echo $row1['cl_id']; ?>">
    <div class="modal-dialog modal-lg" style="max-width: 60%">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Channel Info</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Name</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['channel_name']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel ID</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['cl_id']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Stream Base Link</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['stream_link']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Stream Count</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['stream_count']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Reporter Total Count</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['reporter_count_total']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Current Reporter Count</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['reporter_count_current']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Playback URL</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['playback_url']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Job ID</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['job_id']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP IP</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_ip']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Port</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_port']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Username</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_user']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Password</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['ftp_pwd']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">News Feed</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['news_feed']; ?></label>
                    </div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
  </div>




  <!-- The Modal -->
  <div class="modal fade" id="myModal_rep<?php echo $row1['cl_id']; ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Channel</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form action="edit_channel_reporter.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="channel_id" value="<?php echo $row1['cl_id']; ?>">

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Stream Link</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="stream_link" placeholder="Stream Link" class="form-control" value="<?php echo $row1['stream_link']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Stream Count</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="stream_count" placeholder="Stream Count" class="form-control" value="<?php echo $row1['stream_count']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Total Reporter Count</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="reporter_count_total" placeholder="Total Reporter Count" class="form-control" value="<?php echo $row1['reporter_count_total']; ?>"></div>
                </div>

                  <div class="row form-group">
                      <div class="col col-md-6"><label for="text-input" class=" form-control-label">Playback URL</label></div>
                      <div class="col-12 col-md-6"><input type="text" name="reporter_playback_url" placeholder="Playback URL" class="form-control" value="<?php echo $row1['playback_url']; ?>"></div>
                  </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Logo</label></div>
                    <div class="col-12 col-md-6"><input type="file" id="fileToUpload" name="fileToUpload" class="form-control-file" accept="image/*"></div>
                </div>



                    <div class="form-group row">
                        <label for="inputEmail3" class="col col-md-6 col-form-label">Is Watermark</label>
                        <div class="col-4">
                            <div class="radio radio-info form-check-inline">
                                <input type="radio" id="is_watermark1<?php echo $row1['cl_id']; ?>" data-channel_id="<?php echo $row1['cl_id']; ?>" value="0" name="is_watermark_edit" <?php if ($row1['watermark_status'] == '0') { echo "checked";} ?>>
                                <label for="is_watermark1<?php echo $row1['cl_id']; ?>"> Yes </label>
                            </div>
                            <div class="radio form-check-inline">
                                <input type="radio" id="is_watermark2<?php echo $row1['cl_id']; ?>" data-channel_id="<?php echo $row1['cl_id']; ?>" value="1" name="is_watermark_edit" <?php if ($row1['watermark_status'] == '1') { echo "checked";} ?>>
                                <label for="is_watermark2<?php echo $row1['cl_id']; ?>"> No </label>
                            </div>
                        </div>
                    </div>

                    
                <?php if ($row1['watermark_status'] == '1') {
                  $display="display:none;";
                }
                ?>
                <div id="watermark_edit_div<?php echo $row1['cl_id']; ?>" style="<?php echo $display; ?>">
                  <div class="row form-group">
                      <div class="col col-md-6">
                        <img src="<?php echo $row1['watermark_logo']; ?>" style="max-width:20%;">
                      </div>
                  </div>

                  <div class="row form-group">
                      <div class="col col-md-6"><label for="text-input" class=" form-control-label">Watermark Logo</label></div>
                      <div class="col-12 col-md-6"><input type="file" id="watermark_edit" name="watermark_edit" class="form-control-file" accept="image/*"></div>
                  </div>
                </div>




                  <div class="row form-group">
                      <div class="col col-md-6"><label for="text-input" class=" form-control-label">Job ID</label></div>
                      <div class="col-12 col-md-6"><input type="text" name="reporter_job_id" placeholder="Job ID" class="form-control" value="<?php echo $row1['job_id']; ?>"></div>
                  </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP IP</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="ftp_ip" placeholder="FTP IP" class="form-control" value="<?php echo $row1['ftp_ip']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Port</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="ftp_port" placeholder="FTP Port" class="form-control" value="<?php echo $row1['ftp_port']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Username</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="ftp_user" placeholder="FTP Username" class="form-control" value="<?php echo $row1['ftp_user']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">FTP Password</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="ftp_pwd" placeholder="FTP Password" class="form-control" value="<?php echo $row1['ftp_pwd']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">News Feed Or IFrame Link</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="news_feed" placeholder="News Feed Or IFrame Link" class="form-control" value="<?php $new=htmlspecialchars($row1['news_feed']); echo $new; ?>"></div>
                </div>


            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Change</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>

                        <?php
                          $chk_id=$chk_id+1;
                          }
                        }
                        ?>
                      
                    </tbody>
                  </table>


                </div>


      					</div>
                    </div>
                </div>
                </div>
        </div><!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->


<script language="javascript" type="text/javascript">
  $('#bootstrap-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
    });

  $('#bootstrap-data-table1').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
    });


  $('#bootstrap-data-table2').DataTable({
       lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
   });
   

$(document).ready(function () {
  $('input[type=radio][name=is_watermark_edit]').change(function() {
      var channel_id = $(this).data("channel_id");
      if (this.value == '0') {
          $("#watermark_edit_div"+channel_id).show();
      }
      else if (this.value == '1') {
          $("#watermark_edit_div"+channel_id).hide();
      }
  });
});

function change_status(channel_id, check_value){
    if('#on_offline_status'+check_value.checked)
    {
      var returnVal = 'Online';
    }
    else
    {
      var returnVal = 'Offline';
    }

      var cl_id = channel_id;
      $.ajax
      ({
        type: 'post',
        url: 'status_change.php',
        data: {
          cl_id:cl_id
        },
        success: function(data)
        {
          //alert(data);
        }
      });
    
}

function change_type(channel_id, check_value){
    if('#on_offline_status'+check_value.checked)
    {
      var returnVal = 'FIFO';
    }
    else
    {
      var returnVal = 'ASSIGN';
    }
      $.ajax
      ({
        type: 'post',
        url: 'type_change.php',
        data: {
          channel_id:channel_id
        },
        success: function(data)
        {
          //alert(data);
        }
      });
    
}



function delete_channel(channel_id)
{
    if (window.confirm('Are you sure to Delete this Channel?'))
    {
          $.ajax
          ({
          type: 'post',
          url: 'delete_channel.php',
          data: {
            channel_id:channel_id
          },
        success: function(data)
        {
          window.location.href="channel_list.php";
        }

        });
    }
    else
    {
        return;
    }
}


function enable_reporter_edition(channel_id){
    if (window.confirm('Are you sure to Enable/Disable this Channel?'))
    {
          $.ajax
          ({
          type: 'post',
          url: 'license_check.php',
          data: {
            channel_id:channel_id
          },
        success: function(data)
        {
          window.location.href="channel_list.php";          
        }

        });
    }
    else
    {
        return;
    }
}


function change_push_notification(channel_id)
{
    if (window.confirm('Are you sure to Enable/Disable Push Notification for this Channel in Client Portal?'))
    {
          $.ajax
          ({
          type: 'post',
          url: 'yes_no.php',
          data: {
            channel_id:channel_id
          },
        success: function(data)
        {
          window.location.href="channel_list.php";          
        }

        });
    }
    else
    {
        return;
    }
}

function show_hide_link(channel_id){
  if (window.confirm('Are you sure to Show/Hide RTMP Link in Client Portal?'))
    {
          $.ajax
          ({
          type: 'post',
          url: 'show_hide_link.php',
          data: {
            channel_id:channel_id
          },
        success: function(data)
        {
          window.location.href="channel_list.php";          
        }

        });

    }
    else
    {
        return;
    }
}

function access_check(channel_id, title)
{
  if (window.confirm('Are you sure to '+title+' Online Access to the Channel '+channel_id+'?'))
  {
    $.ajax
    ({
      type: 'post',
      url: 'online_access.php',
      data: {
        channel_id:channel_id
      },
      success: function(data)
      {
        window.location.href="channel_list.php";          
      }

    });

  }
  else
  {
    return;
  }
}
</script>

</body>
</html>
<?php
}
?>