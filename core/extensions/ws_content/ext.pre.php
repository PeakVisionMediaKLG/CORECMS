<?php
namespace CORE;

LI::PRE(array("class"=>"mb-1"));
    if(@$_SESSION[$EXT_CONFIG['view_state']]) 
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
        "data-bs-toggle"=>"collapse",
        "data-bs-target"=>"#".$EXT_CONFIG['name'],
        "aria-expanded"=>$ariaExpanded,
        'data-path'=>'core/actions/session.toggle.value.php',
        'data-thekey'=>$EXT_CONFIG['view_state']
    ));
    echo BI::GET(array('style'=>'font-size: 16px;'),array('icon'=>$EXT_CONFIG['icon']))."&nbsp;".$TXT['Content'];
    BTN::POST();
    DIV::PRE(array("class"=>"collapse".$show,"id"=>$EXT_CONFIG['name']));
        UL::PRE(array("class"=>"btn-toggle-nav list-unstyled fw-normal pb-1 small"));
?>