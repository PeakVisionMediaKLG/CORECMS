<?php

class PAGE
{
public $DB;
public $URL;
public $PAGEVALS;
public $ALL_PAGES_ARRAY;

    function __construct($url)
    {

    }

    static function ALL_PAGE_ITEMS($DB)
    {
        $page_items = $DB->RETRIEVE(
            "app_page_items",
            array(),
            array()
        );
        //print_r($page_items);

        $page_data = $DB->RETRIEVE(
            "app_page_data",
            array(),
            array()
        );
        //print_r($page_data);

        if($page_items)
        {
            for($i=0;$i<count($page_items);$i++)
            {
                if($page_data)
                {
                    $translations = array(); 
                    for($x=0;$x<count($page_data);$x++)
                    {
                        if($page_data[$x]['shared_id']==$page_items[$i]['id'])
                        {
                            array_push($translations, $page_data[$x]);
                        }
                    }
                    $page_items[$i]['attached_pages'] = $translations;
                }   
            }
        }
        return $page_items;
    }

}

?>