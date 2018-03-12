<?php


/**
 * Description of Deposit_model
 *
 * @author maceta
 */
class Deposit_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->set_table_name("deposit_collected");
    }




}
