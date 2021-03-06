<?php

class Common_model extends CI_Model {

	public $app_db;
	
	public function __construct()
    {
    	parent::__construct();
    }

    function run_app_query($query){
		
		$result = [];

		$result['error_code'] = NULL;
		$result['error_message'] = NULL;
		$result['success'] = 0;

		try{
			
			$this->app_db->trans_start(FALSE);
				$query_result = $this->app_db->query($query);
				$db_error = $this->app_db->error();
			$this->app_db->trans_complete();

			if(!empty($db_error['code'])){
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
            		return false; // unreachable retrun statement !!!
			}
			else{
				$result['success'] = 1;
			}

		}
		catch(\Exception $e){

			$result['error_code'] = $db_error['code'];
			$result['error_message'] = $db_error['message'];
			$result['success'] = 0;
		}

		return $result;

	} // End Function


	function get_entry_by_data($table_name, $single = false, $data = array(),$select="",$order_by='',$orderby_field='',$limit='',$offset=0) {

	 	if(!empty($select)){
	 		$this->app_db->select($select);
	 	}

        if (empty($data)){

          	$id = $this->input->post('id');

          	if ( ! $id ) return false;

            $data = array('id' => $id);

        }

        if(!empty($limit)){
        	$this->app_db->limit($limit,$offset);
        }

        if(!empty($order_by) && !empty($orderby_field)){

        	$this->app_db->order_by($orderby_field,$order_by);
        }



        $query = $this->app_db->get_where($table_name, $data);

        

        $res = $query->result_array();

        //echo $this->app_db->last_query();exit;

        if (!empty($res)) {

            if ($single)
                return $res[0];
			else
                return $res;
        }

        else
            return false;
    }

	function save_entry($table_name, $data, $key_field = 'id', $id = false) {
    if (!empty($id))
    {
      if (!empty($data) and $this->app_db->update($table_name, $data, array($key_field => $id)))
      {
				$query = $this->app_db->get_where($table_name, array($key_field => $id));

				$result = $query->result_array();

				return (!empty($result)) ? $result[0] : false;
			}
			else
      {
        return false;
      }
    }
    else
		{
      if ($this->app_db->insert($table_name, $data)) 
			{
        return $this->get_entry_by_data($table_name, true, array($key_field => $this->app_db->insert_id()));
      }
      else
      {
        return false;
      }
    }
  }

	public function getNumRows($table,$orderby_field='',$orderby_val='',$where_field='',$where_val='')
	{

        if (empty($data)){

          	$id = $this->input->post('id');

          	if ( ! $id ) return false;

            $data = array('id' => $id);

        }

        $query = $this->app_db->get_where($table_name, $data);

        $res = $query->num_rows;

      	 return $res;
    }

	public function getAllRecords($table,$orderby_field='',$orderby_val='',$where_field='',$where_val='')
	{
		if($orderby_field)
		$this->app_db->order_by($orderby_field, $orderby_val);

		if($where_field)
		$this->app_db->where($where_field, $where_val);

		$query = $this->app_db->get($table);
		if($query->num_rows >0)
		{
			return $query->result_array();
		}
	}

	public function count_results($table_name,$where='')
	{

		    $this->app_db->from($table_name);

		    if($where)
		    $this->app_db->where($where);

	return	$this->app_db->count_all_results();

	}

	function insert_entry($table,$data)
	{
		$this->app_db->insert($table,$data);
		return $this->app_db->insert_id();
	}

	/* --------------------------------------------------------------------------------- */

	function update_entry($table_name, $data, $where)
	{
		return $this->app_db->update($table_name, $data, $where);

		//echo $this->app_db->last_query();exit;
	}

    /* --------------------------------------------------------------------------------- */


	/* --------------------------------------------------------------------------------- */

