<?php


/**
 * Description of Configuration_model
 *
 * @author mct
 */
class Configuration_model extends MY_Model {

    protected $adress = 'adresse';
    protected $zone = 'zone';
    protected $region = 'regions';
    protected $weight = 'weight';
    protected $cash = 'cash_interval';
      
    // la liste des adresses
    public function getAllAdresses(){
    	$this->db->select('*');
		$this->db->from($this->adress);
		return $this->db->get()->result();
    }

    // la liste des zones
    public function getAllZones(){
    	$this->db->select('*');
		$this->db->from($this->zone);
		return $this->db->get()->result();
    }

    // la liste des régions
    public function getAllRegions(){
    	$this->db->select('*');
		$this->db->from($this->region);
		return $this->db->get()->result();
    }

     // les intervalles de poids
    public function getAllWeight(){
    	$this->db->select('*');
		$this->db->from($this->weight);
		return $this->db->get()->result();
    }

     // les intervalles de cash
    public function getAllCashIntervalls(){
    	$this->db->select('*');
		$this->db->from($this->cash);
		return $this->db->get()->result();
    }
  

 

}
