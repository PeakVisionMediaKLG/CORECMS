<?php

namespace CORE;
trait HELPERS 
{
    public function CREATE_URL($previousUrl) 
    {  
        //$previousUrl = substr($previousUrl,strpos($previousUrl,"/core/")+1);

        $previousUrl = substr($previousUrl,strpos($previousUrl,"/")+1);

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

    static function UNIQUE($name)
    {
        return $name."_".md5(microtime(true));
    }

}

?>