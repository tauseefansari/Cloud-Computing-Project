<?php
    require 'config/config.php';

    if(isset($_SESSION['username']))
    {
      header("Location: welcome.php");
    }

    $username="";
    $password="";
    $password1="";
    $password2="";
    if(isset($_POST['register']))
    {
      $username=strip_tags($_POST['username']);
      $username=ucfirst($username);
      $_SESSION['username']=$username;
      $password1=strip_tags($_POST['pass1']);
      $password2=strip_tags($_POST['pass2']);

      if ($password1 == $password2)
      {
      	$password1=md5($password1);
        $check=mysqli_query($con,"SELECT name FROM users WHERE name='$username'");
        if(mysqli_num_rows($check) == 0)
        {
          $query=mysqli_query($con,"INSERT INTO users VALUES('','$username','$password1')");
          echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> Registration Successful! Go ahead and Login!</div>';
          $username="";
          $password1="";
          $password2="";
        }
        else{
          echo '<div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Username already in use! try different username!</div>';
        }
      }
      else{
        echo '<div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> Both password should be same!</div>';
      }
    }


    if(isset($_POST['lgin']))
    {
      $username=strip_tags(md5($_POST['uname']));
      $password=strip_tags($_POST['pass']);
      $check_database_query=mysqli_query($con,"SELECT * FROM users WHERE name='$username' AND password='$password'");
      if(mysqli_num_rows($check_database_query) == 1)
      {
        $row=mysqli_fetch_array($check_database_query);
        //$username=$row['name'];
        $_SESSION['username']=$username;
        header("Location: welcome.php");
        exit();
      }
      else
      {
        echo '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong> Username or Password is incorrect!</div>';
      }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cloud Store</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="row">
    <div class="col-md-6">
      <div class="col-md-1">
      <img src="icloud.png" style="width: 230px; height: 230px; margin-left: 22px;">
      </div>
      <div class="col-md-11">
      <h1 style="margin-top: -187px;
    margin-left: 257px;
    font-size: 36px;
    font-style: italic;
    font-weight: bold;
    color: white;">Community Cloud</h1>
    <h2 style="margin-top: 0px;
    margin-left: 267px;
    font-size: 24px;
    font-style: italic;
    color: white;" align="center"> Developed for Cloud Computing</h2>
    </div>
    <div class="col-md-12">
    <p style="margin-left: 100px;
    margin-top: 100px;
    font-size: 25px;
    color: white;
    font-style: italic;"><B>A Community Cloud is designed to meet the needs of a community.

</B><br> <font style="font-size: 25px; font-style: italic; color: white;"> Community Cloud is the type of cloud computing technique in which the setup of the cloud is shared manually among different organizations that belong to the same community or area. Examples such as Research Organizations, Firms etc.<br> <strong>Register</strong> and <strong>Login</strong> to access your "Presentation Templates" which are available online on Cloud!</p></strong></font>
    </div>

    </div>
    <div class="col-md-6">  
<div class="pen-title">
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Login</h1>
    <form method="post">
      <div class="input-container">
        <input type="#{type}" id="#{label}" name="uname" required="required"/>
        <label for="#{label}">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" id="#{label}"  name="pass" required="required"/>
        <label for="#{label}">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button name="lgin"><span>Go</span></button>
      </div>
    </form>
  </div>
  <div class="card alt">
    <div class="toggle">
    </div>
    <h1 class="title">Register
      <div class="close"></div>
    </h1>
    <form method="post">
      <div class="input-container">
        <input type="#{type}" id="#{label}" name="username" required="required"/>
        <label for="#{label}">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" id="pass1" name="pass1" required="required"/>
        <label for="#{label}">Password</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" id="pass2" name="pass2" required="required"/>
        <label for="#{label}">Repeat Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button name="register"><span>Next</span></button>
      </div>
    </form>
  </div> <br><br>
</div>
</div>
</div>

<!-- Section: Team v.1 -->
<section class="team-section text-center my-5" >

  <!-- Section heading -->
  <h2 class="h1-responsive font-weight-bold my-5">Our Development Team</h2>
  <!-- Section description -->
  <p class="grey-text w-responsive mx-auto mb-5" style="color: #fff; font-size: 20px;">Copyright &copy by All Rights Reserved</p>

  <!-- Grid row -->
  <div class="row">

    <!-- Grid column -->
    <div class="col-lg-3 col-md-6 mb-lg-0 mb-5">
      <div class="avatar">
        <img src="tauseef.jpg" class="rounded-circle z-depth-1"
          alt="Sample avatar">
      </div>
      <h5 class="font-weight-bold mt-4 mb-3">Tauseef Ansari</h5>
      <p class="text-uppercase blue-text"><strong>Web & Java Developer</strong></p>
      <p class="grey-text" style="visibility: hidden;">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur,
        adipisci sed quia non numquam modi tempora eius.</p>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col-lg-3 col-md-6">
      <div class="avatar mx-auto">
        <img src="mohsin.jpg" class="rounded-circle z-depth-1"
          alt="Sample avatar">
      </div>
      <h5 class="font-weight-bold mt-4 mb-3">Mohsin Essani</h5>
      <p class="text-uppercase blue-text"><strong>Graphics Designer</strong></p>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col-lg-3 col-md-6">
      <div class="avatar mx-auto">
        <img src="sufyan.jpg" class="rounded-circle z-depth-1"
          alt="Sample avatar">
      </div>
      <h5 class="font-weight-bold mt-4 mb-3">Sufyan Bhakshey</h5>
      <p class="text-uppercase blue-text"><strong>UI Developer</strong></p>
    </div>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col-lg-3 col-md-6">
      <div class="avatar mx-auto">
        <img src="aamir.jpg" class="rounded-circle z-depth-1"
          alt="Sample avatar">
      </div>
      <h5 class="font-weight-bold mt-4 mb-3">Aamir Thekiya</h5>
      <p class="text-uppercase blue-text"><strong>Backend developer</strong></p>
    </div>

</section>
<!-- Section: Team v.1 -->


  <script type="text/javascript">
    $('.toggle').on('click', function() {
  $('.container').stop().addClass('active');
});

$('.close').on('click', function() {
  $('.container').stop().removeClass('active');
});

  </script>
</body>
</html>