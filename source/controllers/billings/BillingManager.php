<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerManager
 *
 * @author hepomenzengue
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . 'third_party/spout/src/spout/Autoloader/autoload.php';
libxml_disable_entity_loader(false);

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

//equire_once (APPPATH . '/third_party/PHPExcel.php');
include_once (APPPATH . 'controllers/MainController.php');

class BillingManager extends MainController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('general/header.php');
        $this->load->view('customers/test.php');
        $this->load->view('general/footer.php');
    }

}
