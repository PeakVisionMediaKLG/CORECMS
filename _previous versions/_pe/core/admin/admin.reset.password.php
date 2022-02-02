<?php 
session_start(); 
include_once('../../custom/config/config.php');
include_once('../classes/class.sessiondata.php');
include_once("../classes/class.db.php"); 
$MY_SESSION = new SESSIONDATA();
$DB = new DB($SETTINGS,$MY_SESSION);

include_once('../classes/class.user.php');    	
$USER = new USER($DB);

$mykey = $_GET['key'] ?? $_POST['key'] ?? "";
$login_form_action = $_POST['login_form_action'] ?? "";
if($mykey=="") die('no key sent');
$success=0;
$errormessage = "";
$myusername = $_POST['uUser'] ?? "";
if($login_form_action==$USER->TXT['set password'])
{
    $success=1;
    if($_POST['password']=="" or $_POST['repeatpassword']=="") $success=0;
    if($_POST['password']!=$_POST['repeatpassword']) {$success=0; $errormessage=$USER->TXT['The passwords do not match.'];}
    
    if($success==1 and isset($_POST['uUID']))
    {
        $DB->PREP_QUERY ('UPDATE users SET uPassword=?, uIdentifier=? WHERE uUID=?', 
                             'users', 
                             array('uPassword','uIdentifier','uUID'), //
                             array(md5($_POST['password']),md5($DB->SETTINGS['session_salt'] . md5($myusername . $DB->SETTINGS['session_salt'])),$_POST['uUID']), 
                             array(), //'uUID'
                             array(), //$_POST['uUID']
                             0);
        
    }
    
    
}
if($login_form_action!=$USER->TXT['set password'] or $success!=1){
    $result = $DB->PREP_QUERY ('SELECT * FROM USERS', 
                             'users', 
                             array(), //
                             array(), 
                             array(), 
                             array(),
                             0); 
    $cleared=0;
    //print_r($result);
    while ($userrow = mysqli_fetch_array($result))
    {   
        //print_r($userrow);
        if(md5(implode($userrow))==$mykey) {$cleared=1; $myuserid=$userrow['uUID']; $myusername=$userrow['uUser'];} 
    }
    if(!$cleared) die('invalid key sent'); 
}




?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script defer src="../../components/font-awesome/svg-with-js/js/fontawesome-all.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../components/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../components/animate.css/animate.css">	
  </head>
  <body>
 	<div class="container">
		<div class="row" style="height:100%;padding-top:10%">
		  <div class="col-sm-4 mr-auto ml-auto">
			<div class="card">
                <div style="font-size:3em;padding:20px;width:100%; text-align: center;">
				    <i class="fas fa-key"></i>
                </div>
				  <div class="card-body">
						
					  <?php if($login_form_action!=$USER->TXT['set password'] or $success!=1) { ?>
					  	<h5 class="card-title"><?php echo $myusername."<br><br>".$USER->TXT['Please input your new password.'];?></h5>
						<form name="loginform" class="" id="loginform" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
							<div class="form-group row">
                                
								<div class="col-12 mt-3">
									<label for="input_user" class="col"><?php echo $USER->TXT['password'];?></label>
								</div>	
								<div class="col-12">
								  <input type="text" name="password" class="form-control" id="input_password" placeholder="" tabindex="20">
								</div>
                                <div class="col-12 mt-3">
									<label for="input_user" class="col"><?php echo $USER->TXT['repeat password'];?></label>
								</div>	
								<div class="col-12">
								  <input type="text" name="repeatpassword" class="form-control" id="input_password" placeholder="" tabindex="20">
                                    <?php if($success!=1 and $login_form_action==$USER->TXT['set password'] ) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php  echo $errormessage; ?>
                                    </div><?php  } ?>       
								</div>
								<div class="col-12 mt-3">
									<input type="submit" name="login_form_action" id="wp-submit" class="btn btn-default submit-login"  value="<?php echo $USER->TXT['set password'];?>" tabindex="40">
								</div>
                                <input type="hidden" name="uUID" value="<?php echo $myuserid; ?>">
                                <input type="hidden" name="key" value="<?php echo $mykey; ?>">
                                <input type="hidden" name="uUser" value="<?php echo $myusername; ?>">
							</div> 
					  	</form>
					 <?php } elseif($login_form_action==$USER->TXT['set password'] and $success) { ?>
                        <h5 class="card-title"><?php echo $myusername."<br><br>".$USER->TXT['Your password was successfully changed.'];?></h5>
						<form name="loginform" class="" id="loginform" action="admin.login.php" method="POST">
							<div class="form-group row">
                				<div class="col-12 mt-3">
									<input type="submit" name="login_form_action" id="wp-submit" class="btn btn-default btn-primary" value="<?php echo $USER->TXT['signin'];?>" tabindex="40">
								</div>
                                <input type="hidden" name="uUID" value="<?php echo $myuserid; ?>">
							</div> 
					  	</form>  
                      
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