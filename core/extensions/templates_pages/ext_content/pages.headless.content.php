<?php
namespace CORE;
require_once('../../../../root.directory.php');
include_once(ROOT.'core/includes/ext.header.php');

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['Headless content'],'lang'=>'en','resources'=>array(),"DB"=>$DB,"CORE"=>$CORE));

        ROW::PRE(array('class'=>'g-0 px-5 m-0 align-items-end'));
            COLUMN::PRE(array('class'=>'col-4 col-sm-3 pt-3'));
                    A::PRE(array('class'=>'nav-link core-add-action-btn','href'=>'pages.overview.php'),array(
                        'data-path'=>'core/actions/session.set.value.php',
                        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
                        'data-thevalue'=>$EXT_ARRAY['DOM_PATH']."/ext_content/pages.overview.php"            
                    ));
                        echo $TXT['Back to pages overview'];
                    A::POST();
                    HR::PRINT();
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-8 col-sm-9 pt-3'));
                H::PRINT(array("class"=>"mt-3","size"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['Headless content']." - ".$TXT['Page'].": ".$_GET['url']));
                HR::PRINT();
            COLUMN::POST();
        ROW::POST();    
        ROW::PRE(array('class'=>'g-0 p-0 m-0'));    
            COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1'));
                
            COLUMN::POST();
            COLUMN::PRE(array('class'=>'col-12 text-center mb-4'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['Add headless content']." ".BI::GET(array('icon'=>'plus')),'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.headless_content.create.php"));BTN::POST();
            COLUMN::POST();
        ROW::POST();



    DOCUMENT::FOOTER(array("DB"=>$DB,"CORE"=>$CORE,"resources"=>array("bootstrap_js")));
?>    