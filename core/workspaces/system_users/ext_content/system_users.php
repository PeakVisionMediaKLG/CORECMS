<?php
/* CORECMS - https://github.com/PeakVisionMediaKLG/CORECMS */
require_once('../../../../root.directory.php');
include_once(ROOT.'core/includes/ext.header.php');

$allUsersData = $DB->RETRIEVE(
                                'core_users',
                                array(),
                                array(),
                                " ORDER BY id ASC"
                             );

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['User management'],'lang'=>'en_US','assets'=>array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js"),"DB"=>$DB,"CORE"=>$CORE));
    ROW::PRE(array('class'=>'mx-auto w90 gx-3'));
        COLUMN::PRE(array('class'=>'text-center col-12 mt-5'));
            H::PRINT(array('heading'=>$TXT['User management'],'type'=>4));
        COLUMN::POST();

        if($USER->IS_ADMIN){
            COLUMN::PRE(array('class'=>'col-12 text-center my-4'));
                BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>$TXT['New user']." ".BI::GET(array('icon'=>'person-plus','size'=>'16'))),array('data-path'=>'core/modals/modal.user.new.php'));BTN::POST();
            COLUMN::POST();
        }
    ROW::POST();
    ROW::PRE(array('class'=>'mx-auto w90 g-3'));
        //var_dump($allUsersData);
        foreach ($allUsersData as $key => $userData)
        {   
            if($USER->ID == $userData['id'] or $USER->IS_ADMIN){

                switch($userData['gender'])
                {
                    case "female":
                        $avatar = "img/img_avatar_female.png";    
                    break;
                    case "male":
                        $avatar = "img/img_avatar_male.png";
                    break;
                    case "diverse":
                    default:
                        $avatar = "img/img_avatar_diverse.png";
                    break;
                }
                
                COLUMN::PRE(array('class'=>'col-xs-12 col-md-6 col-lg-4 col-xxl-3'));
                    CARD::PRE(array('class'=>'',
                                    'image'=>$CORE->CREATE_URL(ROOT."core/workspaces/widget_logout/".$avatar),
                                    'imageclass'=>'mt-3 mx-auto be-user-card-image w-50',
                                    ));
                        TABLE::PRE();
                            TR::PRE();TH::PRE(); echo $userData['username'];   echo '&nbsp;&nbsp;&nbsp;  # '.$userData['id'];  TH::POST();TR::POST();            
                            TR::PRE();TD::PRE(); echo $userData['first_name'];  TD::POST();TR::POST();
                            TR::PRE();TD::PRE(); echo $userData['last_name'];  TD::POST();TR::POST();
                            TR::PRE();TD::PRE(); A::PRE(array('href'=>'mailto:'.$userData['email'],'class'=>'be-user-card-link')); echo $userData['email']; A::POST(); ?>&nbsp;<?php TD::POST();TR::POST();
                            TR::PRE();TD::PRE(); CHECKBOX::PRINT(array('caption'=>$TXT['Active'].' ','inline'=>1,'value'=>$userData['is_active'],'disabled'=>'disabled')); TD::POST();TR::POST();                    
                            TR::PRE();TD::PRE(); echo $TXT['Preferred language'].': <b>'.$userData['preferred_language'].'</b>';  TD::POST();TR::POST();
                            TR::PRE();TD::PRE(); CHECKBOX::PRINT(array('caption'=>$TXT['Admin'].' ','inline'=>1,'value'=>$userData['is_admin'],'disabled'=>'disabled')); TD::POST();TR::POST();              
                            TR::PRE();TD::PRE(); echo $TXT['Created'].': <b>'.date("Y-m-d",intval($userData['date_created'])).'</b>';  TD::POST();TR::POST(); 

                            TR::PRE();
                                TD::PRE();
                                    ROW::PRE(array('class'=>'g-0')); 
                                        COLUMN::PRE(array('class'=>'col text-center'));
                                            if($USER->ID == $userData['id'] 
                                                or ($USER->IS_ADMIN and (!$userData['is_admin']))
                                            ){$editDisabled = "";} else {$editDisabled = "disabled";}

                                            BTN::PRE(array( 'class'=>'btn btn-outline-primary core-modal-btn',
                                                            'caption'=>BI::GET(array('icon'=>'pencil','size'=>'16')),
                                                            'disabled'=>$editDisabled),
                                                    array(  'data-path'=>'core/modals/modal.user.edit.php',
                                                            'data-condition'=>$userData['id'],
                                                            'data-bs-toggle'=>"tooltip", 
                                                            'data-bs-placement'=>"bottom", 
                                                            'title'=>$TXT['Edit']));
                                            BTN::POST();
                                        COLUMN::POST();
                                        COLUMN::PRE(array('class'=>'col text-center'));
                                            if($USER->ID == $userData['id'] 
                                                or ($USER->IS_ADMIN and (!$userData['is_admin']))
                                            ){$editDisabled = "";} else {$editDisabled = "disabled";}

                                            BTN::PRE(array( 'class'=>'btn btn-outline-primary core-modal-btn',
                                                            'caption'=>BI::GET(array('icon'=>'key','size'=>'16')),
                                                            'disabled'=>$editDisabled),
                                                    array(  'data-path'=>'core/modals/modal.user.password.php',
                                                            'data-condition'=>$userData['id'],
                                                            'data-bs-toggle'=>"tooltip", 
                                                            'data-bs-placement'=>"bottom", 
                                                            'title'=>$TXT['Reset password']));
                                            BTN::POST();
                                        COLUMN::POST();                                    
                                        COLUMN::PRE(array('class'=>'col text-center'));
                                            if(($USER->ID != $userData['id'] and $USER->IS_ADMIN)
                                                and count($allUsersData)>1 
                                                ){$deleteDisabled = "";}    
                                            else $deleteDisabled = "disabled";
                                            BTN::PRE(array( 'class'=>'btn btn-outline-primary core-modal-btn',
                                                            'caption'=>BI::GET(array('icon'=>'trash','size'=>'16')),
                                                            'disabled'=>$deleteDisabled),
                                                    array(  'data-path'=>'core/modals/modal.dataset.delete.php',
                                                            'data-table'=>'core_users',
                                                            'data-condition'=>'id',
                                                            'data-conditionvalue'=>$userData['id'],
                                                            'data-bs-toggle'=>"tooltip", 
                                                            'data-bs-placement'=>"bottom", 
                                                            'title'=>$TXT['Delete']));
                                            BTN::POST();
                                        COLUMN::POST();                                      
                                    ROW::POST();
                                TD::POST();
                            TR::POST();   

                        TABLE::POST();
                    CARD::POST();
                COLUMN::POST();
            }
        }
    ROW::POST();
