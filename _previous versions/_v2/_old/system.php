<?php
session_start();
include_once('custom/config/config.php');
include_once('core/classes/class.sessiondata.php');
include_once('core/classes/class.db.php');
include_once('core/classes/class.modal.php');
include_once('core/classes/class.page.php');
include_once('core/classes/class.user.php');
include_once('core/classes/class.admin.php');
include_once('core/classes/class.content.php');

$MY_SESSION = new SESSIONDATA();

$MY_SESSION->SET_VAL('interface','toolbar_expand_system',1);
$DISPLAY_MODE= $_GET['mode'] ?? header("Location: show.php");

$DB = new DB($SETTINGS,$MY_SESSION);
$PAGE = new PAGE($DB,@$_GET['url']);

$USER = new USER($DB);
$USER->CHECK_SESSION_STATE();

if(!$USER->USER_AUTH_OK) die ('unauthorized access');

$ADMIN = new ADMIN($DB,$PAGE,$USER);
$CONTENT = new CONTENT($DB,$PAGE,$USER);
?>

<!doctype html>
<html lang="<?php echo $PAGE->GET_PAGEVAL('pLanguage'); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $PAGE->GET_PAGEVAL('pDescription');?>">
    <meta name="keywords" content="<?php echo $PAGE->GET_PAGEVAL('pKeywords');?>">  
    <title><?php echo $PAGE->GET_PAGEVAL('pTitle');?></title>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="components/bootstrap/css/bootstrap.css">
    <!-- fontawesome js -->
    <script defer src="components/font-awesome/js/all.js"></script>
    <!-- core css -->
    <link rel="stylesheet" href="core/css/core.css">
    <!-- user css -->
    <link rel="stylesheet" href="custom/css/user.css">      
	<!-- animate css -->
    <link rel="stylesheet" href="components/animate.css/animate.css">
	
	<script src="components/jquery/jquery-3.2.1.min.js"></script>  
	<script src="components/lazyload/build/jquery.lazyload-any.min.js"></script>
    
    <?php
            if($USER->USER_AUTH_OK) { include_once('core/admin/admin.includes.php');  } 
            $PAGE->JS_SESSION_CREATE(); 
    ?>
  </head>
  <body>
    
  	<?php
			if($USER->USER_AUTH_OK) { $ADMIN->TOOLBAR(); }

			switch($_GET['mode'])
            {
                case "configuration":
                    include_once('core/system/system.configuration.php');
                break;
                case "users":
                    include_once('core/system/system.users.php');                   
                break;
                case "languages":
                    include_once('core/system/system.languages.php');                   
                break;                     
                default:
                    echo "<div class='row'><div class='col-md-8 m-auto core-admin-toolbar'><h2>Available soon</h2><br></h2></div></div>";
                break;    
            }

			if($USER->USER_AUTH_OK) { $ADMIN->TOOLBAR_CLOSETAGS(); } 
      
            echo $DB->SETTINGS['bodyInclude'];
	?>
	  
	<!-- required js includes -->  
    <script src="components/popper/popper1.11.0.js"></script>
    <script src="components/bootstrap/js/bootstrap.min.js"></script>
    <script src="components/wow/wow.min.js"></script>
    <script src="core/js/core.js"></script>  
  </body>
</html>