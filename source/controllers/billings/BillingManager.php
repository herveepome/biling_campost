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
        $this->load->model('customer_model');
        $this->load->model('state_model');
        $this->load->model('operation_model');
        $this->load->model('versement_model');
        $this->load->model('billing_model');
        $this->load->library('excel');
        $this->load->library('htmlpdf');
    }

    public function index() {

    }

    // données pour la création du fichier de facturation

    public function create() {
       $this->create_file("Fichier de facturation", "billing_file", 'billings/new_state.php', 'billing/generate_billing_file');
    }

     public function create_file($file_to_upload, $file_name, $view, $link, $error = null) {
        
        if ($file_name == "versement_file")
            $data['time'] = 15000;
        if ($file_name == "operation_file")
            $data['time'] = 125000;

        $data['link'] = $link;
        $data['file_to_upload'] = $file_to_upload;
        $data['file_name'] = $file_name;
        $data['error'] = $error;
        $data['customers'] = $this->customer_model->getALL(array("deleted" => 0));
        $this->load->view('general/header.php');
        $this->load->view($view, $data);
        $this->load->view('general/footer.php');
    }

     public function generate_file($test, $name_file, $nam, $data, $operation_id, $type, $file_type, $file_name, $customer_id, $type_file_required, $period, $headers, $file, $newfile, $path, $name, $versement_id = null) {
        $error = null;

        if ($versement_id != null && empty($versement_id) || empty($operation_id)) {
            $error = "Ce fichier ne peut pas encore être généré car au moins un des fichiers requis  correspondant à ces critères n'a pas encore été chargé. Veuillez le(s) charger et réessayer";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } elseif (empty($operation_id)) {
            $error = "Ce fichier ne peut pas encore être généré car fichier des " . $name . " correspondant à ces critères n'a pas encore été chargé. Veuillez le charger et réessayer";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } elseif (!empty($this->state_model->getALL(array("period" => $period, "type" => $type, "customerID" => $customer_id[0]->id)))) {
            $error = "un fichier correspondant à ces critères existe déjà. Veuillez le supprimer et réessayer ou changez de critères";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } else {

            $name = $name . "_" . $period . ".xlsx";
            //$this->generating_file($test, $file, $newfile, $data, $name);
           $this->state_model->insert(array("file_path" => $newfile, "type" => $type, "facturation_date" => $operation_id[0]->facturation_date, "period" => $period, "customerID" => $customer_id[0]->id, "name" => $nam));
            $state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FF", "customerID" => $customer_id[0]->id)));

             foreach ($data as $row) {
            	$rows[] = array(
			    	'date_collected'=>$row->start_time,
			    	'tracking_number'=>$row->tracking_number,
			    	'destination'=>$row->address,
			    	'region'=>$row->region,
			    	'order_number'=>$row->order,
			    	'weight'=>$row->size,
			    	'final_status'=>$row->status,
			    	'final_status_date'=>$row->delivered_date,
			    	'deleted'=>0,
			         'state_file_id'=>$state_file_id[0]->id,
			    	'amount_to_collect'=>$row->amount_to_collect,
			    	'amount_collected'=>$row->amount_collected,
			    	'deposit_local'=>$row->deposit_local
					);  
            }
          
           $this->billing_model->insert_many_rows($rows);
           $result['billings'] = $this->billing_model->getALL(array("state_file_id" => $state_file_id[0]->id));
           $result['billing_id'] = $state_file_id[0]->id;
            $result['period'] = $period;

            // var_dump($values); die;
            $this->load->view('general/header.php');
            $this->load->view('billings/list_bill.php', $result);
            $this->load->view('general/footer.php');

        

        }
    }


    public function generate_billing_file(){
    	//var_dump($this->input->post());die;
        if ($this->input->post()) {
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);
            $customer_id = $this->customer_model->getALL(array("name" => $customer));

            //$state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FO", "customerID" => $customer_id[0]->id)));

            $operation_id=$this->state_model->getALL(array("type" =>"FO","period"=>$period,"customerID"=>$customer_id[0]->id));

            $versement_id=$this->state_model->getALL(array("type" =>"FV","period"=>$period,"customerID"=>$customer_id[0]->id));

            //$state_croisement_id = ($this->state_model->getALL(array("period" => $period, "type" => "FV", "customerID" => $customer_id[0]->id)));
            //var_dump($operation_id,$versement_id);die;
             $data = array();

            if (!empty($operation_id)){

            	// les retournés
            	$returned = $this->operation_model->getCroisedRows("SELECT o.shipment_provider,o.status,o.address, o.delivered_date,o.start_time, o.tracking_number,o.size,o.order,o.region,o.payment_method,o.amount_to_collect,o.bureau, o.amount_collected,o.date_operation, o.deposit_local FROM operation o
                                                            WHERE status = 'Returned' OR status = 'Lost' OR status = 'Reversed' AND state_file_id =" .$operation_id[0]->id.
                                                            " ORDER  BY o.order ");

            	// les payés en ligne
            	$paidOnLine = $this->operation_model->getCroisedRows("SELECT o.shipment_provider,o.status,o.start_time, o.delivered_date,o.tracking_number,o.size,o.order,o.region,o.payment_method,o.address,o.amount_to_collect,o.bureau,o.date_operation,o.amount_collected,o.deposit_local FROM operation o
                                                            WHERE amount_to_collect=0 AND payment_method !='Paiement Ã  la livraison' AND payment_method !='CashOnDelivery' AND state_file_id =" .$operation_id[0]->id.
                                                            " ORDER  BY o.order ") ;
            	//les croisés
            	$croised = array();

            	$data1 = $this->operation_model->getCroisedRows("SELECT o.shipment_provider,o.status,o.start_time,o.tracking_number,v.reference as amount_collected,o.size,o.order,o.delivered_date,o.address,o.region,o.payment_method,o.amount_to_collect, v.credit as amount_collected, o.bureau, o.date_operation, o.deposit_local FROM versement v
                                                            cross join operation o 
                                                            WHERE  o.tracking_number=v.reference AND cast(O.amount_to_collect as unsigned integer)<>0 AND status <>'Returned' AND status <>'Lost' AND o.state_file_id=".$operation_id[0]->id." AND v.state_file_id=".$versement_id[0]->id.
                                                            " GROUP  BY o.order ");
            $data2 = $this->operation_model->getCroisedRows("SELECT o.shipment_provider,o.status,o.start_time,o.tracking_number,v.reference as amount_collected ,o.size,o.order,o.address, o.delivered_date,o.region,o.payment_method,o.amount_to_collect,v.credit as amount_collected,o.bureau,o.date_operation,o.deposit_local FROM versement v
                                                            cross join operation o
                                                            WHERE right(v.reference,9)=o.order AND o.tracking_number <> v.reference AND  cast(O.amount_to_collect as unsigned integer)<>0 AND status<>'Returned' AND status <>'Lost' AND cast(O.amount_to_collect as unsigned integer)= cast(v.credit as unsigned integer) AND o.state_file_id=".$operation_id[0]->id." AND v.state_file_id=".$versement_id[0]->id.
                                                            " ORDER BY o.order");

            $data3 = $this->operation_model->getCroisedRows("SELECT o.shipment_provider,o.status,o.start_time,o.tracking_number,v.reference, o.address ,o.size,o.delivered_date,o.order,o.region,o.payment_method,o.amount_to_collect,v.credit as amount_collected ,o.bureau,o.date_operation,o.deposit_local FROM versement v
                                                            cross join operation o
                                                            WHERE right(v.reference,9)=o.order AND o.tracking_number <> v.reference AND  cast(O.amount_to_collect as unsigned integer)<>0 AND status<>'Returned' AND status <>'Lost' AND cast(O.amount_to_collect as unsigned integer)<  cast(v.credit as unsigned integer) AND o.state_file_id=".$operation_id[0]->id." AND v.state_file_id=".$versement_id[0]->id.
                                                            " ORDER BY o.order");


                $croised = array_merge($data1, $data2);
                $croised = array_merge($croised, $data3);
                $data = array_merge($croised, $returned);
                $data = array_merge($data, $paidOnLine); // contenu du fichier de facturation

               // var_dump($data) ; die();
            }

            //var_dump($period,$customer_id,$state_file_id);die;
            $name = "opérations";
            $file_type = "Fichier de facturation";
            $file_name = "billing_file";
            $path = "billing/generate_billing_file";
            $file = "./upload/model/returned_paidonline_delivery.xlsx";
            $newfile = "./upload/billing/billing_" . $period . ".xlsx";

            $type = "FF";
            $headers = array('No', 'Date de collecte', 'Numéro de commande', 'No colis AIGE', 'Destination', 'Poids','Statut final', 'Date statut final');
            $file_text_name = "Ficher de facturation";
            $name_file = "billing_file";
            $nam = "billing_" . $period;
            $test = "billing";
            $this->generate_file($test, $name_file, $nam, $data, $operation_id, "FF", "Fichier de facturation", "billing", $customer_id, $customer, $period, $headers, $file, $newfile, $path, $file_name, $name, $versement_id);
        }

    }

    public function newLine($state_file_id) {
        $this->editBilling($state_file_id);
    }

    public function editBilling($state_file_id,$id=null) {

        
            $data['billing'] = null;
            $data['billing_id'] = $state_file_id ;

            
        if ($id != null) {
            

            $data['billing']=$this->billing_model->getALL(array("id"=>$id,"deleted"=>0));

        }
        
        $data['state_file_id']=$state_file_id ;
        //var_dump($id,$data);die;
        $this->load->view('general/header.php');
        $this->load->view('billings/new_billing.php', $data);
        $this->load->view('general/footer.php');
    }

    public function store($state_file_id) {
        $this->update($state_file_id);
    }

    public function update($state_file_id,$id = null)
    {

        if ($this->input->post()) {
            extract($this->input->post(NULL, TRUE));
            $billing = $this->input->post();

            if ($id == null) {

                $this->billing_model->insert($billing);

            } else {

                $this->billing_model->insert($billing, $id);

            }
            $this->list_billing_file($state_file_id);

        }
    }


    public function read($billing_id) {
        $data['billing']=$this->billing_model->getALL(array("state_file_id"=>$billing_id, "deleted"=>0));
        $period=$this->state_model->getALL(array("id"=>$billing_id))[0]->period;
        //var_dump($period);die;
        $data['file_text_name'] ='Fichier de facturation de la période du ' .$period ;
        $this->load->view('general/header.php');
        $this->load->view('billings/read_billing.php', $data);
        $this->load->view('general/footer.php');
    }

    public function destroy($id,$state_file_id) {
        $this->billing_model->insert(array("deleted"=>1),$id);
        //var_dump($state_file_id);die;
        $this->list_billing_file($state_file_id);
    }

    public function list_billing_file($state_file_id) {
        //var_dump($state_file_id);die;

        $data["billings"]= $this->billing_model->getALL(array("deleted"=>0, "state_file_id"=>$state_file_id));
        $data["billing_id"]=$state_file_id;

        $this->load->view('general/header.php');
        $this->load->view('billings/list_bill.php', $data);
        $this->load->view('general/footer.php');
    }





}
