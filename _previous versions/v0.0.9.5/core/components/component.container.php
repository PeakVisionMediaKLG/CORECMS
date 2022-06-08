<?php
//writes the HTML code for a multi-use div

class CONTAINER extends CORE\COMPONENT
{	//class, style
    
    static function PRECODE($params=NULL,$data=NULL)
    {
        $CODE = "<div ".(new self)->WRITE($params,'class')." ".(new self)->WRITE($params,'style').">
        ";
        return $CODE;
    }

    static function POSTCODE($params=NULL,$data=NULL)
    {
        $CODE = "</div>
        ";
        return $CODE;
    }		

}
?>