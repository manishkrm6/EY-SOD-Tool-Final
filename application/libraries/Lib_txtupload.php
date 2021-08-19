<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_txtupload extends CI_Controller {
    
    private $CI;

 	function __construct()
    {
      $this->CI = get_instance();
    }

    //function sanitize

    function import_textdb($param){
        
        $handle = fopen($param['target_file'], 'r');
    	$col = [];

        //pr($param); die;


    	$index_arr = [];
    	$line_cntr = 0;
        $num_saved_entry = 0;

        // May Prepare Upto 10 Thousands OF Records at One Time to write into fresh file
        $bulk_batch = [];

    	while ( $line = fgets($handle) ){

			if( strpos($line, '|') !== false ){

    			$line_arr = !empty($line) ? array_map('trim',array_filter(explode('|',$line))) : array();

    			// It Means Column
    			if( $line_cntr == 0){
    			    
                    $col = $line_arr;
    				foreach ( $param['target_columns'] as $key_val) {
    					$index = array_search($key_val, $col);
    					if($index)
    						array_push($index_arr, $index);
    				} // End Foreach Loop

    			} // End IF
    			else{

                    // $i goes through each column in each single line
                    $i = 0;

                    // Insert Array Captures Each Single Line Into Array
                    $insert_array = [];

                    //pr($line_arr); die;

    				foreach ($index_arr as $index_seq) {

    					$value = isset($line_arr[$index_seq]) ? $line_arr[$index_seq] : NULL;

                        // IF Date Columns
                        if ( preg_match('/^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$/', $value ) ){

                            $value = str_replace('.', '-', $value);

                            // Below 2 Lines are added after Realizing default support date and year upto 2037

                            $value = new DateTime($value);
                            $value =  $value->format('Y-m-d');

                            //$value = date('Y-m-d',strtotime($value));
                            $value = str_replace('-','', $value);
                        }

                        // 

                        $insert_array[$i] = addslashes($value);
    					$i++;

    				} // End Foreach Loop

                    // Insert On Table

                    if(!empty($insert_array)){

                        // Below Line prepare refined String intended to write into fresh file
                        $insert_array_str = '|'.implode('|', $insert_array).'|';
                        
                        array_push($bulk_batch, $insert_array_str);

                        //pr($bulk_batch); die;

                        if( 10000 == count($bulk_batch) ){

                            $bulk_batch_str = implode(PHP_EOL,$bulk_batch);

                            // Sanitization Logic inherited from EY Extractor Tools
                                $bulk_batch_str = str_replace("'","", $bulk_batch_str);
                                $bulk_batch_str = str_replace("`","", $bulk_batch_str);
                                $bulk_batch_str = str_replace(",","", $bulk_batch_str);
                                $bulk_batch_str = str_replace(" ","", $bulk_batch_str);
                                $bulk_batch_str = str_replace("\�","�", $bulk_batch_str);
                                $bulk_batch_str = str_replace("�", "','", $bulk_batch_str);


                            $myfile = file_put_contents($param['destination_file'], $bulk_batch_str.PHP_EOL, FILE_APPEND | LOCK_EX);

                            $bulk_batch_str = '';
                            $bulk_batch = [];

                            $num_saved_entry += 10000;

                        } // End IF

                    } // End IF

    			} // End Else
    			
                $line_cntr++;

    		} // End IF Parsing |

    	} // End While	 

        // IF IT Still Contains Some Values Then also Write Rest Lines into File
        if(!empty($bulk_batch)){    

            $bulk_batch_str = implode(PHP_EOL,$bulk_batch);

            $bulk_batch_str = str_replace("'","", $bulk_batch_str);
            $bulk_batch_str = str_replace("`","", $bulk_batch_str);
            $bulk_batch_str = str_replace(",","", $bulk_batch_str);
            $bulk_batch_str = str_replace(" ","", $bulk_batch_str);
            $bulk_batch_str = str_replace("\�","�", $bulk_batch_str);
            $bulk_batch_str = str_replace("�", "','", $bulk_batch_str);

            $myfile = file_put_contents($param['destination_file'], $bulk_batch_str.PHP_EOL, FILE_APPEND | LOCK_EX);

            $num_saved_entry += count($bulk_batch);
            
            $bulk_batch_str = '';
            $bulk_batch = [];

        } // 

    	
        return $num_saved_entry; 

    } // End Function

} // End Class