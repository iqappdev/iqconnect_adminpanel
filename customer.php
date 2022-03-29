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
                            <strong class="card-title">Customer List</strong>
                        </div>
                        <div class="card-body">
                  <table id="customer_table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Customer Name</th>
                        <th>Email ID</th>
                        <th>Channel</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
$chk_id='1';
$sql1 = "SELECT * FROM customer order by cl_id";
$result1 = $con->query($sql1);
if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc())
    {
        if($row1['status']=="Blocked")
        {
            $text = "Block";
            $icon = "fa fa-lock";
            $value = "Unblock";
        }
        else
        {
            $text = "Active";
            $icon = "fa fa-unlock";
            $value = "Block";
        }
?>

                      <tr>
                        <td><label><?php echo $row1['username'] ?></label></td>
                        <td><label><?php echo $row1['email'] ?></label></td>
                        <td><label><?php echo $row1['cl_id'] ?></label></td>
                        <td>
                            <a class="block_user" onclick="block_user('<?php echo $row1['email'] ?>','<?php echo $row1['cl_id'] ?>','<?php echo $value ?>')" href="#" style="color: blue;">
                                <i class="<?php echo $icon; ?>" aria-hidden="true"></i>
                                &nbsp; <?php echo $text; ?>
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


function block_user( email, channel_id, value){
    if (window.confirm('Are you sure to '+value+' this User?'))
    {
          $.ajax
          ({
          type: 'post',
          url: 'block_user.php',
          data: {
            email:email, channel_id:channel_id
          },
        success: function(data)
        {
            window.location.href="customer.php";
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
          $('#customer_table').DataTable({
            "order": []
          });
        } );
    </script>


</body>
</html>
<?php
}
?>