    public function get_all_entries($table_name, $input = array()) {

		$default = array(
			'start' => 0,
			'limit' => false,
			'sort'  => 'id',
			'sort_type' => 'asc',
			'single' => false,
			'distinct' => false,
			'custom_where' => false,
			'group_by' => false,
			'count' => false
		);

		$args = array_merge($default, $input);

        if (!empty($args['fields'])) {
            foreach ($args['fields'] as $key => $value) {
                foreach ($value as $val) {
                    if (strpos($val, "(") !== false)
                    	$this->app_db->select($val);
                    else
                    	$this->app_db->select($key . '.' . $val);
                }
            }
        }
        if ($args['limit'] && !$args['count'])
            $this->app_db->limit($args['limit'], $args['start']);

        if (!$args['count']) $this->app_db->order_by($args['sort'], $args['sort_type']);

        if (!empty($args['joins'])) {
            foreach ($args['joins'] as $key => $value) {
				if (is_array($value))
				{
					if ($value[0] == 'custom')
					{
						$this->app_db->join($key, $value[1], ((!empty($value[2])) ? $value[2] : 'left'));
					}
					else
						$this->app_db->join($key, $key . '.'.$value[0].' = ' . $table_name . '.' . $value[1], ((!empty($value[2])) ? $value[2] : 'left'));
				}
				else
				{
					$this->app_db->join($key, $key . '.id = ' . $table_name . '.' . $value, 'left');
				}
            }
        }

        if (!empty($args['where'])) {
            foreach ($args['where'] as $key => $value) {
                if (is_array($value))
				{
					if (!empty($value[0]) and $value[0] == 'custom')
						$this->app_db->where($value[1], NULL, FALSE);
					elseif (!empty($value[0]))
						$this->app_db->where($value[0] . '.' . $key, $value[1]);
					else
						$this->app_db->where($table_name.'.'.$value[1], NULL, FALSE);
				}
				else
				{

					if ($value !== '')
						$this->app_db->where($table_name . '.' . $key, $value);
				}
            }
        };

        if (!empty($args['where_in'])) {
            foreach ($args['where_in'] as $key => $value) {
                if (is_array($value))
				{
					$this->app_db->where_in($table_name . '.' . $key, $value);
				}
            }
        };

          if (!empty($args['where_not_in'])) {
            foreach ($args['where_not_in'] as $key => $value) {
                if (is_array($value))
				{
					$this->app_db->where_not_in($table_name . '.' . $key, $value);
				}
            }
        };


        if ($args['custom_where']):

            $this->app_db->where($args['custom_where']);

        endif;

        if (!empty($args['or_where'])) {
            foreach ($args['or_where'] as $key => $value) {
                if ($value !== '')
                    $this->app_db->or_where($table_name . '.' . $key, $value);
            }
        };

        if (!empty($args['like'])) {
            foreach ($args['like'] as $key => $value) {
				if (is_array($value))
				{
					if (empty($value[2]))
						$this->app_db->like($value[0] . '.' . $key, $value[1]);
					else
						$this->app_db->like($value[0] . '.' . $key, $value[1], $value[2]);
				}
				else
				{
					if ($value !== '')
						$this->app_db->like($table_name . '.' . $key, $value);
				}
            }
        };

		if (!empty($args['or_like'])) {
            foreach ($args['or_like'] as $key => $value) {
				if (is_array($value))
				{
					$this->app_db->or_like($value[0] . '.' . $key, $value[1]);
				}
				else
				{
					if ($value !== '')
						$this->app_db->or_like($table_name . '.' . $key, $value);
				}
            }
        };

		if (!empty($args['not_like'])) {
            foreach ($args['not_like'] as $key => $value) {
				if (is_array($value))
				{
					$this->app_db->not_like($value[0] . '.' . $key, $value[1]);
				}
				else
				{
					if ($value !== '')
						$this->app_db->not_like($table_name . '.' . $key, $value);
				}
            }
        };

        if ($args['distinct'])
            $this->app_db->distinct();

		if ($args['group_by'] && !$args['count'])
            $this->app_db->group_by($args['group_by']);

        if ($args['count'])
		{
			$this->app_db->from($table_name);

			return $this->app_db->count_all_results();
		}
		else
		{
			$query = $this->app_db->get($table_name);

			$results = $query->result_array();

			if (!empty($results)) {

				if ($args['single'])
					return $results[0]; else
					return $results;
			}
			else
				return array();
		}
    }

    /* --------------------------------------------------------------------------------- */

	function UpdateRecords($table,$data,$field,$id)
	{
		$this->app_db->where($field, $id);
		$this->app_db->update($table,$data);
		return $this->app_db->affected_rows();
	}

	function DeleteWhere($table,$where){

		$this->app_db->where($where);
		$this->app_db->delete($table);
		return $this->app_db->affected_rows();
	}

	function DeleteRecord($table,$field,$id)
	{
		$this->app_db->where($field, $id);
		$this->app_db->delete($table);
		return $this->app_db->affected_rows();
	}

	function DeleteRecordWhere($table,$where,$data)
	{
		$this->app_db->where($where);
		$this->app_db->update($table, $data);
		return $this->app_db->affected_rows();
	}


	function getSingleRow($table,$where_field,$where_val)
	{
		$this->app_db->where($where_field,$where_val);
		$query = $this->app_db->get($table);
		if($query->num_rows>0)
		{
			return $query->row();
		}else
		{
			return false;
		}


	}


	function CheckExisting($table,$field_name,$param)
	{
		$this->app_db->where($field_name,$param);
		$rec = $this->app_db->get($table);
		return $rec->num_rows();
	}


	function selectColumn($table,$sel_field,$where_field,$where_val)
	{
		$this->app_db->select($sel_field);
	    $this->app_db->from($table);
	    $this->app_db->where($where_field, $where_val);
	    return  $this->app_db->get()->result();
	}

	function get_last_query(){
		
		return $this->app_db->last_query();
	}

	function run_custom_query($query){

		$query = $this->app_db->query($query);
		
		if($query)
			return $query->result_array();

		return NULL;
	}



	function run_query($query){


		$query = $this->app_db->query($query);
		
		if($query)
			return true;
		
		return false;

	}

	function get($table_name , $all = true, $condition = array() , $colom = array()){

		if(!empty($colom)){

			$this->app_db->select(implode(',', $colom));
		}

		$this->app_db->from($table_name);

		foreach ($condition as $key => $value) {
			$this->app_db->where($key, $value);
		}

		$query = $this->app_db->get();

		//echo $this->app_db->last_query();die;
		$result = array();
		if($all){
			$result = $query->result();
		}else{
			if ($query->num_rows() > 0){
			   $result = $query->row_array();
			}
		}

		//echo '<pre>';
		//print_r($result);die;
		return $result;
	}
	

	public function getAllDataWhere($table,$where='')
	{
		if($where)
		{
			$this->app_db->where($where);
		}
		$q = $this->app_db->get($table);
		return $q->result_array();
	}

	public function getSingleRowWhere($table,$where='')
	{
		if($where)
		{
			$this->app_db->where($where);
		}
		$q = $this->app_db->get($table);
		return $q->row_array();
	}

	public function getQueryRow($query)
	{
		$q = $this->app_db->query($query);
		return $q->row();
	}

	public function do_insert_batch($table,$batch)
	{
		$first_id = $this->app_db->insert_batch($table,$batch);

		return $first_id;

	}

	


}//class end here.
?>
