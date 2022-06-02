<?php
//writes the HTML code for a bootstrap row

namespace CORE;
class ROW extends COMPONENT
{	
    static function PRECODE($attributes=NULL,$parameters=NULL)
    {
        $CODE = "<div".(new self)->WRITE_ATTRIBUTES($attributes).">
        ";
        return $CODE;
    }

    static function POSTCODE($attributes=NULL,$parameters=NULL)
    {
        $CODE = "</div>
        ";
        return $CODE;
    }
}
?>