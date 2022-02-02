<?php

$CONFIG = array(
					// Domain Settings (for mail function, etc)
					"domain"            		=>  "localhost",

					// This array sets the basic database connection parameters.
					"mysqlServer"          	=>  "localhost",
					"mysqlDB"              	=>  "core-cms",
					"mysqlUser"            	=>  "root",
					"mysqlPassword"        	=>  "",
					"mysqlTablePrefix"    	=>  "",	// global prefix for all core-cms tables set during install

					"sessionSalt"			=> 	"core-salt", 	// Add-in for md5 encrypted user authentication variables		
					"mysqlEncryptionKey"    =>  "core-key",		// Encryption key for two-way MySQL dump encryption	
					"mysqlEncryptionSalt"   =>  "1234567891011121",		// Encryption SALT for two-way MySQL dump encryption	
                );
?>