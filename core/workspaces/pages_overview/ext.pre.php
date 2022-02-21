<?php
LI::PRE();
    A::PRE(array(
        "class"=>"link-dark rounded core-add-action-btn",
        "href"=>$this->DOM_PATH['pages_overview']."ext_content/pages.overview.php",
        "target"=>"core-main-panel",
        "caption"=>$TXT['Overview']
    ),
    array(
        'data-path'=>'core/actions/session.set.value.php',
        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
        'data-thevalue'=>$this->DOM_PATH['pages_overview']."ext_content/pages.overview.php"            
    ));
?>