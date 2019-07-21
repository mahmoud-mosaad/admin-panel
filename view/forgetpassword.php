<!DOCTYPE html>
<html>
	<head>
		<title>Forget Password</title>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
		<link rel="stylesheet" type="text/css" href="../public/css/style.css">
		<script type="text/javascript"  src="../public/js/script.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-4" >
					<br><br><br><br><br><br><br><br>

					<h4 class="text-center">Forget Password</h4>
					<p class="text-center">Enter your email address and we will send you instructions on how to reset your password.</p>
					<form id="forgetPasswordFrom" method="post" action="<?php echo BASEURL.'User/submit_forgetPassword'; ?>">
					    <div class="form-group input-group">
					    	<div class="input-group-prepend">
							    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
							 </div>
					        <input id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" type="email" required autofocus="autofocus">
					    </div>                                    
					    <div class="form-group">
					        <button id="submitForgetPassword" name="submitForgetPassword" type="submit" class="btn btn-primary btn-block"> Send Email  </button>
					    </div>       
					    <p class="text-center">Have an account? <a href="<?php echo BASEURL.'User/register'; ?>">Register</a> </p>
					    <p class="text-center">Already registered? <a href="<?php echo BASEURL.'User/login'; ?>">Login</a> </p>

					</form>
					<br><br><br><br><br><br><br><br><br>
				</div>
			</div>
		</div>
	</body>
</html>