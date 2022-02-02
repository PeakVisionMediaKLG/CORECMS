<?php
session_start(); 
include_once('../../custom/config/config.php');
include_once('../classes/class.sessiondata.php');
include_once("../classes/class.db.php");
$MY_SESSION = new SESSIONDATA();
$DB = new DB($SETTINGS,$MY_SESSION);

include_once('../classes/class.user.php');
$USER = new USER($DB);

$login_form_action = $_POST['login_form_action'] ?? '';

$inputresponses="";

if($login_form_action==$USER->TXT['signin'])
{
    if($USER->USER_AUTH_OK!=1) $USER_AUTH_OK=$USER->VERIFY_LOGIN_DATA(@$_POST['user'],@$_POST['password']);
    if($USER->ERROR_RESPONSE==2) $inputresponses.="<br><div class='alert alert-warning' role='alert'>".$USER->TXT["Please input both your user name and password."]."</div>";
    if($USER->ERROR_RESPONSE==1) $inputresponses.="<br><div class='alert alert-danger' role='alert'>".$USER->TXT["The provided login information is incorrect."]."</div>";
}

if($login_form_action==$USER->TXT['sign out'])
{
    $USER->SIGNOUT('admin.login.php');
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../components/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../components/animate.css/animate.css">	
  </head>
  <body>
 	<div class="container">
		<div class="row" style="height:100%;padding-top:10%">
		  <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4 mr-auto ml-auto">
			<div class="card">
				<img class="card-img-top" src="login.svg" alt="Login">
				  <div class="card-body">
						
					  	<?php if($USER->USER_AUTH_OK!=1){ ?>
					  
					  	<h5 class="card-title"><?php echo $USER->TXT['signin'];?></h5>
						<form name="loginform" class="" id="loginform" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
							<div class="form-group row">
								<div class="col-12 mt-2">
									<label for="input_user" class="col"><?php echo $USER->TXT['username'];?></label>
								</div>	
								<div class="col-12">
								  <input type="text" name="user" class="form-control" id="input_user" placeholder="" tabindex="10" value="<?php if ($USER->USER_AUTH_OK) echo $USER->GET_USERVAL('user'); elseif(isset($_POST['user'])) echo $_POST['user']?>">
								</div>
								<div class="col-12 mt-3">
									<label for="input_user" class="col"><?php echo $USER->TXT['password'];?></label>
								</div>	
								<div class="col-12">
								  <input type="password" name="password" class="form-control" id="input_password" placeholder="" tabindex="20">
								</div>
								<div class="col-12">
									<?php echo $inputresponses; ?>
								</div>	
								<div class="col-12 mt-3">
									<input type="submit" name="login_form_action" id="wp-submit" class="btn btn-default submit-login"  value="<?php echo $USER->TXT['signin'];?>" tabindex="40">
								</div>
								<div class="col-12 input-message">
									
								</div>	
                                <input type="hidden" name="signin" value="1">
							</div> 
					  	</form>
					  
					  	<?php } else { ?>
					  	<div class="form-group row">
							<div class="col-6 ">
								<p class="text-right"><a href="../../show.php" class="btn btn-primary" tabindex="40"><?php echo $USER->TXT['continue'];?></a></p>
							</div>
							<div class="col-6">
								<form name="loginform" class="" id="loginform" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
									<input type="submit" name="login_form_action" id="wp-submit" class="btn btn-default submit-login"  value="<?php echo $USER->TXT['sign out'];?>" tabindex="40">
                                </form>
							</div>
					  	</div>	
					   	<?php } ?> 
					  
				  </div>
			</div>
		</div>
	</div>   
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="../../components/wow/wow.min.js"></script>	
    <script src="../../components/jquery/jquery-3.2.1.min.js"></script>
    <script src="../../components/popper/popper1.11.0.js"></script>
    <script src="../../components/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>