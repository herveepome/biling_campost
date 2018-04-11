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

//require_once APPPATH . 'third_party/PhpOffice/PhpSpreadsheet/Spreadsheet.php';
//require_once APPPATH . 'third_party/PhpOffice/PhpSpreadsheet/Writer/Xlsx.php';

libxml_disable_entity_loader(false);

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
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
        $this->load->model('tempo_model');
        $this->load->model('bill_number_model');

        $this->load->library('excel');
        $this->load->library('htmlpdf');
        $this->load->library('session');
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

    // générer le fichier de facturation
     public function generate_file($test, $name_file, $nam, $data, $operation_id, $type, $file_text_name,  $customer_id, $period, $headers, $file, $newfile, $path, $file_name, $name, $dateFacturation,$versement_id,$file_type) {
        $error = null;

      // var_dump($period); die;
        if (empty($versement_id) || empty($operation_id)) {
            $error = "Ce fichier ne peut pas encore être généré car au moins un des fichiers requis  correspondant à ces critères n'a pas encore été chargé. Veuillez le(s) charger et réessayer";
            $this->session->message = $error ;
             redirect("billing/create");

        } elseif (empty($operation_id)) {

             } elseif (!empty($this->state_model->getALL(array("period" => $period, "type" => $type, "customerID" => $customer_id[0]->id)))) {
            $error = "un fichier correspondant à ces critères existe déjà. Veuillez le supprimer et réessayer ou changez de critères";
            $this->session->message = $error ;
            redirect("billing/create");

             } else {

            $name = $name . "_" . $period . ".xlsx";
            $weight = $this->configuration_model->all("weight");
            var_dump($weight); die;
             foreach ($data as $row) {
                /*if(is_numeric($row->size)) {
                    $i=-1 ;
                    do {
                            $i++;
                            $dataInterval = explode('-', $intervals[$i]->interval);

                        } while ((int)$bill->amount_collected > (int)$dataInterval[1]);

                    do{
                        $i++ ;
                    }while()
                } */
            	$rows[] = array(
            	   // 'id'=>$row->id,
			    	'date_collected'=>$row->start_time,
			    	'tracking_number'=>$row->tracking_number,
			    	'destination'=>$row->address,
			    	'region'=>$row->region,
			    	'order_number'=>$row->order,
			    	'weight'=>$row->size,
			    	'final_status'=>$row->status,
			    	'final_status_date'=>$row->delivered_date,
			    	'deleted'=>0,
			    	'amount_to_collect'=>$row->amount_to_collect,
			    	'amount_collected'=>$row->amount_collected,
			    	'deposit_local'=>$row->deposit_local
					);
            }


            // créer une table temporaire qui sera supprimée plustard et sur laquelle les éditions du FF se feront
           $req =  $this->operation_model->executeQuery("DROP TABLE IF EXISTS tempo_bill  " );

            if ($this->operation_model->executeQuery("CREATE TABLE tempo_bill( `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL ,`date_collected` varchar(32) NOT NULL, `tracking_number` varchar(32) NOT NULL,`destination` varchar(32) NOT NULL,`region` varchar(50) NOT NULL, `order_number` varchar(50) NOT NULL,`weight` varchar(50) DEFAULT NULL, `final_status` varchar(50) NOT NULL, `final_status_date` varchar(50) NOT NULL,`deleted` varchar(5) NOT NULL DEFAULT '0', `amount_to_collect` varchar(45) NOT NULL, `amount_collected` varchar(45) NOT NULL, `deposit_local` varchar(45) NOT NULL)"))

                $this->tempo_model->insert_many_rows($rows);

           $result['billings'] = $this->tempo_model->getALL(array("deleted"=>0));

           $result['period'] = $period;
           $result['infos'] = array("customer"=>$customer_id[0]->id,
                                    "name"=>$nam,
                                    "period"=>$period,
                                    "newfile"=>$newfile,
                                    "type"=>$type,
                                    "date_de_facturation"=>$dateFacturation,
                                    );
            $this->session->item = $result['infos'];



            $result['malformedLines']= $this->malformedLines();


            $this->load->view('general/header.php');
            $this->load->view('billings/list_bill.php', $result);
            $this->load->view('general/footer.php');



        }
    }
