<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

header("Cache-Control: no-cache");

	if($DB->SESSIONDATA->GET_VAL('interface','show_toolbar')==1) $DB->SESSIONDATA->SET_VAL('interface','show_toolbar',0); 
    else $DB->SESSIONDATA->SET_VAL('interface','show_toolbar',1);
}
?>