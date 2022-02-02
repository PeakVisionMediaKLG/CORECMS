<?php
session_start(); 
require_once('../../root.directory.php');
require_once(ROOT.'core/classes/class.db.php');

$DB = new DB();
print_r($DB);

function BUILD_DB_TABLES($json,$DB)
{
    $jsonData = json_decode($json,true);
    echo "<br>\n<br>\n";
    echo "JSON FILE: ";
    print_r($jsonData);
    echo "<br>\n<br>\n";

    $findTable = $DB->EXEC_TBL("SHOW TABLES LIKE '",$jsonData['table'],"'");
    //echo $findTable;
    var_dump($DB->currentResult[$findTable]);

    //var_dump($DB->currentStatementVars);
    if($DB->currentResult[$findTable]->num_rows>0)
    {
        echo "<br>\n Table exists. <br>\n";
        
        $findColumns = $DB->EXEC_TBL("SHOW COLUMNS FROM ",$jsonData['table'],"");
        var_dump($DB->currentResult[$findColumns]);
        $columnArray=$DB->MAP_RESULT($findColumns);

        $existingColumns = array();
        foreach($columnArray as $key => $value)
        {   
            //echo $key;
            foreach($value as $subkey => $subvalue)
            {   //echo $subkey;
                if($subkey == "Field") $existingColumns[] = $subvalue;
            }
        }
        $jsonColumns = array();
        foreach ($jsonData['structure'] as $key => $value)
        {
            $jsonColumns[] = $key;
        }
        //print_r($existingColumns);
        if($existingColumns == $jsonColumns)
        {
            echo "<br>\n Table columns correspond to JSON columns.<br>\n ";

            $findData = $DB->RETRIEVE(
                $jsonData['table'],
                array(),
                array()
            );

            var_dump($findData);
        } 
        elseif($existingColumns < $jsonColumns) 
        {
            echo "<br>\n New JSON table columns have been found.<br>\n ";

        }
        elseif($existingColumns > $jsonColumns) 
        {
            echo "<br>\n JSON table columns have been removed. The existing columns will not be deleted.<br>\n ";            
        }               
        
        //"SELECT * FROM ",$jsonData['table']," LIMIT 1"
        /*
        $existingColumns = array();
        foreach ($DB->FETCH_ARRAY() as $key => $value)
        {
            
        }
        
        $jsonColumns = array();
        foreach ($jsonData['structure'] as $key => $value)
        {
            $jsonColumns[] = $key;
        }
        if($existingColumns == $jsonColumns)
        {
            echo "<br>\n Table columns correspond to JSON columns.<br>\n ";
        }
        else 
        {
            
        }
        */
    }
    else 
    {
        echo "<br>\n Table doesn't exist.<br>\n";
        
        $preparedSQL='
        START TRANSACTION;
        SET time_zone = "+00:00";
        DROP TABLE IF EXISTS `'.$jsonData['table'].'`;
        CREATE TABLE `'.$jsonData['table'].'` (';
        foreach($jsonData['structure'] as $key => $value)
        {
            switch($value['type'])
            {
                case "int":
                case "tinyint":
                    $collate="";
                break;
                case "varchar":
                    $collate = "COLLATE ".$jsonData['collation'];
                break;
                case "text":
                    $collate = "COLLATE ".$jsonData['collation'];
                break;            
            }
            if(isset($value['length'])) $myLength = '('.$value['length'].') '; else $myLength = ' ';
            $preparedSQL.='`'.$key.'` '.$value['type'].$myLength.$collate.' '.$value['null'].',';

            if(isset($value['primary']))
            {
                if($value['primary']){ 
                    $specialInstructions = "ADD PRIMARY KEY (`".$key."`),"; 
                    $specialInstructions2 =' MODIFY `'.$key.'` '.$value['type'].'('.$value['length'].')'.$collate.' '.$value['null'].' AUTO_INCREMENT, ';
                }
            }
            if(isset($value['unique']))
            {
                $specialInstructions .= "ADD UNIQUE KEY `".$key."` (`".$key."`),";
            }            

            $collate="";    
        }
        $preparedSQL=substr($preparedSQL,0,-1).") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=".$jsonData['collation'].";";  
          
        $datasetCounter=0;
        if(isset($jsonData['data'][0]))
        {
        $preparedSQL.="INSERT INTO `".$jsonData['table']."` (";

        //print_r($jsonData['data']);

            foreach($jsonData['data'][0] as $key => $value)
            {
                //foreach($value as $subkey => $subvalue)
                //{
                //$preparedSQL.="`".$subkey."`, ";   
                //}
                $preparedSQL.="`".$key."`, ";   
            }
            $preparedSQL=substr($preparedSQL,0,-2).") VALUES ";

            
            foreach($jsonData['data'] as $key => $value)
            {
                $preparedSQL.="(";
                foreach($value as $subkey => $subvalue)
                {
                    if (is_numeric($subvalue))
                    {
                        $preparedSQL.=$subvalue.", "; 
                    }    
                    else  $preparedSQL.="'".$subvalue."', ";
                }
                $preparedSQL=substr($preparedSQL,0,-2);

                $preparedSQL.="),";
                $datasetCounter++; 
            }
        $preparedSQL=substr($preparedSQL,0,-1);
        $preparedSQL.=";";
        }

        if($specialInstructions<>"")
        {
            $preparedSQL.="ALTER TABLE `".$jsonData['table']."`";  
            $specialInstructions=substr($specialInstructions,0,-1);
            $preparedSQL.=$specialInstructions;
            if($specialInstructions2<>"")
            {   
                $preparedSQL.=",".$specialInstructions2." AUTO_INCREMENT=".($datasetCounter+1).";";
            }
        }

        //$preparedSQL.="COMMIT;"; 

        // echo $preparedSQL;

        //$DB->MULTI_EXEC($preparedSQL);
        return $preparedSQL;
    }


}

$completeDBString="";
foreach (new DirectoryIterator(ROOT.'core/tables/') as $fileInfo) {
    if($fileInfo->isDot()) continue;

        $json = file_get_contents(ROOT.'core/tables/'.$fileInfo->getFilename().'/database.json');
        
        $completeDBString.=BUILD_DB_TABLES($json,$DB);

        echo "<br>\n<br>\n";
}
$completeDBString.="COMMIT;";
echo $completeDBString;

$DB->MULTI_EXEC($completeDBString);










/*
function BUILD_TABLES ($json,$DB)
{
    //Decode JSON
    $jsonData = json_decode($json,true);
    //Print data
    echo "test";
    print_r($jsonData);
    $checkTable = $DB->SINGLE_QUERY("SHOW TABLES LIKE '".$jsonData['table']."'"); 
    if($checkTable and $DB->NUM_ROWS() and $DB->NUM_ROWS()>0)
    {
        
        $tableData = $DB->SINGLE_QUERY('SELECT * FROM '.$jsonData['table']);
        if($DB->NUM_ROWS() and $DB->NUM_ROWS()>0) $updateTable = 1;
        
    }
    else $updateTable = 0;
    
    switch($updateTable)
    {
        case 1:
            $existingcolumns = $DB->SINGLE_QUERY('SELECT * FROM '.$jsonData['table']);
            $existingcolumns = $existingcolumns->FETCH_ARRAY();
            
            //print_r($existingcolumns);
            //echo "<br><br>";                               
            $preparedSQL='
            START TRANSACTION;
            SET time_zone = "+00:00";
            ALTER TABLE `'.$jsonData['table'].'`
            ';
            $lastColumn="";
            $specialInstructions="";
            foreach($jsonData['structure'] as $key => $value)
            {   
                echo $key;
                switch($value['type'])
                {
                    case "int":
                    case "tinyint":
                        $collate="";
                    break;
                    case "varchar":
                        $collate = "COLLATE ".$jsonData['collation'];
                    break;
                    case "text":
                        $collate = "COLLATE ".$jsonData['collation'];
                    break;            
                }
                $newCols=0;
                if(array_key_exists($key, $existingcolumns)) 
                {
                    echo "found"; 
                }
                else
                {
                    $newCols=1;
                    if ($lastColumn <> "") 
                    {
                        $afterColumn=' AFTER `'.$lastColumn.'`';                
                    }
                    $preparedSQL.='
                    ADD COLUMN `'.$key.'` '.$value['type'].'('.$value['length'].') '.$collate.' '.$value['null'].' '.$afterColumn.',';
                    if(isset($value['unique']))
                    {
                        $specialInstructions .= "ADD UNIQUE KEY `".$key."` (`".$key."`),";
                    }  
                }
                $lastColumn=$key;
            }
            $preparedSQL= substr($preparedSQL,0,-1);
            $preparedSQL.= substr($specialInstructions,0,-1);
            $preparedSQL.="; COMMIT;";
            
        break;
        default:
            //echo "TEST";
            $specialInstructions="";
            $preparedSQL='
            START TRANSACTION;
            SET time_zone = "+00:00";
            DROP TABLE IF EXISTS `'.$jsonData['table'].'`;
            CREATE TABLE `'.$jsonData['table'].'` (';
            foreach($jsonData['structure'] as $key => $value)
            {
                switch($value['type'])
                {
                    case "int":
                    case "tinyint":
                        $collate="";
                    break;
                    case "varchar":
                        $collate = "COLLATE ".$jsonData['collation'];
                    break;
                    case "text":
                        $collate = "COLLATE ".$jsonData['collation'];
                    break;            
                }
                if(isset($value['length'])) $myLength = '('.$value['length'].') '; else $myLength = ' ';
                $preparedSQL.='`'.$key.'` '.$value['type'].$myLength.$collate.' '.$value['null'].',';
                if(isset($value['primary']))
                {
                    if($value['primary']){ 
                        $specialInstructions = "ADD PRIMARY KEY (`".$key."`),"; 
                        $specialInstructions2 =' MODIFY `'.$key.'` '.$value['type'].'('.$value['length'].')'.$collate.' '.$value['null'].' AUTO_INCREMENT, ';
                    }
                }
                if(isset($value['unique']))
                {
                    $specialInstructions .= "ADD UNIQUE KEY `".$key."` (`".$key."`),";
                }            
                $collate="";    
            }
            $preparedSQL=substr($preparedSQL,0,-1).") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=".$jsonData['collation'].";";    
            
            $preparedSQL.="INSERT INTO `".$jsonData['table']."` (";
            //print_r($jsonData['data']);
            foreach($jsonData['data'][0] as $key => $value)
            {
                //foreach($value as $subkey => $subvalue)
                //{
                //$preparedSQL.="`".$subkey."`, ";   
                //}
                $preparedSQL.="`".$key."`, ";   
            }
            $preparedSQL=substr($preparedSQL,0,-2).") VALUES ";
            $datasetCounter=0;
            foreach($jsonData['data'] as $key => $value)
            {
                $preparedSQL.="(";
                foreach($value as $subkey => $subvalue)
                {
                    if (is_numeric($subvalue))
                    {
                        $preparedSQL.=$subvalue.", "; 
                    }    
                    else  $preparedSQL.="'".$subvalue."', ";
                }
                $preparedSQL=substr($preparedSQL,0,-2);
                $preparedSQL.="),";
                $datasetCounter++; 
            }
            $preparedSQL=substr($preparedSQL,0,-1);
            $preparedSQL.=";";
            if($specialInstructions<>"")
            {
                $preparedSQL.="ALTER TABLE `".$jsonData['table']."`";  
                $specialInstructions=substr($specialInstructions,0,-1);
                $preparedSQL.=$specialInstructions;
                if($specialInstructions2<>"")
                {   
                    $preparedSQL.=",".$specialInstructions2." AUTO_INCREMENT=".($datasetCounter+1).";";
                }
            }
            //$preparedSQL.="COMMIT;";
            break;
    }
    
   // if($updateTable==1 or ($updateTable==0 and $newCols==1))
  //  {
        echo "<br>\n<br>\n".$preparedSQL."<br>\n<br>\n";
        $createTable = $DB->MULTI_QUERY($preparedSQL);
  //  }
}
$DB->CONNECTION->autocommit(FALSE);
foreach (new DirectoryIterator(ROOT.'core/tables/') as $fileInfo) {
    if($fileInfo->isDot()) continue;
    echo $fileInfo->getFilename() . "<br>\n";
    if(strpos($fileInfo->getFilename(),".json"))
    {
        $json = file_get_contents(ROOT.'core/tables/'.$fileInfo->getFilename());
        //$DB->FREE_RESULT();
        BUILD_TABLES($json,$DB);
    }
    echo "<br>\n<br>\n";
    $DB->CONNECTION->autocommit(True);    
}    */
?>