// les lignes dont les régions sont vides ou mal formées
    public function malformedLines(){
        $query = $this->operation_model->getCroisedRows("SELECT s.id from (SELECT * from tempo_bill t where t.region='' or t.region not in (select r.name from regions r)  )s ");
        return $query ;
    }

// les données nécessaires à la génération du fichier de facturation
    public function generate_billing_file(){
        if ($this->input->post()) {
            $dataInput = $this->input->post();
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($dataInput['period'], 3, 2) . substr($dataInput['period'], 0, 2) . substr($dataInput['period'], 6);
            $customer_id = $this->customer_model->getALL(array("name" => $dataInput['customer']));

            //$state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FO", "customerID" => $customer_id[0]->id)));

            $operation_id=$this->state_model->getALL(array("type" =>"FO","period"=>$period,"customerID"=>$customer_id[0]->id));

            $versement_id=$this->state_model->getALL(array("type" =>"FV","period"=>$period,"customerID"=>$customer_id[0]->id));

            //$state_croisement_id = ($this->state_model->getALL(array("period" => $period, "type" => "FV", "customerID" => $customer_id[0]->id)));
            //var_dump($operation_id,$versement_id);die;
             $data=array();

            if (!empty($operation_id) && !empty($versement_id) ){

               $this->operation_model->executeQuery("CREATE  TEMPORARY TABLE IF NOT EXISTS nominal AS ("
                    . "select * from (SELECT v.reference,"
                    . "o.status,o.start_time,o.tracking_number,o.size,o.order,o.delivered_date,"
                    . "o.address,o.region,o.payment_method,o.amount_to_collect, v.credit as amount_collected,"
                    . "o.bureau, o.date_operation, o.deposit_local FROM versement v LEFT join operation o "
                    . "ON o.tracking_number=v.reference  AND o.state_file_id=".$operation_id[0]->id." AND v.state_file_id=".$versement_id[0]->id
                    . " ORDER BY o.order)A where A.tracking_number IS NOT NULL)");

                //tuples avec les éléments de tracking_number null pour traiter les scénario alternatif
                $this->operation_model->executeQuery("CREATE  TEMPORARY TABLE IF NOT EXISTS alternatifs AS "
                    ."(select t.reference,s.status,s.start_time,s.tracking_number,s.size,s.order,s.delivered_date,"
                    ."s.address,s.region,s.payment_method,s.amount_to_collect, t.credit as amount_collected,"
                    ."s.bureau, s.date_operation, s.deposit_local from versement t left join operation s ON right(t.reference,LENGTH(s.order))=s.order "
                    ." where s.tracking_number<>t.reference AND t.id in (select A.id from "
                    ."(SELECT v.id,o.tracking_number FROM versement v LEFT join operation o "
                    ."ON o.tracking_number=v.reference AND o.state_file_id=".$operation_id[0]->id." AND v.state_file_id=".$versement_id[0]->id." ORDER BY o.order)A where A.tracking_number IS NULL) "
                    ."AND s.tracking_number IS NOT NULL AND s.state_file_id=".$operation_id[0]->id." AND t.state_file_id=".$versement_id[0]->id. ")");

                $this->operation_model->executeQuery("CREATE  TEMPORARY TABLE IF NOT EXISTS alternatifs_egaux AS"
                    ."(SELECT * FROM `alternatifs`A "
                    . "WHERE cast(A.amount_to_collect as unsigned integer)=cast(A.amount_collected as unsigned integer) "
                    . "AND right(A.reference,LENGTH(A.order))=A.order AND right(A.tracking_number,LENGTH(A.order))=A.order)");


                $this->operation_model->executeQuery("CREATE  TEMPORARY TABLE IF NOT EXISTS alternatifs_differents AS"
                    . " SELECT * FROM `alternatifs`A "
                    . "WHERE cast(A.amount_to_collect as unsigned integer)<>cast(A.amount_collected as unsigned integer) "
                    . "AND right(A.reference,LENGTH(A.order))=A.order AND right(A.tracking_number,LENGTH(A.order))=A.order");

                $this->operation_model->executeQuery("CREATE  TEMPORARY TABLE IF NOT EXISTS alternatifs_superieur AS ( "
                    . "select v.reference,m.status,"
                    . "m.start_time,m.tracking_number,m.size,m.order,m.delivered_date,"
                    ."m.address,m.region,m.payment_method,m.amount_to_collect, v.credit as amount_collected,"
                    ."m.bureau, m.date_operation, m.deposit_local from versement v left join operation m "
                    . "on right(v.reference,LENGTH(m.order))=m.order where m.order in "
                    . "(select DISTINCT a.order from alternatifs_differents a "
                    . "left join operation o on o.order=a.order where a.amount_collected in (select T.credit "
                    . "from(select sum(cast(c.amount_to_collect as unsigned integer)) as credit,"
                    . "c.order from operation c group by c.order)T where o.order=T.order) "
                    . "order by a.order)AND m.state_file_id=".$operation_id[0]->id." AND v.state_file_id=".$versement_id[0]->id.")");



                //scénario nominal du croisement
                $nominal=$this->operation_model->getCroisedRows("SELECT * from nominal");


                //Scénario alternatif avec amount_to_collect égal à amount_collected
                $alternatifs_egaux=$this->operation_model->getCroisedRows("select * from alternatifs_egaux");


                //Scénario alternatif avec amount_to_collect < à amount_collected
                $alternatifs_differents=$this->operation_model->getCroisedRows("select * from alternatifs_superieur");

                $this->operation_model->executeQuery("DROP TABLE nominal");
                $this->operation_model->executeQuery("DROP TABLE alternatifs");
                $this->operation_model->executeQuery("DROP TABLE alternatifs_egaux");
                $this->operation_model->executeQuery("DROP TABLE alternatifs_differents");
                $this->operation_model->executeQuery("DROP TABLE alternatifs_superieur");
                $data =  array_merge($nominal,$alternatifs_egaux,$alternatifs_differents);


            }

            $name = "billing";
            $file_type = "Fichier de facturation";
            $file_name = "billing_file";
            $path = "billing/generate_billing_file";
            $file = "./upload/model/returned_paidonline_delivery.xlsx";
            $newfile = "./upload/billing/billing_" . $period . ".xlsx";
            $dateFacturation = $dataInput['period'];

            $type = "FF";
            $headers = array('No', 'Date de collecte', 'Numéro de commande', 'No colis AIGE', 'Destination', 'Poids','Region','Lieux de dépôt','Statut final', 'Date statut final');
            $file_text_name = "Ficher de facturation";
            $name_file = "billing_file";
            $nam = "billing_" . $period;
            $test = "billing";

            $this->generate_file($test, $name_file, $nam, $data, $operation_id, $type, $file_text_name, $customer_id, $period, $headers, $file, $newfile, $path, $file_name, $name, $dateFacturation,$versement_id,$file_type);
        }

    }

    public function newLine() {
        $this->editBilling();
    }


    public function editBilling($id=null) {

            $data['billing'] = null;

        if ($id != null) {

            $data['billing']=$this->tempo_model->getALL(array("id"=>$id));

        }

        $data['malformedLines']= $this->malformedLines();

        $this->load->view('general/header.php');
        $this->load->view('billings/new_billing.php', $data);
        $this->load->view('general/footer.php');
    }

    public function store() {
        $this->update();
    }

    public function update($id = null)

    {
        if ($this->input->post()) {
            extract($this->input->post(NULL, TRUE));
            $billing = $this->input->post();
            if ($id == null) {
                $this->tempo_model->insert($billing);
            } else {
                $this->tempo_model->insert($billing, $id);
            }
            $this->list_billing_file();
        }
    }



    public function read($id=null) {
        if(isset($_SESSION['item']) && $_SESSION['item']!=null){
            $infos = $_SESSION['item'];
            if ($id==null){


                $id=$this->state_model->insert(array("file_path" => $infos['newfile'], "type" => $infos['type'] ,"facturation_date" => $infos['date_de_facturation'], "period" => $infos['period'], "customerID" => $infos['customer'], "name" => $infos['name']));

                $tempo_bill  = $this->operation_model->getCroisedRows("select * from tempo_bill t1 where t1.id not in (SELECT s.id from (SELECT * from tempo_bill t2 where t2.region='' or t2.region not in (select r.name from regions r)  )s)");

                foreach ($tempo_bill as $tempo){
                    if($tempo->deposit_local=="")
                        $tempo->deposit_local = "A domicile";
                    $rows[] = array(
                        'date_collected'=>$tempo->date_collected,
                        'tracking_number'=>$tempo->tracking_number,
                        'destination'=>$tempo->destination,
                        'region'=>$tempo->region,
                        'order_number'=>$tempo->order_number,
                        'weight'=>$tempo->weight,
                        'state_file_id'=>$id,
                        'final_status'=>$tempo->final_status,
                        'final_status_date'=>$tempo->final_status_date,
                        'deleted'=>0,
                        'amount_to_collect'=>$tempo->amount_to_collect,
                        'amount_collected'=>$tempo->amount_collected,
                        'deposit_local'=>$tempo->deposit_local
                    );

                }

                $this->operation_model->executeQuery("DROP TABLE IF EXISTS tempo_bill  " );
                $this->billing_model->insert_many_rows($rows);
            }
            $data['file_text_name'] ='Fichier de facturation de la période du ' .$infos['period'] ;
        }
        else
            $data['file_text_name'] ='Fichier de facturation ' ;
        $data['billing']=$this->billing_model->getALL(array("deleted"=>0, "state_file_id"=>$id));

        $this->load->view('general/header.php');
        $this->load->view('billings/read_billing.php', $data);
        $this->load->view('general/footer.php');


    }

    public function destroy($id) {
        $this->tempo_model->insert(array("deleted"=>1),$id);
        //var_dump($state_file_id);die;
        $this->list_billing_file();
    }

    public function list_billing_file() {
        $data['malformedLines']= $this->malformedLines();
        $data["billings"]= $this->tempo_model->getALL(array("deleted"=>0));
        $this->load->view('general/header.php');
        $this->load->view('billings/list_bill.php', $data);
        $this->load->view('general/footer.php');
    }

