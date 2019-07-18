<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="public/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="index.php?controller=UserController&method=submit_login" method="post" id="loginForm">
          <div class="form-group">
            <div class="form-label-group">
              <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
              <label for="inputEmail">Email address</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" name="inputPasswordLogin" class="form-control" placeholder="Password" required="required" >
              <label for="inputPassword">Password</label>
            </div>
          </div>

            <div class="form-group form-check">
                <input id="rememberme" name="rememberme" type="checkbox" class="form-check-input" value="1">
              <label class="form-check-label" for="exampleCheck1">Remember Me</label>
            </div>

          <button id="submitLogin" name="submitLogin" type="submit" class="btn btn-primary btn-block">Login</button>

        <!--  <a class="btn btn-primary btn-block" href="index.html">Login</a>-->
        

        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="index.php?controller=UserController&method=register">Register an Account</a>
          <a class="d-block small" href="index.php?controller=UserController&method=forgetPassword">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script type="text/JavaScript" src="public/vendor/jquery/jquery.min.js"></script>
  <script type="text/JavaScript" src="public/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/JavaScript" src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script type="text/JavaScript" src="public/vendor/jquery-easing/jquery.easing.min.js"></script>

  
  <!-- customize script -->
  <script type="text/JavaScript" src="public/js/script.js"></script>

</body>

</html>
