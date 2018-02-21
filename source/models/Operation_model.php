<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Operation_model
 *
 * @author hepomenzengue
 */
class Operation_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->set_table_name("operation");
    }
    
    public function getRows($where){
        $this->db->select('shipment_provider,status,tracking_number,size,order,region,payment_method,amount_to_collect,bureau,date_operation');
        $this->db->from($this->_table_name);
        $this->db->where($where);
        $query=$this->db->get();
        return $query->result();
    }
    public function getCroisedRows($query){
        $req= $this->db->query($query);
        return $req->result();
    }
            

}
