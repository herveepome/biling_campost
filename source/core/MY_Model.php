<?php
class MY_Model extends CI_Model {
	
	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'id';
	public $_rules = array();
	protected $_timestamps = TRUE;
	
	function __construct() {
		parent::__construct();
	}
	
        /**
         * 
         * @return STRING Table Name
         */
        function get_table_name() {
            return $this->_table_name;
        }

        /**
         * 
         * @return INT Primary Key
         */
        function get_primary_key() {
            return $this->_primary_key;
        }

        /**
         * 
         * @return STRING Primary Filter
         */
        function get_primary_filter() {
            return $this->_primary_filter;
        }

        /**
         * 
         * @return STRING Get OrderBy
         */
        function get_order_by() {
            return $this->_order_by;
        }

        function get_rules() {
            return $this->_rules;
        }

        function get_timestamps() {
            return $this->_timestamps;
        }

        function set_table_name($_table_name) {
            $this->_table_name = $_table_name;
        }

        function set_primary_key($_primary_key) {
            $this->_primary_key = $_primary_key;
        }

        function set_primary_filter($_primary_filter) {
            $this->_primary_filter = $_primary_filter;
        }

        function set_order_by($_order_by) {
            $this->_order_by = $_order_by;
        }

        function set_rules($_rules) {
            $this->_rules = $_rules;
        }

        function set_timestamps($_timestamps) {
            $this->_timestamps = $_timestamps;
        }

                

    public function array_from_post($fields){
		$data = array();
		foreach ($fields as $field) {
			$data[$field] = $this->input->post($field, TRUE);
		}
		return $data;
	}
	public function get($id = NULL, $single = FALSE, $result_type=NULL){
            if ($id != NULL) {
                $filter = $this->_primary_filter;
                $id = $filter($id);
                $this->db->where($this->_primary_key, $id);
                $method = 'row';
            }
            elseif($single == TRUE) {
                $method = 'row';
            }
            else {
                $method = 'result';
            }                
            if($result_type)
            {
                $method = $result_type;
            }
            //if (!count($this->db->ar_orderby)) {
                $this->db->order_by($this->_order_by);
            //}
            return $this->db->get($this->_table_name)->$method();
	}
	
	public function get_by($where, $single = FALSE, $result_type=NULL){
		$this->db->where($where);
		return $this->get(NULL, $single, $result_type);
	}
	
        
	public function save($data, $id = NULL, $andWhere = NULL){
		// Set timestamps
		if ($this->_timestamps == TRUE) {
			$now = date('Y-m-d H:i:s');
			$id || $data['created'] = $now;
			$data['modified'] = $now;
		}
		// Insert
		if ($id === NULL) {
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id = $this->db->insert_id();
		}
		// Update
		else {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->set($data);
                        $this->db->where($this->_primary_key, $id);
                        if($andWhere){$this->db->where($andWhere);}
			$this->db->update($this->_table_name);
                        //die($this->db->last_query());
		}
		
		return $id;
	}
        
    public function delete_by($where, $single = FALSE, $result_type=NULL){
        $id = $this->get_by($where, $single, $result_type);
        $this->delete($id);
    }
	
	public function delete($id){
            $filter = $this->_primary_filter;
            $id = $filter($id);
            if (!$id) {
                return FALSE;
            }
            $this->db->where($this->_primary_key, $id);
            $this->db->limit(1);
            $this->db->delete($this->_table_name);
            return TRUE;
	}
        
        public function hash ($string)
	{
		return hash('sha512', $string . config_item('encryption_key'));
	}
        
        /* Mise a jour d'une tuple sans le champ modifié*/
        public function insert($data, $id = NULL, $andWhere = NULL){
            // Insert
            if ($id === NULL) {
                    !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
                    $this->db->set($data);
                    $this->db->insert($this->_table_name);
                    $id = $this->db->insert_id();
            }
            // Update
            else {
                    $filter = $this->_primary_filter;
                    $id = $filter($id);
                    $this->db->set($data);
                    $this->db->where($this->_primary_key, $id);
                    if($andWhere){$this->db->where($andWhere);}
                    $this->db->update($this->_table_name);
                    //die($this->db->last_query());
            }

        return $id;
    }
    
    public function insert_many_rows($data){
          //var_dump(count($data));die;
        $this->db->insert_batch($this->_table_name, $data);
    }
            
       /**
     * Lecture de tous les clients
     * @result 
     * 		t
     */
    public function getAll($where = null) {
        
        $this->db->select('*');
        $this->db->from($this->_table_name);
        if ($where != null)
            $this->db->where($where);
        $query=$this->db->get();
        return $query->result();
    }

        
}