//générer la facture
    public function createBill() {
        $this->create_file("LISTING et de la FACTURE", "bill_file", 'billings/new_state.php', 'billing/generate_bill_file');
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
            $bill_file=array();
            // le fichier de facturation pour ce client à cette périod
            if(!empty($state_id))
            $bill_file = $this->billing_model->getALL(array("state_file_id" => $state_id[0]->id));

            $intervals = $this->configuration_model->all('cash_interval');
            $totalCommissions = 0;
            $totalDomicile = 0;
            $totalRejets = 0;
            $totalRetours = 0;
            $totalEchecs = 0;
            $totalRelais = 0;
            $interval_poids = $this->configuration_model->all('weight');
         $listing_rows=array();
         $facture=array();

          if(!empty($bill_file)){

                foreach ($bill_file as $bill) {
                    // gestion des commissions sur les cash collectés
                    if ($bill->amount_collected == "")
                        $commissions = "";
                    else if ($bill->amount_collected > 500000)
                        $commissions = $bill->amount_collected / 100;
                    else {
                        $i = -1;
                        do {
                            $i++;
                            $dataInterval = explode('-', $intervals[$i]->interval);

                        } while ((int)$bill->amount_collected > (int)$dataInterval[1]);

                        $commissionsId = $intervals[$i]->id;

                        $commissions = $this->cash_model->getALL(array('cash_interval_id' => $commissionsId))[0]->amount;
                    }
                    $poids30 = $this->configuration_model->getWhere('weight', 'weight',20000-30000);

                    // gestion des tarifs à domicile ou en point relais


                    $zone = $this->configuration_model->getWhere('regions', 'name', $bill->region)[0]->zone_id;   // id de la zone partant de la région
                    $domicile = $this->local_model->getALL(array("name" => 'A domicile'))[0]->id; // id à domicile
                    $bureau = $this->local_model->getALL(array("name" => 'Bureau de poste'))[0]->id; // id en point relais

                    if ($bill->deposit_local == "A domicile") {

                        if(is_int(str_replace(' ', '', $bill->weight))){
                            $size = str_replace(' ', '', $bill->weight) ;
                            if ($size > 30){
                                $extra = $size - 30 ;
                                $poid = $poids30[0]->id;
                                $tarifBureau = 0;
                                $tarifDomicile = $this->deposit_model->getALL(array("zone_id" => $zone, "weight_id" => $poid, "deposit_local_id" => $domicile, "customer_id" => $customer_id[0]->id))[0]->amount + (100*$extra);
                            }
                            else{
                                $j = -1;
                                do {
                                    $j++;
                                    $dataWeight= explode('-', $interval_poids[$i]->weight);

                                } while ($size > (int)$dataWeight[1]);
                                $poid = $interval_poids['$j']->id ;
                                $tarifBureau = 0;
                                $tarifDomicile = $this->deposit_model->getALL(array("zone_id" => $zone, "weight_id" => $poid, "deposit_local_id" => $domicile, "customer_id" => $customer_id[0]->id))[0]->amount;
                            }
                        }
                        else{
                            $poid = $this->configuration_model->getWhere('weight', 'name', $bill->weight)[0]->id; // id du poids partant de son nom
                            $tarifDomicile = $this->deposit_model->getALL(array("zone_id" => $zone, "weight_id" => $poid, "deposit_local_id" => $domicile, "customer_id" => $customer_id[0]->id))[0]->amount;
                            $tarifBureau = 0;
                        }

                    } else {
                        if(is_int(str_replace(' ', '', $bill->weight))){
                            $size = str_replace(' ', '', $bill->weight) ;
                            if ($size > 30){
                                $extra = $size - 30 ;
                                $poid = $poids30[0]->id;
                                $tarifDomicile = 0;
                                $tarifBureau = $this->deposit_model->getALL(array("zone_id" => $zone, "weight_id" => $poid, "deposit_local_id" => $bureau, "customer_id" => $customer_id[0]->id))[0]->amount + (100*$extra);
                            }
                            else{
                                $j = -1;
                                do {
                                    $j++;
                                    $dataWeight= explode('-', $interval_poids[$i]->weight);

                                } while ($size > (int)$dataWeight[1]);
                                $poid = $interval_poids['$j']->id ;
                                $tarifDomicile = 0;
                                $tarifBureau = $this->deposit_model->getALL(array("zone_id" => $zone, "weight_id" => $poid, "deposit_local_id" => $bureau, "customer_id" => $customer_id[0]->id))[0]->amount;
                            }
                        }
                        else{
                            $poid = $this->configuration_model->getWhere('weight', 'name', $bill->weight)[0]->id; // id du poids partant de son nom
                            $tarifBureau = $this->deposit_model->getALL(array("zone_id" => $zone, "weight_id" => $poid, "deposit_local_id" => $bureau, "customer_id" => $customer_id[0]->id))[0]->amount;
                            $tarifDomicile = 0;
                        }


                    }
                    // gestion de la tarification retour

                    $tarifRejets = 0;
                    $tarifRetours = 0;
                    $tarifEchecs = 0;

                    if (($bill->final_status == 'Returned') || ($bill->final_status == 'At the hub') ) {

                        if ($tarifDomicile == 0)
                            $tarifRetours = 0.5 * (float)$tarifBureau;
                        else

                            $tarifRetours = 0.5*(float)$tarifDomicile;

                    } else if (($bill->final_status == 'Reversed') || ($bill->final_status == 'Failed') || ($bill->final_status == 'Lost')  || ($bill->final_status == 'Partially delivered')) {
                        if ($tarifDomicile == 0) {
                            $tarifEchecs = $tarifBureau;
                        } else {
                            $tarifEchecs = $tarifDomicile;
                        }

                    }
                    else if($bill->final_status == 'On the way to hub'){
                        if ($tarifDomicile == 0) {
                            $tarifRejets = $tarifBureau;
                        } else {
                            $tarifRejets = $tarifDomicile;
                        }
                    }

                // les données du listing et de la facture

                    $listing_rows[] = array("Num" => $bill->id,

                        "Date_de_collecte" => $bill->date_collected,
                        "Numero_de_commande" => $bill->order_number,
                        "Num_colis_AIGE" => $bill->tracking_number,
                        "Destination" => $bill->destination,
                        "Poids" => $bill->weight,
                        "Statut_final" => $bill->final_status,
                        "Date_statut_final" => $bill->final_status_date,
                        "Tarif_domicile" => $tarifDomicile,
                        "Tarif_en_point_relais" => $tarifBureau,
                        "Tarif_retours" => $tarifRetours,
                        "Tarif_echecs" => $tarifEchecs,
                        "Tarif_rejets" => $tarifRejets,
                        "Cash_collecte" => $bill->amount_collected,
                        "Commission_sur_cash_collecte" => $commissions,
                    );

                //données de la facture
                            //données de la facture
                $totalCommissions += (float)$commissions;
                $totalDomicile += (float)$tarifDomicile;
                $totalEchecs += (float)$tarifEchecs;
                $totalRejets+= (float)$tarifRejets;
                $totalRelais += (float)$tarifBureau;
                $totalRetours += (float)$tarifRetours ;

             }

                $facture["totalCommissions"] = $totalCommissions;
                $facture["totalDomicile"] = $totalDomicile;
                $facture["totalEchecs"] = $totalEchecs;
                $facture["totalRejets"]= $totalRejets;
                $facture["totalRelais"] = $totalRelais;
                $facture["totalRetours"] = $totalRetours ;


                $listing_facture["listing_rows"]=$listing_rows;
                $listing_facture["facture"]=$facture;

                    $name = "facturation";
                    $file_type = "Listing de facturation";
                    $file_name = "listing";
                    $path = "billing/generate_bill_file";
                    $file = "./upload/model/listing.xlsx";
                    $newfilelisting = "/upload/listing/listing_" . $period . ".xlsx";
                    $newfilefact = "./upload/billing/facture_" . $period . ".xls";

                    $billing_id=null;
                    if(!empty($state_id))
                    $billing_id = $state_id[0]->id ;

                    $type = "LF";
                    $facturation_date = $data['period'] ;
                    $headers = array('No', 'Date de collecte', 'Numéro de commande', 'No colis AIGE', 'Destination', 'Poids', 'Statut final', 'Date statut final');
                    $file_text_name = "Listing de facturation";
                    $name_file = "listing_file";
                    $name=array();

                    $name["namlisting"] = "listing_" .str_replace(' ', '',$customer_id[0]->name)."_".$period;
                    $name["facture"] = "facture_" .str_replace(' ', '',$customer_id[0]->name)."_".$period;


                    $newfilelisting = "/upload/listing/" . $name["namlisting"] . ".xlsx";
                    $newfilefact = "./upload/bill/". $name["facture"]. ".xls";


                    $test = "listing";

                    $this->generate_facture($test, $name_file, $name, $listing_facture, $type, $file_text_name, $facturation_date, $file_name, $customer_id, $period, $headers, $file, $newfilelisting, $newfilefact, $path,$file_type,$billing_id);


            }
        }
    }




    public function generate_facture($test, $name_file, $name, $data, $type, $file_text_name, $facturation_date, $file_name, $customer_id, $period, $headers, $file, $newfilelisting, $newfilefact, $path, $file_type, $billing_id = null) {

        $error = null;

        if ($billing_id == null) {
            $error = "Ce fichier ne peut pas encore être généré car le fichier requis  correspondant à ces critères n'a pas encore été chargé. Veuillez le charger et réessayer";
            $this->session->message = $error ;
            redirect("bill/create");

        } elseif (!empty($this->state_model->getALL(array("period" => $period, "type" => "LF", "customerID" => $customer_id[0]->id)))
                ||!empty($this->state_model->getALL(array("period" => $period, "type" => "F", "customerID" => $customer_id[0]->id)))
               ) {
            $error = "un fichier correspondant à ces critères existe déjà. Changez de critères et réessayez!";
            $this->session->message = $error ;
            redirect("bill/create");

               } else {
            //renseigne la base de données de la création d'un nouveau litiong
            $this->state_model->insert(array("file_path" => $newfilelisting,
                "type" => "LF", "facturation_date" => $facturation_date,
                "period" => $period, "customerID" => $customer_id[0]->id,
                "name" => $name["namlisting"]));
            //création du listing
            if ($data["listing_rows"] != null && !empty($data["listing_rows"]))
            $this->listing_file($data["listing_rows"],$name["namlisting"]);

            //renseigne dans la base de données la création de la facture
            $id_facture=$this->state_model->insert(array("file_path" => $newfilefact,
                "type" => "F", "facturation_date" => $facturation_date,
                "period" => $period, "customerID" => $customer_id[0]->id,
                "name" => $name["facture"]));

            $bill_number=$this->bill_number_model->insert(array("bill_id" => $id_facture));
            $bill_number="FACTURE N°".$bill_number."/".$customer_id[0]->name."/".substr ($period,2);

            //var_dump("PERIODE: ".$this->monthinFrench(substr ($period,2,2))." ".substr ($period,6),$customer_id[0]);die;

            //création de la facture
            if ($data["facture"] != null && !empty($data["facture"]))
            $this->facture_file($data["facture"],$name["facture"],$bill_number,
           "PERIODE: ".$this->monthinFrench(date('F', mktime(0, 0, 0, substr ($period,2,2))))." ".substr ($period,4),$customer_id[0] );
            $this->list_facture($fact=1);

            /*$inputFileType = PHPExcel_IOFactory::identify("./upload/bill/" . $name["facture"].".xls");
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load("./upload/bill/" . $name["facture"].".xls");
            $name_facture=$name["facture"].".pdf";

            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment;filename=\"" . $name_facture . "\"");
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
            //$objWriter->save('php://output');*/

                }
    }

     public function list_facture($file_name) {

          redirect("billing/list_facture_file/".$file_name);
    }



    public function listing_file($data, $filename) {


      copy(FCPATH."upload\\model\\listing.xlsx", "upload\\listing\\" . $filename.".xlsx");

        $writer = WriterFactory::create(Type::XLSX);

        $writer->setShouldUseInlineStrings(true)
                ->openToFile(FCPATH."upload\\listing\\" . $filename.".xlsx")
                ->addRow(["Num", "Date de collecte", "Num commande"
                    , "Num colis", "Poids", "Destination", "Statut final", "Date statut final", "Tarif livraison à domicile"
                    , "Tarif livraison en point relais"
                    , "Tarif retour", "Tarif échec", "Tarif rejet", "Cash collecté"
                    , "Commission sur cash collecté"])
                ->addRows($data)
                ->close();
    }

    public function facture_file($data,$filename,$bil_number,$period,$customer) {
        //var_dump($bil_number,$period,$customer);die;


        copy(FCPATH."upload\\model\\facture.xls", FCPATH."upload\\bill\\" . $filename.".xls");

        chmod(FCPATH."upload\\bill\\" . $filename.".xls", 0755);

        $tht=0;
        $ttt=0;

        $tht=$data["totalCommissions"]+$data["totalDomicile"]+
                $data["totalEchecs"]+$data["totalRejets"]+
                $data["totalRelais"]+$data["totalRetours"];
        $tva=round(($tht*19.25)/100,3);
        $ttt=round($tht+$tva,3);

        if (is_float($ttt)){
           $total_letter=  explode(".", (string)$ttt);
           $total_letter="Arrêté la présente facture à la somme de "
                    .numfmt_create('fr_FR', NumberFormatter::SPELLOUT)->format($total_letter[0])
                    ." Francs C.F.A. TTC./-";
        }else{
            $total_letter="Arrêté la présente facture à la somme de "
                    .numfmt_create('fr_FR', NumberFormatter::SPELLOUT)->format($ttt).
                    " Francs C.F.A. TTC./-";
        }




        $inputFileType = PHPExcel_IOFactory::identify(FCPATH."upload\\bill\\" . $filename.".xls");
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load(FCPATH."upload\\bill\\" . $filename.".xls");

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()
                    ->setCellValue('A8',$bil_number)
                    ->setCellValue('A10',$period)
                    ->setCellValue('B12',$customer->name)
                    ->setCellValue('B13',$customer->adress)
                    ->setCellValue('B14',$customer->business_register)
                    ->setCellValue('B15',$customer->uin)
                    ->setCellValue('A20',$data["totalDomicile"])
                    ->setCellValue('C20',$data["totalRelais"])
                    ->setCellValue('D20',$data["totalEchecs"])
                    ->setCellValue('E20',$data["totalRejets"])
                    ->setCellValue('F20',$data["totalRetours"])
                    ->setCellValue('G20',$data["totalCommissions"])
                    ->setCellValue('H20',$tht)
                    ->setCellValue('H21',$tva)
                    ->setCellValue('H22',$ttt)
                    ->setCellValue('A25',$total_letter);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(FCPATH."upload\bill\\" . $filename.".xls");



    }

    public function monthinFrench($month) {
        $final_month="";
        switch ($month) {

            case "January":
            $final_month="Janvier";
            break;

            case "February":
            $final_month="Février";
            break;

            case "March":
            $final_month="Mars";
            break;

            case "April":
            $final_month="Avril";
            break;

            case "May":
            $final_month="Mai";
            break;

            case "June":
            $final_month="Juin";
            break;

            case "July":
            $final_month="Juillet";
            break;

            case "August":
            $final_month="Août";
            break;

            case "September":
            $final_month="Septembre";
            break;

            case "October":
            $final_month="Octobre";
            break;

            case "November":
            $final_month="Novembre";
            break;

            case "December":
            $final_month="Décembre";
            break;

            default:
            $final_month="Mois inconnu";


        }

        return $final_month;
    }



}

