<?php
/* CORECMS - https://github.com/PeakVisionMediaKLG/CORECMS */
require_once('../../../../root.directory.php');
require_once(ROOT.'core/includes/ext.header.php');
require_once(ROOT."core/classes/class.page.php");

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['Headless content'],'lang'=>'en_US','assets'=>array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js"),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 p-0 m-0 align-items-end'));
            COLUMN::PRE(array('class'=>'col-4 col-sm-3 offset-sm-1 p-1'));
                    A::PRE(array('class'=>'nav-link core-add-action-btn','href'=>'pages.overview.php'),array(
                        'data-path'=>'core/actions/session.set.value.php',
                        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
                        'data-thevalue'=>$EXT_DOMPATH."/ext_content/pages.overview.php"            
                    ));
                        echo $TXT['Back to pages overview'];
                    A::POST();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-8 col-sm-7 p-1'));
                H::PRINT(array("class"=>"mt-3","type"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['Headless content']." - ".$_GET['url']));
            COLUMN::POST();
        ROW::POST();    
        ROW::PRE(array('class'=>'g-0 p-0 m-0'));    
            COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1'));
                HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add headless content']." ".BI::GET(array('icon'=>'pencil-square','size'=>'16'))),array('data-path'=>$EXT_DOMPATH."modals/modal.headless_content.create.php"));BTN::POST();
            COLUMN::POST();
        ROW::POST();
