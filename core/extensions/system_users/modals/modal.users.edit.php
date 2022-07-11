<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();

$CORE->BUILD_EXTENSIONS(1);

$userRow = $DB->RETRIEVE(
                'core_users',
                array(),
                array('id'=>$data['condition']),
                " LIMIT 1"
            )[0];
                                
$data['table'] = 'core_users';

$adminNum = $DB->EXEC_TBL("SELECT COUNT(*) FROM ",'core_users'," WHERE  is_admin=1");
$adminNum=$DB->MAP_RESULT($adminNum)[0]['COUNT(*)'];
if($adminNum<2) $lastAdmin="disabled"; else $lastAdmin="";


    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_users')).
                    HIDDEN::PRINT_R(array('name'=>'condition','value'=>'id')). 
                    HIDDEN::PRINT_R(array('name'=>'conditionvalue','value'=>$data['condition'])).                    
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Username'],
                        'type'=>'text',
                        'name'=>'core_data__username',
                        'tabindex'=>'10',
                        ''=>'required',
                        'value'=>$userRow['username'],
                        'autocomplete'=>'off',
                        'liveValidation'=>array('alphaNum','Unique'),
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Password'],
                        'type'=>'password',
                        'name'=>'core_data__ph__password',
                        'tabindex'=>'20',
                        'value'=>'',
                        'autocomplete'=>'new-password',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).                
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['First name'],
                        'type'=>'text',
                        'name'=>'core_data__first_name',
                        'tabindex'=>'30',
                        ''=>'required',
                        'value'=>$userRow['first_name'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Last name'],
                        'type'=>'text',
                        'name'=>'core_data__last_name',
                        'tabindex'=>'40',
                        ''=>'required',
                        'value'=>$userRow['last_name'],
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['E-mail'],
                        'type'=>'text',
                        'name'=>'core_data__email',
                        'tabindex'=>'50',
                        'value'=>$userRow['email'],
                        'liveValidation'=>array('eMail')
                        )
                    ).
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            $TXT['Preferred language'].
                        COLUMN::POST_R().
                        COLUMN::PRE_R(array('class'=>'col')).
                            SELECT::PRINT_R(array(
                                'class'=>'has-validation core-select',
                                'label'=>$TXT['Preferred language'],
                                'name'=>'core_data__preferred_language',
                                'tabindex'=>'60',
                                'options'=>$CORE->LOAD_LANGUAGES(),
                                'selected-option'=>$userRow['preferred_language']
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R(). 
                    ROW::PRE_R(array('class'=>'my-2')).
                        COLUMN::PRE_R(array('class'=>'col')).
                            $TXT['Gender'].
                        COLUMN::POST_R().
                        COLUMN::PRE_R(array('class'=>'col')).
                            SELECT::PRINT_R(array(
                                'class'=>'has-validation core-select',
                                'label'=>$TXT['Gender'],
                                'name'=>'core_data__gender',
                                'id'=>'gender',
                                'tabindex'=>'70',							
                                'options'=>$CORE->GET_VALUESET('system_users','genders'),
                                'selected-option'=>$userRow['gender']
                            )).
                        COLUMN::POST_R().
                    ROW::POST_R();
                    if($CORE->USER->IS_ADMIN){
                        $modalcontent .=
                            HR::PRINT_R().                    
                            ROW::PRE_R(array('class'=>'my-2')).
                                COLUMN::PRE_R(array('class'=>'col')).
                                    CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2 mb-2',
                                    'caption'=>$TXT['Active'],
                                    'name'=>'core_data__is_active]',
                                    'value'=>$userRow['is_active'],
                                    'tabindex'=>'80','disabled'=>$lastAdmin)).
                                COLUMN::POST_R().
                            ROW::POST_R().                     
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2',
                                                    'caption'=>$TXT['Admin'],
                                                    'name'=>'core_data__is_admin]',
                                                    'tabindex'=>'90',
                                                    'value'=>$userRow['is_admin'],
                                                    'disabled'=>$lastAdmin
                                                    ));
                            

                    }
$modal= new MODAL(array(
                        'id'=>"core-edit-user-".time(),
                        'title'=>$TXT['Edit user'],
                        'content'=>$modalcontent,
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.update.php",
                        'dataAttributes'=>array('data-table'=>$data['table'],'data-id'=>$data['condition']),
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>