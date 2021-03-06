<?php
// CORECMS - https://github.com/PeakVisionMediaKLG/CORECMS

$CONFIG = array(

    /* DATABASE CONNECTION*/
    "dbHost"          	            =>  "localhost",
	"dbName"              	        =>  "newcore",
	"dbUser"            	        =>  "root",
	"dbPassword"        	        =>  "",

    "dbTablePrefix"                 =>  "v3_",	
	"dbCharset"                     =>  "utf8mb4",
	"dbCollation"                   =>  "utf8mb4_general_ci",

	"dbGeneralLog"                  =>  0,
    "dbInternalLog"                 =>  0,
	"dbStrictMode"                  =>  1,
    "dbShowErrors"                  =>  1, 
    "dbShowMessages"                =>  0, 
	"dbAutoDumpOnLogin"             =>  0, 

	"dbSessionSalt"			        => 	"core-salt",        // Add-in for md5 encrypted user authentication variables
	"dbEncryptionKey"               =>  "core-key",         // Encryption key for two-way MySQL dump encryption
	"dbEncryptionSalt"              =>  "1234567891011121", // Encryption SALT for two-way MySQL dump encryption

    /* CORE SYSTEM VARIABLES */
    "coreProtocol"                  =>  "http://",
    "coreDomain"                    =>  "localhost/",

    /* Error Reporting for Javascript functions */
    "jQueryDebugToConsole"          =>  1,
    "jQueryDebugToDocument"         =>  0,

    "useCDN"                        =>  1,
);

?>