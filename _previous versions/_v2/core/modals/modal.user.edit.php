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

$getUser = $DB->EASY_QUERY( "SELECT", 
                                    'core_users',
                                    array('*'),
                                    array(),
                                    array('id'),
                                    array($data['condition']),
                                    "LIMIT 1");

while ($userRow=$getUser->fetch_array())
{
    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_users')).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition'])).                    
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>TXT['Username'],
                        'type'=>'text',
                        'name'=>'coredata_username',
                        'tabindex'=>'60',
                        'required'=>'required',
                        'value'=>$userRow['username'],
                        'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum','Unique'),
                        )
                    ).
                    /*TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>TXT['Password'],
                        'type'=>'password',
                        'name'=>'coredata_password',
                        'tabindex'=>'100',
                        'required'=>'required',
                        'value'=>$userRow['password'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).  */                  
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>TXT['First name'],
                        'type'=>'text',
                        'name'=>'coredata_first_name',
                        'tabindex'=>'100',
                        'required'=>'required',
                        'value'=>$userRow['first_name'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>TXT['Last name'],
                        'type'=>'text',
                        'name'=>'coredata_last_name',
                        'tabindex'=>'120',
                        'required'=>'required',
                        'value'=>$userRow['last_name'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'inline'=>1,
                        'class'=>'mt-2 has-validation',		
                        'label'=>TXT['E-mail'],
                        'type'=>'text',
                        'name'=>'coredata_email',
                        'tabindex'=>'140',
                        'required'=>'',
                        'value'=>$userRow['email'],
                        'liveValidation'=>array('eMail')
                        )
                    ).
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            TXT['Preferred language'].
                        COLUMN::POST_R().
                        COLUMN::PRE_R(array('class'=>'col')).
                            SELECT::PRINT_R(array(
                                'class'=>'has-validation',
                                'label'=>TXT['Preferred language'],
                                'name'=>'coredata_preferred_language',
                                'tabindex'=>'160',
                                'options'=>$BE->BELANGUAGES,
                                'selectedOption'=>$userRow['preferred_language']
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R(). 
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            TXT['Gender'].
                        COLUMN::POST_R().
                        COLUMN::PRE_R(array('class'=>'col')).
                            SELECT::PRINT_R(array(
                                'class'=>'has-validation',
                                'label'=>TXT['Gender'],
                                'name'=>'coredata_gender',
                                'id'=>'gender',
                                'tabindex'=>'180',							
                                'options'=>$BE->LOADVALUESET('genders',1),
                                'selectedOption'=>$userRow['gender']
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R();
                    if($BE->USER->IS_SYSTEMADMIN){
                        $modalcontent .=                    
                            ROW::PRE_R(array('class'=>'my-2')).
                                COLUMN::PRE_R(array('class'=>'col')).
                                    CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                                    'caption'=>TXT['Active'],
                                    'name'=>'coredata_is_active]',
                                    'value'=>$userRow['is_active'],
                                    'tabindex'=>'220',),
                                    array()).
                                COLUMN::POST_R().
                            ROW::POST_R().                     
                            HR::PRINT_R().
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2',
                                                    'caption'=>TXT['Admin'],
                                                    'name'=>'coredata_is_admin]',
                                                    'tabindex'=>'200',
                                                    'value'=>$userRow['is_admin']),
                                                    array()).
                            HR::PRINT_R().
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2',
                                                    'caption'=>TXT['System admin'],
                                                    'name'=>'coredata_is_systemadmin]',
                                                    'value'=>$userRow['is_systemadmin'],
                                                    'tabindex'=>'220',),
                                                    array());
                    }
}
$modal= new MODAL(array(
                        'id'=>"core-edit-user-".time(),
                        'title'=>TXT['Edit user'],
                        'content'=>$modalcontent,
						'contentSize'=>'',
						'staticModal'=>'',//'data-bs-backdrop="static"',
                        'cancelLabel'=>TXT['Cancel'],
                        'actionLabel'=>TXT['save'],
                        'actionPath'=>"core/actions/dataset.update.php",
                        'dataAttributes'=>'', //array()
                        'actionDisabled'=>'disabled', //'disabled'
                        ));

echo $modal->GET_MODAL();  
?>