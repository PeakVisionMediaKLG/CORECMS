<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

print_r($data);


$currentTable = $data['table'];
$condition = $data['condition'];
$conditionValue = $data['conditionvalue'];

if($data['new_password']==$data['new_password_repeated']){

$result = $DB->EASY_QUERY(  "UPDATE",
                            $currentTable,
                            array('password'),
                            array(password_hash($data['new_password'],PASSWORD_DEFAULT)),
                            array($condition),
                            array($conditionValue)
                            );

if(!$result) {echo TXT['An error occurred while updating this dataset.']."<br><br>"; print_r($allColumns);  print_r($allValues); echo "<br><br>".$condition."<br><br>".$conditionValue;}
}
else {echo TXT['Passwords do not match.'];}
?>