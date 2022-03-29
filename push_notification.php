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
			            


<form action="push_notify_msg.php" method="post" enctype="multipart/form-data" class="form-horizontal">
						<input type="text" hidden name="type" value="customer">
                        <div class="card-header">
                          <strong>Push Notification</strong>
                        </div>
                        <div class="card-body card-block">
                          <div class="row form-group">
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label">Title</label>
                            </div>
                            <div class="col-12 col-md-3">
                              <input type="text" required id="text-input" name="title_push" placeholder="Notification Title" class="form-control">
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label">Message</label>
                            </div>
                            <div class="col-12 col-md-3">
                              <textarea type="text" class="form-control" name="push_notify_message" placeholder="Notification Message" rows="3" data-form-field="Message" id="add_message"></textarea>
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Application</label></div>
                            <div class="col-12 col-md-9">
                              <select name="channel" id="channel" class="form-control" style="width: 20%">
                                <option value="iqlive" selected>IQ Live</option>
                                <?php
                                $sql1 = "SELECT * FROM channel_app";
                                $result1 = $con->query($sql1);
                                if ($result1->num_rows > 0) 
                                {
                                    // output data of each row
                                    while($row1 = $result1->fetch_assoc())
                                    {
                                ?>
                                <option value="<?php echo $row1['cl_id']; ?>"><?php echo $row1['channel_name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                              <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                          </div>
</div>
                          </form>




				</div>
        <div class="tab-pane fade" id="Reporters" role="tabpanel" aria-labelledby="Reporters-tab">
        <br>

                  
<form action="push_notify_msg.php" method="post" enctype="multipart/form-data" class="form-horizontal">

						<input type="text" hidden name="type" value="reporter">
                        <div class="card-header">
                          <strong>Push Notification</strong>
                        </div>
                        <div class="card-body card-block">
                          <div class="row form-group">
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label">Title</label>
                            </div>
                            <div class="col-12 col-md-3">
                              <input type="text" required id="text-input" name="title_push" placeholder="Notification Title" class="form-control">
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3">
                              <label for="text-input" class=" form-control-label">Message</label>
                            </div>
                            <div class="col-12 col-md-3">
                              <textarea type="text" class="form-control" name="push_notify_message" placeholder="Notification Message" rows="3" data-form-field="Message" id="add_message"></textarea>
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Application</label></div>
                            <div class="col-12 col-md-9">
                              <select name="channel" id="channel" class="form-control" style="width: 20%">
                                <?php
                                $sql1 = "SELECT * FROM channel where purchase='LICENSED' order by channel_name ";
                                $result1 = $con->query($sql1);
                                if ($result1->num_rows > 0) 
                                {
                                    // output data of each row
                                    while($row1 = $result1->fetch_assoc())
                                    {
                                ?>
                                <option value="<?php echo $row1['cl_id']; ?>"><?php echo $row1['channel_name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                              </select>
                            </div>
                          </div>

                          <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                              <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                          </div>
</div>
                          </form>


                </div>

			</div>

      					</div>
                    </div>
                </div>
                </div>
        </div><!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="assets/js/lib/data-table/datatables-init.js"></script>


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