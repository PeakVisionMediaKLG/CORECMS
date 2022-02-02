<?php
LI::PRE(array("class"=>"nav-item"));
    A::PRE(array("href"=>"../show.php","class"=>"nav-link link-dark rounded","target"=>"core-main-panel"));
       echo BI::GET(array('icon'=>'eye','size'=>'20',"style"=>"position:relative;top:2px;"))."&nbsp;".$TXT['View'];
?>