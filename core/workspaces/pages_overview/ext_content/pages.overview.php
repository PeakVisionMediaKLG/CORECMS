<?php
session_start();
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/core.includes.php');

if($USER->AUTH_OK) {

include_once(ROOT."core/classes/class.page.php");

    $ASSETS_HEAD = array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js","sortable");
    include_once(ROOT.'core/includes/core.header.php');


        ROW::PRE(array('class'=>'g-0 p-0 m-0',"style"=>"height:100vh;"));
            COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1 p-3'));
                H::PRINT(array("class"=>"m-3","type"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['Pages - Overview']));
                HR::PRINT();
                $page_items = PAGE::ALL_PAGE_ITEMS($DB) ?? array();
                //print_r($page_items);
                
                TABLE::PRE();
                        THEAD::PRE();
                            TH::PRE(); echo $TXT['ID']; TH::POST();
                            TH::PRE(); echo $TXT['Internal name']; TH::POST();
                            TH::PRE(); echo $TXT['Author']; TH::POST();
                            TH::PRE(); /*echo $TXT['Limited access'];*/ TH::POST();
                            /*TH::PRE(); echo $TXT['Active']; TH::POST();*/
                            TH::PRE(); echo $TXT['Translations']; TH::POST();
                            TH::PRE(); /*echo $TXT['Edit'];*/ TH::POST();
                            /*TH::PRE(); echo $TXT['Delete']; TH::POST();*/
                            TH::PRE(); echo $TXT['Move']; TH::POST();
                        THEAD::POST();
                        TBODY::PRE(array("class"=>"js-sortable-table"),array("data-path"=>"core/actions/db.dataset.reorder.php"));
                        HIDDEN::PRINT(array("name"=>"table","value"=>"app_languages")); 
                for($i=0;$i<count($page_items);$i++)
                {
                    TR::PRE();
                    TD::PRE(); echo $page_items[$i]['id']; TD::POST();
                    TD::PRE(); echo $page_items[$i]['internal_name']; TD::POST();
                    TD::PRE(); echo $page_items[$i]['date']." ".$page_items[$i]['author']; TD::POST();
                    TD::PRE(); 
                        if($page_items[$i]['limited_access']==1)  echo BI::GET(array('icon'=>'pencil','size'=>'16'));
                    TD::POST();
                    TD::PRE();

                    $app_languages = $DB->RETRIEVE(
                        "app_languages",
                        array(),
                        array()
                    );

                    if($page_items[$i]['attached_pages'])
                    {   
                        $y_ext=0;
                        for($y=0;$y<count($page_items[$i]['attached_pages']);$y++)
                        {
                            BTN::PRE(array(
                                "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                ),
                                    array(
                                        'data-path'=>'core/modals/modal.db.dataset.edit/modal.php',
                                        'data-table'=>'app_page_data',
                                        'data-id'=>$y,      
                                    ));
                                echo $page_items[$i]['attached_pages'][$y]['app_language'];
                            BTN::POST();
                            $y_ext++; 
                        }
                    } 
                    //echo $y_ext."ddddddd".count($app_languages);
                    if($y_ext <= count($app_languages) or !$page_items[$i]['attached_pages'])
                    {
                        BTN::PRE(array(
                            "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                            ),
                                array(
                                    'data-path'=>'core/modals/modal.db.dataset.insert/modal.php',
                                    'data-table'=>'app_page_data',     
                                ));
                            echo $TXT['Create'];
                        BTN::POST();                           
                    }


                    TD::POST();
                        TD::PRE();
                            BTN::PRE(array(
                                "class"=>"btn btn-sm btn-outline-secondary core-modal-btn",
                                ),
                                    array(
                                        'data-path'=>'core/modals/modal.db.dataset.edit/modal.php',
                                        'data-table'=>'app_page_items',
                                        'data-id'=>$i,      
                                    ));
                                echo BI::GET(array('icon'=>'pencil','size'=>'16')); //$TXT['Edit'];
                            BTN::POST();  
                            BTN::PRE(array(
                                "class"=>"btn btn-sm btn-outline-secondary core-modal-btn"),
                                    array(
                                        'data-path'=>'core/modals/modal.db.dataset.delete/modal.php',
                                        'data-table'=>'app_page_items',
                                        'data-id'=>$i   
                                    )
                            );
                                echo BI::GET(array('icon'=>'trash','size'=>'16')); //$TXT['Delete'];
                            BTN::POST();  
                        TD::POST();
                        TD::PRE(array('class'=>'text-center '));
                            A::PRE(array("class"=>"js-sortable-handle"));
                            echo BI::GET(array('icon'=>'arrow-down-up','size'=>'20',"style"=>"position:relative;top:2px;"));
                            A::POST();
                        TD::POST();
                    TR::POST();
                }
                    TBODY::POST();
                TABLE::POST();

                HR::PRINT();
                
                BTN::PRE(array(
                    "class"=>"btn btn-sm btn-outline-secondary core-modal-btn"),
                        array(
                            'data-path'=>'core/modals/modal.db.dataset.insert/modal.php',
                            'data-table'=>'app_page_items'
                        )
                ); //$EXT_CORE_PATH."modal.new.page.php"
                    echo BI::GET(array('icon'=>'plus','size'=>'16','style'=>"position:relative;top:-2px;"))." ".$TXT['Create'];
                BTN::POST();  

            COLUMN::POST();
        ROW::POST();

        
        $ASSETS_BODY = array("core_sortable_js","bootstrap_js");  
        include_once(ROOT.'core/includes/core.footer.php'); 
    }
    
    ?>  