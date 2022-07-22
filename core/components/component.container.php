<?php
namespace CORE;
class CONTAINER extends COMPONENT
{	
    static function PRECODE($attributes=NULL)
    {
        $attributes = (new self)::FORCE($attributes, array('class'=>'container-fluid'));
        
        $CODE = "<div".(new self)->WRITE_ATTRIBUTES($attributes).">".PHP_EOL;
        return $CODE;
    }

    static function POSTCODE($attributes=NULL)
    {
        $CODE = "</div>".PHP_EOL;
        return $CODE;
    }		
}
?>