<?php

if($USER->USER_AUTH_OK and $USER->IS_ADMIN) {
    
    $systemdataset = $DB->PREP_QUERY("SELECT * FROM settings ORDER BY sUID ASC",
            'settings',
            array(),
            array(),
            0); //@$DB->SETTINGS['mysqlErrorReporting']
?>
<div class="row">
    <div class="col-md-8 m-auto core-admin-toolbar">
        <h2><?php echo $ADMIN->TXT['Installation status']; ?></h2><br>
        
        Check if all tables exist. If not, Link to Install page mit ?mode=override.<br>
        Settings -> see if all are there<br>
        Languages -> check if number of languages corresponds to languages in pages and content, fix when not<br>
        Users -> check if Admin is there<br>
        Pages -><br>
        Content -><br>
        ContentData ->check if data exists for inexistant content<br><br>
        
        
        <h2><?php echo $ADMIN->TXT['Basic system settings']; ?></h2><br>
<?php
    
    while ($thedata=$systemdataset->fetch_array()){
        if(is_numeric($thedata['sValue']) and strlen($thedata['sValue'])<2){
            if($thedata['sValue']==1){$checked="checked"; $val=1;} else {$checked=""; $val=0;}
                ?>
                    <div class="form-check">
                      <input class="core-checkbox form-check-input core-in-place-edit" type="checkbox" data-sanitizetype='bool' data-table='settings' data-object='sValue' data-condition='<?php echo $thedata['sUID']; ?>' value="<?php echo $val; ?>" id="<?php echo $thedata['sSettingName']; ?>" name="<?php echo $thedata['sSetting']; ?>" <?php echo $checked; ?>>
                          <label class="form-check-label" for="<?php echo $thedata['sSetting']; ?>">
                            <?php echo $thedata['sSettingName']; ?>
                          </label>

                    </div><br>
                <?php  
            
        }
        elseif(!is_numeric($thedata['sValue']))
        {   
            if(strlen($thedata['sValue'])>50) $rowcount=3; else $rowcount=1;
              ?>
                <div class="form-group">
                    <label for="<?php echo $thedata['sSettingName']; ?>"><?php echo $thedata['sSettingName']; ?></label>
                    <textarea class="form-control core-in-place-edit" data-sanitizetype='text' data-table='settings' data-object='sValue' data-condition='<?php echo $thedata['sUID']; ?>' value='<?php echo $thedata['sValue']; ?>'id="<?php echo $thedata['sSettingName']; ?>" rows="<?php echo $rowcount; ?>" name="<?php echo $thedata['sSetting']; ?>"><?php echo $thedata['sValue']; ?></textarea>
                </div>        
                <br>
              <?php  
        }
    }
}
?>  
    </div>
</div>        