<?php
namespace CORE;
class ROW extends COMPONENT
{	
    static function PRECODE($attributes=NULL)
    {
        $attributes = (new self)::FORCE($attributes, array('class'=>'row'));

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