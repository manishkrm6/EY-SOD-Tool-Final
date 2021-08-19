

<!DOCTYPE html>
<html>
<head>
	<title>Left bottom-File List</title>
</head>
<body>
<?php
session_start();
require 'import_structure.php';

header("refresh: 3"); 
//print_r($_SESSION);
error_reporting(E_ERROR | E_PARSE);
ob_implicit_flush(1);

$database_no = getActdatabaseno();


if (!isset($database_no)) {echo " NO database found "; die();} 
$database = "test_sap".$database_no;
$path = $database_no."/test/";
$Analysis_name = get_analysis_name($database_no);

echo "<span class='edit_btn'> Analysis Name: ".$Analysis_name ."<br>".'</span>' ;
print "Number :".$database_no ;

?>





 
