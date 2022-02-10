<?php
session_start(); 
require_once('../../root.directory.php');
require_once(ROOT.'core/classes/traits.core.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');
include_once(ROOT.'core/classes/class.core.php');
require_once(ROOT.'core/classes/class.component.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;

$CORE = new CORE\CORE(); 
$CORE->DB = $DB;
$CORE->USER = $USER; 

$TXT = json_decode(file_get_contents(ROOT.'core/login/txt/'.($USER->PREFERRED_LANGUAGE ?? 'en').'.json'),true);

/*$TXT = isset($TXT) ? array_merge($TXT,json_decode(file_get_contents('txt/'.($USER->PREFERRED_LANGUAGE ?? 'en').'.json'),true)) : json_decode(file_get_contents('txt/'.($USER->PREFERRED_LANGUAGE ?? 'en').'.json'),true);*/

$LOGIN_FORM_ACTION = $_POST['loginFormAction'] ?? '';
$INPUT_RESPONSE="";
$ERROR="";

if($LOGIN_FORM_ACTION==$TXT['Sign in'])
{
	//AUTH_ERROR_RESPONSE => 2 missing name or password, => 1 wrong name or password
    if($USER->AUTH_OK!=1) $USER_AUTH_OK=$USER->VERIFY_LOGIN_DATA($_POST['username'],$_POST['password']);
    if(@$USER->ERROR_RESPONSE==2) {$INPUT_RESPONSE.=$TXT['Please input both your user name and password.']; $ERROR="is-invalid";}
    if(@$USER->ERROR_RESPONSE==1) {$INPUT_RESPONSE.=$TXT['The provided login information is incorrect.']; $ERROR="is-invalid";}
}
//echo $INPUT_RESPONSE;
if($LOGIN_FORM_ACTION==$TXT['Sign out'])
{
    $USER->SIGN_OUT();
}

if($LOGIN_FORM_ACTION=="") //no input provided, check if $_SESSION['session_identifier'] is set
{
	$USER->CHECK_SESSION_STATE();
}
DOCUMENT::HEADER(array('title'=>'CORE - Log in','lang'=>'en_US','assets'=>array("bootstrap_css","bootstrap_icons","jquery"/*,"core_css","core_js"*/),"DB"=>$DB,"CORE"=>$CORE));
	//DOCUMENT::HEADER(array('title'=>"Log in - Core"));
		
		CONTAINER::PRE(array('class'=>'container-fluid'));
			ROW::PRE(array('style'=>'height:95%;padding-top:10%'));
				COLUMN::PRE(array('class'=>'col-sm-10 col-md-8 col-lg-6 col-xl-4 col-xxl-3 mx-auto'));
					CARD::PRE(array('image'=>'img/login.svg','imageclass'=>'w-50 mx-auto','title'=>$TXT['Sign in'],'titleclass'=>'text-center'));

						if(!$USER->AUTH_OK){

						FORM::PRE(array('name'=>'loginform',
										'class'=>'',
										'id'=>'loginform',
										'action'=>htmlentities($_SERVER['PHP_SELF']),
										'method'=>'POST')	
								 );

							if ($USER->AUTH_OK) $userName = $USER->$USERNAME ?? $_POST['user'] ?? ""; else $userName = "";
							TEXTBOX::PRINT(array(
												'inline'=>0,
												'class'=>'mt-5',				
												'label'=>$TXT['User name'],
												'type'=>'text',
												'name'=>'username',
												'autocomplete'=>'username',
												'id'=>'input_user',
												'tabindex'=>'10',
												'value'=>$userName,
												'required'=>'required',
												'invalid-feedback'=>$INPUT_RESPONSE,
												'validity'=>$ERROR
												)
										  );

							TEXTBOX::PRINT(array(
												'inline'=>0,
												'class'=>'mt-4',		
												'label'=>$TXT['Password'],
												'type'=>'password',
												'name'=>'password',
												'autocomplete'=>'current-password',
												'id'=>'input_password',
												'tabindex'=>'20',
												'required'=>'required',
												'invalid-feedback'=>$INPUT_RESPONSE,
												'validity'=>$ERROR
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
		
	DOCUMENT::FOOTER(array('DB'=>$DB,"CORE"=>$CORE,"assets"=>array("bootstrap_js")));
?>