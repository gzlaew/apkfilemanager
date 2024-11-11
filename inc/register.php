<?php
session_start();


// Cek apakah dia sudah login apa belum (sudah ada session)

if (@$_SESSION['email']) {
    if (@$_SESSION['level'] == "Admin") {header ("Location: ../admin/index.php");}
     elseif (@$_SESSION['level'] == "Supervisor") {header ("Location: ../supervisor/index.php");}
     elseif (@$_SESSION['level'] == "Petugas") {header ("Location: ../petugas/index.php");}
}






require 'function.php';

if (isset($_POST['register'])) {
   if (registrasi($_POST) > 0 ) {
     echo "<script>
    alert('user baru berhasil di tambahkan ');
    document.location.href = 'login.php';
  </script>";
   }else{
     echo mysqli_error($kon);
   }
}


$data = setting("SELECT * FROM tb_setting");
  ?>




<!doctype html>
<html class="no-js " lang="en">

<!-- Mirrored from www.wrraptheme.com/templates/compass/html/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 01 Feb 2024 07:19:20 GMT -->
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>:: Compass Bootstrap4 Admin ::</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/assets/css/main.css">
    <link rel="stylesheet" href="../admin/assets/css/authentication.css">
    <link rel="stylesheet" href=".../admin/assets/css/color_skins.css">
</head>

<body class="theme-cyan authentication sidebar-collapse">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
    <div class="container">        
        <div class="navbar-translate n_logo">
            <a class="navbar-brand" href="#" title="" target="_blank">COMPASS</a>
            <button class="navbar-toggler" type="button">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<div class="page-header">
    <div class="page-header-image" style="background-image:url(../admin/assets/images/login.jpg)"></div>
    <div class="container">
        <div class="col-md-12 content-center">
            <div class="card-plain">
                <form class="form" method="post" action="#">
                    <div class="header">
                        <div class="logo-container">
                            <img src="../admin/assets/images/logo_mvp.png" alt="">
                        </div>
                        <h5>Sign Up</h5>
                    </div>
                    <div class="content">                                                
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter User Name" name="Nama">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-account-circle"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter Email" name="Email">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-email"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <input type="password" placeholder="Password" class="form-control" name="Password" />
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-lock"></i>
                            </span>
                        </div>  
                        <div class="input-group">
                            <input type="password" placeholder="Password" class="form-control" name="Password2" />
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-lock"></i>
                            </span>
                        </div>        
                    </div>
                    <div class="checkbox">
                            <input id="terms" type="checkbox">
                        </div>
                    <div class="footer text-center">
                        <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="register">Sig up</button>
                        <h6 class="m-t-20"><a class="link" href="sign-in.html">You already have a membership?</a></h6>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <nav>
            </nav>
            <div class="copyright">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>,
                <span>Designed by <a href="#" target="#">ThemeMAkker</a></span>
            </div>
        </div>
    </footer>
</div>

<!-- Jquery Core Js -->
<script src="../admin/assets/bundles/libscripts.bundle.js"></script>
<script src="../admin/assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
<script>
   $(".navbar-toggler").on('click',function() {
    $("html").toggleClass("nav-open");
});
</script>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/compass/html/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 01 Feb 2024 07:19:20 GMT -->
</html>