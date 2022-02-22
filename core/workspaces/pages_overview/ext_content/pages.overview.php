<?php
/* CORECMS - https://github.com/PeakVisionMediaKLG/CORECMS */
require_once('../../../../root.directory.php');
require_once(ROOT.'core/includes/ext.header.php');
require_once(ROOT."core/classes/class.page.php");

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['Pages - Overview'],'lang'=>'en_US','assets'=>array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js","sortable"),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 p-0 m-0'));
            COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1 p-3'));
                H::PRINT(array("class"=>"m-3","type"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['Pages - Overview']));
                HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add page object']." ".BI::GET(array('icon'=>'plus','size'=>'16'))),array('data-path'=>$EXT_DOMPATH."modals/modal.page_object.create.php"));BTN::POST();
            COLUMN::POST();
        ROW::POST();
    
        ROW::PRE(array('class'=>'mx-auto g-0 px-5 m-0'));
           
            COLUMN::PRE();
                FORM::PRE(array("class"=>'js-sortable-form'));
                TABLE::PRE();

                    CORE\PAGE::PREPARE_PAGE_OBJECTS("",$DB);
                    $pageData = CORE\PAGE::$SORTED_PAGE_OBJECTS;

                    if ($pageData and count($pageData) > 0) 
                    {   
                    THEAD::PRE();
                        TH::PRE(); echo $TXT['Internal name']; TH::POST();
                        TH::PRE(); echo $TXT['ID']; TH::POST();
                        TH::PRE(); echo $TXT['Object type']; TH::POST();
                        TH::PRE(); echo $TXT['Active']; TH::POST();
                        TH::PRE(); echo $TXT['Localization']; TH::POST();
                    THEAD::POST();
                    }
                    TBODY::PRE(array("class"=>"js-sortable-table"),array("data-path"=>"core/actions/db.dataset.reorder.php"));
                    HIDDEN::PRINT(array("name"=>"table","value"=>"app_assets")); 
                    if ($pageData and count($pageData) > 0) 
                    {   
                        $i=1;
                        foreach($pageData as $key => $pageRow)
                        {   
                            TR::PRE(array("class"=>"js-sortable-tr"));
                                TD::PRE(); 
                                    for($i=1;$i<$pageRow['INDENTATION'];$i++)
                                    { echo "&nbsp;&nbsp;&nbsp;&nbsp;"; } 
                                    echo $pageRow['internal_name']; 
                                TD::POST();
                                TD::PRE(); echo $pageRow['id']; 
                                    HIDDEN::PRINT(array("name"=>$i."_id","value"=>$pageRow['id'])); 
                                TD::POST();
                                TD::PRE(); echo $pageRow['object_type']; TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"id",
                                    "value"=>$pageRow['is_active'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();

                                TD::PRE();
                                    $appLanguages = $DB->RETRIEVE(
                                        'app_languages',
                                        array(),
                                        array(),
                                        " ORDER BY id ASC"
                                     );
                                     print_r($appLanguages);
                                    foreach($appLanguages as $key => $languageValues)
                                    {
                                        $localizedPage  = $DB->RETRIEVE(
                                            'app_pages',
                                            array(),
                                            array("shared_id"=>$pageRow['id']),
                                            " ORDER BY id ASC LIMIT 1"
                                         );
                                         if($localizedPage)
                                         {
                                            $localizedPage=$localizedPage[0];
                                            //print_r($localizedPage);
                                            DIV::PRE(array("class"=>"btn-group", "role"=>"group"));
                                                BTN::PRE(array("class"=>"btn btn-sm btn-outline-secondary","disabled"=>"disabled"));
                                                    echo strtoupper($languageValues['code_2digit']);
                                                BTN::POST();
                                                BTN::PRE(array(
                                                    "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                        ),
                                                        array(
                                                            'data-path'=>'core/modals/modal.db.dataset.delete/modal.php',
                                                            'data-table'=>'app_assets',
                                                            'data-id'=>$pageRow['id']   
                                                        )
                                                );
                                                    echo BI::GET(array('icon'=>'pen','size'=>'16'));
                                                BTN::POST();
                                                BTN::PRE(array(
                                                    "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                        ),
                                                        array(
                                                            'data-path'=>'core/modals/modal.db.dataset.delete/modal.php',
                                                            'data-table'=>'app_assets',
                                                            'data-id'=>$pageRow['id']   
                                                        )
                                                );
                                                    echo BI::GET(array('icon'=>'eye-fill','size'=>'16'));
                                                BTN::POST();           
                                            DIV::POST();
                                         }
                                         else 
                                         {
                                            
                                         }    
                                    }
                                TD::POST();

                                TD::PRE();
                                    BTN::PRE(array(
                                        "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                        ),
                                            array(
                                                'data-path'=>$EXT_DOMPATH."modals/modal.assets.edit.php",
                                                'data-table'=>'app_assets',
                                                'data-condition'=>$pageRow['id'],      
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
                                                'data-id'=>$pageRow['id']   
                                            )
                                    );
                                        echo $TXT['Delete'];
                                    BTN::POST();  
                                TD::POST();
                                /*TD::PRE(array('class'=>'text-center '));
                                    A::PRE(array("class"=>"js-sortable-handle"));
                                    echo BI::GET(array('icon'=>'arrow-down-up','size'=>'20',"style"=>"position:relative;top:2px;"));
                                    A::POST();
                                TD::POST();*/
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