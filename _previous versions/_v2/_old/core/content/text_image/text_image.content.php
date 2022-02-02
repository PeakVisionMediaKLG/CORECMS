<div class='no-shadow <?php if($this->USER->SHOW_TO_ALL()) { echo"core-editable'"; echo "contenteditable='true' data-id='".$ContentData['ckeditable'][0]['cDataUID']."'"; } else echo "'";?>>

<?php  
  if($this->USER->SHOW_TO_ALL()){
	if($ContentData['ckeditable'][0]['cDataContent']=="") echo "<br><br><h2>Edit this content</h2>"; else echo stripslashes($ContentData['ckeditable'][0]['cDataContent']);	
	}
	else echo stripslashes($ContentData['ckeditable'][0]['cDataContent']);  
?>
</div>
