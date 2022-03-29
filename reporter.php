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
            <div class="animated fadeIn">
                <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Reporter List</strong>
                        </div>
                        <div class="card-body">
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Reporter First Name</th>
                        <th>Last Name</th>
                        <th>Mobile</th>
                        <th>Email ID</th>
                        <th>User ID</th>
                        <th>Password</th>
                        <th>Channel</th>
                        <th>Status</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
$chk_id='1';
$sql1 = "SELECT * FROM reporter order by username";
$result1 = $con->query($sql1);
if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc())
    {

        if($row1['status']=="Block")
        {
            $text = "Block";
            $icon = "fa fa-lock";
        }
        else
        {
            $text = "Active";
            $icon = "fa fa-unlock";
        }

?>
                      <tr>
                        <td><label><?php echo $row1['username'] ?></label></td>
                        <td><label><?php echo $row1['last_name'] ?></label></td>
                        <td><label><?php echo $row1['phone'] ?></label></td>
                        <td><label><?php echo $row1['mail'] ?></label></td>
                        <td><label><?php echo $row1['user_id'] ?></label></td>
                        <td><label><?php echo $row1['password'] ?></label></td>
                        <td><label><?php echo $row1['cl_id'] ?></label></td>
                        <td>
                            <a style="color: blue;">
                                <i class="<?php echo $icon; ?>" aria-hidden="true"></i>
                            </a>
                            &nbsp; <?php echo $text; ?>
                        </td>
                        <td>
                            <center>
                                <a style="color: blue;" onclick="delete_reporter('<?php echo $row1['user_id'] ?>')" title="Delete" href="#">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </center>
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
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="assets/js/lib/data-table/datatables-init.js"></script>

<script language="javascript" type="text/javascript">
function delete_reporter(reporter_id)
{
    if (window.confirm('Are you sure to Delete this Reporter?'))
    {
          var str=$(this).attr('href');
          var len=str.length;
          var reporter_id = str.substring(1,len);
          $.ajax
          ({
          type: 'post',
          url: 'delete_reporter.php',
          data: {
            reporter_id:reporter_id
          },
        success: function(data)
        {
          window.location.href="reporter.php";
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