<?php
class SANITIZER
{

    /*function __construct($USER)
    {
            $this->USER=$USER; 
            $languagetoload = $this->USER->GET_USERVAL("uLanguage") ?? 'EN';
            include('txt/'.$languagetoload.'.php');
            $this->TXT = $TXT;   
    }*/
    
    function CLEAN ($value,$type)
    {
        switch ($type)
        {
            case "text":
                    return preg_replace("[^A-Za-z0-9_]", "", $value); // /[^ \w]+/ 
                
            break;             

            case "url":
                if (!filter_var($value, FILTER_SANITIZE_URL)) 
                {
                    echo $this->TXT['\\ error: invalid url']; 
                } 
                else //"/[^0-9a-zA-Z-]/"
                {
                    return preg_replace("/[^0-9a-zA-Z-]/", "", $value);;
                }
            break;
                
            case "email":
                
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) 
                {
                    echo $this->TXT['\\ error: invalid e-mail address']; 
                } 
                else 
                {
                    return $value;
                }
                
            break; 
                
            case "integer":
                
                if (!filter_var($value, FILTER_VALIDATE_INT)) 
                {
                    echo $this->TXT['\\ error: invalid integer value']; 
                } 
                else 
                {
                    return $value;
                }
            break;     
                
            case "bool":
                
                    switch ($value) 
                    {    
                        case 1:
                        case TRUE:    
                        case "true":
                        case "on": 
                        case "yes":
                            return 1;
                        break;
                            
                        case 0:
                        case FALSE:
                        case "0":
                        case "false":
                        case "off": 
                        case "no":
                            return 0;
                        break;
                        
                        case NULL:    
                        default:
                            return 0;
                        break;    
                    } 

            break; 
            
            
            default: //sanitize_type = none
                return $value;
            break;    
        }
        
    }

}

?>