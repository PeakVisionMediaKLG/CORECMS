<?php
LI::PRE();
    A::PRE(array(
        "class"=>"link-dark rounded core-add-action-btn",
        "href"=>$this->DOM_PATH['system_users']."ext_content/system_users.php",
        "target"=>"core-main-panel",
        "caption"=>$TXT['Users']
    ),
    array(
        'data-path'=>'core/actions/session.set.value.php',
        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
        'data-thevalue'=>$this->DOM_PATH['system_users']."ext_content/system_users.php"            
    )
);
?>