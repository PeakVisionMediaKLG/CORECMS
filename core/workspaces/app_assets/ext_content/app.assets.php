<?php
session_start();
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/core.includes.php');

if($USER->AUTH_OK) {

    $ASSETS_HEAD = array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js","sortable");
    include_once(ROOT.'core/includes/core.header.php');

        ROW::PRE(array('class'=>'g-0 p-0 m-0 core-h100'));
            COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1 p-3'));
                H::PRINT(array("class"=>"m-3","type"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['App - Assets']));
                HR::PRINT();

/*
                $language_data = $DB->RETRIEVE(
                    'app_languages',
                    array(),
                    array(),
                    " ORDER BY id ASC"
                    );
                FORM::PRE(array("class"=>'js-sortable-form'));
                TABLE::PRE();
                    THEAD::PRE();
                        TH::PRE(); echo $TXT['ID']; TH::POST();
                        TH::PRE(); echo $TXT['Language']; TH::POST();
                        TH::PRE(); echo $TXT['Code']; TH::POST();
                        TH::PRE(); echo $TXT['Caption']; TH::POST();
                        TH::PRE(); echo $TXT['Short caption']; TH::POST();
                        TH::PRE(); echo $TXT['Active']; TH::POST();
                        TH::PRE(); echo $TXT['Edit']; TH::POST();
                        TH::PRE(); echo $TXT['Delete']; TH::POST();
                        TH::PRE(); echo $TXT['Move']; TH::POST();
                    THEAD::POST();
                    TBODY::PRE(array("class"=>"js-sortable-table"),array("data-path"=>"core/actions/db.dataset.reorder.php"));
                    HIDDEN::PRINT(array("name"=>"table","value"=>"app_languages")); 
                    if (count($language_data) > 0) 
                    {   
                        
                        $i=1;
                        foreach($language_data as $key => $language_row)
                        {
                            if($i==0) $disabled="disabled"; else $disabled="";
                            TR::PRE(array("class"=>"js-sortable-tr"));
                                TD::PRE(); echo $language_row['id']; HIDDEN::PRINT(array("name"=>$i."_id","value"=>$language_row['id'])); TD::POST();
                                TD::PRE(); echo $language_row['name']; TD::POST();
                                TD::PRE(); echo $language_row['code']; TD::POST();
                                TD::PRE(); echo $language_row['caption']; TD::POST();
                                TD::PRE(); echo $language_row['short_caption']; TD::POST();
                                TD::PRE(); CHECKBOX::PRINT(array(
                                    "class"=>"",
                                    "name"=>"id",
                                    "value"=>$language_row['active'],
                                    "disabled"=>"disabled"
                                ));
                                TD::POST();
                                TD::PRE();
                                    BTN::PRE(array(
                                        "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                        ),
                                            array(
                                                'data-path'=>'core/modals/modal.db.dataset.edit/modal.php',
                                                'data-table'=>'app_languages',
                                                'data-id'=>$language_row['id'],      
                                            ));
                                        echo $TXT['Edit'];
                                    BTN::POST();  
                                TD::POST();
                                TD::PRE();
                                    BTN::PRE(array(
                                        "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                        "disabled"=>$disabled),
                                            array(
                                                'data-path'=>'core/modals/modal.db.dataset.delete/modal.php',
                                                'data-table'=>'app_languages',
                                                'data-id'=>$language_row['id']   
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
                BTN::PRE(array(
                    "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                    ),
                        array(
                            'data-path'=>'core/modals/modal.db.dataset.insert/modal.php',
                            'data-table'=>'app_languages',                                           
                        )
                );
                    echo $TXT['Add language'];
                BTN::POST();*/
            COLUMN::POST();
        ROW::POST();

    $ASSETS_BODY = array("core_sortable_js","bootstrap_js");  
    include_once(ROOT.'core/includes/core.footer.php'); 

}
?>    