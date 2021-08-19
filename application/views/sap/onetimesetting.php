<!DOCTYPE html>
<html>
<head>

	<style>
h1 {text-align: center;}
p {text-align: left;}
div {text-align: center;}
</style>


<?php

// require 'import_structure.php';
// require 'example-sap-multiple-tables-write.php';


// $file = "upload/";
// $database = "test_sap";

//  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['someAction']))
//     {

// $pathname = "upload";
// $database1 = "test_sap";

//$result = sapconnectionimport_tables("table-ddl.txt");

//$result = sapconnectionimport_tables("table-ddl.txt",$pathname);

//$result = truncate_tables_folder($pathname,$database1);

//$result = import_file_folder($pathname,$database1);


//print $result ;

//exit();
// 	}

// 	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ddlimportinsql']))
//     {

// $pathname = "upload";
// $database1 = "test_sap";


// $result = truncate_tables_folder($pathname,$database1);

// $result = import_file_folder($pathname,$database1);



// print $result ;

// 	}


?>

<title>
		Audit tool V1.0 
	</title>
</head>
<body>

<p><b>One Time DB Settings : </b></p>

			<form action="index.php" method="post" target = "main_page">
			<input type="submit" name="sapsetting" value="Manage Analysis "style="height:30px; width:170px" />
			</form>

			<form action="sap_table_structure.php" method="post" target = "main_page">
			<input type="submit" name="filesexportinfile" value="Download Table Structure" style="height:30px; width:170px" /> <br>
			</form>
		

			<form action="sap_table_structure.php" method="post" target = "main_page">
			<input type="submit" name="filesimportinsql2" value="Download Table (All)"style="height:30px; width:170px" />
			</form>



<p><b>Clear Tables  </b></p>

			<form action="sap_table_structure.php" method="post" target = "main_page">
			<input type="submit" name="truncatetablesall" value="Initialize Analysis"style="height:30px; width:170px" />
			</form>
			<form action="sap_table_structure.php" method="post" target = "main_page">
			<input type="submit" name="truncatetablestructure" value="Delete Table Structure" style="height:30px; width:170px" /> <br>
			</form>
			<br>


<p><b>Results   </b></p>

			<form action="results_analysis.php" method="post" target = "main_page">
			<input type="submit" name="results" value="Results"style="height:30px; width:170px" />
			</form>
			
				

</body>
</html>