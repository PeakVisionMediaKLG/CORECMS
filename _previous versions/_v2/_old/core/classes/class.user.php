<?php

class USER
{
	
	public  $DB;
	public	$USER_AUTH_OK;	
	public	$IS_ADMIN; 
	public	$USERVALS;
	public	$THE_USER;
	private	$SALT;
	
	function __construct($DB,$LANGUAGE="EN")
        {
            include('txt/'.$LANGUAGE.'.php');
            $this->TXT = $TXT;
            $this->DB = $DB;
            $this->SALT = $this->DB->SETTINGS['session_salt'];

            $this->ERROR_RESPONSE=0;
            if($this->CHECK_SESSION_STATE()) $this->INITIALIZE_USER();
        }

    function INITIALIZE_USER()
        {   //Prep_Query - $query,$table,$columns,$parameters,$reporting
            $this->USERVALS = $this->DB->PREP_QUERY("SELECT * FROM users WHERE uIdentifier=? ",'users',array('uIdentifier'),array($_SESSION['user']['session_identifier']),0); 
            $this->USERVALS = $this->USERVALS->fetch_array();
        
            $this->DB->SESSIONDATA->SET_VAL('user','uLanguage',$this->USERVALS['uLanguage']);
        
            if($this->USERVALS['uAdmin']) $this->IS_ADMIN=1; else $this->IS_ADMIN=0;
        }
	
	function GET_USERVAL($which_val)
        {
            if(isset($this->USERVALS[$which_val])) return $this->USERVALS[$which_val];
        }
	
	function VERIFY_LOGIN_DATA($user,$password)        
        {
                if ((isset($user) && isset($password)) and ($user <> "" and $password <> "")) {
                    // if user sent form

                    $user = $this->DB->ESCAPE($user);
                    $password = $this->DB->ESCAPE($password);
                    
	                //Prep_Query - $query,$table,$columns,$parameters,$reporting
                    $result=$this->DB->PREP_QUERY('SELECT * FROM users WHERE uUser=? AND uPassword= ? LIMIT 1','users',array('uUser','uPassword'),array($user,md5($password)),@$DB->SETTINGS['mysqlErrorReporting']);

                        if (mysqli_num_rows($result) > 0) { 

                            //if user is legit
                            $identifier = md5($this->SALT . md5($user . $this->SALT));
                            $_SESSION['user']['session_identifier'] = $identifier;

                            $validate_user_db = $this->DB->PREP_QUERY("UPDATE users SET uIdentifier = ? WHERE uUser = ?", "users", array('uIdentifier','uUser'), array($identifier,$user), @$DB->SETTINGS['mysqlErrorReporting']); 
                            
                            $this->USER_AUTH_OK=1;
                            $this->INITIALIZE_USER();
                            return 1;
                        }
                        else 
                        { 
                            $this->USER_AUTH_OK=0; $this->ERROR_RESPONSE=1;
                        }
                }
                else {
                    $this->USER_AUTH_OK=0; $this->ERROR_RESPONSE=2;
                }
        }
	
    function CHECK_SESSION_STATE()
        {
            if (isset($_SESSION['user']['session_identifier'])){

                $this->THE_USER = $_SESSION['user']['session_identifier'];
                $this->USER_AUTH_OK = 1;	

                $this->INITIALIZE_USER();

                if (!isset($_SESSION['interface']["show_toolbar"])) $_SESSION['interface']["show_toolbar"]=1;
                return 1;
            }
            else 
            {	
                if(!@isset($_POST['signin']))
                {
                    $this->SIGNOUT('check_session_state');
                }
                $this->USER_AUTH_OK=0;
                return 0;
            }
        }

    function SHOW_TO_ADMIN()
        {
            if($this->IS_ADMIN and (@$_SESSION['interface']['show_toolbar']==1)) return 1; else return 0;
        }

	function SHOW_TO_ALL()
        {
            if($this->USER_AUTH_OK and (@$_SESSION['interface']['show_toolbar']==1)) return 1; else return 0;	
        }

	function SIGNOUT($calledwhere)
        {
        //echo "signout called ".$calledwhere;
        session_unset();
        @session_destroy();

        $this->USER_AUTH_OK=0;
        }
}

?>