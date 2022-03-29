<?php
include 'db.php';
include 'left_panel.php';

session_start();
$user=$_SESSION['userid'];
if(!isset($_SESSION['userid']))
{
  require("index.php");
}
else
{

$msg_id=$_GET['msg_id'];

$sql2 = "UPDATE messages SET status='OPEN' WHERE id='$msg_id'";  
$con->query($sql2);

$sql1 = "SELECT * FROM messages where id='".$msg_id."'";
$result1 = $con->query($sql1);
$row1 = $result1->fetch_assoc();

?>


        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                <div class="col-md-12">


          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Mail</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?php echo $row1['subject']; ?></h3>
                <h5>From: <?php echo $row1['email']; ?>
                  <span class="mailbox-read-time pull-right"><?php echo $row1['mail_time']; ?></span></h5>
              </div>
              <!-- /.mailbox-read-info -->
<!--               <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete" data-original-title="Delete">
                    <i class="fa fa-trash-o"></i></button>
                  <a href="reply_mail.php?msg_id=<?php echo $row1['id']; ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply" data-original-title="Reply">
                    <i class="fa fa-reply"></i></a>
                  <a href="forward_mail.php?msg_id=<?php echo $row1['id']; ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward" data-original-title="Forward">
                    <i class="fa fa-share"></i></a>
                  <a href="javascript:window.print()" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print" data-original-title="Print">
                    <i class="fa fa-print"></i></a>
                </div>
                
              </div> -->
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">

                <p><?php echo $row1['message']; ?></p>

              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <a href="reply_mail.php?msg_id=<?php echo $row1['id']; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Reply</a>
                <a href="forward_mail.php?msg_id=<?php echo $row1['id']; ?>" class="btn btn-default"><i class="fa fa-share"></i> Forward</a>
              </div>
              <button type="button" class="btn btn-default delete_mail" name="<?php echo $row1['id']; ?>"><i class="fa fa-trash-o"></i> Delete</button>
              <button type="button" onclick="printPage();" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
            </div>
            <!-- /.box-footer -->
          </div>


                </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


<script type="text/javascript">


function printPage()
{
  window.print();
}



$(function(){
  $("button.delete_mail").click(function()
  {
    if (window.confirm('Are you sure to Delete this Mail?'))
    {
          var msg_id=$(this).attr('name');
          $.ajax
          ({
          type: 'post',
          url: 'delete_mail.php',
          data: {
            msg_id:msg_id
          },
        success: function(data)
        {
          window.location.href = "mailbox.php";
        }

        });

    }
    else
    {
        return;
    }


  });
});

$(document).ready(function()
{
  $('#bootstrap-data-table').DataTable({
      "columnDefs":
      [
        { "width": "60%", "targets": 2 }
      ]
  });
  $('input[type=search]').attr('placeholder','Enter Your Search Text');
} );

</script>

</body>
</html>
<?php
}
?>