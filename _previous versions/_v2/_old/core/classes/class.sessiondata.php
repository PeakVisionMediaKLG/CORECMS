<?php

class SESSIONDATA
{
    public $SESSIONVALS;
    
    function __construct()
        {    
        /*
        $_SESSION['system'][]
        $_SESSION['user'][]
        $_SESSION['alert'][]
        $_SESSION['interface'][]
        */    
        $this->SESSIONVALS = array();
        $this->SESSIONVALS = $_SESSION;
        
        }
    
    function GET_VALSET($type)
    {
        return $this->SESSIONVALS[$type];
    }
    
    function GET_VAL($type,$which)
    {
        if(isset($this->SESSIONVALS[$type][$which])) return @$this->SESSIONVALS[$type][$which]; else return;
    }
    
    function SET_VAL($type,$which,$value)
    {
        if(!isset($_SESSION[$type]))$_SESSION[$type]=array();
        $_SESSION[$type][$which]=$value;
        $this->UPDATE_SESSION_DATA();
    }
    
    function UPDATE_SESSION_DATA()
    {
        $this->SESSIONVALS = $_SESSION;
        //var_dump($this->SESSIONVALS);
    }
}