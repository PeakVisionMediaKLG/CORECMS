<?php //class.modal.php

class MODAL
{
	private $FORMUSED;
	private $FINISHEDMODAL;
	public	$BECOMPONENT;
	
	function __construct($parameters = NULL)
        {
          if(isset($parameters))
          {    
            $this->ID = $parameters['id'] ?? time();
            $this->TITLE = $parameters['title'] ?? ''; 
            $this->CONTENT = $parameters['content'] ?? '';
            $this->CONTENTSIZE = $parameters['contentSize'] ?? '';
            $this->STATICMODAL = $parameters['staticModal'] ?? '';        
            $this->CANCELLABEL = $parameters['cancelLabel'] ?? '';
            $this->ACTIONLABEL = $parameters['actionLabel'] ?? '';
            $this->ACTIONPATH = $parameters['actionPath'] ?? '';
            $this->DATAATTRIBUTES = $parameters['dataAttributes'] ?? NULL;
            $this->ACTIONDISABLED = $parameters['actionDisabled']  ?? '';
            $this->NOCLEANUP = $parameters['noCleanup']  ?? '';
                
                $full_modal=$this->MODAL_HEAD();
            
                $full_modal.=$this->CONTENT;
                
                $full_modal.=$this->MODAL_FOOTER();

                if(!$this->NOCLEANUP) $full_modal=$this->CLEAN_MARKUP($full_modal);
            
                $this->FINISHEDMODAL=$full_modal;
          }
        }
	
//--------------------------------------------------------------------------------------------------------------------------
	
	function MODAL_HEAD()
        {
            $modalHead = "
            <div class='modal fade core-text' id='$this->ID' tabindex='-1' $this->STATICMODAL>
              <div class='modal-dialog modal-dialog-centered $this->CONTENTSIZE'>
                <div class='modal-content'>";
                  if($this->ACTIONLABEL!=''){ $modalHead.="<form id='$this->ID-form' class='core-modal-form'>"; $this->FORMUSED=1;}		
                  $modalHead.="
                  <div class='modal-header'>
                    <h6 class='modal-title'>$this->TITLE</h6>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
            ";
            
            return $modalHead;
        }

//--------------------------------------------------------------------------------------------------------------------------
	
	
	function WRITE_DATA($data)
		{	
			if($data!=NULL and count($data)>0){
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
          $timeout = $this->DATAATTRIBUTES['data-timeout'] ?? "data-timeout='100'";

          $modalFooter = "
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>$this->CANCELLABEL</button>";
                  if($this->ACTIONLABEL!=""){$modalFooter.="
                    <button type='button' class='btn btn-outline-primary $this->ID-action-btn core-serialize-btn' data-path='$this->ACTIONPATH' ".$this->WRITE_DATA($this->DATAATTRIBUTES)." $this->ACTIONDISABLED $timeout>$this->ACTIONLABEL</button>
                    ";}
                    $modalFooter.="                  
                </div>
              </div>
              ";
            if($this->FORMUSED==1){ $modalFooter.="</form>";}
            $modalFooter.="
            </div>
          </div>
          ";
          return $modalFooter;
        }

//--------------------------------------------------------------------------------------------------------------------------	
	
	function CLEAN_MARKUP($input)
        {
            $output = str_replace(array("\r", "\n"), '', $input);
            return $output;
        }
		
//--------------------------------------------------------------------------------------------------------------------------	
	
	function GET_MODAL()
        {
			echo $this->FINISHEDMODAL;
        }
			
}



?>