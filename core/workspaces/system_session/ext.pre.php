<?php
LI::PRE();
    A::PRE(array(
            "class"=>"link-dark rounded core-add-action-btn",
            "href"=>$this->DOM_PATH['system_session']."ext_content/system_session.php",
            "target"=>"core-main-panel",
            "caption"=>$TXT['Session Variables']
        ),
        array(
            'data-path'=>'core/actions/session.set.value.php',
            'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
            'data-thevalue'=>$this->DOM_PATH['system_session']."ext_content/system_session.php"            
        )
    );
?>