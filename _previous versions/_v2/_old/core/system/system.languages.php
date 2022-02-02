<?php

if($USER->USER_AUTH_OK and $USER->IS_ADMIN) {
    
    $systemlanguageset = $DB->PREP_QUERY("SELECT * FROM languages ORDER BY lUID ASC",
            'settings',
            array(),
            array(),
            0); //@$DB->SETTINGS['mysqlErrorReporting']
?>
<div class="row">
    <div class="col-md-8 m-auto core-admin-toolbar">
        <h2><?php echo $ADMIN->TXT['System languages']; ?></h2><br><?php echo $ADMIN->TXT['Pages will be symmetrically available in all languages listed here.']; ?><br>
        
<?php
   $odd="";
    while ($thelanguage=$systemlanguageset->fetch_array()){ 
        if($odd=="core-odd") $odd="core-even"; else $odd="core-odd";?>
            <div class="row mt-2 p-5 align-items-end <?php echo $odd; ?>">
                <div class="col">
                    <label for="core-language-<?php echo $thelanguage['lUID']; ?>"><?php echo $ADMIN->TXT['Language']." ".$thelanguage['lUID']; ?></label>
                    <input type="text" class="form-control core-in-place-edit" data-sanitizetype='text' data-table='languages' data-object='lLanguageName' data-condition='<?php echo $thelanguage['lUID']; ?>' value='<?php echo $thelanguage['lLanguageName']; ?>'id="core-language-<?php echo $thelanguage['lUID']; ?>" name="core-language-<?php echo $thelanguage['lUID']; ?>">
                </div>
                <div class="col">
                    <label for="core-languagecode-<?php echo $thelanguage['lUID']; ?>"><?php echo $ADMIN->TXT['Language code']; ?></label>
                    <input type="text" class="form-control" data-sanitizetype='text' data-table='languages' data-object='lLanguageCode' data-condition='<?php echo $thelanguage['lUID']; ?>' value='<?php echo $thelanguage['lLanguageCode']; ?>'id="core-languagecode-<?php echo $thelanguage['lUID']; ?>" name="core-languagecode-<?php echo $thelanguage['lUID']; ?>" disabled>
                </div>  
                <div class="col">
                    <label for="core-languagecaption-<?php echo $thelanguage['lUID']; ?>"><?php echo $ADMIN->TXT['Language caption']; ?></label>
                    <input type="text" class="form-control core-in-place-edit" data-sanitizetype='text' data-table='languages' data-object='lShortCaption' data-condition='<?php echo $thelanguage['lUID']; ?>' value='<?php echo $thelanguage['lShortCaption']; ?>'id="core-language-<?php echo $thelanguage['lUID']; ?>" name="core-language-<?php echo $thelanguage['lUID']; ?>">
                </div>
                <div class="col ">
                    <button type='button' class='btn btn-primary core-modal-btn' data-lUID='<?php echo $thelanguage['lUID']; ?>' data-lLanguageName="<?php echo $thelanguage['lLanguageName']; ?>" data-lLanguageCode="<?php echo $thelanguage['lLanguageCode']; ?>" data-action-path="core/modals/language.delete.modal.php"><?php echo $ADMIN->TXT['delete']; ?></button>
                </div>    
            </div>
    <?php } ?> 
    
        <div class="row mt-5">
            <div class="col"> <button type='button' class='btn btn-outline-primary core-action-btn' data-action-path='core/actions/language.add.php'><?php echo $ADMIN->TXT['add language']; ?></button></div><div class="col"></div><div class="col"></div><div class="col"></div>
        </div>    
    </div>
</div>    
<?php } ?>        