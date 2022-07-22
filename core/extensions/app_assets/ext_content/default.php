<?php
namespace CORE;
require_once('../../../../root.directory.php');
include_once(ROOT.'core/includes/ext.header.php');

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['App - Assets'],'lang'=>'en','resources'=>array(),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 px-5 m-0'));
            COLUMN::PRE(array('class'=>'col-12 pt-3'));
                H::PRINT(array("class"=>"m-3","size"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['App - Assets']));
                HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4 text-nowrap'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add asset']." ".BI::GET(array('icon'=>'plus')),'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.assets.create.php"));BTN::POST();

                $delete_data = $DB->RETRIEVE(
                    'app_assets_archive',
                    array('edited_by','edited_date'),
                    array('edited_action'=>'delete'),
                    " ORDER BY edited_date DESC LIMIT 1"
                    );
                if($delete_data)
                {
                    BTN::PRE(array('class'=>'btn btn-outline-secondary core-modal-btn','title'=>$TXT['Restore asset'],'caption'=>BI::GET(array('icon'=>'arrow-counterclockwise')),'data-path'=>$CORE->DOM_PATH."core/modals/modal.db.dataset.undelete/modal.php",
                    'data-table'=>'app_assets'
                    ));BTN::POST();
                }
            COLUMN::POST();
        ROW::POST();
        
        ROW::PRE(array('class'=>'mx-auto g-0 px-5 m-0'));
            COLUMN::PRE();
                $asset_data = $DB->RETRIEVE(
                    'app_assets',
                    array(),
                    array(),
                    " ORDER BY id ASC"
                    );
                FORM::PRE(array("class"=>'js-sortable-form'));
                TABLE::PRE();
                    if ($asset_data and count($asset_data) > 0) 
                    {   
                    THEAD::PRE();
                        TH::PRE(); echo $TXT['Name']; TH::POST();
                        TH::PRE(); echo $TXT['File']; TH::POST();
                        TH::PRE(); echo $TXT['Database']; TH::POST();
                        TH::PRE(); echo $TXT['Development']; TH::POST();
                        TH::PRE(); echo $TXT['Production']; TH::POST();
                        TH::PRE(); echo $TXT['Active']; TH::POST();
                        TH::PRE(); TH::POST();
                    THEAD::POST();
                    }
                    TBODY::PRE(array("class"=>"js-sortable-table even-odd","data-path"=>$CORE->GET_DOM_PATH()."core/actions/db.dataset.reorder.php"));
                    HIDDEN::PRINT(array("name"=>"table","value"=>"app_assets")); 
                    if ($asset_data and count($asset_data) > 0) 
                    {   
                        
                        $i=1;
                        foreach($asset_data as $key => $asset_row)
                        {
                            TR::PRE(array("class"=>"js-sortable-tr"));
                                HIDDEN::PRINT(array("name"=>$i."_id","value"=>$asset_row['id']));
                                TD::PRE(); echo $asset_row['name']; TD::POST();
                                TD::PRE(); echo CORE::SHORTEN(htmlentities($asset_row['src_file'])); TD::POST();
                                TD::PRE(); echo CORE::SHORTEN(htmlentities($asset_row['src_db'])); TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"use_in_dev",
                                    "value"=>$asset_row['use_in_dev'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"use_in_prod",
                                    "value"=>$asset_row['use_in_prod'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"is_active",
                                    "value"=>$asset_row['is_active'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();
                                TD::PRE(array("class"=>"text-nowrap"));

                                    $backup_data = $DB->RETRIEVE(
                                        'app_assets_archive',
                                        array('edited_by','edited_date'),
                                        array('unique_id'=>$asset_row['unique_id'],'edited_action'=>'update'),
                                        " ORDER BY edited_date DESC LIMIT 1"
                                        );

                                    TR_CONTROLS::PRE(array(
                                        'base-path'=>$CORE->GET_DOM_PATH(),
                                        'edit-modal'=>$EXT_ARRAY['DOM_PATH']."modals/modal.assets.edit.php",
                                        'dataset'=>$asset_row,
                                        'backup-data'=>$backup_data,
                                        'txt'=>$TXT,
                                        'data-table'=>'app_assets',
                                        'data-unique-id'=>$asset_row['unique_id'],
                                        'movable'=>1
                                    ));
                                    TR_CONTROLS::POST();
                                    
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