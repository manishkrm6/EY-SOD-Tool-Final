

<!DOCTYPE html>
<html>
<head>
	<title>Left bottom-File List</title>
</head>
<body>
<?php
require 'import_structure.php';
error_reporting(E_ERROR | E_PARSE);
ob_implicit_flush(1);



if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['showresults']))
    {
if (isset($_POST['id'])) $id = trim($_POST['id']);
if (isset($_POST['database_no'])) $database = trim($_POST['database_no']);

// echo "number:". $database."<br>"; 
// echo "ID is :". $id."<br>"; 

//$database_no = getActdatabaseno();
$foldername = "test/".$id;
$database1 = "test_sap".$database;
$path = __DIR__."/".$database."/".$foldername;
echo "<br>";

echo "<br>";
echo "<br>";
echo "<br>";

print " Click to Download <br>";
print " or check <br>";
print  $path."<br>";

$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..', 'del'));

if (count($files) == 0) die();
  echo "<table border=\"1\">\n";
  echo "<thead>\n";
  echo "<tr><th>Sno</th><th>Name</th></tr>\n";
  echo "</thead>\n";
  echo "<tbody>\n";
  $sno =1;

  $no =0;
  
  foreach($files as $file) {
    echo "<tr>\n";
    echo "<td>".$sno++."</td>\n";
    echo "<td>";
   echo "<a href=$path$file download >$file </a>";
   // echo "<td>{$file['size']}</td>\n";
 //   echo "<td>",date('r', $file['lastmod']),"</td>\n";
    echo "</tr>\n";
  }
  echo "</tbody>\n";
  echo "</table>\n\n";



  }

//$path    = 'test/';

// foreach($files as $file){
//   echo "<a href=$path$file download >$file </a>";
//   echo "<br>";
// }



//$dir = "test";

// Sort in ascending order - this is default
//$a = scandir($dir);

// $dirlist = getFileList("test");
// //  echo "<pre>",print_r($dirlist[$name]),"</pre>";

// // output file list in HTML TABLE format

// // echo "<a href="."file:///localhost/test.txt" ."  download >link text</a>";

 


// function getFileList($dir)
//   {
//     // array to hold return value
//     $retval = [];

//     // add trailing slash if missing
//     if(substr($dir, -1) != "/") {
//       $dir .= "/";
//     }

//     // open pointer to directory and read list of files
//     $d = @dir($dir) or die("getFileList: Failed opening directory {$dir} for reading");
//     while(FALSE !== ($entry = $d->read())) {
//       // skip hidden files
//       if($entry{0} == ".") continue;
//       if(is_dir("{$dir}{$entry}")) {
//         $retval[] = [
//           'name' => "{$dir}{$entry}/",
//           'type' => filetype("{$dir}{$entry}"),
//           'size' => 0,
//           'lastmod' => filemtime("{$dir}{$entry}")
//         ];
//       } elseif(is_readable("{$dir}{$entry}")) {
//         $retval[] = [
//           'name' => "{$dir}{$entry}",
//           'type' => mime_content_type("{$dir}{$entry}"),
//           'size' => filesize("{$dir}{$entry}"),
//           'lastmod' => filemtime("{$dir}{$entry}")
//         ];
//       }
//     }
//     $d->close();

//     return $retval;
 // }

 ?>
