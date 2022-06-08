<?php
namespace CORE;
require_once('../../../../root.directory.php');
include_once(ROOT.'core/includes/ext.header.php');

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['App - Assets'],'lang'=>'en','resources'=>array(),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 p-0 m-0'));
            COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1 p-3'));
                H::PRINT(array("class"=>"m-3","size"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['App - Assets']));
                HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add asset']." ".BI::GET(array('icon'=>'plus')),'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.assets.create.php"));BTN::POST();
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
                        TH::PRE(); echo $TXT['ID']; TH::POST();
                        TH::PRE(); echo $TXT['Name']; TH::POST();
                        TH::PRE(); echo $TXT['Source from file']; TH::POST();
                        TH::PRE(); echo $TXT['Source from database']; TH::POST();
                        TH::PRE(); echo $TXT['PHP Eval']; TH::POST();
                        TH::PRE(); echo $TXT['Active']; TH::POST();
                        TH::PRE(); TH::POST();
                        TH::PRE(); echo $TXT['Move']; TH::POST();
                    THEAD::POST();
                    }
                    TBODY::PRE(array("class"=>"js-sortable-table","data-path"=>$EXT_ARRAY['DOM_PATH']."core/actions/db.dataset.reorder.php"));
                    HIDDEN::PRINT(array("name"=>"table","value"=>"app_assets")); 
                    if ($asset_data and count($asset_data) > 0) 
                    {   
                        
                        $i=1;
                        foreach($asset_data as $key => $asset_row)
                        {
                            TR::PRE(array("class"=>"js-sortable-tr"));
                                TD::PRE(); echo $asset_row['id']; HIDDEN::PRINT(array("name"=>$i."_id","value"=>$asset_row['id'])); TD::POST();
                                TD::PRE(); echo $asset_row['name']; TD::POST();
                                TD::PRE(); echo htmlentities($asset_row['src_file']); TD::POST();
                                TD::PRE(); echo htmlentities($asset_row['src_db']); TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"id",
                                    "value"=>$asset_row['eval'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"id",
                                    "value"=>$asset_row['is_active'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();
                                TD::PRE(array("class"=>"text-nowrap"));
                                    TR_CONTROLS::PRE(array(
                                        'edit-modal'=>$EXT_ARRAY['DOM_PATH']."modals/modal.assets.edit.php",
                                        'backup-data'=>$backup_data,
                                        'txt'=>$TXT,
                                        'data-table'=>'app_assets',
                                        'data-id'=>$asset_row['id'],
                                    ));
                                    TR_CONTROLS::POST();
                                    /*
                                    BTN::PRE(array(
                                                "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                "title"=>$TXT['Edit'],
                                                'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.assets.edit.php",
                                                'data-table'=>'app_assets',
                                                'data-condition'=>$asset_row['id'], 
                                                'data-bs-toggle'=>'tooltip'     
                                            ));
                                        echo BI::GET(array('icon'=>'pencil'));
                                    BTN::POST();  

                                    BTN::PRE(array(
                                                "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                "title"=>$TXT['Delete'],
                                                'data-path'=>$EXT_ARRAY['DOM_PATH'].'core/modals/modal.db.dataset.delete/modal.php',
                                                'data-table'=>'app_assets',
                                                'data-id'=>$asset_row['id'],
                                                'data-bs-toggle'=>'tooltip'   
                                            )
                                    );
                                        echo BI::GET(array('icon'=>'trash3'));
                                    BTN::POST();  */

                                    $backup_data = $DB->RETRIEVE(
                                        'app_assets_archive',
                                        array('edited_by','edited_date'),
                                        array('unique_id'=>$asset_row['unique_id'],'edited_action'=>'update'),
                                        " ORDER BY edited_date DESC LIMIT 1"
                                        );
                                        //print_r($backup_data);
                                    if($backup_data)
                                    {
                                        BTN::PRE(array(
                                                    "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                    "title"=>$TXT['Restore previous version']."<br>".$TXT['Author: '].$backup_data[0]['edited_by']."<br>".$TXT['Last edit: '].date("F j, Y, g:i a",$backup_data[0]['edited_date']),
                                                    'data-path'=>$EXT_ARRAY['DOM_PATH'].'core/modals/modal.db.dataset.restore/modal.php',
                                                    'data-table'=>'app_assets',
                                                    'data-unique_id'=>$asset_row['unique_id'],
                                                    'data-bs-toggle'=>'tooltip',
                                                    'data-bs-html'=>'true'  
                                                )
                                        );
                                            echo BI::GET(array('icon'=>'arrow-clockwise'));
                                        BTN::POST();   
                                    }
                                    else
                                    {
                                        BTN::PRE(array(
                                                    "class"=>"btn btn-sm btn-outline-secondary",
                                                    "title"=>$TXT['Author: '].$asset_row['created_by']."<br>".$TXT['Date: '].date("F j, Y, g:i a",$asset_row['created_date']),
                                                    'data-bs-toggle'=>'tooltip',
                                                    'data-bs-html'=>'true', 
                                                )
                                        );
                                            echo BI::GET(array('icon'=>'info-circle'));
                                        BTN::POST();                                         
                                    }
                                TD::POST();
                                TD::PRE(array('class'=>'text-center '));
                                    A::PRE(array("class"=>"js-sortable-handle btn btn-sm btn-outline-primary"));
                                    echo BI::GET(array('icon'=>'arrow-down-up','size'=>'20',"style"=>"position:relative;top:2px;"));
                                    A::POST();
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