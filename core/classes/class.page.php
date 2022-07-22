<?php
namespace CORE;
class PAGE
{
public $DB;
public $USER;

public $ALL_PAGES;

static $INDENTATION;
static $SORTED_PAGE_OBJECTS;

function GET_ALL_PAGES()
    {
        $this->ALL_PAGES = $this->DB->RETRIEVE(
            "core_pages",
            array(),
            array(),
        );
        
        return $this->ALL_PAGES;
    }

function INITIALIZE($url)
    {
        $this->CURRENT_PAGE = $this->DB->RETRIEVE(
            "app_pages",
            array(),
            array("url"=>$url),
            "LIMIT 1"
        )[0];  

        foreach($this->CURRENT_PAGE as $key => $value)
        {
            $key=strtoupper($key);
            $this->{$key}=$value;
        }  
    }    

static function PREPARE_PAGE_OBJECTS($parent, $DB)
    {
        if(!SELF::$SORTED_PAGE_OBJECTS) SELF::$SORTED_PAGE_OBJECTS = array();
        SELF::$INDENTATION++;

        $currentPageObjects = $DB->RETRIEVE(
            "app_page_objects",
            array(),
            array("parent"=>$parent),
            "ORDER BY id ASC"
        );

        if($currentPageObjects)
        {
            foreach ($currentPageObjects as $key => $values)
            {
                $currentID=$values['id'];
                foreach($values as $name => $value)
                {
                    SELF::$SORTED_PAGE_OBJECTS[$currentID][$name] = $value;
                }
                SELF::$SORTED_PAGE_OBJECTS[$currentID]["INDENTATION"] = SELF::$INDENTATION;

                SELF::PREPARE_PAGE_OBJECTS(SELF::$SORTED_PAGE_OBJECTS[$currentID]['unique_id'],$DB); 
            }
        }
        SELF::$INDENTATION--;
    }

static function SELECT_PARENT($pageObjects,$currentObject = NULL)
    {
        $optionPairs = array(""=>"");
        foreach($pageObjects as $key => $values)
        {
            if(($values['unique_id']!=$currentObject) and 
            ($values['object_type']!="separator"))
            {   
                $indentation="";
                for($i=1;$i<$values['INDENTATION'];$i++) $indentation.="&nbsp;&nbsp;";
                $optionPairs[$indentation.$values['name']]=$values['unique_id'];
                $indentation=NULL;
            }

        }
        return $optionPairs;
    }
 
function BUILD_CONTENT()
{
    print_r($this);

}    

}
?>