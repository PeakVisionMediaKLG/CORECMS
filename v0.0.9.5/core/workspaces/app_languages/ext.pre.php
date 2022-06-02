<?php
LI::PRE();
    A::PRE(array(
        "class"=>"link-dark rounded core-add-action-btn",
        "href"=>$this->DOM_PATH['app_languages']."ext_content/app.languages.php",
        "target"=>"core-main-panel",
        "caption"=>$TXT['Languages']
    ),
    array(
        'data-path'=>'core/actions/session.set.value.php',
        'data-thekey'=>'CORE.CURRENT_RIGHT_PANE',
        'data-thevalue'=>$this->DOM_PATH['app_languages']."ext_content/app.languages.php"            
    ));
?>