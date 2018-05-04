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
include_once (APPPATH . 'controllers/MainController.php');

class CustomerManager extends MainController {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer_model');
    }

    public function index() {
        $data['customers']=$this->customer_model->getALL(array("deleted"=>0));
        
        $this->load->view('general/header.php');
        $this->load->view('customers/list_customers.php', $data);
        $this->load->view('general/footer.php');
    }

    /**
     *  Formulaire  de creation d'un client 
     */
    public function create() {
        $this->edit();
    }

    /* Permet d'afficher l'interface de modification d'un client */

    public function edit($id = null) {
        $data['customer'] = null;
        if ($id != null)
            $data['customer']=$this->customer_model->getALL(array("id"=>$id));
          
        $this->load->view('general/header.php');
        $this->load->view('customers/add_customer.php', $data);
        $this->load->view('general/footer.php');
    }

    /**
     *  Permet de sauvegarder les données lors d'une création d'un client 
     */
    public function store() {
        $this->update();
    }

    public function update($id = null) {

        if ($this->input->post()) {
            extract($this->input->post(NULL, TRUE));
            $customer = array("name"=>$name,
                             "business_register"=>$business_register,
                             "uin"=>$uin,
                            "account_number"=>$account_number,
                            "bank"=>$bank,
                            "adress"=>$adress,
                            "phone_number"=>$phone_number,
                            "tracking_number"=>$tracking_number
                             );
        }

            $this->customer_model->insert($customer,$id); // éditer la table customer
              
            redirect('customers');
        
    }
    
    public function read($id) {
        $data['customer']=$this->customer_model->getALL(array("id"=>$id));
        
        $this->load->view('general/header.php');
        $this->load->view('customers/detail_customer.php', $data);
        $this->load->view('general/footer.php');
    }
    
     public function destroy($id) {
         $this->customer_model->insert(array("deleted"=>1),$id);
         redirect('customers');
     }

}
