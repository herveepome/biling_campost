<?php

/*
  |--------------------------------------------------------------------------
  | @author f.ngapouche
  |--------------------------------------------------------------------------
  |
  | Controleur constituant le parent de tous les controleurs de l'application
  | Il peut par exemple permettre d'�ffectuer des controles de s�curit� et bien
  | d'autres.
  |
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('state_model');
        $this->load->library('excel');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('general/login.php');
        $this->load->view('general/footer.php');
    }

    public function getFiles() {

        $data['customers'] = $this->customer_model->getALL(array("deleted" => 0));
        if ($this->input->post()) {
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $customer_id = $this->customer_model->getALL(array("name" => $customer))[0]->id;
            $periode = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);

            if (  $file == 'Facture') {

                $fichier= $this->state_model->getALL(array("period" => $periode, "type" => 'F', "customerID" => $customer_id, "deleted" => 0));

                if (isset($fichier) && !empty($fichier) && $fichier != null) {
                    $path = base_url() . 'upload/bill/' . $fichier[0]->name . '.xls';
                    $this->downloadFile($path);
                } else{
                    $this->session->message = "Ce fichier n'existe pas encore. Vérifiez les critères et réessayez!";
                    redirect('accueil');
                    
                }
            }else {
                $fichier = $this->state_model->getALL(array("period" => $periode, "type" => 'LF', "customerID" => $customer_id,"deleted" => 0));

                if (isset($fichier) && !empty($fichier) && $fichier != null) {
                    $path = base_url() . 'upload/listing/' . $fichier[0]->name . '.xlsx';
                    $this->downloadFile($path);
                } else{
                    $this->session->message = "Ce fichier n'existe pas encore. Vérifiez les critères et réessayez!";
                    redirect('accueil');die;
                    
                }}
        }

        $this->load->view('general/header.php');
        $this->load->view('general/accueil.php', $data);
        $this->load->view('general/footer.php');
    }

    public function downloadFile($path) {
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($path) . "\"");
        readfile($path); // do the double-download-dance (dirty but worky)
    }

    public function accueil() {
       
        $data['customers'] = $this->customer_model->getALL(array("deleted" => 0));
        
        $this->load->view('general/header.php');
        $this->load->view('general/accueil.php', $data);
        $this->load->view('general/footer.php');
    }

}