/*    
        ROW::PRE(array('class'=>'mx-auto g-0 px-5 m-0'));
           
            COLUMN::PRE(array("class"=>"col-12"));
                FORM::PRE();
                STATIC_TABLE::PRE();

                    CORE\PAGE::PREPARE_PAGE_OBJECTS("",$DB);
                    $pageData = CORE\PAGE::$SORTED_PAGE_OBJECTS;
                    //print_r($pageData);

                    if ($pageData and count($pageData) > 0) 
                    {   
                    THEAD::PRE();
                        TH::PRE(); echo $TXT['Name']; TH::POST();
                        TH::PRE(); echo $TXT['ID']; TH::POST();
                        TH::PRE(); echo $TXT['Object type']; TH::POST();
                        TH::PRE(); echo $TXT['Localization']; TH::POST();
                        TH::PRE(); echo $TXT['Active']; TH::POST();
                    THEAD::POST();
                    }
                    TBODY::PRE();
                    HIDDEN::PRINT(array("name"=>"table","value"=>"app_page_objects")); 
                    if ($pageData and count($pageData) > 0) 
                    {   
                        $i=1;
                        foreach($pageData as $key => $pageRow)
                        {   
                            $indentationBrightness = (1-($pageRow['INDENTATION']-1)*0.05)*100;
                            $indentationColor = "background-color: hsl(0, 0%, ".$indentationBrightness."%)";

                        TR::PRE(array("class"=>"check-indentation",                    "style"=>$indentationColor));
                                TD::PRE(); 
                                    for($i=1;$i<$pageRow['INDENTATION'];$i++)
                                    { echo "&nbsp;&nbsp;&nbsp;&nbsp;"; } 
                                    echo $pageRow['name']; 
                                TD::POST();
                                TD::PRE(); echo $pageRow['id']; 
                                    HIDDEN::PRINT(array("name"=>$i."_id","value"=>$pageRow['id'])); 
                                TD::POST();
                                TD::PRE(); echo $pageRow['object_type']; TD::POST();
                                TD::PRE();
                                    $appLanguages = $DB->RETRIEVE(
                                        'app_languages',
                                        array(),
                                        array(),
                                        " ORDER BY id ASC"
                                     );
                                    //print_r($appLanguages);
                                    DIV::PRE(array("class"=>"btn-group", "role"=>"group")); 
                                    foreach($appLanguages as $key => $languageValues)
                                    {
                                        $localizedPage  = $DB->RETRIEVE(
                                            'app_pages',
                                            array(),
                                            array("shared_identifier"=>$pageRow['shared_identifier'],"language"=>$languageValues['code_2digit']),
                                            " ORDER BY id ASC LIMIT 1"
                                         );
                                         if($localizedPage)
                                         {
                                            $localizedPage=$localizedPage[0];
                                            //print_r($localizedPage);
                                            BTN_DROPDOWN::PRE(array("class"=>"btn btn-sm btn-secondary",
                                                "id"=>$languageValues['code_2digit']."_dropdown",
                                                "caption"=>strtoupper($languageValues['code_2digit'])
                                            ));
                                                LI::PRE();
                                                    A::PRE(array("class"=>"dropdown-item core-modal-btn","href"=>"#"),array('data-path'=>$EXT_DOMPATH."modals/modal.page.edit.php",'data-table'=>'app_pages',
                                                    'data-condition'=>$localizedPage['id']));
                                                        echo $TXT['Edit page'];
                                                    A::POST();
                                                LI::POST();
                                                LI::PRE();
                                                    A::PRE(array("class"=>"dropdown-item"));
                                                        echo $TXT['Edit content'];
                                                    A::POST();
                                                LI::POST();
                                                LI::PRE();
                                                    A::PRE(array(
                                                        "class"=>"dropdown-item core-modal-btn",
                                                            ),
                                                            array(
                                                                'data-path'=>'core/modals/modal.db.dataset.delete/modal.php',
                                                                'data-table'=>'app_pages',
                                                                'data-id'=>$localizedPage['id'],
                                                               )
                                                    );
                                                        echo $TXT['Delete page'];
                                                    A::POST();
                                                LI::POST();  
                                                LI::PRE();
                                                    HR::PRINT(array("class"=>"dropdown-divider"));
                                                LI::POST();
                                                LI::PRE();
                                                    A::PRE(array("class"=>"dropdown-item","href"=>"show.php?url=".$localizedPage['url'],"target"=>"_blank"),array('data-path'=>$EXT_DOMPATH."modals/modal.page_object.create.php"));
                                                        echo $TXT['View page'];
                                                    A::POST();
                                                LI::POST(); 
                                            BTN_DROPDOWN::POST();
                                         }
                                         else 
                                         {
                                            $excludedLanguages = json_decode($pageRow['excluded_languages']) ?? array();
                                            if(!in_array($languageValues['code_2digit'],$excludedLanguages))
                                            {
                                                BTN::PRE(array("class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                    "id"=>$languageValues['code_2digit']."_dropdown",
                                                    "caption"=>strtoupper($languageValues['code_2digit']).BI::GET(array('icon'=>'plus','size'=>'16'))
                                                ),
                                                array('data-path'=>$EXT_DOMPATH."modals/modal.page.create.php","data-language"=>$languageValues['code_2digit'],"data-shared_identifier"=>$pageRow['shared_identifier']));
                                                BTN::POST();
                                            }                                            
                                         }    
                                    }
                                    DIV::POST();
                                TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"id",
                                    "value"=>$pageRow['is_active'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();
                                TD::PRE();
                                    BTN::PRE(array(
                                        "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                        ),
                                            array(
                                                'data-path'=>$EXT_DOMPATH."modals/modal.page_object.edit.php",
                                                'data-table'=>'app_page_objects',
                                                'data-condition'=>$pageRow['id'],      
                                            ));
                                        echo $TXT['Edit'];
                                    BTN::POST();  

                                    BTN::PRE(array(
                                        "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                            ),
                                            array(
                                                'data-path'=>'core/modals/modal.db.dataset.delete/modal.php',
                                                'data-table'=>'app_page_objects',
                                                'data-id'=>$pageRow['id'],
                                                'data-alternate-action'=>'page.object.delete.php' 
                                            )
                                    );
                                        echo $TXT['Delete'];
                                    BTN::POST();  
                                TD::POST();
                                TD::PRE();

                                $currentLevelItemsArray = $DB->RETRIEVE(
                                    'app_page_objects',
                                    array('id'),
                                    array('parent'=>$pageRow['parent']),
                                    " ORDER BY id ASC"
                                );
                                
                                if($currentLevelItemsArray) $currentLevelItems=count($currentLevelItemsArray); else $currentLevelItems=0;
                                if($currentLevelItems>1)
                                {
                                    DIV::PRE(array("class"=>"btn-group", "role"=>"group"));
                                        if($pageRow['id']!=$currentLevelItemsArray[0]['id'])
                                        {
                                            BTN::PRE(array(
                                                "class"=>"btn btn-sm btn-outline-secondary core-action-btn"
                                                    ),
                                                    array(
                                                        'data-path'=>'core/actions/db.dataset.move.php',
                                                        'data-table'=>'app_page_objects',
                                                        'data-direction'=>'up',
                                                        'data-id'=>$pageRow['id'],
                                                        'data-selector'=>'parent',
                                                        'data-selection'=>$pageRow['parent'], 
                                                    )
                                            );
                                                echo BI::GET(array('icon'=>'chevron-up','size'=>'16'));
                                            BTN::POST();
                                        }
                                        if($pageRow['id']!=$currentLevelItemsArray[count($currentLevelItemsArray)-1]['id']) {
                                            BTN::PRE(array(
                                                "class"=>"btn btn-sm btn-outline-secondary core-action-btn"
                                                    ),
                                                    array(
                                                        'data-path'=>'core/actions/db.dataset.move.php',
                                                        'data-table'=>'app_page_objects',
                                                        'data-direction'=>'down',
                                                        'data-id'=>$pageRow['id'],
                                                        'data-selector'=>'parent',
                                                        'data-selection'=>$pageRow['parent'], 
                                                    )
                                            );
                                                echo BI::GET(array('icon'=>'chevron-down','size'=>'16'));
                                            BTN::POST();
                                        }
                                    DIV::POST();
                                }
                                TD::POST();
                            TR::POST();
                            $i++;
                        }
                        
                       
                    }    
                    TBODY::POST(); 
                TABLE::POST();FORM::POST();
            COLUMN::POST();
        ROW::POST();*/
    DOCUMENT::FOOTER(array("DB"=>$DB,"CORE"=>$CORE,"assets"=>array("bootstrap_js")));
?>    