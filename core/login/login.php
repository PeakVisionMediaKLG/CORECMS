<?php
namespace CORE;
session_start(); 
require_once('../../root.directory.php');
require_once(ROOT.'core/classes/traits.core.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new DB();
$USER = new USER();
$USER->DB = $DB;

require_once(ROOT.'core/classes/class.component.php');
require_once(ROOT.'core/classes/class.loader.php');
LOADER::EXT_CLASSES();

require_once(ROOT.'core/classes/class.core.php');
$CORE = new CORE(); 
$CORE->DB = $DB;
$CORE->USER = $USER; 

$TXT = json_decode(file_get_contents(ROOT.'core/login/txt/'.($USER->PREFERRED_LANGUAGE ?? 'en').'.json'),true);

$LOGIN_FORM_ACTION = $_POST['loginFormAction'] ?? '';
$INPUT_RESPONSE="";
$ERROR="";

if($LOGIN_FORM_ACTION==$TXT['Sign in'])
{
	//AUTH_ERROR_RESPONSE 2 => missing name or password, 1 => wrong name or password
    if($USER->AUTH_OK!=1) $USER_AUTH_OK=$USER->VERIFY_LOGIN_DATA($_POST['username'],$_POST['password']);
    if(@$USER->ERROR_RESPONSE==2) {$INPUT_RESPONSE.=$TXT['Please input both your user name and password.']; $ERROR="is-invalid";}
    if(@$USER->ERROR_RESPONSE==1) {$INPUT_RESPONSE.=$TXT['The provided login information is incorrect.']; $ERROR="is-invalid";}
}

if($LOGIN_FORM_ACTION==$TXT['Sign out'])
{
    $USER->SIGN_OUT();
}

if($LOGIN_FORM_ACTION=="") //no input provided, check if $_SESSION['session_identifier'] is set
{
	$USER->AUTHENTICATE();
}

	DOCUMENT::HEADER(array('title'=>'CORE - Log in','lang'=>'en_US','DB'=>$DB,'CORE'=>$CORE,'resources'=>array("bootstrap_css","bootstrap_icons","jquery")));
		
		CONTAINER::PRE(array('class'=>'container-fluid'));
			ROW::PRE(array('style'=>'height:95%;padding-top:10%'));
				COLUMN::PRE(array('class'=>'col-sm-10 col-md-8 col-lg-6 col-xl-4 col-xxl-3 mx-auto'));
					CARD::PRE(array('image'=>'img/login.svg','image-class'=>'w-50 mx-auto','title'=>$TXT['Sign in'],'title-class'=>'text-center'));

						if(!$USER->AUTH_OK){

							FORM::PRE(array('name'=>'loginform',
											'id'=>'loginform',
											'action'=>htmlentities($_SERVER['PHP_SELF']),
											'method'=>'POST')	
									);

								if ($USER->AUTH_OK) $userName = $USER->$USERNAME ?? $_POST['user'] ?? ""; else $userName = "";
								TEXTBOX::PRINT(	array(
													'type'=>'text',		
													'name'=>'username',
													'id'=>'input_user',
													'tabindex'=>'10',
													'autocomplete'=>'username',
													'value'=>$userName,
													''=>'required',
													'outer-class'=>"mt-5",
													'label'=>$TXT['Username'],
													'validity'=>$ERROR,
													'feedback'=>$INPUT_RESPONSE,
												)
											);

								TEXTBOX::PRINT(array(
													'type'=>'password',
													'name'=>'password',
													'id'=>'input_password',
													'tabindex'=>'20',
													'autocomplete'=>'current-password',
													'class'=>'mt-4',		
													'label'=>$TXT['Password'],
													''=>'required',
													'validity'=>$ERROR,
													'feedback'=>$INPUT_RESPONSE,
													)
											);

								SUBMIT::PRINT(array(
													'class'=>'btn-outline-primary submit-login mt-5 btn-block',
													'name'=>'loginFormAction',
													'id'=>'login-submit',
													'tabindex'=>'30',
													'value'=>$TXT['Sign in']	
													)
											);

							FORM::POST();
							
						}
						else
						{
							
							ROW::PRE(array());
								COLUMN::PRE(array('class'=>'col col-sm-6 text-end'));
									A::PRE(array('class'=>'btn btn-primary mt-5 btn-block','href'=>'../core.php','caption'=>$TXT['Continue']));
									A::POST();
								COLUMN::POST();
								COLUMN::PRE(array('class'=>'col col-sm-6'));
									FORM::PRE(array('name'=>'loginform',
													'class'=>'',
													'id'=>'loginform',
													'action'=>htmlentities($_SERVER['PHP_SELF']),
													'method'=>'POST'
													)
											 );
										SUBMIT::PRINT(array(
															'class'=>'btn-outline-primary submit-login mt-5 btn-block',
															'name'=>'loginFormAction',
															'id'=>'login-submit',
															'tabindex'=>'50',
															'value'=>$TXT['Sign out']	
															)
													  );
									FORM::POST();						
								COLUMN::POST();
							ROW::POST();
						}

					CARD::POST();
				COLUMN::POST();
			ROW::POST();
		CONTAINER::POST();
		
	DOCUMENT::FOOTER(array('DB'=>$DB,"CORE"=>$CORE,"resources"=>array("bootstrap_js")));
?>