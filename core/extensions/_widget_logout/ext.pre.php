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
    A::PRE(array("href"=>"#","class"=>"ms-3 d-flex align-items-center link-dark text-decoration-none dropdown-toggle","id"=>"core-user-dropdown","data-bs-toggle"=>"dropdown","aria-expanded"=>"false"));
       IMG::PRINT(array("src"=>$this->EXTENSIONS["_widget_logout"]['DOM_PATH'].$this->USER->GET_AVATAR(),"style"=>"width:45px;height:45px; border-radius:50%; margin-right:10px;","alt"=>"user")); echo "<b>".substr($this->USER->USERNAME,0,8)."..."."</b>";
    A::POST();
    UL::PRE(array("class"=>"dropdown-menu text-small shadow","aria-labelledby"=>"core-user-dropdown"));
        LI::PRE();
            A::PRE( array("href"=>"#","class"=>"dropdown-item core-action-btn",'data-path'=>'core/actions/user.sign.out.php'));
                echo $TXT['Sign out'];
            A::POST();    
?>