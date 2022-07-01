<?php
namespace CORE;
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');

$data = $_POST['data'] ?? die('no data sent');

include_once(ROOT."core/classes/class.modal.php");

define('TXT', json_decode(file_get_contents(ROOT."/core/modals/modal.db.dataset.restore.extend/".$USER->PREFERRED_LANGUAGE.".json"), true));
echo "<pre>";
print_r($data);

$pageRow = $DB->RETRIEVE(
    $data['table']."_archive",
    array(),
    array('archive_id'=>$data['dataset_to_restore']),
    " LIMIT 1"
)[0];
print_r($pageRow);
echo "</pre>";

foreach($pageRow as $key => $value)
{
    if($key != "edited_by" 
    and $key != "edited_date" 
    and $key != "edited_action"
    and $key != "id"
    and $key != "unique_id"   
    )
    {
        HIDDEN::PRINT(array('name'=>"core_data__".$key,'value'=>$value));
    }
}

?>