<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Register</title>

  <!-- Custom style-->
  <link href="public/css/bootstrap.min.css" rel="stylesheet" type="text/css">

  <!-- Custom fonts for this template-->
  <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="public/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form action="index.php?controller=UserController&method=submit_register" method="post" id="registerForm">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="name" name="name" class="form-control" placeholder="Name" required="required" autofocus="autofocus" value="<?php echo (isset($_POST['name']) ? $_POST['name'] : ''); ?>">
              <label for="name">Name</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required value="<?php echo (isset($_POST['inputEmail']) ? $_POST['inputEmail'] : ''); ?>">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required="required">
                  <label for="inputPassword">Password</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm password" required="required">
                  <label for="confirmPassword">Confirm password</label>
                </div>
              </div>
            </div>
          </div>
            
            <button id="submitRegister" name="register" type="submit" class="btn btn-primary btn-block">Register</button>

<!--
      <a class="btn btn-primary btn-block" href="login.html">Register</a>
-->
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="index.php?controller=UserController&method=login">Login Page</a>
          <a class="d-block small" href="index.php?controller=UserController&method=forgetPassword">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script type="text/javascript" src="public/vendor/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="public/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script type="text/javascript" src="public/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- customize script -->
  <script type="text/javascript" src="public/js/script.js"></script>


</body>

</html>