DOCUMENT::FOOTER(array("DB"=>$DB,"CORE"=>$CORE,"assets"=>array("bootstrap_js")));
?>    




































<?php
/*
session_start();
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/core.includes.php');

if($USER->AUTH_OK and $USER->IS_ADMIN) {

    /*$result =   $this->DB->RETRIEVE(
                                        'core_users',
                                        array(),
                                        array('username'=>$user),
                                        " LIMIT 1"
                                    );
    
    $systemdataset = $DB->EASY_QUERY("SELECT * FROM settings ORDER BY id ASC",
            'settings',
            array(),
            array(),
            0); //@$DB->SETTINGS['mysqlErrorReporting']*//*
?>
<div class="row">
    <div class="col-md-8 m-auto core-admin-toolbar core-user-container">
        <h2><?php echo $$TXT['User management']; ?></h2><br>
<?php        
        $languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('core/classes/$TXT/'.$languagetoload.'.php');	


$get_user_data_sql="SELECT * FROM users";	
$get_user_data=$DB->MULTI_ROW($get_user_data_sql);

var_dump($get_user);

$odd="bg-secondary";	

$modalcontent="<div class='row'><div class='col'><button type='button' class='btn btn-primary core-extend-btn' data-action-path='core/actions/user.new.php'  data-append-to='.core-user-container'>".$$TXT['add user']."</button><br><br></div></div>";  
    
while ($user_data = $get_user_data->fetch_array())
	{ if($odd=="core-odd") $odd="core-even"; else $odd="core-odd"; if($user_data['uAdmin']==1) $admin = " checked"; else $admin="";
        if($user_data['uUID']==1) $primaryadmin=" disabled"; else  $primaryadmin="";
   
		$modalcontent.="
        <div class='row $odd'>
            <div class='col'>
            ".$$TXT['user name']."<br>
            <input type='text' class='core-in-place-edit' data-sanitizetype='unique_text' data-table='users' data-object='uUser' data-condition='".$user_data['uUID']."' value='".$user_data['uUser']."'>
            </div>
            <div class='col '>
            ".$$TXT['e-mail']."<br>   
            <input type='text' class='core-in-place-edit' data-sanitizetype='email' data-table='users' data-object='uEmail' data-condition='".$user_data['uUID']."' value='".$user_data['uEmail']."'>
            </div>
            <div class='col ' $primaryadmin>
            ".$$TXT['admin']."<br>
            <input class='core-checkbox core-in-place-edit' data-sanitizetype='bool' data-table='users' data-object='uAdmin' data-condition='".$user_data['uUID']."' type='checkbox' $admin $primaryadmin>    
            </div>
            <div class='w-100'></div>

            <div class='col '>
            ".$$TXT['usertitle']."<br>
            <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uUserTitle' data-condition='".$user_data['uUID']."' value='".$user_data['uUserTitle']."'>
            </div>
            <div class='col '>
            ".$$TXT['first name']."<br>    
            <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uFirstName' data-condition='".$user_data['uUID']."' value='".$user_data['uFirstName']."'>
            </div>
            <div class='col '>
            ".$$TXT['last name']."<br>   
            <input type='text' class='core-in-place-edit' data-sanitizetype='text' data-table='users' data-object='uLastName' data-condition='".$user_data['uUID']."'value='".$user_data['uLastName']."'>
            </div>
            <div class='w-100'></div>

            <div class='col '>
            <br><button type='button' class='btn btn-dark core-action-notimeout-btn' data-action-path='core/actions/user.reset.password.php' data-uUID='".$user_data['uUID']."' value='reset'>".$$TXT['reset password']."</button>

            </div>
            <div class='col '>
            </div>
            <div class='col '><br><button type='button' class='btn btn-primary core-action-btn' data-action-path='core/actions/user.delete.php' data-uUID='".$user_data['uUID']."'   $primaryadmin>".$$TXT['delete user']."</button><br><br>
            </div>
        </div><br>";

    }
    
echo $modalcontent;     
}*/
?>    

