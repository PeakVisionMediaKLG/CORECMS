<?php
namespace CORE;
require_once('../../../../root.directory.php');
require_once(ROOT.'core/includes/ext.header.php');
require_once(ROOT."core/classes/class.page.php");

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['Pages - Overview'],'lang'=>'en_US','resources'=>array(),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 p-0 m-0'));
            COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1 p-3'));
                H::PRINT(array("class"=>"m-3","size"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['Pages - Overview']));
                HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add page object']." ".BI::GET(array('icon'=>'plus','size'=>'16')),'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page_object.create.php"));BTN::POST();
                
                $delete_data = $DB->RETRIEVE(
                    'app_page_objects_archive',
                    array('edited_by','edited_date'),
                    array('edited_action'=>'delete'),
                    " ORDER BY edited_date DESC LIMIT 1"
                    );
                if($delete_data)
                {
                BTN::PRE(array('class'=>'btn btn-outline-secondary core-modal-btn','title'=>$TXT['Restore page object'],'caption'=>BI::GET(array('icon'=>'arrow-counterclockwise')),'data-path'=>$CORE->DOM_PATH."core/modals/modal.db.dataset.undelete/modal.php",
                'data-table'=>'app_page_objects'
                ));BTN::POST();
                }
            COLUMN::POST();
        ROW::POST();
    
        ROW::PRE(array('class'=>'mx-auto g-0 px-5 m-0'));
           
            COLUMN::PRE(array("class"=>"col-12"));
                FORM::PRE();
                TABLE::PRE();

                    PAGE::PREPARE_PAGE_OBJECTS("",$DB);
                    $pageData = PAGE::$SORTED_PAGE_OBJECTS;
                    //print_r($pageData);

                    if ($pageData and count($pageData) > 0) 
                    {   
                    THEAD::PRE();
                        TH::PRE(); echo $TXT['Name']; TH::POST();
                        //TH::PRE(); echo $TXT['ID']; TH::POST();
                        TH::PRE(); echo $TXT['Object type']; TH::POST();
                        TH::PRE(); echo $TXT['Localization']; TH::POST();
                        TH::PRE(); echo $TXT['Active']; TH::POST();
                        TH::PRE();TH::POST();
                        TH::PRE(); echo $TXT['Move']; TH::POST();
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
                                    echo BI::GET(array('icon'=>'file-earmark','size'=>'16'))." <b>".$pageRow['name']."</b>"; 
                                TD::POST();
                                //TD::PRE(); echo $pageRow['id']; 
                                    HIDDEN::PRINT(array("name"=>$i."_id","value"=>$pageRow['id'])); 
                                //TD::POST();
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
                                            array("shared_id"=>$pageRow['unique_id'],"language"=>$languageValues['code_2digit']),
                                            " ORDER BY id ASC LIMIT 1"
                                         );

                                         if($localizedPage)
                                         {
                                            $localizedPage=$localizedPage[0];
                                            //print_r($localizedPage);
                                            BTN_DROPDOWN::PRE(array(
                                                "outer_class"=>"btn-group",
                                                "class"=>"btn btn-sm btn-secondary",
                                                "id"=>$languageValues['code_2digit']."_dropdown",
                                                "caption"=>strtoupper($languageValues['code_2digit'])
                                            ));

                                                $page_backup_data = $DB->RETRIEVE(
                                                    'app_pages_archive',
                                                    array('edited_by','edited_date'),
                                                    array('unique_id'=>$localizedPage['unique_id'],'edited_action'=>'update'),
                                                    " ORDER BY edited_date DESC LIMIT 1"
                                                );
                                                if($page_backup_data)
			                                    {
                                                    A::PRE(array(
                                                        "class"=>"dropdown-item core-modal-btn",
                                                        "title"=>$TXT['Restore previous version']."<br>".$TXT['Author: '].$page_backup_data[0]['edited_by']."<br>".$TXT['Last edit: '].date("F j, Y, g:i a",$page_backup_data[0]['edited_date']),
                                                        'data-path'=>$CORE->DOM_PATH."core/modals/modal.db.dataset.restore/modal.php",
                                                        'data-table'=>'app_pages',
                                                        'data-unique_id'=>$localizedPage['unique_id'],
                                                        'data-bs-toggle'=>'tooltip',
                                                        'data-bs-html'=>'true'  
                                                            )
                                                    );
                                                        echo BI::GET(array('icon'=>'arrow-counterclockwise'));
                                                    A::POST();
                                                }
                                                else 
                                                {
                                                    A::PRE(array(
                                                        "class"=>"dropdown-item",
                                                        "title"=>$TXT['Author: '].$localizedPage['created_by']."<br>".$TXT['Date: '].date("F j, Y, g:i a",(int)$localizedPage['created_date']),
                                                        'data-bs-toggle'=>'tooltip',
                                                        'data-bs-html'=>'true', 
                                                            )
                                                    );
                                                        echo BI::GET(array('icon'=>'info-circle'));
                                                    A::POST(); 
                                                }    
                                                LI::PRE();
                                                    A::PRE(array("class"=>"dropdown-item core-modal-btn","href"=>"#",'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page.edit.php",'data-table'=>'app_pages',
                                                    'data-condition'=>$localizedPage['unique_id']));
                                                        echo $TXT['Edit page'];
                                                    A::POST();
                                                LI::POST();
                                                LI::PRE();
                                                    A::PRE(array(
                                                        "class"=>"dropdown-item core-modal-btn",
                                                                'data-path'=>'core/modals/modal.db.dataset.delete.backup/modal.php',
                                                                'data-table'=>'app_pages',
                                                                'data-unique_id'=>$localizedPage['unique_id'],
                                                            )
                                                    );
                                                        echo $TXT['Delete page'];
                                                    A::POST();
                                                LI::POST();
                                                LI::PRE();
                                                    HR::PRINT(array("class"=>"dropdown-divider"));
                                                LI::POST();
                                                LI::PRE();
                                                    A::PRE(array("class"=>"dropdown-item core-add-action-btn", "href"=>"pages.headless.content.php?url=".$localizedPage['url'],
                                                        'data-path'=>'core/actions/session.set.value.php',
                                                        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
                                                        'data-thevalue'=>$EXT_ARRAY['DOM_PATH']."ext_content/pages.headless.content.php?url=".$localizedPage['url']            
                                                    ));
                                                        echo $TXT['Headless content'];
                                                    A::POST();
                                                LI::POST();
                                                LI::PRE();
                                                    A::PRE(array("class"=>"dropdown-item core-add-action-btn", "href"=>"pages.headless.content.php?url=".$localizedPage['url'],
                                                        'data-path'=>'core/actions/session.set.value.php',
                                                        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
                                                        'data-thevalue'=>$EXT_ARRAY['DOM_PATH']."ext_content/pages.headless.content.php?url=".$localizedPage['url']            
                                                    ));
                                                        echo $TXT['Visual content'];
                                                    A::POST();
                                                LI::POST();
                                            BTN_DROPDOWN::POST();
                                         }
                                         else 
                                         {
                                            $excludedLanguages = json_decode($pageRow['excluded_languages']) ?? array();
                                            if(!in_array($languageValues['code_2digit'],$excludedLanguages))
                                            {
                                                $restorable_pages  = $DB->RETRIEVE(
                                                    'app_pages_archive',
                                                    array(),
                                                    array("shared_id"=>$pageRow['unique_id']),
                                                    " ORDER BY edited_date DESC"
                                                 );
                                                
                                                if($restorable_pages)
                                                {
                                                    BTN::PRE(array('class'=>'btn btn-outline-secondary core-modal-btn','title'=>$TXT['Restore page object'],'caption'=>strtoupper($languageValues['code_2digit']).BI::GET(array('icon'=>'arrow-counterclockwise')),'data-path'=>$CORE->DOM_PATH."core/modals/modal.db.dataset.undelete/modal.php",
                                                    'data-table'=>'app_pages'
                                                    ));
                                                    BTN::POST();
                                                }
                                                else 
                                                { 
                                                    BTN::PRE(array("class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                                        "id"=>$languageValues['code_2digit']."_dropdown",
                                                        "caption"=>strtoupper($languageValues['code_2digit']).BI::GET(array('icon'=>'plus','size'=>'16')),
                                                        'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page.create.php","data-language"=>$languageValues['code_2digit'],"data-unique_id"=>$pageRow['unique_id']));
                                                    BTN::POST();
                                                }
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

                                    $backup_data = $DB->RETRIEVE(
                                        'app_page_objects_archive',
                                        array('edited_by','edited_date'),
                                        array('unique_id'=>$pageRow['unique_id'],'edited_action'=>'update'),
                                        " ORDER BY edited_date DESC LIMIT 1"
                                    );

                                    TR_CONTROLS::PRE(array(
                                        'base-path'=>$CORE->GET_DOM_PATH(),
                                        'edit-modal'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page_object.edit.php",
                                        'dataset'=>$pageRow,
                                        'backup-data'=>$backup_data,
                                        'txt'=>$TXT,
                                        'data-table'=>'app_page_objects',
                                        'data-unique-id'=>$pageRow['unique_id']
                                    ));
                                    TR_CONTROLS::POST();

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
                                                "class"=>"btn btn-sm btn-outline-secondary core-action-btn",
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
                                                "class"=>"btn btn-sm btn-outline-secondary core-action-btn",
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
        ROW::POST();
    DOCUMENT::FOOTER(array("DB"=>$DB,"CORE"=>$CORE,"resources"=>array("bootstrap_js","core_tooltip")));
?>    