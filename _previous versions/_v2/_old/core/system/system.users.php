<?php

if($USER->USER_AUTH_OK and $USER->IS_ADMIN) {
    
    $systemdataset = $DB->PREP_QUERY("SELECT * FROM settings ORDER BY sUID ASC",
            'settings',
            array(),
            array(),
            0); //@$DB->SETTINGS['mysqlErrorReporting']
?>
<div class="row">
    <div class="col-md-8 m-auto core-admin-toolbar core-user-container">
        <h2><?php echo $ADMIN->TXT['User management']; ?></h2><br>
<?php        
        $languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('core/classes/txt/'.$languagetoload.'.php');	


$get_user_data_sql="SELECT * FROM users";	
$get_user_data=$DB->MULTI_ROW($get_user_data_sql);

$odd="bg-secondary";	

$modalcontent="<div class='row'><div class='col'><button type='button' class='btn btn-primary core-extend-btn' data-action-path='core/actions/user.new.php'  data-append-to='.core-user-container'>".$TXT['add user']."</button><br><br></div></div>";  
    
while ($user_data = $get_user_data->fetch_array())
	{ if($odd=="core-odd") $odd="core-even"; else $odd="core-odd"; if($user_data['uAdmin']==1) $admin = " checked"; else $admin="";
        if($user_data['uUID']==1) $primaryadmin=" disabled"; else  $primaryadmin="";
   
		$modalcontent.="
        <div class='row $odd'>
            <div class='col'>
            ".$TXT['user name']."<br>
            <input type='text' class='core-in-place-edit' data-sanitizetype='unique_text' data-table='users' data-object='uUser' data-condition='".$user_data['uUID']."' value='".$user_data['uUser']."'>
            </div>
            <div class='col '>
            ".$TXT['e-mail']."<br>   
            <input type='text' class='core-in-place-edit' data-sanitizetype='email' data-table='users' data-object='uEmail' data-condition='".$user_data['uUID']."' value='".$user_data['uEmail']."'>
            </div>
            <div class='col ' $primaryadmin>
            ".$TXT['admin']."<br>
            <input class='core-checkbox core-in-place-edit' data-sanitizetype='bool' data-table='users' data-object='uAdmin' data-condition='".$user_data['uUID']."' type='checkbox' $admin $primaryadmin>    
            </div>
            <div class='w-100'></div>

            <div class='col '>
            ".$TXT['usertitle']."<br>
            <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uUserTitle' data-condition='".$user_data['uUID']."' value='".$user_data['uUserTitle']."'>
            </div>
            <div class='col '>
            ".$TXT['first name']."<br>    
            <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uFirstName' data-condition='".$user_data['uUID']."' value='".$user_data['uFirstName']."'>
            </div>
            <div class='col '>
            ".$TXT['last name']."<br>   
            <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uLastName' data-condition='".$user_data['uUID']."'value='".$user_data['uLastName']."'>
            </div>
            <div class='w-100'></div>

            <div class='col '>
            <br><button type='button' class='btn btn-dark core-action-notimeout-btn' data-action-path='core/actions/user.reset.password.php' data-uUID='".$user_data['uUID']."' value='reset'>".$TXT['reset password']."</button>

            </div>
            <div class='col '>
            </div>
            <div class='col '><br><button type='button' class='btn btn-primary core-action-btn' data-action-path='core/actions/user.delete.php' data-uUID='".$user_data['uUID']."'   $primaryadmin>".$TXT['delete user']."</button><br><br>
            </div>
        </div><br>";

            }
    
echo $modalcontent;     
?>        
        
    </div>
</div> 
<?php
} else {echo "unauthorized access"; exit;}
?>    