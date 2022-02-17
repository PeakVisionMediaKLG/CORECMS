<?php
/* CORECMS - https://github.com/PeakVisionMediaKLG/CORECMS */
require_once('../../../../root.directory.php');
include_once(ROOT.'core/includes/ext.header.php');

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['App - Assets'],'lang'=>'en_US','assets'=>array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js","sortable"),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 p-0 m-0'));
            COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1 p-3'));
                H::PRINT(array("class"=>"m-3","type"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['App - Assets']));
                HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add asset']." ".BI::GET(array('icon'=>'plus','size'=>'16'))),array('data-path'=>$EXT_DOMPATH."modals/modal.assets.create.php"));BTN::POST();
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
                        TH::PRE(); echo $TXT['Edit']; TH::POST();
                        TH::PRE(); echo $TXT['Delete']; TH::POST();
                        TH::PRE(); echo $TXT['Move']; TH::POST();
                    THEAD::POST();
                    }
                    TBODY::PRE(array("class"=>"js-sortable-table"),array("data-path"=>"core/actions/db.dataset.reorder.php"));
                    HIDDEN::PRINT(array("name"=>"table","value"=>"app_assets")); 
                    if ($asset_data and count($asset_data) > 0) 
                    {   
                        
                        $i=1;
                        foreach($asset_data as $key => $asset_row)
                        {
                            TR::PRE(array("class"=>"js-sortable-tr"));
                                TD::PRE(); echo $asset_row['id']; HIDDEN::PRINT(array("name"=>$i."_id","value"=>$asset_row['id'])); TD::POST();
                                TD::PRE(); echo $asset_row['name']; TD::POST();
                                TD::PRE(); echo $asset_row['src_file']; TD::POST();
                                TD::PRE(); echo $asset_row['src_db']; TD::POST();
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
                                TD::PRE();
                                    BTN::PRE(array(
                                        "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                        ),
                                            array(
                                                'data-path'=>$EXT_DOMPATH."modals/modal.assets.edit.php",
                                                'data-table'=>'app_assets',
                                                'data-condition'=>$asset_row['id'],      
                                            ));
                                        echo $TXT['Edit'];
                                    BTN::POST();  
                                TD::POST();
                                TD::PRE();
                                    BTN::PRE(array(
                                        "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                            ),
                                            array(
                                                'data-path'=>'core/modals/modal.db.dataset.delete/modal.php',
                                                'data-table'=>'app_assets',
                                                'data-id'=>$asset_row['id']   
                                            )
                                    );
                                        echo $TXT['Delete'];
                                    BTN::POST();  
                                TD::POST();
                                TD::PRE(array('class'=>'text-center '));
                                    A::PRE(array("class"=>"js-sortable-handle"));
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

    DOCUMENT::FOOTER(array("DB"=>$DB,"CORE"=>$CORE,"assets"=>array("core_sortable_js","bootstrap_js")));
?>    