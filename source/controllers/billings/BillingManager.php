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
        $this->load->model('configuration_model');
        $this->load->model('deposit_model');
        $this->load->model('local_model');
        $this->load->model('cash_model');
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
            //stocker dans une table temporaire


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
        if ($this->input->post()) {
            $data = $this->input->post();
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($data['period'], 3, 2) . substr($data['period'], 0, 2) . substr($data['period'], 6);
            $customer_id = $this->customer_model->getALL(array("name" => $data['customer']));

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

    public function editBilling($id=null,$state_file_id) {


            $data['billing'] = null;
            $data['billing_id'] = $state_file_id ;


        if ($id != null) {

            $data['billing']=$this->billing_model->getALL(array("id"=>$id));

        }
       // var_dump($data['billing']); die;
        $data['state_file_id']=$state_file_id ;

        $this->load->view('general/header.php');
        $this->load->view('billings/new_billing.php', $data);
        $this->load->view('general/footer.php');
    }

    public function store($state_file_id) {
        $this->update($state_file_id);
    }

    public function update($id = null,$state_file_id)
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

//générer la facture
    public function createBill() {
        $this->create_file("Listing", "bill_file", 'billings/new_state.php', 'billing/generate_bill_file');
    }

    public function generate_bill_file()
    {
        //  var_dump();exit;
        if ($this->input->post()) {
            $data = $this->input->post();
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($data['period'], 3, 2) . substr($data['period'], 0, 2) . substr($data['period'], 6);
            $customer_id = $this->customer_model->getALL(array("name" => $data['customer']));
            // l'id du state pour ce client à cette période
            $state_id = $this->state_model->getALL(array("period" => $period, "customerID" => $customer_id[0]->id, "type" => 'FF'));
            // le fichier de facturation pour ce client à cette période
            $bill_file = $this->billing_model->getALL(array("state_file_id" => $state_id[0]->id));
            $intervals = $this->configuration_model->all('cash_interval');
            $totalCommissions = 0;
            $totalDomicile = 0;
            $totalRejets = 0;
            $totalRetours = 0;
            $totalEchecs = 0;
            $totalRelais = 0;
            foreach ($bill_file as $bill) {
                if ($bill->amount_collected == "")
                    $commissions = "";
                else {
                    $i = -1;
                    do {
                        $i++;
                        $dataInterval = explode('-', $intervals[$i]->interval);

                    } while ((int)$bill->amount_collected > (int)$dataInterval[1]);
                    $commissionsId = $intervals[$i]->id;
                    $commissions = (int)$this->cash_model->getALL(array('cash_interval_id' => $commissionsId))[0]->amount;

                    $bill_file = $this->billing_model->getALL(array("state_file_id" => $state_id[0]->id));
                    $intervals = $this->configuration_model->all('cash_interval');

                    foreach ($bill_file as $bill) {
                        $i = -1;
                        do {
                            $i++;
                            $dataInterval = explode('-', $intervals[$i]->interval);

                        } while (intVal($bill->amount_collected) > intVal($dataInterval[1]));
                        $commissionsId = $intervals[$i]->id;

                        $commissions = $this->cash_model->getALL(array('cash_interval_id' => $commissionsId));
                        var_dump($commissions);
                        die;
                        $poid = $this->configuration_model->getWhere('weight', 'name', $bill->weight)[0]->id; // id du poids partant de son nom
                        // $zone = $this->configuration_model->getWhere('regions','name',$bill->region) ;   // id de la zone partant de la région
                        $zoneId = $this->region_model->getALL(array("name" => $bill->region))[0]->zone_id;
                        $domicile = $this->local_model->getALL(array("name" => 'A domicile'))[0]->id; // id à domicile
                        $bureau = $this->local_model->getALL(array("name" => 'Bureau de poste'))[0]->id; // id en point relais

                        $tarifDomicile = $this->deposit_model->getALL(array("zone_id" => $zoneId, "weight_id" => $poid, "deposit_local_id" => $domicile, "customer_id" => $customer_id[0]->id));
                        $tarifBureau = $this->deposit_model->getALL(array("zone_id" => $zoneId, "weight_id" => $poid, "deposit_local_id" => $bureau, "customer_id" => $customer_id[0]->id));
                        $tarifRejets = 0;
                        $tarifRetours = 0;
                        $tarifEchecs = 0;
                        if ($bill->final_status == 'Returned') {
                            if (intVal($tarifDomicile) == 0)
                                $tarifRetours = intVal($tarifBureau) / 2;
                            else
                                $tarifRetours = intVal($tarifDomicile) / 2;
                        }

                        $zone = $this->configuration_model->getWhere('regions', 'name', $bill->region)[0]->zone_id;
                        $poid = $this->configuration_model->getWhere('weight', 'name', $bill->weight)[0]->id; // id du poids partant de son nom

                        $domicile = $this->local_model->getALL(array("name" => 'A domicile'))[0]->id; // id à domicile
                        $bureau = $this->local_model->getALL(array("name" => 'Bureau de poste'))[0]->id; // id en point relais


                        $tarifDomicile = (int)$this->deposit_model->getALL(array("weight_id" => $poid, "zone_id" => $zone, "deposit_local_id" => $domicile, "customer_id" => $customer_id[0]->id))[0]->amount;

                        $tarifBureau = (int)$this->deposit_model->getALL(array("zone_id" => $zone, "weight_id" => $poid, "deposit_local_id" => $bureau, "customer_id" => $customer_id[0]->id))[0]->amount;

                        $tarifRejets = 0;
                        $tarifRetours = 0;
                        $tarifEchecs = 0;
                        if (($bill->final_status == 'Returned') || ($bill->final_status == 'At the hub picked')) {
                            if ($tarifDomicile == 0)
                                $tarifRetours = $tarifBureau / 2;
                            else
                                $tarifRetours = $tarifDomicile / 2;
                        } else if (($bill->final_status == 'Reversed') || ($bill->final_status == 'Failed') || ($bill->final_status == 'Lost') || ($bill->final_status == 'On the way to the hub') || ($bill->final_status == 'Partially delivered')) {
                            if ($tarifDomicile == "") {
                                $tarifRejets = $tarifBureau;
                                $tarifEchecs = $tarifBureau;
                            } else {
                                $tarifRejets = $tarifDomicile;
                                $tarifEchecs = $tarifDomicile;
                            }

                        }


                        $data[] = array("Num" => $bill->id,
                            "Date de collecte" => $bill->date_collected,
                            "Numéro de commande" => $bill->order_number,
                            "Num colis AIGE" => $bill->tracking_number,
                            "Destination" => $bill->destination,
                            "Poids" => $bill->weight,
                            "Statut final" => $bill->final_status,
                            "Date statut final" => $bill->final_status_date,
                            "Tarif à domicile" => $tarifDomicile,
                            "Tarif en point relais" => $tarifBureau,
                            "Tarif rejets" => $tarifRejets,
                            "Tarif retours" => $tarifRetours,
                            "Tarif échecs" => $tarifEchecs,
                            "Cash collecté" => $bill->amount_collected,
                            "Commission sur cash collecté" => $commissions,
                        );
                        var_dump($data);

                        $totalCommissions += $commissions;
                        $totalDomicile += $tarifDomicile;
                        $totalRejets += $tarifRejets;
                        $totalRetours += $tarifRetours;
                        $totalEchecs += $tarifEchecs;
                        $totalRelais += $tarifBureau;

                    }
                    //var_dump($data);exit;

                    $name = "billing";
                    $file_type = "Listing de facturation";
                    $file_name = "listing";
                    $path = "billing/generate_bill_file";
                    $file = "./upload/model/listing.xlsx";
                    $newfile = "./upload/billing/listing_" . $period . ".xlsx";

                    $type = "LF";
                    $headers = array('No', 'Date de collecte', 'Numéro de commande', 'No colis AIGE', 'Destination', 'Poids', 'Statut final', 'Date statut final');
                    $file_text_name = "Listing de facturation";
                    $name_file = "listing_file";
                    $nam = "listing_" . $period;
                    $test = "listing";
                    $this->generate_listing($test, $name_file, $nam, $data, $state_id[0]->id, "LF", "Listing de facturation", "billing", $customer_id, $period, $headers, $file, $newfile, $path, $file_name, $name, $billing_id);
                }
            }
        }
    }


    public function generate_listing($test, $name_file, $nam, $data, $state_file_id, $type, $file_type, $file_name, $customer_id, $type_file_required, $period, $headers, $file, $newfile, $path, $name, $billing_id = null) {
        $error = null;

        if ($billing_id != null && empty($billing_id) || empty($state_file_id)) {
            $error = "Ce fichier ne peut pas encore être généré car le fichier requis  correspondant à ces critères n'a pas encore été chargé. Veuillez le charger et réessayer";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } elseif (empty($state_file_id)) {
            $error = "Ce fichier ne peut pas encore être généré car fichier des " . $name . " correspondant à ces critères n'a pas encore été chargé. Veuillez le charger et réessayer";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } elseif (!empty($this->state_model->getALL(array("period" => $period, "type" => $type, "customerID" => $customer_id[0]->id)))) {
            $error = "un fichier correspondant à ces critères existe déjà. Veuillez le supprimer et réessayer ou changez de critères";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } else {

            $name = $name . "_" . $period . ".xlsx";
            $this->generating_file($test, $file, $newfile, $data, $name);
            $this->state_model->insert(array("file_path" => $newfile, "type" => $type, "facturation_date" => $state_file_id[0]->facturation_date, "period" => $period, "customerID" => $customer_id[0]->id, "name" => $nam));

            $this->list_file($name_file, "votre fichier a bien été généré. Vous pouvez le consulter dans la liste ci-dessous");
        }
    }






}




