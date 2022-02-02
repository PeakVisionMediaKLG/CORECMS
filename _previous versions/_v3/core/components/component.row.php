<?php
//writes the HTML code for a bootstrap row

class ROW extends BE_COMPONENT
{	//class, style
    static function PRECODE($params=NULL,$data=NULL)
    {
        $CODE = "<div class='row ".(new self)->WRITE_S($params,'class')."' ".(new self)->WRITE($params,'style')." ".(new self)->WRITE($params,'id').">
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