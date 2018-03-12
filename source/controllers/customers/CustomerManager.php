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
        $this->load->model('local_model');
        $this->load->model('deposit_model');

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
            $domicileId = $this->local_model->getALL(array("name"=>'A domicile'))[0]->id; // récupérer dans deposit_local l'id pour à domicile
            $bureauId = $this->local_model->getALL(array("name"=>'Bureau de poste'))[0]->id;   // récupérer dans deposit_local l'id pour bureau de poste

            $data['customer']=$this->customer_model->getALL(array("id"=>$id));
            $data['cash_collected']=$this->cash_model->getALL(array("customer_id"=>$id));
            $data['bureau_collected']=$this->deposit_model->getALL(array("customer_id"=>$id,"deposit_local_id"=>$bureauId));
            $data['domicile_collected']=$this->deposit_model->getALL(array("customer_id"=>$id,"deposit_local_id"=>$domicileId));

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
           //var_dump($data); die;
            $customer = array("name"=>$data['name'],
                             "business_register"=>$data['business_register'],
                             "uin"=>$data['uin'],
                            "account_number"=>$data['account_number'],
                            "bank"=>$data['bank'],
                            "adress"=>$data['adress'],
                            "phone_number"=>$data['phone_number'],
                            "tracking_number"=>$data['tracking_number']
                             );
            $cashData = $data['amount'];
            $tarifDomicile= $data['tarifdomicile']; // récupérer tous les tarifs pour à domicile
            $tarifBureau= $data['tarifbureau'];   // récupérer tous les tarifs pour bureau de poste

            $intervals = $this->configuration_model->all('cash_interval');
            $zones = $this->configuration_model->all('zone');
            $poids = $this->configuration_model->all('weight');
            $domicileId = $this->local_model->getALL(array("name"=>'A domicile'))[0]->id; // récupérer dans deposit_local l'id pour à domicile
            $bureauId = $this->local_model->getALL(array("name"=>'Bureau de poste'))[0]->id;   // récupérer dans deposit_local l'id pour bureau de poste

            if ($id == null)
                $customer_id = $this->customer_model->insert($customer);

            else
                $customer_id  = $id;
            $i=0; $j=0;$k=0;
            foreach ($intervals as $interval){
                $cashs[]=array("cash_interval_id"=>$interval->id,
                    "customer_id"=>$customer_id,
                    "amount"=>$cashData[$i]
                    );
                $i++;
            }
            foreach ($zones as $zone){
                foreach ($poids as $poid){
                    $tarifs_domicile[] = array( "weight_id"=>$poid->id,
                                        "zone_id"=>$zone->id,
                                        "deposit_local_id"=>$domicileId,
                                        "customer_id"=>$customer_id,
                                        "amount"=>$tarifDomicile[$j],
                    );
                    $j++;
                }

            }
            foreach ($zones as $zone){
                foreach ($poids as $poid){
                    $tarifs_bureau[] = array( "weight_id"=>$poid->id,
                        "zone_id"=>$zone->id,
                        "deposit_local_id"=>$bureauId,
                        "customer_id"=>$customer_id,
                        "amount"=>$tarifBureau[$k],
                    );
                    $k++;
                }

            }
            if($id == null){
                $this->cash_model->insert_many_rows($cashs);
                $this->deposit_model->insert_many_rows($tarifs_bureau);
                $this->deposit_model->insert_many_rows($tarifs_domicile);

                }

                
            else{
                $cashCollected = $this->cash_model->getALL(array("customer_id"=>$id)) ; //les cash collected à éditer
                $bureauCollected = $this->deposit_model->getALL(array("customer_id"=>$id,"deposit_local_id"=>$bureauId)) ; // les deposit collected au bureau à éditer
                $domicileCollected = $this->deposit_model->getALL(array("customer_id"=>$id,"deposit_local_id"=>$domicileId)) ; // les deposit collected à domicile à éditer

                $this->customer_model->insert($customer,$id); // éditer la table customer
                //var_dump(count($cashData));exit;
                for($i=0;$i<count($cashData); $i++)
                   $this->cash_model->insert($cashs[$i],$cashCollected[$i]->id);
                for($i=0;$i<count($tarifDomicile); $i++)
                    $this->deposit_model->insert($tarifs_domicile[$i],$domicileCollected[$i]->id);
                for($i=0;$i<count($tarifBureau); $i++)
                    $this->deposit_model->insert($tarifs_bureau[$i],$bureauCollected[$i]->id);

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
        $data['cashs']=$this->cash_model->getALL(array("customer_id"=>$id)); //récupérer les commissions pour ce client
        $bureauId = $this->local_model->getALL(array("name"=>'Bureau de poste'))[0]->id;
        $domicileId = $this->local_model->getALL(array("name"=>'A domicile'))[0]->id;
        $data['depositsDomicile']=$this->deposit_model->getALL(array("deposit_local_id"=>$domicileId)); //récupérer les tarifs à domicile pour ce client
        $data['depositsBureau']=$this->deposit_model->getALL(array("deposit_local_id"=>$bureauId)); //récupérer les tarifs au bureau de poste pour ce client
        $data['intervals'] = $this->configuration_model->all('cash_interval'); // les intervals de cashs
        $data['zones'] = $this->configuration_model->all('zone');  // les zones
        $data['poids'] = $this->configuration_model->all('weight'); // les poids

        $this->load->view('general/header.php');
        $this->load->view('customers/detail_customer.php', $data);
        $this->load->view('general/footer.php');
    }
    
     public function destroy($id) {
         $this->customer_model->insert(array("deleted"=>1),$id);
         redirect('customers');
     }

}
