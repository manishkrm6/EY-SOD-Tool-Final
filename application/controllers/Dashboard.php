<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Access_Controller {

	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}

	function dashboard(){
		
		$data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class' => 'active'] ];
		$this->layout->render('dashboard',$data);
	}

} // End Class