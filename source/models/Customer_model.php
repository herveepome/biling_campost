<?php


/**
 * Description of Customer_model
 *
 * @author hepomenzengue
 */
class Customer_model extends MY_Model {

    public function __construct() {
        parent::__construct();
       $this->set_table_name("customer");
    }
  

 

}