<?php


/**
 * Description of Interval_model
 *
 * @author maceta
 */
class Interval_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->set_table_name("cash_interval");
    }




}
