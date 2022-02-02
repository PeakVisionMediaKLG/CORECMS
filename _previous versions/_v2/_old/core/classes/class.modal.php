<?php

class MODAL
{
	
	private $form_used;
	private $finished_modal;
	
	function __construct($id,
                         $title,
                         $content,
                         $cancel_label,
                         $action_label,
                         $action_path,
                         $data_attribute="", 
                         $action_disabled=0)
        {
            
        $this->id=$id;
        $this->title=$title; 
        $this->content=$content;
        $this->cancel_label=$cancel_label;
        $this->action_label=$action_label;
        $this->action_path=$action_path;
        $this->data_attribute=$data_attribute;
        $this->action_disabled=$action_disabled;
        if($this->action_disabled!=0) $this->action_disabled="disabled"; else $this->action_disabled="";
        
            $full_modal=$this->MODAL_HEAD();
        
            $full_modal.=$this->content;
            
            $full_modal.=$this->MODAL_FOOTER();

            $full_modal=$this->CLEAN_MARKUP($full_modal);
        
            $this->finished_modal=$full_modal;
        }
	
//--------------------------------------------------------------------------------------------------------------------------
	
	function MODAL_HEAD()
        {
            $modalhead="
            <div class='modal fade' id='$this->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
              <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
                <div class='modal-content'>";

                     if($this->action_label!=''){ $modalhead.="<form id='$this->id-form'>"; $this->form_used=1;}		
                      $modalhead.="<div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'>$this->title</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                      </div>
                      <div class='modal-body $this->id-body'>";

            return $modalhead;
        }

//--------------------------------------------------------------------------------------------------------------------------
	
	function MODAL_FOOTER()
        {	 
        
        
            $modalfooter="
                </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal' onclick='window.location.reload();'>$this->cancel_label</button>";
                        
             if($this->action_label!=""){$modalfooter.="
             <button type='button' class='btn btn-primary $this->id-action-btn core-serialize-btn' data-action-path='$this->action_path' data-input='$this->data_attribute' $this->action_disabled>$this->action_label</button>
             ";}
             $modalfooter.="
                        </div>
                    </div>";
                   if($this->form_used==1){ $modalfooter.="</form>";}
                   $modalfooter.="
                  </div>
                </div>";

            return $modalfooter;
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
            echo $this->finished_modal;
        }
			
}



?>