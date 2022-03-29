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
                        <th>Channel Name</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
$chk_id='1';
$sql1 = "SELECT * FROM waiting_reporter order by username";
$result1 = $con->query($sql1);
if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc())
    {
?>
    </script>
                      <tr>
                        <td><label><?php echo $row1['username'] ?></label></td>
                        <td><label><?php echo $row1['last_name'] ?></label></td>
                        <td><label><?php echo $row1['phone'] ?></label></td>
                        <td><label><?php echo $row1['mail'] ?></label></td>
                        <td><label><?php echo $row1['cl_id'] ?></label></td>
                        <td>
                            <a class="add_delete" onclick="add_delete_reporter('<?php echo $row1['id'] ?>','add')" href="#" style="color: blue;">
                                <i class="fa fa-plus-square" aria-hidden="true"></i>
                            </a>&nbsp; &nbsp; 
                            <a class="add_delete" onclick="add_delete_reporter('<?php echo $row1['id'] ?>','delete')" href="#" style="color: blue;">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
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
  

    // $('#check_status').click(function()
    // {
    //   alert("status");
    // });


function add_delete_reporter(reporter_id,check){

    if(check=="add")
    {
      var msg="Are you sure to add this Reporter?";
    }
    else
    {
      var msg="Are you sure to delete this Reporter?";
    }
    if (window.confirm(msg))
    {
          $.ajax({
          type: 'post',
          url: 'add_delete_reporter.php',
          data: {
           reporter_id:reporter_id, check:check
          },
          success: function(data)
          {
              alert(data);
              location.reload(true);
          }
        });
    }
    else
    {
        return;
    }


  }

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