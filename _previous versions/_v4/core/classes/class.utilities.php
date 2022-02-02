<?php
class UTILITIES
{
    static function FLATTEN_ARRAY_BY_VALUE($input)
    {
        $tempArray = array();
        foreach ($input as $key => $value)
        {
            array_push($tempArray,$value);
        }
        return $tempArray;
    }
}
?>