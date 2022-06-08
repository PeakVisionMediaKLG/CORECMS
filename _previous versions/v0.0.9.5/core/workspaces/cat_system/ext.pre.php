<?php
LI::PRE(array("class"=>"mb-1"));
    if(@$_SESSION[$extConfigArray['session-show-state']]) 
    {
        $ariaExpanded="true";
        $show=" show";
    }
    else 
    {
        $ariaExpanded="false";
        $show="";
    }
    BTN::PRE(
    array(
        "class"=>"btn btn-toggle rounded collapsed core-add-action-btn",
        "caption"=>$TXT['System']
    ),
    array(
        "data-bs-toggle"=>"collapse",
        "data-bs-target"=>"#".$extConfigArray['name'],
        "aria-expanded"=>$ariaExpanded,
        'data-path'=>'core/actions/session.toggle.value.php',
        'data-thekey'=>$extConfigArray['session-show-state']
    ));
    BTN::POST();
    DIV::PRE(array("class"=>"collapse".$show,"id"=>$extConfigArray['name']));
        UL::PRE(array("class"=>"btn-toggle-nav list-unstyled fw-normal pb-1 small"));
?>