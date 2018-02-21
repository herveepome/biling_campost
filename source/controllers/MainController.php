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

	}


        public function index()
	{
            $this->load->view('general/header.php');
            $this->load->view('general/accueil.php');
            $this->load->view('general/footer.php');
	}

}
