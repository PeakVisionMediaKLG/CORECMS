        <?php  
            if(file_exists("../../_self/ext_content/ext.bodyincludes.php")) 
            {       
                include_once("../../_self/ext_content/ext.bodyincludes.php");
            }

            PRINT_ASSETS($ASSETS_BODY,$DB);
        ?>
    </body>
</html>