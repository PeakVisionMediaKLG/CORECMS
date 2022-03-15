<?php
include_once("../includes/user.auth.php");
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

include_once(ROOT."core/classes/class.modal.php");

include_once(ROOT."core/classes/class.be.php");
$BE = new BE();
$BE->DB = $DB;
$BE->GETBELANGUAGES();
$BE->USER = $USER;
include_once(ROOT."core/classes/class.component.php");

//print_r($BE->BELANGUAGES);

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_users')).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition'])).                    
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>TXT['New password'],
                        'type'=>'password',
                        'name'=>'new_password',
                        'tabindex'=>'60',
                        'required'=>'required',
                        'value'=>'',
                        'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum','Unique'),
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>TXT['New password (repeated)'],
                        'type'=>'password',
                        'name'=>'new_password_repeated',
                        'tabindex'=>'120',
                        'required'=>'required',
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    );


$modal= new CORE\MODAL(array(
                        'id'=>"core-edit-password-".time(),
                        'title'=>TXT['Reset password'],
                        'content'=>$modalcontent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/user.update.password.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>