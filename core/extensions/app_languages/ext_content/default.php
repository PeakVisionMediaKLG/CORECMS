<?php
namespace CORE;
require_once('../../../../root.directory.php');
include_once(ROOT.'core/includes/ext.header.php');

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['App languages'],'lang'=>'en_US','resources'=>array(),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 px-5 m-0'));
            COLUMN::PRE(array('class'=>'col-12 pt-3'));
                H::PRINT(array("class"=>"m-3","size"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['App - Languages']));
                HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4  text-nowrap'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add language']." ".BI::GET(array('icon'=>'plus')),'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.languages.create.php"));BTN::POST();

                $delete_data = $DB->RETRIEVE(
                    'app_languages_archive',
                    array('edited_by','edited_date'),
                    array('edited_action'=>'delete'),
                    " ORDER BY edited_date DESC LIMIT 1"
                    );
                if($delete_data)
                {
                BTN::PRE(array('class'=>'btn btn-outline-secondary core-modal-btn','title'=>$TXT['Restore language'],'caption'=>BI::GET(array('icon'=>'arrow-counterclockwise')),'data-path'=>$CORE->DOM_PATH."core/modals/modal.dataset.restore.php"));BTN::POST();
                }
            COLUMN::POST();
        ROW::POST();
        
        ROW::PRE(array('class'=>'mx-auto g-0 px-5 m-0'));
            COLUMN::PRE();
                $language_data = $DB->RETRIEVE(
                    'app_languages',
                    array(),
                    array(),
                    " ORDER BY id ASC"
                    );
                FORM::PRE(array("class"=>'js-sortable-form'));
                TABLE::PRE();
                    if ($language_data and count($language_data) > 0) 
                    {   
                    THEAD::PRE();
                        TH::PRE(); echo $TXT['Language']; TH::POST();
                        TH::PRE(); echo $TXT['2-digit code']; TH::POST();
                        TH::PRE(); echo $TXT['5-digit code']; TH::POST();
                        TH::PRE(); echo $TXT['Short caption']; TH::POST();
                        TH::PRE(); echo $TXT['Long caption']; TH::POST();
                        TH::PRE(); echo $TXT['Active']; TH::POST();
                        TH::PRE(); TH::POST();
                    THEAD::POST();
                    }
                    TBODY::PRE(array("class"=>"js-sortable-table even-odd","data-path"=>$CORE->DOM_PATH."core/actions/db.dataset.reorder.php"));
                    HIDDEN::PRINT(array("name"=>"table","value"=>"app_languages")); 
                    if ($language_data and count($language_data) > 0) 
                    {   
                        
                        $i=1;
                        foreach($language_data as $key => $language_row)
                        {
                            TR::PRE(array("class"=>"js-sortable-tr"));
                                HIDDEN::PRINT(array("name"=>$i."_id","value"=>$language_row['id']));
                                TD::PRE(); echo $language_row['name']; TD::POST();
                                TD::PRE(); echo $language_row['code_2digit']; TD::POST();
                                TD::PRE(); echo $language_row['code_5digit']; TD::POST();
                                TD::PRE(); echo $language_row['short_caption']; TD::POST();
                                TD::PRE(); echo $language_row['long_caption']; TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"id",
                                    "value"=>$language_row['is_active'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();
                                TD::PRE(array("class"=>"text-nowrap"));

                                    $backup_data = $DB->RETRIEVE(
                                        'app_languages_archive',
                                        array('edited_by','edited_date'),
                                        array('unique_id'=>$language_row['unique_id'],'edited_action'=>'update'),
                                        " ORDER BY edited_date DESC LIMIT 1"
                                        );

                                    TR_CONTROLS::PRE(array(
                                        'base-path'=>$CORE->GET_DOM_PATH(),
                                        'edit-modal'=>$EXT_ARRAY['DOM_PATH']."modals/modal.languages.edit.php",
                                        'dataset'=>$language_row,
                                        'backup-data'=>$backup_data,
                                        'txt'=>$TXT,
                                        'data-table'=>'app_languages',
                                        'data-unique-id'=>$language_row['unique_id'],
                                        'movable'=>1
                                    ));
                                    TR_CONTROLS::POST();

                                   /* BTN::PRE(array(
                                                "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.languages.edit.php",
                                                'data-table'=>'app_languages',
                                                'data-condition'=>$language_row['id'],      
                                            ));
                                        echo $TXT['Edit'];
                                    BTN::POST();  
                                TD::POST();
                                TD::PRE();
                                    BTN::PRE(array(
                                                "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                'data-path'=>$CORE->DOM_PATH.'core/modals/modal.db.dataset.delete/modal.php',
                                                'data-table'=>'app_languages',
                                                'data-id'=>$language_row['id']   
                                            )
                                    );
                                        echo $TXT['Delete'];
                                    BTN::POST();  
                                TD::POST();
                                TD::PRE(array('class'=>'text-center '));
                                    A::PRE(array("class"=>"js-sortable-handle"));
                                    echo BI::GET(array('icon'=>'arrow-down-up',"style"=>"position:relative;top:2px;"));
                                    A::POST();*/
                                TD::POST();
                            TR::POST();
                            $i++;
                        }
                    }    
                    TBODY::POST(); 
                TABLE::POST();FORM::POST();
            COLUMN::POST();
        ROW::POST();

    DOCUMENT::FOOTER(array("DB"=>$DB,"CORE"=>$CORE,"resources"=>array()));
?>    