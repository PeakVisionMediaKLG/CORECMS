<?php

namespace CORE;
class MODAL
{
	private $FORM_USED;
	private $FINISHED_MODAL;
	
	function __construct($parameters = NULL)
    {
      if(isset($parameters))
      {    
        $this->ID = $parameters['id'] ?? time();
        $this->TITLE = $parameters['title'] ?? ''; 
        $this->CONTENT = $parameters['content'] ?? '';
        $this->CONTENT_SIZE = $parameters['contentSize'] ?? 'modal-lg';
        $this->STATIC_MODAL = $parameters['staticModal'] ?? 'data-bs-backdrop="static"';        
        $this->CANCEL_LABEL = $parameters['cancelLabel'] ?? '';
        $this->ACTION_LABEL = $parameters['actionLabel'] ?? '';
        $this->ACTION_PATH = $parameters['actionPath'] ?? '';
        $this->DATA_ATTRIBUTES = $parameters['dataAttributes'] ?? NULL;
        $this->ACTION_DISABLED = $parameters['actionDisabled']  ?? '';
        $this->NO_CLEANUP = $parameters['noCleanup']  ?? '';
            
        $fullModal=$this->MODAL_HEAD();
    
        $fullModal.=$this->CONTENT;
        
        $fullModal.=$this->MODAL_FOOTER();

        if(!$this->NO_CLEANUP) $fullModal=$this->CLEAN_MARKUP($fullModal);
    
        $this->FINISHED_MODAL=$fullModal;
      }
    }


	function MODAL_HEAD()
    {
      $modalHead = "
      <div class='modal fade core-text' id='$this->ID' tabindex='-1' $this->STATIC_MODAL>
        <div class='modal-dialog modal-dialog-centered $this->CONTENT_SIZE'>
          <div class='modal-content'>";
            if($this->ACTION_LABEL!=''){ $modalHead.="<form id='$this->ID-form' class='core-modal-form'>"; $this->FORM_USED=1;}		
            $modalHead.="
            <div class='modal-header'>
              <h6 class='modal-title'>$this->TITLE</h6>
              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
      ";
      
      return $modalHead;
    }


	function WRITE_DATA($data)
		{	
			if($data!=NULL and count($data)>0)
      {
        $data_collection="";
        foreach($data as $key => $value)
          {
            $data_collection.=$key.'="'.$value.'" ';		
          }

        return $data_collection;
			}
		}


	function MODAL_FOOTER()
    {	 
      $timeout = $this->DATA_ATTRIBUTES['data-timeout'] ?? "data-timeout='100'";

      $modalFooter = "
            </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>$this->CANCEL_LABEL</button>";
              if($this->ACTION_LABEL!=""){$modalFooter.="
                <button type='button' class='btn btn-outline-primary $this->ID-action-btn core-serialize-btn' data-path='$this->ACTION_PATH' ".$this->WRITE_DATA($this->DATA_ATTRIBUTES)." $this->ACTION_DISABLED $timeout>$this->ACTION_LABEL</button>
                ";}
                $modalFooter.="                  
            </div>
          </div>
          ";
        if($this->FORM_USED==1){ $modalFooter.="</form>";}
        $modalFooter.="
        </div>
      </div>
      ";

      return $modalFooter;
    }


	function CLEAN_MARKUP($input)
    {
      $output = str_replace(array("\r", "\n"), '', $input);
      
      return $output;
    }


	function GET_MODAL()
    {
      echo $this->FINISHED_MODAL;
    }

}

?>