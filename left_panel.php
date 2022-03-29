<?php
$sql1 = "SELECT * FROM messages where status='NOT_OPEN'";
$result1 = $con->query($sql1);
$total = $result1->num_rows;

function sort_length($word, $limit)
{
    $in=$word;
    $out = strlen($in) > $limit ? substr($in,0,$limit)."..." : $in;
    return $out;
}

?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head id="print_check">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IQ Connect - Admin Portal</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="images/logonew.png">


  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  


    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->


<style type="text/css">
    
a.nostyle:link {
    text-decoration: inherit;
    color: inherit;
}

a.nostyle:visited {
    text-decoration: inherit;
    color: inherit;
}

.cut-text
{
  text-overflow: ellipsis;
  overflow: hidden; 
  width: 560px;
  white-space: nowrap;
}


.switch.switch-text .switch-input:checked ~ .switch-handle {
    left: 58px;
}

</style>


</head>
<body id="print_check1">

<?php
include 'js.php';
?>

<script id="source" language="javascript" type="text/javascript">

window.setInterval(function () 
{
    $.ajax({
        type: 'post',
        url: 'check_new_mail.php',
        data:{},
        dataType: 'json',
        success: function(data)
        {
            if(data!=0)
            {                     
            	document.getElementById("msg_count").innerHTML = data;
        	}
        }
    });
},500); 



window.setInterval(function () 
{
    $.ajax({
        type: 'post',
        url: 'check_new_request.php',
        data:{},
        dataType: 'json',
        success: function(data)
        {
            if(data!=0)
            {
                document.getElementById("request_count").innerHTML = data;
            }
        }
    });
},500); 
</script>



        <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#">IQ Connect</a>
                <a class="navbar-brand hidden" href="#"><img src="images/logonew.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <h3 class="menu-title">Channel (IQ Connect) </h3><!-- /.channel-title -->
                    <li>
                        <a href="channel_list.php"> <i class="menu-icon fa fa-television"></i>Channel List </a>
                    </li>
                    <li>
                        <a href="add_channel.php"> <i class="menu-icon fa fa-plus"></i>Add Channel</a>
                    </li>
                    <h3 class="menu-title">Users</h3><!-- /.Customer-title -->
                    <li>
                        <a href="customer.php"> <i class="menu-icon fa fa-users"></i>Customer</a>
                    </li>
                    <li>
                        <a href="reporter.php"> <i class="menu-icon fa fa-camera"></i>Reporter</a>
                    </li>
                    <li>
                        <a href="reporter_request.php"> <i class="menu-icon fa fa-list-alt"></i>Pending Request
                            <span class="badge badge-primary pull-right" id="request_count"></span>
                        </a>
                    </li>
                    <h3 class="menu-title">Mail</h3><!-- /.channel-title -->
                    <li>
                        <a href="compose.php"> <i class="menu-icon fa fa-plus-circle"></i>Compose </a>
                    </li>
                    <li>
                        <a href="mailbox.php"> <i class="menu-icon fa fa-inbox"></i>Inbox
                            <span class="badge badge-primary pull-right" id="msg_count"></span>
                        </a>
                    </li>
                    <h3 class="menu-title">Others</h3><!-- /.Customer-title -->
                    <li>
                        <a href="history.php"> <i class="menu-icon fa fa-history"></i>History</a>
                    </li>
                    <li>
                        <a href="push_notification.php"> <i class="menu-icon fa fa-flag"></i>Push Notifications</a>
                    </li>
                   <!--  <li>
                        <a href="push_notify.php"> <i class="menu-icon fa fa-mobile" style="font-size: 1.5em;"></i>Push Notifications</a>
                    </li> -->

                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        Admin Panel
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="images/admin.jpg" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="logout.php"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->