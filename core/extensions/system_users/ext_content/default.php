<?php
namespace CORE;
require_once('../../../../root.directory.php');
include_once(ROOT.'core/includes/ext.header.php');

$allUsersData = $DB->RETRIEVE(
                                'core_users',
                                array(),
                                array(),
                                " ORDER BY id ASC"
                             );

DOCUMENT::HEADER(array('title'=>'CORE '.$TXT['User management'],'lang'=>'en_US','DB'=>$DB,'CORE'=>$CORE,'resources'=>array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js")));

    ROW::PRE(array('class'=>'g-0 p-0 m-0'));
        COLUMN::PRE(array('class'=>'col-12 col-sm-10 offset-sm-1 p-3'));
            H::PRINT(array("class"=>"m-3","size"=>4,"style"=>"margin-left:15px;","heading"=>$TXT['User management']));
            HR::PRINT(); 
        COLUMN::POST();
    ROW::POST();

        if($USER->IS_ADMIN){
            ROW::PRE(array('class'=>'g-0 p-0 m-0'));
                COLUMN::PRE(array('class'=>'col-12 text-center mb-4'));
                    BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.users.create.php"));
                        echo $TXT['New user']." ".BI::GET(array('icon'=>'person-plus'));
                    BTN::POST();
                COLUMN::POST();
            ROW::POST();
        }

    ROW::PRE(array('class'=>'mx-auto w90 g-3'));
        //var_dump($allUsersData);
        $odd=0;
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

                if($odd % 2) $oddColor='background-color:#e6f2ff;'; else $oddColor="";
                $odd++;

                COLUMN::PRE(array('class'=>'col-xs-12 col-md-6 col-lg-4 col-xxl-3'));
                    CARD::PRE(array('class'=>'',
                                    'image'=>$CORE->CREATE_URL(ROOT."core/extensions/_widget_logout/".$avatar),
                                    'imageclass'=>'mt-3 mx-auto be-user-card-image w-50',
                                    'style'=>$oddColor
                                    ));
                        TABLE::PRE();
                            TR::PRE();TH::PRE(); echo $userData['username'];   echo '&nbsp;&nbsp;&nbsp;  # '.$userData['id'];  TH::POST();TR::POST();            
                            TR::PRE();TD::PRE(); echo $userData['first_name'];  TD::POST();TR::POST();
                            TR::PRE();TD::PRE(); echo $userData['last_name'];  TD::POST();TR::POST();
                            TR::PRE();TD::PRE(); A::PRE(array('href'=>'mailto:'.$userData['email'],'class'=>'be-user-card-link')); echo $userData['email']; A::POST(); ?>&nbsp;<?php TD::POST();TR::POST();
                            TR::PRE();TD::PRE(); CHECKBOX::PRINT(array('caption'=>$TXT['Active'].' ','inline'=>1,'value'=>$userData['is_active'],'disabled'=>'disabled')); TD::POST();TR::POST();                    
                            TR::PRE();TD::PRE(); echo $TXT['Preferred language'].': <b>'.$userData['preferred_language'].'</b>';  TD::POST();TR::POST();
                            TR::PRE();TD::PRE(); CHECKBOX::PRINT(array('caption'=>$TXT['Admin'].' ','value'=>$userData['is_admin'],'disabled'=>'disabled')); TD::POST();TR::POST();              
                            TR::PRE();TD::PRE(); echo $TXT['Created'].': <b>'.date("Y-m-d",intval($userData['created_date'])).'</b>';  TD::POST();TR::POST(); 

                            TR::PRE();
                                TD::PRE();
                                    ROW::PRE(array('class'=>'g-0')); 
                                        COLUMN::PRE(array('class'=>'col text-center'));
                                            if($USER->ID == $userData['id'] 
                                                or ($USER->IS_ADMIN and (!$userData['is_admin']))
                                            ){$editDisabled = "";} else {$editDisabled = "disabled";}

                                            BTN::PRE(array( 'class'=>'btn btn-outline-primary core-modal-btn',
                                                            'caption'=>BI::GET(array('icon'=>'pencil')),
                                                            ''=>$editDisabled,
                                                            'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.users.edit.php",
                                                            'data-condition'=>$userData['id'],                                                            
                                                            'data-bs-toggle'=>"tooltip", 
                                                            'data-bs-placement'=>"bottom", 
                                                            'title'=>$TXT['Edit']));
                                            BTN::POST();
                                            
                                            if(($USER->ID != $userData['id'] and $USER->IS_ADMIN)
                                                and count($allUsersData)>1 
                                                ){$deleteDisabled = "";}    
                                            else $deleteDisabled = "disabled";
                                            BTN::PRE(array( 'class'=>'btn btn-outline-primary core-modal-btn',
                                                            'caption'=>BI::GET(array('icon'=>'trash')),
                                                            ''=>$deleteDisabled,
                                                            'data-path'=>$EXT_ARRAY['EXT_PATH'], //'core/modals/modal.dataset.delete.php',
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
DOCUMENT::FOOTER(array("DB"=>$DB,"CORE"=>$CORE,"resources"=>array("bootstrap_js","core_tooltip")));
?> 