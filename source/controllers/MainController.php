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



	public function __construct()
	{
		parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('state_model');
        $this->load->library('excel');

	}


        public function index()
	{

        $this->load->view('general/login.php');
        $this->load->view('general/footer.php');
	}

	public function getFiles(){


        $data['customers'] = $this->customer_model->getALL(array("deleted"=>0)) ;
        if($this->input->post()){
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $customer_id  = $this->customer_model->getALL(array("name"=>$customer))[0]->id;
            $periode = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);
            if($file = 'Facture'){
                $file = $this->state_model->getALL(array("period"=>$periode,"type"=>'F',"customerID"=>$customer_id, "deleted"=>0));
                $path = base_url().'upload/listing/'.$file[0]->name.'xsl';
            }
            else{
                $file = $this->state_model->getALL(array("period"=>$periode,"type"=>'LF',"customerID"=>$customer_id));
                $path = base_url().'upload/listing/'.$file[0]->name.'xslx';
            }

            if(isset($file)&& !empty($file)&& $file != null){
                $this->downloadFile($path) ;
            }
            else
                $data['file_error'] = "Ce fichier n'existe pas, veuillez le charger d'abord" ;
        }

        $this->load->view('general/header.php');
        $this->load->view('general/accueil.php', $data);
        $this->load->view('general/footer.php');
    }

    public function downloadFile($path){
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($path) . "\"");
        readfile($path); // do the double-download-dance (dirty but worky)

    }

}

