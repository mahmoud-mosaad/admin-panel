<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Forgot Password</title>

  <!-- Custom fonts for this template-->
  <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="public/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <div class="text-center mb-4">
          <p>Enter your new Password and confirm it</p>
        </div>
        <form action="index.php?controller=UserController&method=submit_resetPassword" method="post" id="resetPasswordForm">
            <div class="form-group">
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Enter email address" required="required" autofocus="autofocus">
                        <label for="inputEmail">Enter email address</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-label-group">
                            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required="required">
                            <label for="inputPassword">New password</label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-label-group">
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm password" required="required">
                            <label for="confirmPassword">Confirm new password</label>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET['error'])){
                echo '<div class="alert alert-danger" role="alert">';
                echo $_GET['error'];
                echo '</div>';
            }
            ?>
            <button id="submitResetPassword" name="submitResetPassword" type="submit" class="btn btn-primary btn-block">Reset Password</button>

            <!--
          <a class="btn btn-primary btn-block" href="index.php?controller=UserController&method=resetPassword">Reset Password</a>
        -->
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="index.php?controller=UserController&method=register">Register an Account</a>
          <a class="d-block small" href="index.php?controller=UserController&method=login">Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="public/vendor/jquery/jquery.min.js"></script>
  <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="public/vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
