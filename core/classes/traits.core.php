<?php
namespace CORE;
trait WIDGETS {
    public function CREATE_URL($previousUrl) 
    {  
        $previousUrl = substr($previousUrl,strpos($previousUrl,"/core/")+1);
        return $this->DB->coreProtocol.$this->DB->coreHost.$previousUrl;
    }

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