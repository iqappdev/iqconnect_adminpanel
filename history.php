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

$channel_id=$_GET['channel'];
$tab=$_GET['tab'];

if($tab=='reporter')
{
    $display_customer = " ";
    $display_reporter = " show active";
    $tab_customer = " ";
    $tab_reporter = " active";
}
else
{
    $display_customer = " show active";
    $display_reporter = " ";
    $tab_customer = " active";
    $tab_reporter = " ";
}
?>


        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                <div class="col-md-12">
                    <div class="card">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link<?php echo $tab_customer ?>" id="customer-tab" data-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">Customer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link<?php echo $tab_reporter ?>" id="reporter-tab" data-toggle="tab" href="#reporter" role="tab" aria-controls="reporter" aria-selected="false">Reporter</a>
                            </li>
                        </ul>

                        <div class="card-header">
                            <strong class="card-title">History</strong>

                            <select name="select_channel" id="select_channel" class="form-control pull-right" style="width: 20%">
                                <option value="0">Select All Channel</option>
                                <?php
                                $sql1 = "SELECT * FROM channel";
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

                    <div class="tab-content pl-3 p-1" id="myTabContent">
                        <div class="tab-pane fade<?php echo $display_customer ?>" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                        <br>
                            <div class="card-body" id="history_channel_wise">
                      
                            </div>
                        </div>

                        <div class="tab-pane fade<?php echo $display_reporter ?>" id="reporter" role="tabpanel" aria-labelledby="reporter-tab"><br>

                            <div class="card-body" id="history_channel_wise1">
                      
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

    <script type="text/javascript">
        $(document).ready(function() {

            <?php
                if (!isset($channel_id)) $channel_id = '0';
            ?>

            var cl_id = '<?php echo $channel_id; ?>';
            $.ajax
            ({
                type: 'post',
                url: 'selected_channel_history.php',
                data: { cl_id: cl_id },

                success:function(data)
                {
                    $("#history_channel_wise").html(data);
                }
            });

            $.ajax
            ({
                type: 'post',
                url: 'selected_channel_history_reporter.php',
                data: { cl_id: cl_id },

                success:function(data)
                {
                    $("#history_channel_wise1").html(data);
                }
            });

        } );


$(function(){
    $('#select_channel').change(function(){
        var cl_id = $('#select_channel').val();
        
        $.ajax
        ({
            type: 'post',
            url: 'selected_channel_history.php',
            data: { cl_id: cl_id },

            success:function(data)
            {
                $("#history_channel_wise").html(data);
            }
        });

        $.ajax
        ({
            type: 'post',
            url: 'selected_channel_history_reporter.php',
            data: { cl_id: cl_id },

            success:function(data)
            {
                $("#history_channel_wise1").html(data);
            }
        });
    });
});

    </script>


</body>
</html>
<?php
}
?>