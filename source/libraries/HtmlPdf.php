<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HtmlPdf
 *
 * @author hepomenzengue
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/html_to_pdf/html2pdf.php";
class HtmlPdf  extends HTML2PDF {
    public function __construct() {
        parent::__construct();
    }
}
