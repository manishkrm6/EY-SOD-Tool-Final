<?php
	
	if( !function_exists('getTimeDifference') ){

		function getTimeDifference($fromdatetime,$todatetime){
		    
		    $start_date = new DateTime($fromdatetime);
		    $end_date   = new DateTime($todatetime);
		    $interval   = $start_date->diff($end_date);

		    //pr($interval); die;

		    return $interval->h." Hour ".$interval->i." Minute ".$interval->s." Seconds";

  		}

	} // End Helper

	if( !function_exists('emptyFolderFiles') ){

		function emptyFolderFiles($dir_path){
			
			$files = glob($dir_path.'/*');

			foreach($files as $file){ // iterate files
			  if(is_file($file)) {
			    unlink($file); // delete file
			  }
			}

		} // 

	} // End IF Helper Fn


	if( !function_exists('fileExists') ){

		function fileExists($fileName, $caseSensitive = false) {

		    if(file_exists($fileName)) {
		        return $fileName;
		    }

		    if($caseSensitive) return false;

		    // Handle case insensitive requests            
		    $directoryName = dirname($fileName);
		    $fileArray = glob($directoryName . '/*', GLOB_NOSORT);
		    $fileNameLowerCase = strtolower($fileName);
		    foreach($fileArray as $file) {
		        if(strtolower($file) == $fileNameLowerCase) {
		            return $file;
		        }
		    }
		    return false;
		}

	} // End Helper
	
	if( !function_exists('formatBytes') ){

		function formatBytes($bytes, $precision = 2) { 

	    	$units = array("b", "kb", "mb", "gb", "tb"); 
		    $bytes = max($bytes, 0); 
		    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		    $pow = min($pow, count($units) - 1); 
		    $bytes /= (1 << (10 * $pow)); 

		    return round($bytes, $precision) . " " . $units[$pow]; 
		}

	} // End Helper Fn

	if( !function_exists('displayOutput') ){
		function displayOutput($input) {
			echo "<span style='position: absolute;z-index;background:#FFF; font-size: 30px; cursor: default;' class='btn btn-default'> " . $input . "</span>";
		    myFlush();
		}
	} // End Helper Fn

	if( !function_exists('outputProgress') ){
		function outputProgress($current, $total) {
		    echo "<span style='position: absolute;z-index:$current;background:#FFF; font-size: 30px; cursor: default;' class='btn btn-default'> " . round($current / $total * 100) . "% Data Processed</span>";
		    myFlush();
		    
		}
	} // End Helper Fn

	if( !function_exists('myFlush') ){

		function myFlush() {
		    echo(str_repeat(' ', 256));
		    if (@ob_get_contents()) {
		        @ob_end_flush();
		    }
		    flush();
		}

	} // End Helper Fn

	if ( !function_exists('getProceduresListFiles') ) {

		function getProceduresListFiles(){

			$list_sql_files = [];
			$handle = fopen(FCPATH."uploads/list_procedures.txt", "r");

			if ($handle) {
    			while (($line = fgets($handle)) !== false) {
        			// process the line read.
        			array_push($list_sql_files, $line);
        		}
    			fclose($handle);
			} 
			else {
    			// error opening the file.
			}
			return $list_sql_files;
			
		} // End Function

	} // End IF


	if( !function_exists('getTableLines') ){

		function getTableLines(){
			
			$list_sql_files = [];

			$handle = fopen(FCPATH."uploads/list_tables.txt", "r");
			if ($handle) {
    			while (($line = fgets($handle)) !== false) {
        			// process the line read.
        			array_push($list_sql_files, $line);
        		}
    			fclose($handle);
			} 
			else {
    			// error opening the file.
			}

			return $list_sql_files;

		} // End Function

	} // End IF

	if( !function_exists('get_total_files_in_directory') ){
		
		function  get_total_files_in_directory($folder_name, $type){
			
			$folder_filesAr = [];
			$folder_files = scandir($folder_name);
			
			$count = 0;
			foreach ($folder_files as $key => $file) {
				
				$file_ext = pathinfo($file,PATHINFO_EXTENSION);
                if( strcasecmp($file_ext,$type) == 0 ) {
					$count++;
				}
			}
			return $count;
		}

	} // End IF


	if( !function_exists('get_folder_files_with_extension') ){

		function get_folder_files_with_extension($folder_name,$file_type=""){

			$folder_filesAr = [];
				$folder_files = scandir($folder_name);

				foreach ($folder_files as $key => $file) {
					
					$file_name = strtolower($file);
					$file_ext = pathinfo($file_name,PATHINFO_EXTENSION);

					if(!empty($file_name) && $file_name != '.' && $file_name != '..'   ){
						
						if($file_type == "")
							array_push($folder_filesAr, $file_name);
						else if ( strcasecmp($file_ext,$file_type) == 0 )
							array_push($folder_filesAr, $file_name);
					}
				    	
				    

				}
				return $folder_filesAr;

		} // End Function

	} // 


	if( !function_exists('get_folder_files') ){
		
		function get_folder_files($folder_name){
				
				$folder_filesAr = [];
				$folder_files = scandir($folder_name);

				foreach ($folder_files as $key => $file) {
					
					$file_name = strtolower($file);
				    $file_name = explode('.',$file_name);
				    $file_name = $file_name[0];
				    
				    if(!empty($file_name))
				    	array_push($folder_filesAr, $file_name);
				    

				}
				return $folder_filesAr;
			}
	}

	

		if( !function_exists('isValidDate') ){

			function isValidDate($str_date){ 
				
				if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str_date)) {
		    		return true;
				} 
				else {
		    		return false;
				}
			} 

		} // End Helper Function

		if( !function_exists('isValidEmail') ){

			function isValidEmail($email){ 
				return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
			}
		}

		if(!function_exists('short_date_format')){
			
			function short_date_format($params)
			{
			   $date = new DateTime($params);
		       $date = $date->format('d-M-Y');

		       return $date;

			   /*$date = date('d-M-y', strtotime($params));
			   return $date;*/
			}	

		} // End Helper Function 

		if(!function_exists('array_has_duplicates')){
			
			function array_has_duplicates($array) {
		   		return count($array) !== count(array_unique($array));
			}

		} // End Helper Function

		if(!function_exists('short_date_format_ampm')){

			function short_date_format_ampm($params) 
			{       
				if($params == NULL)
			    	return NULL;
			       
				$date = date('d-M-y h:i A', strtotime($params));	   
				return $date; 

			}

		} // End Helper Fn

		if(!function_exists('id_decode')){

			function id_decode($id){
				$id = $id . str_repeat('=', strlen($id) % 4); #create complete base64 code.
				$id = substr(base64_decode($id),6); # decode & remove salt from the start.
				$decoded_id = substr($id,0,-6); # remove salt from the end.
				return $decoded_id;
			}
		} // End Helper Fn
		

		if(!function_exists('id_encode')){

			function id_encode($id){
				$encoded_id = rtrim(base64_encode(SALT.$id.SALT),'='); # add salt in id, convert it into base64 and remove == from base64 id
				return $encoded_id;
			}

		} // End Helper Fn

		if(!function_exists('pr')){

			function pr($arg)
			{
				 echo "<pre>";
				 print_r($arg);
				 echo "<pre>";
			}

		} // End Helper Function 

