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

$msg_id=$_GET['msg_id'];
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
              <h3 class="box-title">Forward Message</h3>
            </div>
            <form action="send_mail.php" method="post">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <input class="form-control" name="email" id="email" required placeholder="To:">
              </div>
              <div class="form-group">
                <input class="form-control" name="subject" id="subject" placeholder="Subject:" value="FWD:<?php echo $row1['subject']; ?>">
              </div>
              <div class="form-group">
                    <textarea id="mail_content" name="mail_content" class="form-control" style="height: 300px">
                        ---------- Forwarded message ---------
                        From: <?php echo $row1['name']; ?> <<?php echo $row1['email']; ?>>
                        Date: <?php echo $row1['mail_time']; ?><br>
                        Subject: <?php echo $row1['subject']; ?><br>
                        To: <info@cloudq.co.in>
                                <?php echo $row1['message']; ?>
                    </textarea>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              <a href="read-mail.php?msg_id=<?php echo $row1['id']; ?>" type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</a>
            </div>
            </form>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->


                </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


<script type="text/javascript">
        $(document).ready(function() {
          
           $('#bootstrap-data-table').DataTable({

            "columnDefs": [
                { "width": "60%", "targets": 2 }
              ]
    });

    $('input[type=search]').attr('placeholder','Enter Your Search Text');

    $('#row-select').DataTable( {
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select class="form-control"><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
     
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
     
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );

        } );
    </script>

</body>
</html>
<?php
}
?>