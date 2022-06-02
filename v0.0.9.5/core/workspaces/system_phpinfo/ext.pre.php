<?php
LI::PRE();
    A::PRE(array(
            "class"=>"link-dark rounded core-add-action-btn",
            "href"=>$this->DOM_PATH['system_phpinfo']."ext_content/system_phpinfo.php",
            "target"=>"core-main-panel",
            "caption"=>$TXT['PHP Info']
        ),
        array(
            'data-path'=>'core/actions/session.set.value.php',
            'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
            'data-thevalue'=>$this->DOM_PATH['system_phpinfo']."ext_content/system_phpinfo.php"            
        )
    );
?>