<?php
namespace CORE;

class CONTENT
{
    public $DB;
    public $CORE;
    public $PAGE;
    public $TEMPLATE;
    public $TXT;

    public $UNIQUE_ID;
    public $LOCKED;
    public $ACTIVE;


    function GET_TXT()
    {
        $activeLanguage = $this->USER->PREFERRED_LANGUAGE ?? "EN";
        if(file_exists(ROOT."core/".$this->CORE->DOM_PATH."/txt/content/".$activeLanguage.".json")) 
        {
                $txt_json_file = file_get_contents(ROOT."core/".$this->CORE->DOM_PATH."/txt/content/".$activeLanguage.".json");
                $this->TXT = json_decode($txt_json_file, true);
        }
        else die(ROOT."core/".$this->CORE->DOM_PATH."/txt/content/".$activeLanguage.".json");
    }

    function BUILD_INCLUDES()
    {

    }

    function CONTROLS($toplevel=0)
    {
        if($toplevel)
        {
            $this->LOCKED=0;
            CONTAINER::PRE();
                ROW::PRE();
                    COLUMN::PRE(array("class"=>"col-6 core-edit-mode text-end"));
                        $this->TOOLS();
                    COLUMN::POST();
                ROW::POST();
            CONTAINER::POST();
        }
        else 
        {
            $this->TOOLS();
        }
    }

    function TOOLS()
    {
        $this->LOCKED=0;
        if($this->LOCKED)
        {
            if($this->USER->IS_ADMIN /*or $this->USER->ALLOWED_WORKSPACE()*/)
            {
                $this->UNLOCK(1);
            }
            else 
            {
                $this->UNLOCK(0);
            }
  
        }
        else 
        {
            $this->TOOLBAR();
        }    

    }

    function TOOLBAR()
    {
        DIV::PRE(array("class"=>"btn-group btn-group-sm core-content-controls", "role"=>"group"));
            
                $this->UNLOCK(1);   

                $this->COPY_CONTROLS(1);

                $this->ACTIVATE(1);

                $this->MOVEMENT_CONTROLS(1);

                BTN_DROPDOWN::PRE(array(
                                        "outer_class"=>"btn-group",
                                        "class"=>"btn btn-sm btn-secondary core-displaceable",
                                        "id"=>"",
                                        "caption"=>""
                                    ));

                    $this->STANDARD_DROPDOWN(1);
                
                BTN_DROPDOWN::POST();

        DIV::POST();

            $this->DISPLACED_DROPDOWN(); 
        
    }

    function COPY_CONTROLS($displaceable=1)
    {
        if($displaceable) $displace=" core-displaceable"; else $displace=" core-displaced"; 

        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn'.$displace,'title'=>"",'caption'=>BI::GET(array('icon'=>'scissors')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();   
        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn'.$displace,'title'=>"",'caption'=>BI::GET(array('icon'=>'files')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();   
        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn'.$displace,'title'=>"",'caption'=>BI::GET(array('icon'=>'box-arrow-in-down')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();     
    }

    function MOVEMENT_CONTROLS($displaceable=1)
    {
        if($displaceable) $displace=" core-displaceable"; else $displace=" core-displaced"; 

        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn'.$displace,'title'=>"",'caption'=>BI::GET(array('icon'=>'arrow-up')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();

        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn'.$displace,'title'=>"",'caption'=>BI::GET(array('icon'=>'arrow-down')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();     
    }

    function UNLOCK($displaceable=1)
    {
        if($displaceable) $displace=" core-displaceable"; else $displace=" core-displaced";

        BTN::PRE(array(
            'class'=>'btn btn-secondary core-action-btn'.$displace,'title'=>"",'caption'=>BI::GET(array('icon'=>'unlock-fill')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
            'data-table'=>'content'
        ));
        BTN::POST();
    }

    function ACTIVATE($displaceable=1)
    {
        if($displaceable) $displace=" core-displaceable"; else $displace=" core-displaced";

        if($this->ACTIVE)
        {
            BTN::PRE(array(
                'class'=>'btn btn-secondary core-action-btn'.$displace,'title'=>"",'caption'=>BI::GET(array('icon'=>'toggle-on')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
                'data-table'=>'content'
            ));
            BTN::POST();
        }
        else 
        {
            BTN::PRE(array(
                'class'=>'btn btn-secondary core-action-btn'.$displace,'title'=>"",'caption'=>BI::GET(array('icon'=>'toggle-off')),'data-path'=>$this->CORE->DOM_PATH."core/actions/content.lock.toggle.php",
                'data-table'=>'content'
            ));
            BTN::POST();
        }
    }

    function STANDARD_DROPDOWN()
    {

            LI::PRE();
                A::PRE(array("class"=>"dropdown-item core-modal-btn","href"=>"#",
                /*'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page.edit.php",*/'data-table'=>'app_pages',
                'data-condition'=>$this->UNIQUE_ID));
                    echo $this->TXT['Edit'];
                A::POST();
            LI::POST();
            LI::PRE();
                A::PRE(array("class"=>"dropdown-item core-modal-btn","href"=>"#",/*'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page.edit.php",*/'data-table'=>'app_pages',
                'data-condition'=>$this->UNIQUE_ID));
                    echo $this->TXT['Delete'];
                A::POST();
            LI::POST();
            LI::PRE();HR::PRINT(array('class'=>'dropdown-divider'));LI::POST();
            LI::PRE();
                A::PRE(array("class"=>"dropdown-item core-modal-btn","href"=>"#",/*'data-path'=>$EXT_ARRAY['DOM_PATH']."modals/modal.page.edit.php",*/'data-table'=>'app_pages',
                'data-condition'=>$this->UNIQUE_ID));
                    echo $this->TXT['Add content'];
                A::POST();
            LI::POST();

    }

    function DISPLACED_DROPDOWN()
    {
        BTN_DROPDOWN::PRE(array(
            "class"=>"btn btn-sm btn-secondary core-displaced",
            "id"=>"",
            "caption"=>""
        ));
            LI::PRE();
                SPAN::PRE(array('class'=>'dropdown-item-text'));
                    DIV::PRE(array("class"=>"btn-group btn-group-sm core-displaced", "role"=>"group"));
                        $this->UNLOCK(0);
                        $this->ACTIVATE(0);
                        $this->MOVEMENT_CONTROLS(0);
                    DIV::POST();
                SPAN::POST();
            LI::POST();
            LI::PRE();
                SPAN::PRE(array('class'=>'dropdown-item-text'));
                    DIV::PRE(array("class"=>"btn-group btn-group-sm core-displaced", "role"=>"group"));
                        $this->COPY_CONTROLS(0);
                    DIV::POST();
                SPAN::POST();        
            LI::POST();
            LI::PRE();HR::PRINT(array('class'=>'dropdown-divider'));LI::POST();

            $this->STANDARD_DROPDOWN();

        BTN_DROPDOWN::POST(); 
    }
}
?>