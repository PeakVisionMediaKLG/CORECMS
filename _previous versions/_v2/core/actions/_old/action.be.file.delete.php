<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

//print_r($data);

if($data['file']!='*')
{
    $file_pointer = $data['directory'].$data['file']; 
    //echo $file_pointer; 
    
    // Use unlink() function to delete a file  
    if (!unlink($file_pointer)) {  
        $output= ("$file_pointer cannot be deleted due to an error");  
    }  
    else {  
        $output=  ("$file_pointer has been deleted");  
    }  
}
else 
{   
    $dir = new DirectoryIterator($data['directory']);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) 
        {
            $file_pointer = $data['directory'].$fileinfo->getFilename(); 

            if (!unlink($file_pointer)) {  
                $output= ("$file_pointer cannot be deleted due to an error");  
            }  
            else {  
                $output=  ("$file_pointer has been deleted");  
            } 
        }
    }
}


?>