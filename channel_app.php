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
              <a class="nav-link active" id="Customers-tab" data-toggle="tab" href="#Customers" role="tab" aria-controls="Customers" aria-selected="true">Channel List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="Reporters-tab" data-toggle="tab" href="#Reporters" role="tab" aria-controls="Reporters" aria-selected="false">Add New Channel</a>
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
                          <th>Channel Mail</th>
			                    <th>Livestream Link</th>
                          <th>Youtube Channel ID</th>
                          <th>Facebook URL</th>
                          <th>Twitter URL</th>
                          <th>IQ Live Subscription</th>
			                    <th><center>Options</center></th>
			                    </tr>
			                </thead>
			             	<tbody>
                        
			                <?php
			                  $chk_id='1';
			                  $sql1 = "SELECT * FROM channel_app order by channel_name";
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
			                        url: 'check_channel_app.php',
			                        data:{},
			                        dataType: 'json',
			                        success: function(data)
			                        {
			                            var id=<?php echo $chk_id ?>;
			                            var channel_id=data[id-1][2];
			                            var iqlive_subscription=data[id-1][7];

										if(iqlive_subscription=='0')
		                                {
		                                	$('#checkbox_status4<?php echo $chk_id ?>').attr("checked", "checked");
		                                }
                                  }
			                   });
			                },1000); 
			                </script>
	                        
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
                          <td><label><?php echo $row1['channel_mail'] ?></label></td>
	                        <td><label><?php echo sort_length($row1['live_stream_link'],15);?></label></td>
                          <td><label><?php echo sort_length($row1['youtube_channel_id'],10);?></label></td>
                          <td><label><?php echo sort_length($row1['fb_url'],15);?></label></td>
                          <td><label><?php echo sort_length($row1['twitter'],15);?></label></td>
                          <td><center>
                            <label class="switch switch-text switch-success switch-pill" style="width: 80px;">
                              <input type="checkbox" id="checkbox_status4<?php echo $chk_id ?>" onclick="change_live_subscription('<?php echo $row1['cl_id'] ?>')" class="switch-input">
                              <span data-on="Enable" data-off="Disable" class="switch-label" style="background-color: red;"></span>
                              <span class="switch-handle"></span>
                            </label></center>
                          </td>
	                        <td>
	                            <center>
                                <a style="color: blue;" title="Edit" href="#" data-toggle="modal" data-target="#myModal<?php echo $row1['cl_id']; ?>">
                                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>&nbsp;&nbsp;&nbsp;
	                            <a style="color: blue;" title="Delete" onclick="change_delete_channel('<?php echo $row1['cl_id'] ?>')" href="#">
                                  <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
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
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Mail</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['channel_mail']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Live Stream Link</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['live_stream_link']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Youtube Channel ID</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['youtube_channel_id']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Facebook URL</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['fb_url']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Twitter URL</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['twitter']; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Privacy Policy Link</label></div>
                    <div class="col-12 col-md-6">
                      <label for="text-input" class=" form-control-label"><?php echo $row1['privacy_policy_link']; ?></label>
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
          <h4 class="modal-title">Edit Channel App for <?php echo $row1['channel_name']; ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form action="edit_channel_app.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="channel_id" value="<?php echo $row1['cl_id']; ?>">
                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Name</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="channel_name" placeholder="Channel Name" class="form-control" value="<?php echo $row1['channel_name']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Logo</label></div>
                    <div class="col-12 col-md-6"><input type="file" id="fileToUpload_edit" name="fileToUpload_edit" class="form-control-file" accept="image/*"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Channel Mail</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="channel_mail" placeholder="Channel Mail" class="form-control" value="<?php echo $row1['channel_mail']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Livestream Link</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="live_stream_link" placeholder="Stream Link" class="form-control" value="<?php echo $row1['live_stream_link']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Youtube Channel ID</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="youtube_channel_id" placeholder="Youtube Channel ID" class="form-control" value="<?php echo $row1['youtube_channel_id']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Facebook URL</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="fb_url_edit" placeholder="Youtube Channel ID" class="form-control" value="<?php echo $row1['fb_url']; ?>"></div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-6"><label for="text-input" class=" form-control-label">Twitter URL</label></div>
                    <div class="col-12 col-md-6"><input type="text" name="twitter_edit" placeholder="Youtube Channel ID" class="form-control" value="<?php echo $row1['twitter']; ?>"></div>
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
        <div class="tab-pane fade" id="Reporters" role="tabpanel" aria-labelledby="Reporters-tab">
        <br>

                                <div class="card">
                                    <form action="channel_app_add.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                                  <div class="card-header">
                                    <strong>Add Channel</strong>
                                  </div>
                                  <div class="card-body card-block">
                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Channel Name</label></div>
                                        <div class="col-12 col-md-3"><input type="text" required id="text-input" name="channel_name" placeholder="Channel Name" class="form-control"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="file-input" class=" form-control-label">Channel Logo</label></div>
                                        <div class="col-12 col-md-3"><input type="file" required id="fileToUpload_add" name="fileToUpload_add" class="form-control-file" accept="image/*"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Channel Email</label></div>
                                        <div class="col-12 col-md-3"><input type="email" required id="text-input" name="channel_mail" placeholder="Channel Email" class="form-control"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Livestream Link</label></div>
                                        <div class="col-12 col-md-3"><input type="text" required id="text-input" name="live_stream_link_add" placeholder="Livestream Link" class="form-control"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Youtube Channel ID</label></div>
                                        <div class="col-12 col-md-3"><input type="text" required id="text-input" name="youtube_channel_id" placeholder="Youtube Channel ID" class="form-control"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Facebook Page URL</label></div>
                                        <div class="col-12 col-md-3"><input type="text" required id="text-input" name="fb_url" placeholder="Facebook Page URL" value="https://www.facebook.com/" class="form-control">
                                        (Type # if they don't have Facebook Page)
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Twitter URL</label></div>
                                        <div class="col-12 col-md-3"><input type="text" required id="text-input" name="twitter" placeholder="Twitter URL" value="https://twitter.com/" class="form-control">
                                        (Type # if they don't have Twitter Page)
                                        </div>
                                      </div>

                                      <!-- <div class="row form-group">
                                        <div class="col col-md-3"><label class=" form-control-label">IQ Live Subscription</label></div>
                                        <div class="col col-md-3">
                                          <div class="form-check-inline form-check">
                                            <label for="inline-radio1" class="form-check-label ">
                                              <input type="radio" id="inline-radio1" name="preset_msg" value="yes" class="form-check-input">Yes
                                            </label>
                                            <label for="inline-radio2" class="form-check-label " style="margin-left: 8px;">
                                              <input type="radio" id="inline-radio2" name="preset_msg" value="no" class="form-check-input">No
                                            </label>
                                          </div>
                                        </div>
                                      </div> -->

                                    </div>
                                  
                                  <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                      <i class="fa fa-dot-circle-o"></i> Submit
                                    </button>
                                  </div>

                                  </form>
                                </div>
                              </div>
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


function change_live_subscription(cl_id){
      $.ajax
      ({
        type: 'post',
        url: 'live_subscription.php',
        data: {
          cl_id:cl_id
        },
        success: function(data)
        {
          alert(data);
        }
      });
}


function change_delete_channel(channel_id){
    if (window.confirm('Are you sure to Delete this Channel?'))
    {
          $.ajax
          ({
          type: 'post',
          url: 'delete_channel_app.php',
          data: {
            channel_id:channel_id
          },
        success: function(data)
        {
          window.location.href="channel_app.php";
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