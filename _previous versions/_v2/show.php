<?php
session_start(); 
require_once('root.directory.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new DB();
$USER = new USER();
$USER->DB = $DB;
$USER->CHECK_SESSION_STATE();

if($USER->AUTH_OK) 
{ 
    require_once(ROOT.'core/classes/class.be.php');
    require_once(ROOT.'core/classes/class.txt.php');
    require_once(ROOT.'core/classes/class.component.php');
 
	$TXT = new TXT($DB,$USER->PREFERRED_LANGUAGE);
	define('TXT', $TXT->GET_VALUES());
	
	$BE = new BE();
    $BE->DB = $DB;
    $BE->GETBELANGUAGES();
	$BE->USER = $USER;
}

$BE_PAGE = $_GET['be_page'] ?? NULL;
?>

<!doctype html>
<html lang="<?php echo isset($PAGE->LANGUAGE) ? $PAGE->LANGUAGE: "en" ; ?>">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="required/bootstrap/css/bootstrap.min.css">
        <title><?php echo isset($PAGE->TITLE) ? $PAGE->TITLE: "empty" ;?></title>

        <?php 
            if($USER->AUTH_OK) { $BE->INCLUDES(); } 
        ?> 
    </head>

    <body class="core-body">
        
        <?php 
            if($USER->AUTH_OK) { ?>
                <div class="row w-100 g-0">
                <?php
                $BE->BACKEND();
                if($BE_PAGE) $BE->PAGE($BE_PAGE);
                ?>
                </div>
                <?php  
            } 
        ?>
        

    <script src="required/bootstrap/js/bootstrap.bundle.min.js"></script>
    <?php 
        if($USER->AUTH_OK) 
        {
            $BE->BODYINCLUDES();
        }
	?>
    </body>

</html>
<?php unset($_SESSION['CORE.ACTIONMESSAGE']); ?>

