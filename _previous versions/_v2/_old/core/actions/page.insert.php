<?php 
include_once("../actions/session.check.php");
include_once("../classes/class.sanitizer.php");
$SANI= new SANITIZER();

$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');

if($USER->USER_AUTH_OK) {
    $the_author = $USER->USERVALS['uUser'];

    header("Cache-Control: no-cache");

    $pLanguage=$_POST["core-page-set-language"] ?? $pLanguage="";
    $pParent=$_POST["core-page-set-parent"] ?? $pParent="";
    $pTitle=$_POST["core-page-set-title"] ?? $pTitle="";

    if($pTitle=="") die('no title sent');

    /*function CLEAN_URL($url) {
       $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
       $url = trim($url, "-");
       $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
       $url = strtolower($url);
       $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
       return $url;
    }*/

    $checkifexistssql="SELECT pURL FROM pages WHERE pURL='$pTitle'";
    $checkifexistsresult = $DB->SINGLE_ROW($checkifexistssql);

    if(@$checkifexistsresult['pURL']==$pTitle)
    {
        //$pURL=CLEAN_URL($pTitle).time();
        $pURL=$SANI->CLEAN($pTitle,'url').time();
    }
    else
    {
        //$pURL=CLEAN_URL($pTitle);
        $pURL=$SANI->CLEAN($pTitle,'url');
    }

    $max_pPos_sql="SELECT MAX(pNavPosition) FROM pages";
    $max_pPos = $DB->SINGLE_ROW($max_pPos_sql);
    $max_pPos = $max_pPos[0];
    $max_pPos++;
    
    $pSharedID=$pTitle.time();

    $config_languages = $DB->MULTI_ROW('SELECT * FROM languages');
                
    while($config_language = $config_languages->fetch_array()){

        $query = $DB->PREP_QUERY ("INSERT INTO pages (pParent,
                                                        pSharedID,
                                                        pURL,
                                                        pLanguage,
                                                        pPageType,
                                                        pGroupMember,
                                                        pStyle,
                                                        pLinkText,
                                                        pTitle,
                                                        pDescription,
                                                        pKeywords,
                                                        pShowInNav,
                                                        pNavPosition,
                                                        pAuthAccessOnly,
                                                        pMenuItemOnly,
                                                        pActive,
                                                        pDate,
                                                        pAuthor,
                                                        pLastEditor,
                                                        pDeleted,
                                                        pAccessCounter) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                  "pages",
                                  array('pParent',
                                        'pSharedID',
                                        'pURL',
                                        'pLanguage',
                                        'pPageType',
                                        'pGroupMember',
                                        'pStyle',
                                        'pLinkText',
                                        'pTitle',
                                        'pDescription',
                                        'pKeywords',
                                        'pShowInNav',
                                        'pNavPosition',
                                        'pAuthAccessOnly',
                                        'pMenuItemOnly',
                                        'pActive',
                                        'pDate',
                                        'pAuthor',
                                        'pLastEditor',
                                        'pDeleted',
                                        'pAccessCounter'),
                                  array($pParent,
                                        $pSharedID,
                                        $pURL."_".$config_language['lLanguageCode'],
                                        $config_language['lLanguageCode'],
                                        "",
                                        "",
                                        "",
                                        $pTitle,
                                        $pTitle,
                                        "",
                                        "",
                                        1,
                                        intval($max_pPos),                                        
                                        0,
                                        0,
                                        0,
                                        time(),
                                        $the_author,
                                        $the_author,
                                        0,
                                        0),@$DB->SETTINGS['mysqlErrorReporting']);

        
        }
    echo $query;
    if($query) $DB->SESSIONDATA->SET_VAL('alert_once_success','insert_page'.time(),$TXT['The following page has been successfully created:']." <b>".$pTitle."</b>"); else $DB->SESSIONDATA->SET_VAL('alert_once_fail','insert_page'.time(),$TXT['The following page could not be created:']." <b>".$pTitle."</b>");

} else {echo "unauthorized access"; exit;}

?>