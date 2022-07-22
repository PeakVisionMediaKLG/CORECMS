<?php
namespace CORE;

class CONTENT
{
    public $DB;
    public $CORE;
    public $PAGE;
    public $TEMPLATE;

    public $LOCKED;
    public $ACTIVE;


    function BUILD_INCLUDES()
    {

    }

    function CONTROLS($toplevel=0)
    {
        if($toplevel)
        {
            CONTAINER::PRE();
                ROW::PRE();
                    COLUMN::PRE(array("class"=>"col-12 core-edit-mode"));
                        $this->CNT_TOOLBAR();
                    COLUMN::POST();
                ROW::POST();
            CONTAINER::POST();
        }
        else 
        {
        
        }
    }

    function CNT_TOOLBAR()
    {
        DIV::PRE(array("class"=>"btn-group btn-group-sm", "role"=>"group"));
            $this->LOCKED=0;
            if($this->LOCKED)
            {
                BTN::PRE(array(
                    'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'lock-fill')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
                    'data-table'=>'content'
                ));
                BTN::POST();        
            }
            else
            {
                BTN::PRE(array(
                    'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'unlock-fill')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
                    'data-table'=>'content'
                ));
                BTN::POST();       
                $this->COPY_CONTROLS();
                if($this->ACTIVE)
                {
                    BTN::PRE(array(
                        'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'toggle-on')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
                        'data-table'=>'content'
                    ));
                }
                else 
                {
                    BTN::PRE(array(
                        'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'toggle-off')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
                        'data-table'=>'content'
                    ));
                }
                $this->MOVEMENT_CONTROLS();
                BTN_DROPDOWN::PRE(array(
                    "outer_class"=>"btn-group",
                    "class"=>"btn btn-sm btn-secondary",
                    "id"=>"",
                    "caption"=>""
                ));
                BTN_DROPDOWN::POST();
                
            }

        DIV::POST();
    }

    function COPY_CONTROLS()
    {
        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'scissors')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();   
        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'files')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();   
        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'box-arrow-in-down')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();     
    }

    function MOVEMENT_CONTROLS()
    {
        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'arrow-up')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();   
        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn','title'=>"",'caption'=>BI::GET(array('icon'=>'arrow-down')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();     
    }

}
?>