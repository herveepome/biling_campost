<?php


/**
 * Description of Configuration_model
 *
 * @author mct
 */
class Configuration_model extends CI_Model {

	// les tables
	protected $adresse = 'adresse';
	protected $zone = 'zone';
	protected $regions = 'regions';
	protected $weight = 'weight';
	protected $cash_interval = 'cash_interval';

    // lister les éléments de la table
    public function all($table){
    	$this->db->select('*');
		$this->db->from($table);
		$this->db->where('deleted',0);
		return $this->db->get()->result();
    }
    public function getWhere($table,$field,$value){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field,$value);
        return $this->db->get()->result();
    }


    // fonction de création

     public function create($data, $table)
	{	
		if ($this->db->insert($table,$data)){
			return $this->db->insert_id();
		}
		else {return false;}
    }

    // éditer une table
    public function edit($id,$key,$table)
	{	
		$query = $this->db->get_where($table,array($key=>$id));
        if($query->num_rows()>0){
			$rows = $query->result();
			return $rows[0];
		}
		
	}
	// mettre à jour

	public function update($id, $data,$key,$table)
	{
		$this->db->where($key, $id)->update($table,$data);
		return true;
	}
	// rechercher un attribut dans la table
	public function find($id,$attr,$data, $table){
		$this->db->select($id);
		$this->db->from($table);
		$this->db->where($attr,$data);
		return $this->db->get()->result();
	}
	

 

}
