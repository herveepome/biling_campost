<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_model
 *
 * @author mct
 */
class User_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->set_table_name("user_login");
    }




}

