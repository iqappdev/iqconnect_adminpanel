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
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Inbox</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
              </div>
              <div class="table-responsive mailbox-messages">
                <table id="bootstrap-data-table" class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Time</th>
                        <th>Options</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
$chk_id='1';
$sql1 = "SELECT * FROM messages";
$result1 = $con->query($sql1);
if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc())
    {
      if($row1['status']=='OPEN')
      {
          $value='style="background: rgba(242,245,245,0.8); color:#202124;"';
      }
      else
      {
          $value='style="background: rgba(255,255,255,0.902); color: #202124;"';
      }
?>
                      <tr <?php echo $value; ?>>
                        <td class="mailbox-name">
                        	<a class="nostyle" href="read-mail.php?msg_id=<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></a>
                        </td>
                        <td class="mailbox-subject">
                        	<a class="nostyle" href="read-mail.php?msg_id=<?php echo $row1['id']; ?>">
                        		<div class="cut-text"><b><?php echo $row1['subject']; ?></b> - <?php echo $row1['message']; ?></div>
                        	</a>
                        </td>
                        <td class="mailbox-date"><?php echo $row1['mail_time']; ?></td>
                        <td class="mailbox-date">
                          <center>
                            <a title="Delete" onclick="delete_mail('<?php echo $row1['id'] ?>')" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                
              </div>
            </div>
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
            "order": [[ 2, "desc" ]],
            "columnDefs": [
                { "width": "60%", "targets": 1 }
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

function delete_mail(msg_id)
{
    if (window.confirm('Are you sure to Delete this Mail?'))
    {
          $.ajax
          ({
          type: 'post',
          url: 'delete_mail.php',
          data: {
            msg_id:msg_id
          },
        success: function(data)
        {
          window.location.href="mailbox.php";
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