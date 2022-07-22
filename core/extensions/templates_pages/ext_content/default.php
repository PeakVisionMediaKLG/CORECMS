<?php
namespace CORE;
require_once('../../../../root.directory.php');
require_once(ROOT.'core/includes/ext.header.php');
require_once(ROOT."core/classes/class.page.php");

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['Templates - Pages'],'lang'=>'en_US','resources'=>array(),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 px-5 m-0'));
            COLUMN::PRE(array('class'=>'col-12 pt-3'));
                H::PRINT(array("class"=>"m-3","size"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['Templates - Pages']));
                HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add page template']." ".BI::GET(array('icon'=>'plus','size'=>'16')),'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page_template.create.php"));BTN::POST();
                
                $delete_data = $DB->RETRIEVE(
                    'templates_pages_archive',
                    array('edited_by','edited_date'),
                    array('edited_action'=>'delete'),
                    " ORDER BY edited_date DESC LIMIT 1"
                    );
                if($delete_data)
                {
                BTN::PRE(array('class'=>'btn btn-outline-secondary core-modal-btn','title'=>$TXT['Restore page template'],'caption'=>BI::GET(array('icon'=>'arrow-counterclockwise')),'data-path'=>$CORE->DOM_PATH."core/modals/modal.db.dataset.undelete/modal.php",
                'data-table'=>'templates_pages'
                ));BTN::POST();
                }
            COLUMN::POST();
        ROW::POST();
    
        ROW::PRE(array('class'=>'mx-auto g-0 px-5 m-0'));
            COLUMN::PRE();
                $template_data = $DB->RETRIEVE(
                    'templates_pages',
                    array(),
                    array(),
                    " ORDER BY id ASC"
                    );
                FORM::PRE(array("class"=>'js-sortable-form'));
                TABLE::PRE();
                    if ($template_data and count($template_data) > 0) 
                    {   
                    THEAD::PRE();
                        TH::PRE(); echo $TXT['Name']; TH::POST();
                        TH::PRE(); echo $TXT['In use']; TH::POST();
                        TH::PRE(); TH::POST();
                    THEAD::POST();
                    }
                    TBODY::PRE(array("class"=>"js-sortable-table even-odd","data-path"=>$CORE->GET_DOM_PATH()."core/actions/db.dataset.reorder.php"));
                    HIDDEN::PRINT(array("name"=>"table","value"=>"templates_pages")); 
                    if ($template_data and count($template_data) > 0) 
                    {   
                        
                        $i=1;
                        foreach($template_data as $key => $template_row)
                        {
                            TR::PRE(array("class"=>"js-sortable-tr"));
                                HIDDEN::PRINT(array("name"=>$i."_id","value"=>$template_row['id']));
                                TD::PRE(); echo $template_row['name']; TD::POST();
                                TD::PRE(); 
                                    $in_use_pages = $DB->RETRIEVE(
                                        'app_pages',
                                        array(),
                                        array("uses_template"=>$template_row['unique_id'])
                                    );
                                    
                                    if($in_use_pages)
                                    {
                                        $in_use=1; $num_uses=count($in_use_pages);
                                    } 
                                    else 
                                    {
                                        $in_use=0; $num_uses=0;
                                    }

                                    CHECKBOX::PRINT(array(
                                        "class"=>"",
                                        "name"=>"in_use",
                                        "value"=>$in_use,
                                        "disabled"=>"disabled",
                                        "caption"=>"(".$num_uses.")"
                                    ));
                                TD::POST();
                                TD::PRE(array("class"=>"text-nowrap"));

                                    $backup_data = $DB->RETRIEVE(
                                        'templates_pages_archive',
                                        array('edited_by','edited_date'),
                                        array('unique_id'=>$template_row['unique_id'],'edited_action'=>'update'),
                                        " ORDER BY edited_date DESC LIMIT 1"
                                        );

                                    A::PRE(array(
                                        "class"=>"btn btn-sm btn-outline-secondary",
                                        "title"=>$TXT['View'],
                                        'href'=>$CORE->DOM_PATH."show.php?template=".$template_row['unique_id'],
                                        'data-bs-toggle'=>'tooltip',
                                        ));
                                        echo BI::GET(array('icon'=>'eye'));
                                    A::POST();    

                                    TR_CONTROLS::PRE(array(
                                        'base-path'=>$CORE->GET_DOM_PATH(),
                                        'edit-modal'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page_template.edit.php",
                                        "delete-disabled"=>$in_use,
                                        'dataset'=>$template_row,
                                        'backup-data'=>$backup_data,
                                        'txt'=>$TXT,
                                        'data-table'=>'templates_pages',
                                        'data-unique-id'=>$template_row['unique_id'],
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
        ROW::POST();    DOCUMENT::FOOTER(array("DB"=>$DB,"CORE"=>$CORE,"resources"=>array("bootstrap_js","core_tooltip")));
?>    