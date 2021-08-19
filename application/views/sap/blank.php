<!DOCTYPE html>
<html>
<head>

	<style>
h1 {text-align: center;}
p {text-align: left;}
div {text-align: center;}
</style>


	<title>
		Audit tool V1.0 
	</title>
</head>
<body>
			<p><b>STEP1 : Check SAP connectivity </b></p>

			<form action="blank.php" method="post">
			<input type="submit" name="someAction" value="Check SAP connectivity" />
			</form>

			






<?php

require 'import_structure.php';
require 'function_download_tables.php' ;

$file = "upload/";
$database = "test_sap";

 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['someAction']))
    {


$result = sapconnectionokornot( );


print $result ;

	}

?>

<p><b> STEP 2 :Kindly ensure one time setting ( Downloading Tables from SAP) else proceed to step 3  <br><br>

				
<p><b> STEP 3 :Kindly Input Coloumn Names and its Value in Left Form . Exmple is as follows </b></p> 
			<p> Lets say if you want to search following :<br>
			 Value 100 , 200 , 300 in all Coloums by name of "GROUP" 
			 then value aaa, bbb, ccc in coloun "GROUP2" 
			 and 2320 in "GROUP3"  
			 in Database "test_database" then<br><br>

				<b>Database:</b> test_database<br>
				<b>input coloumn Name :</b>  GROUP,GROUP2,GROUP3<br>
				<b>input Search Value :</b>  100:200:300,aaa:bbb:ccc,2320<br>
				
</body>
</html>