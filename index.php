<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IQ Live - Admin Panel</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="images/logonew.png">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body class="bg-dark">


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.php" style="font-size: 28px;">
                        IQ Live Admin Portal
                    </a>
                </div>
                <div class="login-form">
                    <form id="login" action="login.php" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" id="remember"> Remember Me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>


<script type="text/javascript">
    
$(document).ready(function() {

        var remember = $.cookie('remember');
        if (remember == 'true') 
        {
            var username = $.cookie('username');
            var password = $.cookie('password');
            // autofill the fields
            $('#username').val(username);
            $('#password').val(password);
        }


    $("#login").submit(function() {
        if ($('#remember').is(':checked')) {
            var username = $('#username').val();
            var password = $('#password').val();

            // set cookies to expire in 14 days
            $.cookie('username', username, { expires: 14 });
            $.cookie('password', password, { expires: 14 });
            $.cookie('remember', true, { expires: 14 });                
        }
        else
        {
            // reset cookies
            $.cookie('username', null);
            $.cookie('password', null);
            $.cookie('remember', null);
        }
  });
});

</script>





</body>
</html>
