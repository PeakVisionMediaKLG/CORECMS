<?php
namespace CORE;
trait WIDGETS {
    public function CREATE_URL($previousUrl) 
    {  
        $previousUrl = substr($previousUrl,strpos($previousUrl,"/core/")+1);
        return $this->DB->coreProtocol.$this->DB->coreHost.$previousUrl;
    }
}


?>