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
        $this->load->model('configuration_model');
        $this->load->model('cash_model');

    }

    public function index() {
        $data['customers']=$this->customer_model->getALL(array("deleted"=>0));
        
        $this->load->view('general/header.php');
        $this->load->view('customers/list_customers.php', $data);
        //$this->load->view('administrator/record', $data);
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
        if ($id != null) {
            
            $data['customer']=$this->customer_model->getALL(array("id"=>$id));
            
        }
        $data['adresses'] = $this->configuration_model->all('adresse');
        $data['cashs'] = $this->configuration_model->all('cash_interval');
        $data['zones'] = $this->configuration_model->all('zone');
        $data['poids'] = $this->configuration_model->all('weight');
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
            $data=$this->input->post();
           // var_dump($data); die;
            $customer = array("name"=>$data['name'],
                             "business_register"=>$data['business_register'],
                             "uin"=>$data['uin'],
                            "account_number"=>$data['account_number'],
                            "bank"=>$data['bank'],
                            "adress"=>$data['adress'],
                            "phone_number"=>$data['phone_number'],
                             );
            $cashData = $data['amount'];
            $tarifData= $data['tarif'];
            $intervals = $this->configuration_model->all('cash_interval');

           // var_dump($interval[0]->interval);die;
            //var_dump($cashData); die;
            if ($id == null) {
                if ($lastId = $this->customer_model->insert($customer) ){
                    $i=0;
                    foreach ($intervals as $interval){
                        $cashs[]=array("cash_interval_id"=>$interval->id,
                            "customer_id"=>$lastId,
                            "amount"=>$cashData[$i]
                            );
                        $i++;
                    }
                    $this->cash_model->insert_many_rows($cashs);
                }

                
            }else{
                
                $this->customer_model->insert($customer,$id);
                
            }
            redirect('customers');
            //$error_array = array();


          /*  if ($name == null)
                $error_array[] = array("status" => "error", "message" => "le Champ 'nom' est requis");
            if ($uin == null)
                $error_array[] = array("status" => "error", "message" => "le Champ 'Numéro de contribuable' est requis");
            if (strlen($uin) != 14)
                $error_array[] = array("status" => "error", "message" => "le Champ 'Numéro de contribuable' doit contenir 14 caractères");
            if ($bussiness_register == null)
                $error_array[] = array("status" => "error", "message" => "le Champ 'Registre du commerce' est requis");
            if ($postal_box == null)
                $error_array[] = array("status" => "error", "message" => "le Champ 'Boite postale' est requis");


            if ($id == null) {
                
                if(!empty($error_array)){
                    $this->session->set_userdata("createCustomerMessage", $error_array);
                    $this->session->mark_as_flash('createCustomerMessage');
                    redirect('customer/create');
                }else{
                    $error_array[] = array("status" => "success", "message" => "Le client: ".$name."a bien été enregistré!");
                    $this->customer_model->insert($customer);
                    $this->session->set_userdata("createCustomerMessage", $error_array);
                    $this->session->mark_as_flash('createCustomerMessage');
                    redirect('customers');
                }
                    
                    
                
            }else{
                
            }*/


           
        }
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
