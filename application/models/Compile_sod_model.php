<?php

class Compile_sod_model extends CI_Model {

	public $app_db;
	
	public function __construct()
    {
    	parent::__construct();
    }

   public function getRiskID()
	{
	   $SQL="SELECT riskid from sod_risk";    
       $query = $this->db->query($SQL);
       return $query->result();
	 
	}
	
	public function getAct1($riskid)
	{
	   $SQL="SELECT b.tcode as tcode1 from sod_risk as a LEFT JOIN actcode as b ON a.act1 = b.activity WHERE a.riskid ='".$riskid."' ORDER by a.riskid ASC";
       $query = $this->db->query($SQL);
       return $query;
       
	}
	
	public function getAct2($riskid)
	{
	   $SQL="SELECT b.tcode as tcode2 from sod_risk as a LEFT JOIN actcode as b ON a.act2=b.activity WHERE a.riskid ='".$riskid."' ORDER by a.riskid ASC";
       $query = $this->db->query($SQL);
       return $query;
	}
	
	public function getAct3($riskid)
	{
	   $SQL="SELECT b.tcode as tcode3 from sod_risk as a LEFT JOIN actcode as b ON a.act3=b.activity WHERE a.riskid ='".$riskid."' ORDER by a.riskid ASC";
       $query = $this->db->query($SQL);
	    return $query;
     
	}
	public function getMaxid()
	{
	   $SQL="SELECT max(`CONFLICTID`) as CONFLICTID FROM .`conflicts_c1`";
       $query = $this->db->query($SQL);
	    return $query;
      
	}
	public function val1_Conflict($conflict_c_id_Generator,$value)
	{
	   $SQL="INSERT into conflicts_c1(CONFLICTID, OBJCT, FIELD, VALUE) VALUES ('$conflict_c_id_Generator', 'S_TCODE', 'TCD', '$value')";
       return $query = $this->db->query($SQL);
    
	}
	public function val2_Conflict($conflict_c_id_Generator,$value)
	{
	   $SQL="INSERT into conflicts_c1(CONFLICTID, OBJCT, FIELD, VALUE) VALUES ('$conflict_c_id_Generator', 'S_TCODE', 'TCD', '$value')";
      return $query = $this->db->query($SQL);
     
 
	}

}//class end here.
?>
