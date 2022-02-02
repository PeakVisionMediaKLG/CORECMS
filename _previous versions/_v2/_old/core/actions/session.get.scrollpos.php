<?php 
session_start(); 

echo $_SESSION['system']['scrollpos'] ?? 0;

unset($_SESSION['system']['scrollpos']);
unset($_SESSION['system']['scrolltime']);
?>