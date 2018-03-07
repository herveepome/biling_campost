<?php


/**
 * Description of Cash_model
 *
 * @author maceta
 */
class Cash_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->set_table_name("cash_collected");
    }




}
