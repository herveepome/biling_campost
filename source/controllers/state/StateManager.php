<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StateManager
 *
 * @author hepomenzengue
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . 'third_party/spout/src/spout/Autoloader/autoload.php';
//require_once APPPATH ."controller/lib/html2pdf.php";
libxml_disable_entity_loader(false);

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

include_once (APPPATH . 'controllers/MainController.php');

class StateManager extends MainController {

    public function __construct() {
        parent::__construct();
        ini_set("memory_limit", "256M");
        $this->load->model('customer_model');
        $this->load->model('state_model');
        $this->load->model('operation_model');
        $this->load->model('versement_model');
        $this->load->library('excel');
        $this->load->library('htmlpdf');
        //$this->load->library('spout');
    }

    public function index() {
        
    }

    public function create_versement_file() {

        $this->create_file("Fichier des versements", "versement_file", 'billings/new_operation_versment.php', 'files/uploading_versement_file');
    }

    public function uploading_versement_file() {
        if ($this->input->post()) {
            extract($this->input->post(NULL, TRUE));
            //nouveaux noms des fichiers d'opérations et de versement

            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);

            $versed_name = "versement_" . $period;

            //récupération de l'id du client correspondant
            $customer_id = $this->customer_model->getALL(array("name" => $customer));


            $versed_file = './upload/operations_versment/' . $versed_name . '.xlsx';

            $this->uploading_file("file", $versed_name, $customer_id[0]->id, $versed_file, $period, "FV", "versement", "versed_file", $facturation_date, "Fichier des versements", "versement_file", "billings/new_operation_versment.php", "files/create_versement_file");
        }
    }

    public function create_operation_file() {
        $this->create_file("Fichier des opérations", "operation_file", 'billings/new_operation_versment.php', 'files/uploading_operation_file');
    }

    public function uploading_operation_file() {
        if ($this->input->post()) {
            extract($this->input->post(NULL, TRUE));
            //nouveaux noms des fichiers d'opérations et de versement
            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);

            $operations_name = "operation_" . $period;

            //récupération de l'id du client correspondant
            $customer_id = $this->customer_model->getALL(array("name" => $customer));


            $operation_file = './upload/operations_versment/' . $operations_name . '.xlsx';

            $this->uploading_file("file", $operations_name, $customer_id[0]->id, $operation_file, $period, "FO", "operation", "operation_file", $facturation_date, "Fichier des opérations", "operation_file", "billings/new_operation_versment.php", "files/create_operation_file");
        }
    }

    public function create_returned_file() {
        $this->create_file("Fichier des retours", "returned_file", 'billings/new_state.php', 'state/generate_returned_file');
    }

    public function generate_returned_file() {
        if ($this->input->post()) {
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);
            $customer_id = $this->customer_model->getALL(array("name" => $customer));
            $state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FO", "customerID" => $customer_id[0]->id)));
            $operation_id=$this->state_model->getALL(array("type" =>"FO","period"=>$period,"customerID"=>$customer_id[0]->id));
            
            
            $name = "opérations";
            $file_type = "Fichier des retours";
            $file_name = "returned_file";
            $path = "state/generate_returned_file";
            $file = "./upload/model/returned_paidonline_delivery.xlsx";
            $newfile = "./upload/returned/returned_" . $period . ".xlsx";


            $type = "FR";
            $headers = array('Shipment Provider', 'Status', 'SIZE', 'Order', 'Region', 'Payment Method',
                'Amount to collect', 'Bureau', 'D. opé');
            $file_text_name = "Ficher des retournés";
            $name_file = "returned";
            $nam = "returned_" . $period;
            $test = "operations";
            $this->generate_file($test, $name_file, $nam, $state_file_id, "FR", "Fichiers des retours", "returned", $customer_id, $customer, $period, $headers, $file, $newfile, $path, $file_name, $name, $state_croisement_id = null);
        }
    }

    public function list_returned_file() {

        $this->list_file("returned");
    }

    public function create_paidonline() {

        $this->create_file("Fichier des produits payés en ligne", "paidonline_file", 'billings/new_state.php', 'state/generate_paidonline_file');
    }

    public function generate_paidonline() {
        if ($this->input->post()) {
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);
            $customer_id = $this->customer_model->getALL(array("name" => $customer));
            $state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FO", "customerID" => $customer_id[0]->id)));
            $operation_id=$this->state_model->getALL(array("type" =>"FO","period"=>$period,"customerID"=>$customer_id[0]->id));
           
            //var_dump($period,$customer_id,$state_file_id);die;
            $name = "opérations";
            $file_type = "Fichier des payés en ligne";
            $file_name = "paidonline_file";
            $path = "state/generate_paidonline_file";
            $file = "./upload/model/returned_paidonline_delivery.xlsx";
            $newfile = "./upload/paid_online/paidonline_" . $period . ".xlsx";


            $type = "FPO";
            $headers = array('Shipment Provider', 'Status', 'SIZE', 'Order', 'Region', 'Payment Method',
                'Amount to collect', 'Bureau', 'D. opé');
            $file_text_name = "Ficher des payés en ligne";
            $name_file = "paidonline";
            $nam = "paidonline_" . $period;
            $test = "operations";
            $this->generate_file($test, $name_file, $nam, $state_file_id, "FPO", "Fichiers des produits payés en ligne", "returned", $customer_id, $customer, $period, $headers, $file, $newfile, $path, $file_name, $name, $state_croisement_id = null);
        }
    }

    public function list_paidonline() {

        $this->list_file("paidonline");
    }

    public function create_delivery() {

        $this->create_file("Fichier des produits payés à la livraison", "delivery_file", 'billings/new_state.php', 'state/generate_delivery_file');
    }

    public function generate_delivery() {
        if ($this->input->post()) {
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);
            $customer_id = $this->customer_model->getALL(array("name" => $customer));
            $state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FO", "customerID" => $customer_id[0]->id)));

            
            //var_dump($period,$customer_id,$state_file_id);die;
            $name = "opérations";
            $file_type = "Fichier des payés à la livraison";
            $file_name = "delivery_file";
            $path = "state/generate_delivery_file";
            $file = "./upload/model/returned_paidonline_delivery.xlsx";
            $newfile = "./upload/delivery/delivery_" . $period . ".xlsx";


            $type = "FCD";
            $headers = array('Shipment Provider', 'Status', 'SIZE', 'Order', 'Region', 'Payment Method',
                'Amount to collect', 'Bureau', 'D. opé');
            $file_text_name = "Ficher des payés à la livraison";
            $name_file = "cashondelivery";
            $nam = "cashondelivery_" . $period;
            $test = "operations";
            $this->generate_file($test, $name_file, $nam, $state_file_id, "FCD", "Fichiers des produits payés à la livraison", "delivery", $customer_id, $customer, $period, $headers, $file, $newfile, $path, $file_name, $name, $state_croisement_id = null);
        }
    }

    public function list_delivery() {

        $this->list_file("cashondelivery");
    }

    public function create_croised() {

        $this->create_file("Fichier croisé", "croised_file", 'billings/new_state.php', 'state/generate_croised_file');
    }

    public function generate_croised() {
        //var_dump($this->input->post());die;
        if ($this->input->post()) {
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);
            $customer_id = $this->customer_model->getALL(array("name" => $customer));

            $state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FO", "customerID" => $customer_id[0]->id)));
            $operation_id=$this->state_model->getALL(array("type" =>"FO","period"=>$period,"customerID"=>$customer_id[0]->id));
            $versement_id=$this->state_model->getALL(array("type" =>"FV","period"=>$period,"customerID"=>$customer_id[0]->id));
            $state_croisement_id = ($this->state_model->getALL(array("period" => $period, "type" => "FV", "customerID" => $customer_id[0]->id)));
            
            //var_dump($period,$customer_id,$state_file_id);die;
            $name = "opérations";
            $file_type = "Fichier croisé";
            $file_name = "croised_file";
            $path = "state/generate_croised_file";
            $file = "./upload/model/returned_paidonline_delivery.xlsx";
            $newfile = "./upload/croised/croised_" . $period . ".xlsx";


            $type = "FC";
            $headers = array('Shipment Provider', 'Status', 'SIZE', 'Order', 'Region', 'Payment Method',
                'Amount to collect', 'amount_collected', 'Bureau', 'D. opé');
            $file_text_name = "Ficher croisé";
            $name_file = "croised";
            $nam = "croised_" . $period;
            $test = "croisement";
            $this->generate_file($test, $name_file, $nam, $state_file_id, "FC", "Fichiers croisé", "croised", $customer_id, $customer, $period, $headers, $file, $newfile, $path, $file_name, $name, $state_croisement_id);
        }
    }

    public function list_croised() {

        $this->list_file("croised");
    }
    
    public function create_rejected() {

        $this->create_file("Fichier des rejets", "rejected_file", 'billings/new_state.php', 'state/generate_rejected_file');
    }

    public function generate_rejected() {
        //var_dump($this->input->post());die;
        if ($this->input->post()) {
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);
            $customer_id = $this->customer_model->getALL(array("name" => $customer));

            $state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FO", "customerID" => $customer_id[0]->id)));
            $operation_id=$this->state_model->getALL(array("type" =>"FO","period"=>$period,"customerID"=>$customer_id[0]->id));
            $versement_id=$this->state_model->getALL(array("type" =>"FV","period"=>$period,"customerID"=>$customer_id[0]->id));
            $state_croisement_id = ($this->state_model->getALL(array("period" => $period, "type" => "FV", "customerID" => $customer_id[0]->id)));
            
            //var_dump($period,$customer_id,$state_file_id);die;
            $name = "opérations";
            $file_type = "Fichier des rejets";
            $file_name = "rejected_file";
            $path = "state/generate_rejected_file";
            $file = "./upload/model/returned_paidonline_delivery.xlsx";
            $newfile = "./upload/croised/rejected_" . $period . ".xlsx";


            $type = "FRT";
            $headers = array('Shipment Provider', 'Status', 'SIZE', 'Order', 'Region', 'Payment Method',
                'Amount to collect', 'amount_collected', 'Bureau', 'D. opé');
            $file_text_name = "Ficher des rejets";
            $name_file = "rejected";
            $nam = "rejected_" . $period;
            $test = "croisement";
            $this->generate_file($test, $name_file, $nam, $state_file_id, "FRT", "Fichiers croisé", "croised", $customer_id, $customer, $period, $headers, $file, $newfile, $path, $file_name, $name, $state_croisement_id);
        }
    }

    public function list_rejected() {

        $this->list_file("rejected");
    }
    
    public function create_unvoiced() {

        $this->create_file("Fichier des produits non facturés", "unvoiced_file", 'billings/new_state.php', 'state/generate_unvoiced_file');
    }

    public function generate_unvoiced() {
        //var_dump($this->input->post());die;
        if ($this->input->post()) {
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $period = substr($period, 3, 2) . substr($period, 0, 2) . substr($period, 6);
            $customer_id = $this->customer_model->getALL(array("name" => $customer));

            $state_file_id = ($this->state_model->getALL(array("period" => $period, "type" => "FO", "customerID" => $customer_id[0]->id)));
            $operation_id=$this->state_model->getALL(array("type" =>"FO","period"=>$period,"customerID"=>$customer_id[0]->id));
            $versement_id=$this->state_model->getALL(array("type" =>"FV","period"=>$period,"customerID"=>$customer_id[0]->id));
            $state_croisement_id = ($this->state_model->getALL(array("period" => $period, "type" => "FV", "customerID" => $customer_id[0]->id)));
            
            //var_dump($period,$customer_id,$state_file_id);die;
            $name = "opérations";
            $file_type = "Fichier des produits non facturés";
            $file_name = "unvoiced_file";
            $path = "state/generate_unvoiced_file";
            $file = "./upload/model/returned_paidonline_delivery.xlsx";
            $newfile = "./upload/croised/unvoiced_" . $period . ".xlsx";


            $type = "FUV";
            $headers = array('Shipment Provider', 'Status', 'SIZE', 'Order', 'Region', 'Payment Method',
                'Amount to collect', 'amount_collected', 'Bureau', 'D. opé');
            $file_text_name = "Ficher des produits non facturés";
            $name_file = "unvoiced";
            $nam = "unvoiced_" . $period;
            $test = "croisement";
            $this->generate_file($test, $name_file, $nam, $state_file_id, "FUV", "Fichiers croisé", "croised", $customer_id, $customer, $period, $headers, $file, $newfile, $path, $file_name, $name, $state_croisement_id);
        }
    }

    public function list_unvoiced() {

        $this->list_file("unvoiced");
    }

    public function list_billing() {

        $this->list_file("billing");
    }

    public function list_file($file_name, $message = null) {
        $name = null;

        if ($file_name == "billing") {
            $data["states"] = $this->state_model->getALL(array("type" => "FF"));
            $name = "des fichiers de facturation";
        }
        if ($file_name == "returned") {
            $data["states"] = $this->state_model->getALL(array("type" => "FR"));
            $name = "des produis retournés";
        }
        if ($file_name == "paidonline") {
            $data["states"] = $this->state_model->getALL(array("type" => "FPO"));
            $name = "des produis payés en ligne";
        }
        if ($file_name == "cashondelivery") {
            $data["states"] = $this->state_model->getALL(array("type" => "FCD"));
            $name = "des produis payés à la livraison";
        }
        if ($file_name == "croised") {
            $data["states"] = $this->state_model->getALL(array("type" => "FC"));
            $name = "croisés";
        }
        if ($file_name == "rejected") {
            $data["states"] = $this->state_model->getALL(array("type" => "FRT"));
            $name = "produits rejetés";
        }
        if ($file_name == "unvoiced") {
            $data["states"] = $this->state_model->getALL(array("type" => "FUV"));
            $name = "produits non facturés";
        }


        if ($message != null)
            $data["message"] = $message;
        $data["name"] = $name;


        $this->load->view('general/header.php');
        $this->load->view('billings/list_state.php', $data);
        $this->load->view('general/footer.php');
    }

    public function show($id) {
        
        $state = $this->state_model->getALL(array("id" => $id));
        
        $operation_id=$this->state_model->getALL(array("type" =>"FO","period"=>$state[0]->period,"customerID"=>$state[0]->customerID));
        $versement_id=$this->state_model->getALL(array("type" =>"FV","period"=>$state[0]->period,"customerID"=>$state[0]->customerID));
        
        
        $data = array();

        if ($state[0]->type == "FR") {
            $data["file_text_name"] = $name = "Produits retournés de la période " . $state[0]->period;
            $data["headers"] = array('Order','Tracking Number', 'Status', 'SIZE', 'Region', 'Payment Method',
                'Amount to collect');
            
                $rows = $this->operation_model->getCroisedRows("SELECT DISTINCT o.shipment_provider,o.status, o.tracking_number,o.size,o.order,o.region,o.payment_method,o.amount_to_collect,o.bureau,o.date_operation FROM operation o
                                                            WHERE status = 'Returned' OR status = 'Lost' OR status = 'Reversed' OR status = 'Being returned' OR status = 'At the hub' OR status = 'At the hub - requested' AND state_file_id =" .$operation_id[0]->id.
                                                            " ORDER  BY o.order ");
            
               
            $data["rows"] = $rows;
        }
        if ($state[0]->type == "FPO") {
            $data["file_text_name"] = $name = "Produits payés en ligne de la période " . $state[0]->period;
            $data["headers"] = array('Order','Tracking Number', 'Status', 'SIZE', 'Region', 'Payment Method',
                'Amount to collect');
            $rows = $this->operation_model->getCroisedRows("SELECT DISTINCT o.shipment_provider,o.status,  o.tracking_number,o.size,o.order,o.region,o.payment_method,o.amount_to_collect,o.bureau,o.date_operation FROM operation o
                                                            WHERE amount_to_collect=0 AND state_file_id =" .$operation_id[0]->id.
                                                            " ORDER  BY o.order "); 
             $data["rows"] = $rows;
        }
        if ($state[0]->type == "FCD") {
            $data["file_text_name"] = $name = "Produits payés à la livraison de la période " . $state[0]->period;
            $data["headers"] = array('Order','Tracking Number', 'Status', 'SIZE', 'Region', 'Payment Method',
                'Amount to collect');
            $rows = $this->operation_model->getCroisedRows("SELECT DISTINCT o.shipment_provider,o.status,  o.tracking_number,o.size,o.order,o.region,o.payment_method,o.amount_to_collect,o.bureau,o.date_operation FROM operation o
                                                            WHERE amount_to_collect<>0 AND status <> 'Returned' AND status <> 'Lost' AND status <> 'Reversed' AND status <> 'Being returned' AND status <> 'At the hub' AND status <> 'At the hub - requested'
                                                             AND SUBSTR(REPLACE(o.start_time,'/',''),3,6)=".substr($state[0]->period,2,6)." AND state_file_id =" .$operation_id[0]->id.
                                                            " ORDER  BY o.order "); 
            
            $data["rows"] = $rows;
        }
        if ($state[0]->type == "FC" || $state[0]->type == "FRT" || $state[0]->type == "FUV") {
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
            ."AND s.tracking_number IS NOT NULL)");
            
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
            . "order by a.order))");
           
            
        if ($state[0]->type == "FC") {
            $data["file_text_name"] = $name = "Fichier croisé   de la période " . $state[0]->period;
            $data["headers"] = array('Order','Tracking Number','Reference', 'Status', 'SIZE','Region', 'Payment Method',
                'Amount to collect', 'Amount_collected');
            
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
            $data["rows"]=  array_merge($nominal,$alternatifs_egaux,$alternatifs_differents);
            
            
        }
        if ( $state[0]->type == "FRT" || $state[0]->type == "FUV") {
            $this->operation_model->executeQuery("CREATE  TEMPORARY TABLE IF NOT EXISTS rejets AS ("
            . "select * from "
            . "(SELECT v.libelle,v.date_operation,v.reference,v.bureau,v.credit as amount_collected,"
            . "o.tracking_number FROM versement v LEFT join operation o ON o.tracking_number=v.reference "
            . "ORDER BY o.order)k where tracking_number IS NULL and reference not in (SELECT reference FROM alternatifs_egaux ) "
            . "and reference not in (select distinct reference from alternatifs_differents))");
              
        if ($state[0]->type == "FRT") {
            $data["rejets"]='rejets';
            $data["file_text_name"] = $name = "Fichier des rejets   de la période " . $state[0]->period;
            $data["headers"] = array('Libellé','Date Opération','Référence','Bureau','Amount Collected');
            
            //ensemble des éléments ne respectant pas le scénario nominal et ne se trouvant dans aucun des scénarios alternatis
            $rejets=$this->operation_model->getCroisedRows("select * from rejets");
              
            
            $this->operation_model->executeQuery("DROP TABLE nominal");
            $this->operation_model->executeQuery("DROP TABLE alternatifs");
            $this->operation_model->executeQuery("DROP TABLE alternatifs_egaux");
            $this->operation_model->executeQuery("DROP TABLE alternatifs_differents");
            $this->operation_model->executeQuery("DROP TABLE alternatifs_superieur");
            $this->operation_model->executeQuery("DROP TABLE rejets");
            $data["rows"]=  $rejets;
            //var_dump($data["rows"]);die;
        }
        
        
        if ($state[0]->type == "FUV") {
            $data["file_text_name"] = $name = "Fichier des non facturés   de la période " . $state[0]->period;
            $data["headers"] = array('Order','Tracking Number', 'Status', 'SIZE', 'Region', 'Payment Method',
                'Amount to collect');
            $unvoiced=$this->operation_model->getCroisedRows("SELECT o.shipment_provider,
            o.status,  o.tracking_number,o.size,o.order,o.region,o.payment_method,
            o.amount_to_collect,o.bureau,o.date_operation FROM operation o
            WHERE o.tracking_number not in (select tracking_number from nominal) AND o.tracking_number not in (select tracking_number from alternatifs_egaux)
            AND o.tracking_number not in (select tracking_number from alternatifs_superieur) AND o.tracking_number not in (select reference from rejets)
            AND amount_to_collect<>0 AND status <> 'Returned' AND status <> 'Lost' AND status <> 'Reversed' AND status <> 'Being returned' AND status <> 'At the hub' AND status <> 'At the hub - requested'
            AND SUBSTR(REPLACE(o.start_time,'/',''),3,6)=".substr($state[0]->period,2,6)." AND state_file_id =" .$operation_id[0]->id.
            " ORDER  BY o.order ");
            
            $this->operation_model->executeQuery("DROP TABLE nominal");
            $this->operation_model->executeQuery("DROP TABLE alternatifs");
            $this->operation_model->executeQuery("DROP TABLE alternatifs_egaux");
            $this->operation_model->executeQuery("DROP TABLE alternatifs_differents");
            $this->operation_model->executeQuery("DROP TABLE alternatifs_superieur");
            $this->operation_model->executeQuery("DROP TABLE rejets");
            $data["rows"]=  $unvoiced;
            
        }
        }
        }

        
       
        
        $this->load->view('general/header.php');
        $this->load->view('billings/preview_state.php', $data);
        $this->load->view('general/footer.php');
    }

    public function generating_file($test, $file, $newfile, $data, $name) {

        //var_dump($data);die;
        $writer = WriterFactory::create(Type::XLSX);
        $writer->openToFile($newfile);
        if ($test != "croisement") {
            //var_dump($data);die;


            $writer->addRow(["Shipment Provider", "Status", "Tracking Number", "SIZE", "Order", "Region", "Payment Method",
                "Amount to collect", "Bureau", "D. opé."]);

            foreach ($data as $row) {
                $writer->addRow([$row->shipment_provider, $row->status, $row->tracking_number,
                    $row->size, $row->order, $row->region, $row->payment_method, $row->amount_to_collect,
                    $row->bureau, $row->date_operation]);
            }
        } else {
            $writer->addRow(["Shipment Provider", "Status", "Tracking Number", "SIZE", "Order", "Region", "Payment Method",
                "Amount to collect", "ammount_collected", "Bureau", "D. opé."]);

            foreach ($data as $row) {
                $writer->addRow([$row->shipment_provider, $row->status, $row->tracking_number,
                    $row->size, $row->order, $row->region, $row->payment_method, $row->amount_to_collect, $row->amount_collected,
                    $row->bureau, $row->date_operation]);
            }



            $writer->close();
        }
    }

    public function generate_file($test, $name_file, $nam, $state_file_id, $type, $file_type, $file_name, $customer_id, $type_file_required, $period, $headers, $file, $newfile, $path, $name, $state_croisement_id = null) {
        
        $error = null;

        if ($state_croisement_id != null && empty($state_croisement_id) || empty($state_file_id)) {
            $error = "Ce fichier ne peut pas encore être généré car au moins un des fichiers requis  correspondant à ces critères n'a pas encore été chargé. Veuillez le(s) charger et réessayer";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } elseif (empty($state_file_id)) {
            $error = "Ce fichier ne peut pas encore être généré car fichier des " . $name . " correspondant à ces critères n'a pas encore été chargé. Veuillez le charger et réessayer";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } elseif (!empty($this->state_model->getALL(array("period" => $period, "type" => $type, "customerID" => $customer_id[0]->id)))) {
            $error = "un fichier correspondant à ces critères existe déjà. Veuillez le supprimer et réessayer ou changez de critères";
            $this->create_file($file_type, $file_name, 'billings/new_state.php', $path, $error);
        } else {

            $name = $name . "_" . $period . ".xlsx";
            //fabrication du fichier
            //$this->generating_file($test, $file, $newfile, $data, $name);
            $this->state_model->insert(array("file_path" => $newfile, "type" => $type, "facturation_date" => $state_file_id[0]->facturation_date, "period" => $period, "customerID" => $customer_id[0]->id, "name" => $nam));

            $this->list_file($name_file, "votre fichier a bien été généré. Vous pouvez le consulter dans la liste ci-dessous");
        }
    }

    public function download($file) {
        
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

    public function uploading_file($uploading_file, $name, $customer, $filepath, $period, $file_type, $operation_type, $file, $facturation_date, $file_to_upload, $file_name, $view, $link) {


        if (!empty($this->state_model->getALL(array("period" => $period, "type" => $file_type, "customerID" => $customer)))) {
            $this->create_file($file_to_upload, $file_name, $view, $link, "un fichier correspondant à ces critères existe déjà. Veuillez le supprimer et réessayer ou changez de critères");
        } else {
            if ($this->upload_file($name, 'xlsx|xls', './upload/operations_versment/', '2048', $uploading_file) == true) {
                $file_id = $this->state_model->insert(array("file_path" => $filepath, "period" => $period, "type" => $file_type, "facturation_date" => $facturation_date, "period" => $period, "customerID" => $customer, "name" => $name));
                $this->excel_to_sql($file_id, $operation_type, $filepath);
                $data = array("message" => "Votre fichier " . $name . " a bien été chargé.");
                $this->load->view('general/header.php');
                $this->load->view('general/accueil.php', $data);
                $this->load->view('general/footer.php');
            }
        }
    }

    public function excel_to_sql($state_file_id, $file_type, $file) {


        $reader = ReaderFactory::create(Type::XLSX); // for XLSX files


        $reader->open($file);
        $data = array();


        if ($file_type == "versement") {
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {

                    if ($row["1"] != "D. Opé.") {

                        $result = array(
                            'state_file_id' => $state_file_id,
                            'date_operation' => $row['1'],
                            'libelle' => $row['2'],
                            'reference' => $row['3'],
                            'bureau' => $row['4'],
                            'debit' =>str_replace(' ', '',$row['5']) ,
                            'credit' =>str_replace(' ', '',$row['6']),
                            'solde' => $row['7'],
                        );

                        $data[] = $result;
                    }
                }
            }
            $this->versement_model->insert_many_rows($data);
        }

        if ($file_type == "operation") {
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    //var_dump($row['30']);die;
                    if(isset($row['30']) && $row['30']=="Warehouse")
                        $deposit_local="Bureau de poste";
                    else
                        $deposit_local="A domicile";
                    
                    if(isset($row['4']) && $row['4']=="null" || $row['4']=="" )
                        $size='SMALL';
                    else
                        $size=$row['4'];
                    
                    if ($row["0"] != "Shipment Provider") {
                        $result = array(
                            'state_file_id' => $state_file_id,
                            'shipment_provider' => $row['0'],
                            'status' => $row['1'],
                            'start_time' => $row['2']->format('d/m/Y'),
                            'tracking_number' => $row['3'],
                            'size' => $size,
                            'delivered_date' => $row['5']->format('d/m/Y'),
                            'last_failed_attempt_date' => $row['6']->format('d/m/Y'),
                            'flow' => $row['7'],
                            'order' => $row['8'],
                            'order_date' => $row['9']->format('d/m/Y'),
                            'phone_number' => $row['10'],
                            'customer_name' => $row['11'],
                            'address' => $row['12'],
                            'city' => $row['13'],
                            'ward' => $row['14'],
                            'postcode' => $row['15'],
                            'region' => $row['16'],
                            'payment_method' => $row['17'],
                            'amount_to_collect' => str_replace(' ', '', $row['18']),
                            'delivery_run' => $row['19'],
                            'delivery_run_create' => $row['20'],
                            'bureau' => $row['21'],
                            'date_operation' => $row['22'],
                            'deposit_local' => $deposit_local,
                        );

                        $data[] = $result;
                    }
                }


                $reader->close();
            }
            $this->operation_model->insert_many_rows($data);
            
            $this->operation_model->executeQuery("CREATE TEMPORARY TABLE IF NOT exists doublons  "
            . "AS(SELECT  id FROM operation t1 WHERE t1.tracking_number "
            . "IN ( SELECT t2.tracking_number FROM operation t2 where t2.start_time=t1.start_time "
            . "and t2.tracking_number=t1.tracking_number and t1.amount_to_collect=t2.amount_to_collect "
            . " and t2.state_file_id= ".$state_file_id." GROUP BY t2.tracking_number "
            . "HAVING COUNT(t2.tracking_number)>1 )  GROUP BY t1.tracking_number "
            . "HAVING COUNT(t1.tracking_number)>1)");
            
            $this->operation_model->executeQuery("DELETE FROM operation where id in (select id from doublons)");
            $this->operation_model->executeQuery("DROP TABLE doublons");
        }
    }

    public function upload_file($file_name, $allowed_types, $upload_path, $max_size, $file_uploading) {
        //var_dump($file_uploading);die;
        if ($file_name != '')
            $config['file_name'] = $file_name;

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $allowed_types;
        $config['max_size'] = $max_size;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file') == TRUE)
            return true;
        else
            echo ($this->upload->display_errors());
        return false;
    }
    
    public function destroy($id) {
        $file = $this->state_model->getALL(array("id" => $id));
       
        unlink($file[0]->file_path);
        
        $this->state_model->delete($id);

        if ($file[0]->type == "FR") {
            redirect('state/StateManager/list_returned');
        }
        if ($file[0]->type == "FPO") {
            redirect('state/StateManager/list_paidonline');
        }
        if ($file[0]->type == "FCD") {
             redirect('state/StateManager/list_delivery');
        }
        if ($file[0]->type == "FC") {
            redirect('state/StateManager/list_croised');
        }
        if ($file[0]->type == "FRT") {
            redirect('state/StateManager/list_rejected');
        }
        if ($file[0]->type == "FUV") {
            redirect('state/StateManager/list_unvoiced_file');
        }
    }


}
