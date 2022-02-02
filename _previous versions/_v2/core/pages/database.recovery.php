<?php

if($this->USER->AUTH_OK and $this->USER->IS_ADMIN) 
{

    ROW::PRE(array('class'=>'ms-auto me-auto w90'));

        COLUMN::PRE(array('class'=>'col-12 '));
        H::PRINT(array('heading'=>TXT['System backup & recovery'],'type'=>4,'class'=>'text-center'));
        ROW::PRE();
            COLUMN::PRE(array('class'=>'col-12 text-center mt-4'));
            if($this->USER->IS_ADMIN){
                    BTN::PRE(array('class'=>'btn btn-outline-primary core-action-btn mx-2','caption'=>TXT['Create backup']." ".BI::GET(array('icon'=>'plus','size'=>'16'))),array('data-path'=>'core/actions/database.backup.php'));BTN::POST();
            }
            if($this->USER->IS_SYSTEMADMIN){
                    BTN::PRE(array('class'=>'btn btn-outline-primary core-modal-btn mx-2','caption'=>TXT['Delete all backups']." ".BI::GET(array('icon'=>'trash','size'=>'16'))),array('data-path'=>'core/modals/modal.file.delete.php','data-directory'=>ROOT."backups/",'data-file'=>'*'));BTN::POST();
          
            }            
            COLUMN::POST();                
        ROW::POST();        
            CARD::PRE(array('class'=>"mt-4 p-2 core-text"));
                ROW::PRE();
                    COLUMN::PRE(array('class'=>'col-3'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['File']));
                    COLUMN::POST();                
                    COLUMN::PRE(array('class'=>'col-3'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Date']));
                    COLUMN::POST();
                    COLUMN::PRE(array('class'=>'col-3'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Created by']));
                    COLUMN::POST();  
                    COLUMN::PRE(array('class'=>'col-1'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Preview']));
                    COLUMN::POST();                                      
                    COLUMN::PRE(array('class'=>'col-1'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Restore']));
                    COLUMN::POST();     
                    COLUMN::PRE(array('class'=>'col-1'));
                        H::PRINT(array('type'=>6,'heading'=>TXT['Delete']));
                    COLUMN::POST();                         
                ROW::POST();
                
                    $dir = new RecursiveDirectoryIterator(ROOT."backups/");
                    $fileMap = iterator_to_array($dir);
                    /*foreach ($dir as $fileinfo) {
                        if (!$fileinfo->isDot()) {
                            $sortedFiles[$this->DB->DUMP_TIMESTAMP($fileinfo->getFilename())] = $fileinfo;
                        }        
                    }*/
                    krsort($fileMap);
                    //var_dump($fileMap);

                    foreach($fileMap as $key => $fileinfo)
                    {
                        if(strpos($fileinfo->getFilename(),'.log')!==false){
                            ROW::PRE(array('class'=>'mt-2 core-bordered-row p-1'));  
                                COLUMN::PRE(array('class'=>'col-3'));
                                    echo $fileinfo->getFilename();
                                COLUMN::POST();                              
                                COLUMN::PRE(array('class'=>'col-3'));
                                    echo $this->DB->DUMP_TIMESTAMP($fileinfo->getFilename());
                                COLUMN::POST();
                                COLUMN::PRE(array('class'=>'col-3'));
                                    //echo $fileinfo->getFilename();
                                    if(strpos($fileinfo->getFilename(),'user-')!==false) echo TXT['User']; elseif(strpos($fileinfo->getFilename(),'core-')!==false) echo TXT['System'];
                                    //echo $this->DB->DUMP_TIMESTAMP($fileinfo->getFilename());
                                COLUMN::POST(); 
                                COLUMN::PRE(array('class'=>'col-1'));
                                    if(!$this->USER->IS_SYSTEMADMIN) $nonAuthorizedDisabled="disabled"; else $nonAuthorizedDisabled="";
                                    BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$nonAuthorizedDisabled,'caption'=>BI::GET(array('icon'=>'search','size'=>'16'))), array('data-path'=>'core/modals/modal.database.view.php','data-directory'=>ROOT."backups/",'data-file'=>$fileinfo->getFilename()));
                                    BTN::POST();
                                COLUMN::POST();                                                               
                                COLUMN::PRE(array('class'=>'col-1'));
                                    if(!$this->USER->IS_SYSTEMADMIN) $nonAuthorizedDisabled="disabled"; else $nonAuthorizedDisabled="";
                                    BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$nonAuthorizedDisabled,'caption'=>BI::GET(array('icon'=>'arrow-counterclockwise','size'=>'16'))), array('data-path'=>'core/modals/modal.database.restore.php','data-directory'=>ROOT."backups/",'data-file'=>$fileinfo->getFilename()));
                                    BTN::POST();
                                COLUMN::POST(); 
                                COLUMN::PRE(array('class'=>'col-1'));
                                    if(!$this->USER->IS_SYSTEMADMIN) $nonAuthorizedDisabled="disabled"; else $nonAuthorizedDisabled="";
                                    BTN::PRE(array('class'=>'btn btn-outline-secondary btn-sm core-modal-btn','disabled'=>$nonAuthorizedDisabled,'caption'=>BI::GET(array('icon'=>'trash','size'=>'16'))), array('data-path'=>'core/modals/modal.file.delete.php','data-directory'=>ROOT."backups/",'data-file'=>$fileinfo->getFilename()));
                                    BTN::POST();
                                COLUMN::POST();                                 
                            ROW::POST();
                        }
                    }
            CARD::POST();
        COLUMN::POST();
    ROW::POST();
}       
?>