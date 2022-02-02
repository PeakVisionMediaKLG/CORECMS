<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

	
	
include_once('../classes/class.page.php');
//include_once('../../core/classes/class.content.php');
$PAGE = new PAGE($DB,@$_POST['url']);	
//$content = new content($DB,$PAGE,$USER);

include_once('../classes/class.admin.php');
$ADMIN = new ADMIN($DB,$PAGE,$USER);	
	

header("Cache-Control: no-cache");
include_once("../classes/class.modal.php");	

$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');	


$get_user_data_sql="SELECT * FROM users";	
$get_user_data=$DB->MULTIROW($get_user_data_sql);

$modalcontent="<div class='container-fluid core-user-container'>


";	
$odd="bg-secondary";	
while ($user_data = $get_user_data->fetch_array())
	{ if($odd=="core-odd") $odd="core-even"; else $odd="core-odd"; if($user_data['uAdmin']==1) $admin = " checked"; else $admin="";
        if($user_data['uUID']==1) $primaryadmin=" disabled"; else  $primaryadmin="";
		$modalcontent.="
<div class='row $odd core-morespace'>
    <div class='col core-morespace'>
	".$TXT['user name']."<br>
    <input type='text' class='core-in-place-edit' data-sanitizetype='unique_text' data-table='users' data-object='uUser' data-condition='".$user_data['uUID']."' value='".$user_data['uUser']."'>
    </div>
    <div class='col core-morespace'>
	".$TXT['e-mail']."<br>   
    <input type='text' class='core-in-place-edit' data-sanitizetype='email' data-table='users' data-object='uEmail' data-condition='".$user_data['uUID']."' value='".$user_data['uEmail']."'>
    </div>
	<div class='col core-morespace' $primaryadmin>
    ".$TXT['admin']."<br>
	<input class='core-checkbox core-in-place-edit' data-sanitizetype='bool' data-table='users' data-object='uAdmin' data-condition='".$user_data['uUID']."' type='checkbox' $admin $primaryadmin>    

	</div>
    <div class='w-100'></div>
    
    <div class='col core-morespace'>
	".$TXT['usertitle']."<br>
    <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uUserTitle' data-condition='".$user_data['uUID']."' value='".$user_data['uUserTitle']."'>
    </div>
    <div class='col core-morespace'>
	".$TXT['first name']."<br>    
    <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uFirstName' data-condition='".$user_data['uUID']."' value='".$user_data['uFirstName']."'>
    </div>
    <div class='col core-morespace'>
	".$TXT['last name']."<br>   
    <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uLastName' data-condition='".$user_data['uUID']."'value='".$user_data['uLastName']."'>
    </div>
    <div class='w-100'></div>
    
	<div class='col core-morespace'>
    <br><button type='button' class='btn btn-dark core-action-notimeout-btn' data-action-path='core/actions/user.reset.password.php' data-uUID='".$user_data['uUID']."' value='reset'>".$TXT['reset password']."</button>
	
	</div>
	<div class='col core-morespace'>

	
	</div>
    <div class='col core-morespace'><br><button type='button' class='btn btn-primary core-action-btn' data-action-path='core/actions/user.delete.php' data-uUID='".$user_data['uUID']."'   $primaryadmin>".$TXT['delete user']."</button><br><br></div>
</div>";

	}
    
$modalcontent.="</div>";
$modalcontent.="<div class='row core-morespace'><div class='col core-morespace'><button type='button' class='btn btn-primary core-extend-btn' data-action-path='core/actions/user.new.php'  data-append-to='.core-user-container'>".$TXT['add user']."</button></div></div>";     
   

	
	
	
$modal= new MODAL("core-users", //modal id
							$TXT['users'], //modal title
							$modalcontent, //modal content
							$TXT['close'], //cancel caption
							"", //action caption$TXT['save changes']
							"", //action class
							"",//action path
							"",//data-attribute
							"",//form class	
							"");//modal body class 	
echo $modal->GET_MODAL();		
	

} 
else {echo "unauthorized access"; exit;}

?>