<!DOCTYPE html>
<html>
	<head>
		<title>Reset Password</title>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
		<link rel="stylesheet" type="text/css" href="public/css/style.css">
		<script type="text/javascript"  src="public/js/script.js"></script>	
	</head>
	<body>
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-4" >
					<br><br><br><br><br><br>

					<h4 class="text-center">Reset Password</h4>
					<p class="text-center">Enter your email address and enter your new Password and confirm it</p>
					<form action="<?php echo BASEURL.'User/submit_resetPassword'; ?>" method="post" id="resetPasswordForm">
					    <div class="form-group input-group">
					    	<div class="input-group-prepend">
							    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
							 </div>
					        <input id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" type="email" required autofocus="autofocus">
					    </div>
					   <div class="form-group input-group" id="show_hide_password">
					    	<div class="input-group-prepend">
							    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
					        <input id="inputPassword" name="inputPassword" class="form-control" placeholder="Enter password" type="password" required>
				            <div class="input-group-append">
		                        <span class="input-group-text">
		                            <a href=""><i class="fa fa-eye-slash"></i></a>
		                        </span>
		                    </div>
					    </div>
					    <div class="form-group input-group" id="show_hide_password">
					    	<div class="input-group-prepend">
							    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
							</div>
					        <input id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Repeat password" type="password" required>
				            <div class="input-group-append">
		                        <span class="input-group-text">
		                            <a href=""><i class="fa fa-eye-slash"></i></a>
		                        </span>
		                    </div>
					    </div>
			            <?php
			                if (isset($_GET['error'])){
			                    echo '<div class="alert alert-danger" role="alert">';
			                    echo $_GET['error'];
			                    echo '</div>';
			                }
			            ?>       
					    <div class="form-group">
					        <button id="submitResetPassword" name="submitResetPassword" type="submit" class="btn btn-primary btn-block"> Reset Password </button>
					    </div>       
					    <p class="text-center">Have an account? <a href="<?php echo BASEURL.'User/register'; ?>">Register</a> </p>
					    <p class="text-center">Already registered? <a href="<? echo BASEURL.'User/login'; ?>">Login</a> </p>

					</form>
					<br><br><br><br><br><br><br><br><br>
				</div>
			</div>
		</div>
	</body>
</html>