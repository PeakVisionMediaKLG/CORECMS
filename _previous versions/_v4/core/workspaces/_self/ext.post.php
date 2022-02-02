<?php
UL::POST();
DIV::PRE(array("class"=>"dropdown","style"=>"margin-bottom:20px; "));
    HR::PRINT();
    A::PRE(array("href"=>"#","class"=>"d-flex align-items-center link-dark text-decoration-none dropdown-toggle","id"=>"core-user-dropdown"),array("data-bs-toggle"=>"dropdown","aria-expanded"=>"false"));
       IMG::PRINT(array("src"=>$EXT_ROOT."img/img_avatar_gender_diverse.png","style"=>"width:45px;height:45px; border-radius:50%; margin-right:10px;","alt"=>"user")); echo "<b>".substr($this->USER->USERNAME,0,8)."..."."</b>";
    A::POST();
    UL::PRE(array("class"=>"dropdown-menu text-small shadow"),array("aria-labelledby"=>"core-user-dropdown"));
        LI::PRE();
            A::PRE( array("href"=>"#","class"=>"dropdown-item core-action-btn"),
                    array('data-path'=>'core/actions/user.sign.out.php'));
                echo $TXT['Sign out'];
            A::POST();    
        LI::POST();
    UL::POST();
DIV::POST();
?>