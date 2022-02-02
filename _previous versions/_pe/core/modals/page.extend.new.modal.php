<?php // renegade cms beta 2
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

$languagetoload = $USER->GET_USERVAL("uLanguage") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');    
    
include_once('../classes/class.page.php');
$PAGE = new page($DB,@$_POST['url']);

include_once('../classes/class.admin.php');
$ADMIN = new ADMIN($DB,$PAGE,$USER);

header("Cache-Control: no-cache");

include_once("../classes/txt/".$USER->GET_USERVAL("uLanguage").".php");

$language = $_POST["data"][0];

        $createthepage_possible_parents="<div>".$TXT['select parent page']." <select name='core-page-set-parent' class='core-page-set-parent form-control'>
		<option rel=''></option>";
		 
		$ADMIN->TEMP_PARENTS = "";
        $ADMIN->POPULATE_PARENTSELECT("",0,$language,0);
    
        $createthepage_possible_parents.= $ADMIN->TEMP_PARENTS;

		$createthepage_possible_parents.="</select></div><hr><div class='form-group'>
				".$TXT['page title']."
				<input type='text' class='form-control' name='core-page-set-title' value=''>
				</div>
				<input type='hidden' name='pUID' value='".$_POST['data'][1]."'>";
		$createthepage_possible_parents = str_replace(array("\r", "\n"), '', $createthepage_possible_parents);
		echo $createthepage_possible_parents;
		
} else {echo "unauthorized access"; exit;}	

	
 
?>