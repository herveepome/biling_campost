<?php


/**
 * Description of Cash_model
 *
 * @author maceta
 */
class Local_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->set_table_name("deposit_local");
    }




}
