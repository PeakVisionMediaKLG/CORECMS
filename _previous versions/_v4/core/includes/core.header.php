<?php

require_once(ROOT.'core/includes/core.asset.loader.php'); 

$valid_language = $USER->PREFERRED_LANGUAGE ?? "en";

if(file_exists("../../_self/txt/".$valid_language.".json")) 
{       
        $txt_json_file = file_get_contents("../../_self/txt/".$valid_language.".json");
        $TXT = json_decode($txt_json_file, true);
}

?>
<!doctype html>
<html lang="<?php echo $USER->PREFERRED_LANGUAGE ?? "en"; ?>">
    <head>    
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php
            PRINT_ASSETS($ASSETS_HEAD,$DB);
            $CORE->JS_SESSION();

            if(file_exists("../../_self/ext_content/ext.headincludes.php")) 
            {       
                include_once("../../_self/ext_content/ext.headincludes.php");
            }
        ?>
    </head>