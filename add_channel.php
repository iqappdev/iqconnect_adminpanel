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


$sql_settings = "SELECT * FROM settings where type='customer_playback'";
$result_settings = $con->query($sql_settings);
// output data of each row
$row_settings = $result_settings->fetch_assoc();

?>


        <div class="content mt-3">
            <div class="animated fadeIn">
                
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Add Channel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Preset Messages</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content pl-3 p-1" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <div class="card">
                                    <form action="channel_add.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                                  <div class="card-header">
                                    <strong>Add Channel</strong>
                                  </div>
                                  <div class="card-body card-block">
                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Channel Name</label></div>
                                        <div class="col-12 col-md-6"><input type="text" required id="text-input" name="channel_name" placeholder="Channel Name" class="form-control"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="file-input" class=" form-control-label">Channel Logo</label></div>
                                        <div class="col-12 col-md-6"><input type="file" required id="fileToUpload" name="fileToUpload" class="form-control-file" accept="image/*"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="file-input" class=" form-control-label">Channel Email</label></div>
                                        <div class="col-12 col-md-6"><input type="email" required id="channel_mail" name="channel_mail" placeholder="Channel Mail" class="form-control-file"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Stream Count</label></div>
                                        <div class="col-12 col-md-6"><input type="number" value='8' required min="4" max="8" id="text-input" name="stream_count" placeholder="Stream Count" class="form-control"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">RTMP Input Stream Link</label></div>
                                        <div class="col-12 col-md-6"><input type="text" required id="text-input" name="stream_link" placeholder="RTMP Stream Link" class="form-control" value="<?php echo $row_settings['value'] ?>"></div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label class=" form-control-label">Preset Messages</label></div>
                                        <div class="col col-md-6">
                                          <div class="form-check-inline form-check">
                                            <label for="inline-radio1" class="form-check-label ">
                                              <input type="radio" id="inline-radio1" name="preset_msg" checked value="yes" class="form-check-input">Yes
                                            </label>
                                            <label for="inline-radio2" class="form-check-label " style="margin-left: 28px;">
                                              <input type="radio" id="inline-radio2" name="preset_msg" value="no" class="form-check-input">No
                                            </label>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">RTMP Playback URL</label></div>
                                        <div class="col-12 col-md-6">
                                          <input type="text" required id="text-input" name="playback_url" placeholder="RTMP Playback URL" class="form-control" value="<?php echo $row_settings['value'] ?>">
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">FTP IP</label></div>
                                        <div class="col-12 col-md-4">
                                          <input type="text" required id="text-input" name="ftp_ip" placeholder="FTP IP" class="form-control" value="37.122.248.79">
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">FTP Port</label></div>
                                        <div class="col-12 col-md-4">
                                          <input type="text" required id="text-input" name="ftp_port" placeholder="FTP Port" class="form-control" value="1021">
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">FTP Username</label></div>
                                        <div class="col-12 col-md-4">
                                          <input type="text" required id="text-input" name="ftp_user" placeholder="FTP Username" class="form-control" value="cqdev">
                                        </div>
                                      </div>

                                      <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">FTP Password</label></div>
                                        <div class="col-12 col-md-4">
                                          <input type="text" required id="text-input" name="ftp_pwd" placeholder="FTP Password" class="form-control" value="cqdev123">
                                        </div>
                                      </div>


                                    </div>
                                  
                                  <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                      <i class="fa fa-dot-circle-o"></i> Submit
                                    </button>
                                  </div>

                                  </form>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                
                                <div class="card">
                                    <div class="card-body">
                                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Preset Message</th>
                                                    <th>Status</th>
                                                    <th>Options</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $chk_id='1';
                                                $sql1 = "SELECT * FROM default_preset_msg";
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
                                                                      url: 'check_preset_msg.php',
                                                                      data:{},
                                                                      dataType: 'json',
                                                                      success: function(data)
                                                                      {                          
                                                                        var id=<?php echo $chk_id ?>;
                                                                        var msg_id=data[id-1][0];
                                                                        var preset_msg=data[id-1][1];
                                                                        var status=data[id-1][2];
                                                                        document.getElementById("preset_msg<?php echo $chk_id ?>").innerHTML = preset_msg;
                                                                        document.getElementById("status<?php echo $chk_id ?>").innerHTML = status;
                                                                        if(status=='Enable')
                                                                        {
                                                                            $("#title<?php echo $chk_id ?>").attr('title','Disable');
                                                                            $("#iconvalue<?php echo $chk_id ?>").removeClass();
                                                                            $('#iconvalue<?php echo $chk_id ?>').addClass("fa fa-eye-slash");
                                                                        }
                                                                        else
                                                                        {
                                                                            $("#title<?php echo $chk_id ?>").attr('title','Enable');
                                                                            $("#iconvalue<?php echo $chk_id ?>").removeClass();
                                                                            $('#iconvalue<?php echo $chk_id ?>').addClass("fa fa-eye");
                                                                        }

                                                                        $("#title<?php echo $chk_id ?>").attr('href','#'+msg_id);

                                                                      }
                                                                    });
                                                                  },1000); 
                                                                  </script>
                                                <tr>
                                                    <td><label id="preset_msg<?php echo $chk_id ?>"></label></td>
                                                    <td><label id="status<?php echo $chk_id ?>"></label></td>
                                                    <td>
                                                        <a class="enable_disable" href="#" id="title<?php echo $chk_id ?>"><i id="iconvalue<?php echo $chk_id ?>" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                
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
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    <script src="assets/js/lib/data-table/datatables-init.js"></script>

<script language="javascript" type="text/javascript">
  

    // $('#check_status').click(function()
    // {
    //   alert("status");
    // });


$(function(){
  $("a.enable_disable").click(function()
  {
      var title=$(this).attr('title');

    if (window.confirm('Are you sure to '+title+' the Preset Message?'))
    {
          var str=$(this).attr('href');
          var len=str.length;
          var msg_id = str.substring(1,len);
          $.ajax
          ({
          type: 'post',
          url: 'preset_msg_enable.php',
          data: {
            title:title, msg_id:msg_id
          },
        success: function(data)
        {
          //alert("Stream "+stream_id+" Has been Going Live");
        }

        });

    }
    else
    {
        return;
    }


  });
});

</script>

    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>


</body>
</html>
<?php
}
?>