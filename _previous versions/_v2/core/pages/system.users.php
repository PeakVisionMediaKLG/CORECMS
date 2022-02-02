<?php
if($this->USER->AUTH_OK) 
{
    $allUsersData = $this->DB->EASY_QUERY(  "SELECT", 
                                            "core_users",
                                            array('*'),
                                            array(),
                                            array(),
                                            array(),
                                            "ORDER BY id ASC"
                                            );	
} else die('Unauthorized Access');


ROW::PRE(array('class'=>'mx-auto w90 gx-3'));
    COLUMN::PRE(array('class'=>'text-center col-12'));
        H::PRINT(array('heading'=>TXT['User management'],'type'=>4));
    COLUMN::POST();

    if($this->USER->IS_ADMIN){
        COLUMN::PRE(array('class'=>'col-12 text-center my-4'));
            BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn','caption'=>TXT['New user']." ".BI::GET(array('icon'=>'person-plus','size'=>'16'))),array('data-path'=>'core/modals/modal.user.new.php'));BTN::POST();
        COLUMN::POST();
    }
ROW::POST();
ROW::PRE(array('class'=>'mx-auto w90 g-3'));
    while ($userData =  $allUsersData->fetch_array())
    {   
        if($this->USER->ID == $userData['id'] or $this->USER->IS_ADMIN or $this->USER->IS_SYSTEMADMIN){

            $userData['avatar'] = ($userData['avatar']=="") ? 'core/img/img_avatar_'.$userData['gender'].'.png' : $userData['avatar'];
            COLUMN::PRE(array('class'=>'col-xs-12 col-md-6 col-lg-4 col-xxl-3'));
                CARD::PRE(array('class'=>'',
                                'image'=>$userData['avatar'],
                                'imageclass'=>'mt-3 mx-auto be-user-card-image w-50',
                                ));
                    TABLE::PRE();
                        TR::PRE();TH::PRE(); echo $userData['username'];   echo '&nbsp;&nbsp;&nbsp;  # '.$userData['id'];  TH::POST();TR::POST();            
                        TR::PRE();TD::PRE(); echo $userData['first_name'];  TD::POST();TR::POST();
                        TR::PRE();TD::PRE(); echo $userData['last_name'];  TD::POST();TR::POST();
                        TR::PRE();TD::PRE(); A::PRE(array('href'=>'mailto:'.$userData['email'],'class'=>'be-user-card-link')); echo $userData['email']; A::POST(); ?>&nbsp;<?php TD::POST();TR::POST();
                        TR::PRE();TD::PRE(); CHECKBOX::PRINT(array('caption'=>TXT['Active'].' ','inline'=>1,'value'=>$userData['is_active'],'disabled'=>'disabled')); TD::POST();TR::POST();                    
                        TR::PRE();TD::PRE(); echo TXT['Preferred language'].': <b>'.$userData['preferred_language'].'</b>';  TD::POST();TR::POST();
                        TR::PRE();TD::PRE(); CHECKBOX::PRINT(array('caption'=>TXT['System admin'].' ','inline'=>1,'value'=>$userData['is_systemadmin'],'disabled'=>'disabled')); TD::POST();TR::POST();  
                        TR::PRE();TD::PRE(); CHECKBOX::PRINT(array('caption'=>TXT['Admin'].' ','inline'=>1,'value'=>$userData['is_admin'],'disabled'=>'disabled')); TD::POST();TR::POST();              
                        TR::PRE();TD::PRE(); echo TXT['Joined on'].': <b>'.date("Y-m-d",intval($userData['date_created'])).'</b>';  TD::POST();TR::POST(); 

                        TR::PRE();
                            TD::PRE();
                                ROW::PRE(); 
                                    COLUMN::PRE(array('class'=>'col text-center'));
                                        if($this->USER->ID == $userData['id'] 
                                            or $this->USER->IS_SYSTEMADMIN 
                                            or ($this->USER->IS_ADMIN and (!$userData['is_admin'] and !$userData['is_systemadmin']))
                                        ){$editDisabled = "";} else {$editDisabled = "disabled";}

                                        BTN::PRE(array( 'class'=>'btn btn-outline-primary core-modal-btn',
                                                        'caption'=>BI::GET(array('icon'=>'pencil','size'=>'16')),
                                                        'disabled'=>$editDisabled),
                                                array(  'data-path'=>'core/modals/modal.user.edit.php',
                                                        'data-condition'=>$userData['id'],
                                                        'data-bs-toggle'=>"tooltip", 
                                                        'data-bs-placement'=>"bottom", 
                                                        'title'=>TXT['Edit']));
                                        BTN::POST();
                                    COLUMN::POST();
                                    COLUMN::PRE(array('class'=>'col text-center'));
                                        if($this->USER->ID == $userData['id'] 
                                            or $this->USER->IS_SYSTEMADMIN 
                                            or ($this->USER->IS_ADMIN and (!$userData['is_admin'] and !$userData['is_systemadmin']))
                                        ){$editDisabled = "";} else {$editDisabled = "disabled";}

                                        BTN::PRE(array( 'class'=>'btn btn-outline-primary core-modal-btn',
                                                        'caption'=>BI::GET(array('icon'=>'arrow-counterclockwise','size'=>'16')),
                                                        'disabled'=>$editDisabled),
                                                array(  'data-path'=>'core/modals/modal.user.password.php',
                                                        'data-condition'=>$userData['id'],
                                                        'data-bs-toggle'=>"tooltip", 
                                                        'data-bs-placement'=>"bottom", 
                                                        'title'=>TXT['Reset password']));
                                        BTN::POST();
                                    COLUMN::POST();                                    
                                    COLUMN::PRE(array('class'=>'col text-center'));
                                        if($this->USER->ID != $userData['id'] 
                                            and ($this->USER->IS_SYSTEMADMIN or $this->USER->IS_ADMIN) 
                                            and !$userData['is_systemadmin']
                                        ){$deleteDisabled = "";} else {$deleteDisabled = "disabled";}
                                        BTN::PRE(array( 'class'=>'btn btn-outline-primary core-modal-btn',
                                                        'caption'=>BI::GET(array('icon'=>'trash','size'=>'16')),
                                                        'disabled'=>$deleteDisabled),
                                                array(  'data-path'=>'core/modals/modal.dataset.delete.php',
                                                        'data-table'=>'core_users',
                                                        'data-condition'=>'id',
                                                        'data-conditionvalue'=>$userData['id'],
                                                        'data-bs-toggle'=>"tooltip", 
                                                        'data-bs-placement'=>"bottom", 
                                                        'title'=>TXT['Delete']));
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

?>    