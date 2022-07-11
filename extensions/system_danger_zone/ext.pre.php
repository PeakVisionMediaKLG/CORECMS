<?php
namespace CORE;
LI::PRE();
    A::PRE(array(
            "class"=>"link-dark rounded core-add-action-btn",
            "href"=>$this->EXTENSIONS["system_danger_zone"]['DOM_PATH']."ext_content/default.php",
            "target"=>"core-main-panel",
            "caption"=>$TXT['Danger Zone'],
            'data-path'=>'core/actions/session.set.value.php',
            'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
            'data-thevalue'=>$this->EXTENSIONS["system_danger_zone"]['DOM_PATH']."ext_content/default.php"            
        )
    );
?>