<?php
LI::PRE();
    A::PRE(array(
        "class"=>"link-dark rounded core-add-action-btn",
        "href"=>$this->DOM_PATH['app_assets']."ext_content/app.assets.php",
        "target"=>"core-main-panel",
        "caption"=>$TXT['Assets']
    ),
    array(
        'data-path'=>'core/actions/session.set.value.php',
        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
        'data-thevalue'=>$this->DOM_PATH['app_assets']."ext_content/app.assets.php"            
    ));
?>