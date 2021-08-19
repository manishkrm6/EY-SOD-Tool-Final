<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CustomReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {

	function __construct(){
		// initialize
	}

	 public function readCell($column, $row, $worksheetName = '') {
		// Read title row and rows 100
        if ( $row >= 1 && $row <= (MAX_IMPORT_ROW + 1) ) {
            return true;        
        }
		return false;

    } // End Function 

} // End Class

class Access_Controller extends CI_Controller {

	function __construct()
    {
		parent::__construct();
		if( !isset($_SESSION['uid']) )
    		redirect(base_url());
    }

	public function dump_sod($data, $path = FCPATH.'/uploads/sod_dump.xlsx' ){
		
		$styleArray = [
		    'font' => [
		        'bold' => true,
		    ],
		 	'fill' => [
		        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
		        'startColor' => [
            		'argb' => 'e3ff7f',
        		],
		    ],

		];


		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->setPreCalculateFormulas(false);

		// Create a new worksheet called "Worksheet Actcode"
		$actcodeWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'actcode');
		// Attach the "Line Item" worksheet as the first worksheet in the Spreadsheet object
		$spreadsheet->addSheet($actcodeWorkSheet, 1);

		// Create a new worksheet called "Worksheet Sod risk"
		$sodRiskWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'sod_risk');
		// Attach the "Line Item" worksheet as the first worksheet in the Spreadsheet object
		$spreadsheet->addSheet($sodRiskWorkSheet, 2);

		$spreadsheet->setActiveSheetIndexByName('Worksheet');
		$sheetIndex = $spreadsheet->getActiveSheetIndex();
		$spreadsheet->removeSheetByIndex($sheetIndex);


		$spreadsheet->getSheetByName('actcode')
		->setCellValue('A1', 'S.No.');
		$spreadsheet->getSheetByName('actcode')->getStyle('A1')->applyFromArray($styleArray);
		$spreadsheet->getSheetByName('actcode')->getColumnDimension('A')->setAutoSize(true);

		$spreadsheet->getSheetByName('actcode')
		->setCellValue('B1', 'Activity');
		$spreadsheet->getSheetByName('actcode')->getStyle('B1')->applyFromArray($styleArray);
		$spreadsheet->getSheetByName('actcode')->getColumnDimension('B')->setAutoSize(true);

		$spreadsheet->getSheetByName('actcode')
		->setCellValue('C1', 'Tcode');
		$spreadsheet->getSheetByName('actcode')->getStyle('C1')->applyFromArray($styleArray);
		$spreadsheet->getSheetByName('actcode')->getColumnDimension('C')->setAutoSize(true);

		$spreadsheet->getSheetByName('actcode')
		->setCellValue('A2', '1');

		$spreadsheet->getSheetByName('actcode')
		->setCellValue('B2', 'Act1');

		$spreadsheet->getSheetByName('actcode')
		->setCellValue('C2', 'ME21N');


		$spreadsheet->getSheetByName('sod_risk')
		->setCellValue('A1', 'S.No.');
		$spreadsheet->getSheetByName('sod_risk')->getStyle('A1')->applyFromArray($styleArray);
		$spreadsheet->getSheetByName('sod_risk')->getColumnDimension('A')->setAutoSize(true);

		$spreadsheet->getSheetByName('sod_risk')
		->setCellValue('B1', 'Conflict Id');
		$spreadsheet->getSheetByName('sod_risk')->getStyle('B1')->applyFromArray($styleArray);
		$spreadsheet->getSheetByName('sod_risk')->getColumnDimension('B')->setAutoSize(true);

		
		$spreadsheet->getSheetByName('sod_risk')
		->setCellValue('A2', '1');

		$spreadsheet->getSheetByName('sod_risk')
		->setCellValue('A2', 'XXCC001');

		
		$writer->save($path);
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);
		
		$this->load->helper('download');
		force_download($path, NULL);
		

	}

	public function get_sheet_names(){
		
		$sheetNames = [];

		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if(isset($_FILES["userfile"]['tmp_name']) && isset($_FILES["userfile"]['type']) && in_array($_FILES["userfile"]['type'], $file_mimes)){

			$arr_file = explode('.', $_FILES['userfile']['name']);
	    	$extension = end($arr_file);

			switch ($extension) {
	    		case 'csv':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter() );
			        $spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
					$sheetNames = $spreadsheet->getSheetNames();
	    			break;
	    		case 'xlsx':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter() );
			        $spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
			    	
					$sheetNames = $spreadsheet->getSheetNames();
					
			    	break;
	    		case 'xls':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter());
					$spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
					$sheetNames = $spreadsheet->getSheetNames();

	    			break;    		
	    		
	    	} // End Switch Case
		}

		return $sheetNames;

	} // End Function

	public function get_excel_data_by_sheet_name($sheetName = ''){

		
		$csvData = NULL;				
		
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if(isset($_FILES["userfile"]['tmp_name']) && isset($_FILES["userfile"]['type']) && in_array($_FILES["userfile"]['type'], $file_mimes)){

			$arr_file = explode('.', $_FILES['userfile']['name']);
	    	$extension = end($arr_file);

	    	switch ($extension) {
	    		case 'csv':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter() );
			        $spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
					//$csvData = $spreadsheet->getActiveSheet()->toArray();
					$csvData = $spreadsheet->getSheetByName($sheetName)->toArray();
	    			break;
	    		case 'xlsx':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter() );
			        $spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
			    	//$csvData = $spreadsheet->getActiveSheet()->toArray();
					$csvData = $spreadsheet->getSheetByName($sheetName)->toArray();
			    	break;
	    		case 'xls':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter());
					$spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
					//$csvData = $spreadsheet->getActiveSheet()->toArray();
					$csvData = $spreadsheet->getSheetByName($sheetName)->toArray();
	    			break;    		
	    		
	    	} // End Switch Case

	    	

	    	return $csvData; 
		}

		return $csvData; 	

	} // End Function



    public function import_csv_data(){

		
		$csvData = NULL;				
		
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if(isset($_FILES["userfile"]['tmp_name']) && isset($_FILES["userfile"]['type']) && in_array($_FILES["userfile"]['type'], $file_mimes)){

			$arr_file = explode('.', $_FILES['userfile']['name']);
	    	$extension = end($arr_file);

	    	switch ($extension) {
	    		case 'csv':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter() );
			        $spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
					$csvData = $spreadsheet->getActiveSheet()->toArray();
	    			break;
	    		case 'xlsx':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter() );
			        $spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
			    	$csvData = $spreadsheet->getActiveSheet()->toArray();
			    	break;
	    		case 'xls':
	    			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			        $reader->setReadDataOnly(true);
			        $reader->setReadFilter( new CustomReadFilter());
					$spreadsheet = $reader->load($_FILES['userfile']['tmp_name']);
					$csvData = $spreadsheet->getActiveSheet()->toArray();
	    			break;    		
	    		
	    	} // End Switch Case

	    	/*$filtered_csv_data = array();
	    	if(!empty($csvData)){
	    		for($i = 0; $i <= 31; $i++){
	    			$tf = isset($csvData[$i]) ? array_push($filtered_csv_data, $csvData[$i]) : false;
	    		}
	    	}*/

	    	return $csvData; 
		}

		return $csvData; 	
	}
	
}