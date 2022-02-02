<?php 
session_start(); 

$_SESSION['system']['scrollpos']=$_POST['scrollpos'];
$_SESSION['system']['scrolltime']=$_POST['time'];

print_r($_SESSION);
?>