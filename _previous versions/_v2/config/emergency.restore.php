<?php
exit;
include_once('../root.directory.php');


if (@$_POST['action']=='Restore')
{

    require_once(ROOT."config/config.php");
    $dbConfig = $CONFIG;

    function DUMP_DECRYPT($file,$dbEncryptionSalt,$dbEncryptionKey)
    {/*Decrypts the file $file, $ciphering must be identical to DUMP_ENCRYPT $ciphering as well as 
        $decryption_key = $encryption_key and $decryption_iv identical to $encryption_iv* and
        $options*/  
        
        //take the same arguments as in DUMP_ENCRYPT
        $ciphering = "AES-128-CTR";
        $decryption_iv = $dbEncryptionSalt; 
        $decryption_key = $dbEncryptionKey;
        $options=0; 

        //open $file , read encryted DUMP into $encryption
        $handle = fopen($file,'r+') or die();
        $encryption = fread($handle,filesize($file));
        fclose($handle);
        // decrypt £encryption
        $decryption = openssl_decrypt ($encryption, $ciphering, $decryption_key, 0, $decryption_iv);  
        //echo '<br><br>'.$decryption ; 
        return $decryption;
    }
    
    $DB = new MySQLi($dbConfig['mysqlServer'],$dbConfig['mysqlUser'],$dbConfig['mysqlPassword'],$dbConfig['mysqlDB']);
    $DB->set_charset('utf8mb4');

$decryptedDump = DUMP_DECRYPT($_POST['decryptdump'],$dbConfig['mysqlEncryptionSalt'],$dbConfig['mysqlEncryptionKey']);
echo $decryptedDump;

$doit = $DB->multi_query($decryptedDump);

}


?>
<html>
<body>
<?php
//echo $_SERVER['PHP_SELF'];
if (@$_POST['action']!='Restore')
{
?>
<label for="decryptdump">Select dump to restore system:</label>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<select id="decryptdump" name="decryptdump">
<?php
    $dir = new RecursiveDirectoryIterator(ROOT."backups/");
    $fileMap = iterator_to_array($dir);
    krsort($fileMap);

    foreach($fileMap as $key => $fileinfo)
    {
        if(strpos($fileinfo->getFilename(),'.log')!==false){

            echo "<option value='".ROOT."backups/".$fileinfo->getFilename()."'>".$fileinfo->getFilename()."</option>";
        }
    }

?>
</select>
<input type="submit" name="action" value="Restore">
</form>

<?php } else { echo "Restore attempted, please try logging into the core system.";  echo $doit;}?>
</body>
</html>
