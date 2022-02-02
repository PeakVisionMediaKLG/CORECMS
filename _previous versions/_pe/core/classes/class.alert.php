<?php

class ALERT
{
    
    
    function __construct($MYSESSION)
        {    

        
        }
    
    function SHOW_ALERTS()
    {
        if(isset($_SESSION['alert_once_success'])){
            foreach($_SESSION['alert_once_success'] as $key => $value)
            {
                echo "
                <div class='alert alert-success' role='alert' alt='$key'>
                $value
                </div>";
                $this->REMOVE_ALERT('alert_once_success',$key);
            }
        }
        if(isset($_SESSION['alert_once_fail'])){
            foreach($_SESSION['alert_once_fail'] as $key => $value)
            {
                echo "
                <div class='alert alert-danger' role='alert' alt='$key'>
                $value
                </div>";
                $this->REMOVE_ALERT('alert_once_fail',$key);
            }
        }
        $this->REMOVE_ALERT_CATEGORY('alert_once_success');
        $this->REMOVE_ALERT_CATEGORY('alert_once_fail');
    }
    
    function ADD_ALERT(){}
    
    function REMOVE_ALERT($category,$which='none')
    {
        if(isset($_SESSION[$category][$which])) unset($_SESSION[$category][$which]);
        //print_r($_SESSION);
    }

    function REMOVE_ALERT_CATEGORY($category)
    {
        if(isset($_SESSION[$category])) unset($_SESSION[$category]);
        //print_r($_SESSION);
    }    
    
    function CLEAN_ALERTS()
    {
        
        
    }
    
    
}