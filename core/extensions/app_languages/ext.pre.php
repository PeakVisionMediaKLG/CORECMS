<?php
namespace CORE;
LI::PRE();
    A::PRE(array(
        "class"=>"link-dark rounded core-add-action-btn",
        "href"=>$this->EXTENSIONS["app_languages"]['DOM_PATH']."ext_content/default.php",
        "target"=>"core-main-panel",
        "caption"=>$TXT['Languages'],
        'data-path'=>'core/actions/session.set.value.php',
        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
        'data-thevalue'=>$this->EXTENSIONS["app_languages"]['DOM_PATH']."ext_content/default.php"            
    ));
?>