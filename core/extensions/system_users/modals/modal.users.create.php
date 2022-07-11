<?php
namespace CORE;
require_once("../../../includes/modal.auth.php");
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

$languages = $CORE->GET_LANGUAGES();

$CORE->BUILD_EXTENSIONS(1);

$data['table'] = 'core_users';

    $modalcontent = HIDDEN::PRINT_R(array('name'=>'table','value'=>'core_users')).             
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['Username'],
                        'type'=>'text',
                        'name'=>'core_data__username',
                        'tabindex'=>'10',
                        ''=>'required',
                        'value'=>'',
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
                        ''=>'required',
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
                        'value'=>'',
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
                        'value'=>'',
                        'liveValidation'=>array('alphaNum')
                        )
                    ).
                    TEXTBOX::PRINT_R(array(
                        'class'=>'mt-2 has-validation',		
                        'label'=>$TXT['E-mail'],
                        'type'=>'text',
                        'name'=>'core_data__email',
                        'tabindex'=>'50',
                        'value'=>'',
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
                                'selected-option'=>''
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
                                'selectedOption'=>''
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
                                    'value'=>0,
                                    'tabindex'=>'80'),
                                    array()).
                                COLUMN::POST_R().
                            ROW::POST_R().                     
                            CHECKBOX::PRINT_R(array('class'=>'core-checkbox mt-2',
                                                    'caption'=>$TXT['Admin'],
                                                    'name'=>'core_data__is_admin]',
                                                    'tabindex'=>'90',
                                                    'value'=>0,
                                                   ),
                                                    array()).
                        HIDDEN::PRINT_R(array('name'=>'core_data__date_created','value'=>time()));
                            

                    }
$modal= new MODAL(array(
                        'id'=>"core-create-user-".time(),
                        'title'=>$TXT['Create user'],
                        'content'=>$modalcontent,
                        'cancelLabel'=>$TXT['Cancel'],
                        'actionLabel'=>$TXT['Save'],
                        'actionPath'=>"core/actions/db.dataset.insert.php",
                        'dataAttributes'=>array('data-table'=>$data['table']),
                        'actionDisabled'=>'disabled',
                        ));

echo $modal->GET_MODAL();  
?>