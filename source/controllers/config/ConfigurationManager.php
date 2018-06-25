<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfigurationManager
 *
 * @author mct
 */
include_once (APPPATH . 'controllers/MainController.php');

class ConfigurationManager extends MainController {

    public function __construct() {
        parent::__construct();
      // chargement de la base de donnée
        $this->load->model('Customer_model');
        $this->load->model('Configuration_model');
        $this->load->model('Operation_model');


        $this->load->model('Cash_model');
        $this->load->model('Adress_model');
        $this->load->model('Interval_model');
        $this->load->model('Weight_model');
        $this->load->model('Region_model');
        $this->load->model('Zone_model');
        $this->load->model('Local_model');
        $this->load->model('Town_model');
        $this->load->model('Deposit_model');
        $this->load->library('session');
    }


     /* configurer les adresses */

    public function adress($action='', $value=''){
        if (($action=='new')&&($value==''))
        {   
            $data['adresse']=null;
            $this->load->view('general/header.php');
            $this->load->view('configuration/adresse/add_adress.php',$data);
            $this->load->view('general/footer.php');
        }

        // éditer une adresse
        else if ($action=='create'){
            
            $adresse=array(
                        'adresse'=>addslashes($this->input->post('adresse'))
                    );
            $this->Adress_model->insert($adresse);

            redirect('config/adresses');
        }
        // éditer une adresse
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['adresse'] = $this->Adress_model->getALL(array('id'=>$value) );
                $this->load->view('general/header.php');
                $this->load->view('configuration/adresse/add_adress.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour une adresse
        else if(($action=='update')&&($value!='')){
                    $adresse=array('adresse'=>addslashes($this->input->post('adresse'))
                                            );
                    $this->Adress_model->insert($adresse,$value);
                    redirect('config/adresses');
             
        } 
        // supprimer une adresse
        else if(($action=='delete')&&($value!=''))
        {   
            $this->Adress_model->insert(array("deleted"=>1),$value);
                    redirect('config/adresses');
             
        }
        // lister les adresses
        else{
            $data['adresses']=$this->Adress_model->getALL(array("deleted"=>0));
            $this->load->view('general/header.php');
            $this->load->view('configuration/adresse/list_adresses.php', $data);
            $this->load->view('general/footer.php');
        }
    }

  /* configurer les zones */

    public function zone($action='', $value=''){
        $data['regions']=$this->Region_model->getALL(array("deleted"=>0));
        $villes = array();
        $regions = $data['regions'] ;
        foreach ($regions as $region) {
            $villes[] = $this->Town_model->getALL(array("deleted"=>0, "regions_id"=>$region->id));
        }
        //var_dump($villes[0]); die;
        $data['villes']=$villes;

        $data['customers']=$this->Customer_model->getALL(array("deleted"=>0));
        
        if (($action=='new')&&($value==''))
        {   
            $data['zone']=null;
            $this->load->view('general/header.php');
            $this->load->view('configuration/zone/add_zone.php',$data);
            $this->load->view('general/footer.php');
        }

        // éditer une zone
        else if ($action=='create'){
            extract($this->input->post()) ; 
            $zone = array();
            $region = array();
            $id_customer=$this->Customer_model->getALL(array("name"=>addslashes($customer)))[0]->id;
            foreach($data['regions'] as $data){
                $region[] = $data->name;
            }
            foreach ($ville as $vil) {
               if (in_array($vil, $region)){
                $id_region=$this->Region_model->getALL(array( "name"=>$vil))[0]->id;
                $id_ville=$this->Town_model->getALL(array( "regions_id"=>$id_region));
                foreach($id_ville as $vil_id){
                    $zone[]=array(
                        'zone'=>addslashes($this->input->post('zone')),
                        'customer_id'=>$id_customer  ,
                        'town_id'=>$vil_id->id
                    );
                }
               }
               else{
                 $id_ville=$this->Town_model->getALL(array( "name"=>$vil))[0]->id;
                 $zone[]=array(
                        'zone'=>addslashes($this->input->post('zone')),
                        'customer_id'=>$id_customer  ,
                        'town_id'=>$id_ville
                    );
               }
            }
            
            $this->Zone_model->insert_many_rows($zone);

            redirect('config/zones');
        }
        // éditer une zone
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['zone'] = $this->Zone_model->getALL(array("id"=>$value))[0]; 

                $data['customer']=$this->Customer_model->getALL(array("deleted"=>0,"id"=>$data['zone']->customer_id) );
                //var_dump($data['customer']) ; die;
                $data['ville']=$this->Town_model->getALL(array("deleted"=>0,"id"=>$data['zone']->town_id));
                $this->load->view('general/header.php');
                $this->load->view('configuration/zone/add_zone.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour une zone
        else if(($action=='update')&&($value!='')){
            extract($this->input->post()) ;
             $id_customer=$this->Customer_model->getALL(array("name"=>addslashes($customer)))[0]->id;
            $id_ville=$this->Local_model->getALL(array( "name"=>addslashes($ville)))[0]->id;
           $zone=array(
                        'zone'=>addslashes($this->input->post('zone')),
                        'customer_id'=>$id_customer  ,
                        'town_id'=>$id_ville  
                    );
            $this->Configuration_model->update($value,$zone,'id','zone');
            redirect('config/zones');
             
        } 
        // supprimer une zone
        else if(($action=='delete')&&($value!=''))
        {   
           $this->zone_model->insert(array("deleted"=>1),$value);
                    redirect('config/zones');
             
        }
        // lister les zones par client
        else{
            $zones=$this->Operation_model->getCroisedRows("select * from zone where deleted=0 group by zone,customer_id" ) ;
            
            $customer = array() ;
            foreach ($zones as $zone) {
                $customer[] = array( "zoneId"=>$zone->id,
                                    "zone"=>$zone->zone,
                                    "id"=>$zone->customer_id,
                                    "name"=> $this->customer_model->getALL(array("id"=>$zone->customer_id))[0]->name,
                );
            }
            $data['zones'] = $customer ; 
            $this->load->view('general/header.php');
            $this->load->view('configuration/zone/list_zones.php', $data);
            $this->load->view('general/footer.php');
        }
    }

  /* configurer les régions */

    public function region($action='', $value=''){
        if (($action=='new')&&($value==''))
        {   
            $data['region']=null;
           // $data['zones']=$this->Configuration_model->all('zone');
            $this->load->view('general/header.php');
            $this->load->view('configuration/region/add_region.php',$data);
            $this->load->view('general/footer.php');
        }

        // éditer une région
        else if ($action=='create'){
          /*  $zone=array('zone' =>$this->Configuration_model->find('id','zone',addslashes($this->input->post('zone')),'zone')) ;
            $id_zone=$zone["zone"][0]->id; */
            $region=array(
                        'name'=>addslashes($this->input->post('region')),
                      //  'zone_id'=>$id_zone  
                    );
            $this->Region_model->insert($region);

            redirect('config/regions');
        }
        // éditer une région
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['region'] = $this->Region_model->getALL(array('id'=>$value));
             //   $data['zones']=$this->Configuration_model->all('zone');
                $this->load->view('general/header.php');
                $this->load->view('configuration/region/add_region.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour une région
        else if(($action=='update')&&($value!='')){
           // $zone=array('zone' =>$this->Configuration_model->find('id','zone',addslashes($this->input->post('zone')),'zone')) ;
           // $id_zone=$zone["zone"][0]->id; 
            $region=array(
                'name'=>addslashes($this->input->post('region')),
               // 'zone_id'=>$id_zone  
            );
            $this->Region_model->insert($region,$value);
            redirect('config/regions');
             
        } 
        // supprimer une région
        else if(($action=='delete')&&($value!=''))
        {   
                    $this->Region_model->insert(array("deleted"=>1),$value);
                    redirect('config/regions');
             
        }
        // lister les régions
        else{
            $data['regions']=$this->Region_model->getALL(array("deleted"=>0));
            $this->load->view('general/header.php');
            $this->load->view('configuration/region/list_regions.php', $data);
            $this->load->view('general/footer.php');
        }
    }

         /* configurer les intervaux de poids */

    public function weightInterval($action='', $value=''){
        if (($action=='new')&&($value==''))
        {   
            $data['weight']=null;
            $this->load->view('general/header.php');
            $this->load->view('configuration/weight/add_weight.php',$data);
            $this->load->view('general/footer.php');
        }

        // éditer un interval de poids
        else if ($action=='create'){
            
            $weight=array(
                        'weight'=>addslashes($this->input->post('weight')),
                        'name'=>addslashes($this->input->post('name'))
                    );
            $this->Weight_model->insert($weight);

            redirect('config/weight_intervals');
        }
        // éditer un interval de poids
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['weight'] = $this->Weight_model->getALL(array("id"=>$value));
                $this->load->view('general/header.php');
                $this->load->view('configuration/weight/add_weight.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour un interval de poids
        else if(($action=='update')&&($value!='')){
                    $weight=array('weight'=>addslashes($this->input->post('weight')),
                                    'name'=>addslashes($this->input->post('name'))
                                            );
                    $this->Weight_model->insert($weight,$value);
                    redirect('config/weight_intervals');
             
        } 
        // supprimer un interval de poids
        else if(($action=='delete')&&($value!=''))
        {   
            $this->Weight_model->insert(array("deleted"=>1),$value);
                    redirect('config/weight_intervals');
             
        }
        // lister les intervaux de poids
        else{
            $data['weight_intervals']=$this->Weight_model->getALL(array("deleted"=>0));
            $this->load->view('general/header.php');
            $this->load->view('configuration/weight/list_weight.php', $data);
            $this->load->view('general/footer.php');
        }
    }

          /* configurer les intervaux de cash */

    public function cashInterval($action='', $value=''){
        if (($action=='new')&&($value==''))
        {   
            $data['cash']=null;
            $this->load->view('general/header.php');
            $this->load->view('configuration/cash/add_cash.php',$data);
            $this->load->view('general/footer.php');
        }

        // créer un interval de cash
        else if ($action=='create'){
            
            $cash=array(
                        'interval'=>addslashes($this->input->post('cash'))
                    );
            $this->Interval_model->insert($cash);

            redirect('config/cash_intervals');
        }
        // éditer un interval de cash
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['cash'] = $this->Interval_model->getALL(array("id"=>$value) );
                $this->load->view('general/header.php');
                $this->load->view('configuration/cash/add_cash.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour un interval de cash
        else if(($action=='update')&&($value!='')){
                    $cash=array('interval'=>addslashes($this->input->post('cash'))
                                            );
                    $this->Interval_model->insert($cash,$value);
                    redirect('config/cash_intervals');
             
        } 
        // supprimer un interval de cash
        else if(($action=='delete')&&($value!=''))
        {   
            $this->Interval_model->insert(array("deleted"=>1),$value);
                    redirect('config/cash_intervals');
             
        }
        // lister les intervaux de cash
        else{
            $data['cash_intervals']=$this->Interval_model->getALL(array("deleted"=>0));
            $this->load->view('general/header.php');
            $this->load->view('configuration/cash/list_cash.php', $data);
            $this->load->view('general/footer.php');
        }
    }

// Configurer les villes
     public function ville($action='', $value=''){
         $data['regions']=$this->Region_model->getALL(array("deleted"=>0));
         $data['deposits']=$this->Local_model->getALL();
        if (($action=='new')&&($value==''))
        {   
            $data['ville']=null;
            $this->load->view('general/header.php');
            $this->load->view('configuration/town/add_town.php',$data);
            $this->load->view('general/footer.php');
        }

        // éditer une ville
        else if ($action=='create'){
            extract($this->input->post()) ;
            $id_region=$this->Region_model->getALL(array( "name"=>addslashes($region)))[0]->id;
            $id_deposit=$this->Local_model->getALL(array( "name"=>addslashes($deposit)))[0]->id;
            $ville=array(
                        'name'=>addslashes($this->input->post('ville')),
                        'regions_id'=>$id_region  ,
                        'deposit_local_id'=>$id_deposit  
                    );
            $this->Town_model->insert($ville);

            redirect('config/villes');
        }
        // éditer une ville
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['ville'] = $this->Town_model->getALL(array("deleted"=>0,"id"=>$value))[0];
                $data['region']=$this->Region_model->getALL(array("id"=>$data['ville']->regions_id));
                $data['deposit']=$this->Local_model->getALL(array("id"=>$data['ville']->deposit_local_id));
                $this->load->view('general/header.php');
                $this->load->view('configuration/town/add_town.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour une ville
        else if(($action=='update')&&($value!='')){
            extract($this->input->post()) ;
            $id_region=$this->Region_model->getALL(array("name"=>addslashes($region)) )[0]->id;
            $id_deposit=$this->Local_model->getALL(array( "name"=>addslashes($deposit)))[0]->id;
            $ville=array(
                'name'=>addslashes($this->input->post('ville')),
                'regions_id'=>$id_region  ,
                'deposit_local_id'=>$id_deposit   
            );
            $this->Town_model->insert($ville,$value);
            redirect('config/villes');
             
        } 
        // supprimer une région
        else if(($action=='delete')&&($value!=''))
        {   
           
            $this->Town_model->insert(array("deleted"=>1),$value);
                    redirect('config/villes');
             
        }
        // lister les régions
        else{
            $data['villes']=$this->Town_model->getALL(array("deleted"=>0));
            $this->load->view('general/header.php');
            $this->load->view('configuration/town/list_town.php', $data);
            $this->load->view('general/footer.php');
        }
    }


    // configurer les tarifs clients

    public function tarifs($action='', $value=''){
        $data['customers'] = $this->customer_model->getALL(array("deleted"=>0)) ; //clients
        $data['intervals'] = $this->Interval_model->getALL(array("deleted"=>0));// interval
      //  $data['zones'] = $this->Zone_model->getALL(array("deleted"=>0)); //zone
        $data['poids'] = $this->Weight_model->getALL(array("deleted"=>0)); //poids
        $data['deposits']=$this->Local_model->getALL(); // point de livraison
      
        if (($action=='new')&&($value==''))
        {   
            $data['tarif']=null;
            $this->load->view('general/header.php');
            $this->load->view('configuration/tarif/add_tarif.php',$data);
            $this->load->view('general/footer.php');
        }

        // créer une tarification client
        else if ($action=='create' || $action=='update'){
            extract($this->input->post());
            $customer_id = $_SESSION['data']['client'] ;
            $domicileId = $this->Local_model->getALL(array("name"=>'A domicile'))[0]->id; // récupérer dans deposit_local l'id pour à domicile
            $bureauId = $this->Local_model->getALL(array("name"=>'Bureau de poste'))[0]->id;   // récupérer dans deposit_local l'id pour bureau de poste
            $intervals = $data['intervals'] ; 
            $zones = $this->Operation_model->getCroisedRows('select * from zone where customer_id='.$customer_id. ' group by zone ');
            $poids = $data['poids'];
            $deposit_local_id = $this->Local_model->getALL(array("name"=>$deposit))[0]->id ;

            foreach($ville as $vil){
                $ville_id = $this->Town_model->getALL(array("name"=>$vil))[0]->id;
                $zone_id = $this->Zone_model->getALL(array("town_id"=>$ville_id, "customer_id"=>$customer_id))[0]->id ;
                $this->Zone_model->insert(array("deposit_local_id"=>$deposit_local_id),$zone_id) ;
            }

             $i=0; $j=0;
            foreach ($intervals as $interval){
                $cashs[]=array("cash_interval_id"=>$interval->id,
                    "customer_id"=>$customer_id,
                    "amount"=>$amount[$i]
                    );
                $i++;
            }
            foreach ($zones as $zone){
                foreach ($poids as $poid){
                    $tarifs_domicile[] = array( "weight_id"=>$poid->id,
                                        "zone_id"=>$zone->id,
                                        "deposit_local_id"=>$domicileId,
                                        "customer_id"=>$customer_id,
                                        "amount"=>$tarifdomicile[$j],
                    );
                    $tarifs_bureau[] = array( "weight_id"=>$poid->id,
                        "zone_id"=>$zone->id,
                        "deposit_local_id"=>$bureauId,
                        "customer_id"=>$customer_id,
                        "amount"=>$tarifbureau[$j],
                    );
                    $j++;
                }

            }
            $this->Cash_model->insert_many_rows($cashs);
            $this->Deposit_model->insert_many_rows($tarifs_bureau);
            $this->Deposit_model->insert_many_rows($tarifs_domicile);


            redirect('config/tarifs');
        }
        // éditer une tarification client
       else if(($action=='edit')&&($value!=''))
        {
            $data['customer'] = $this->customer_model->getALL(array("id"=>$value))[0];
            $domicileId = $this->Local_model->getALL(array("name"=>'A domicile'))[0]->id; 
            $bureauId = $this->Local_model->getALL(array("name"=>'Bureau de poste'))[0]->id; 
           if($value > 0){
                $data['cash_collected']=$this->Cash_model->getALL(array("customer_id"=>$value));
                $bureau_collected=$this->Deposit_model->getALL(array("customer_id"=>$value,"deposit_local_id"=>$bureauId));
                $domicile_collected=$this->Deposit_model->getALL(array("customer_id"=>$value,"deposit_local_id"=>$domicileId));
                $bureau =array() ;$domicile = array();
                foreach ($bureau_collected as $tarifbureau) {
                    $zone = $this->Zone_model->getALL(array("id"=>$tarifbureau->zone_id))[0]->zone;
                    $poids = $this->Weight_model->getALL(array("id"=>$tarifbureau->weight_id))[0]->weight;
                    $bureau[] =  array("label"=>'['.$zone.']['.$poids.']',
                                        "amount"=>$tarifbureau->amount,
                                    );
                 }
                  foreach ($domicile_collected as $tarifdomicile) {
                    $zone = $this->Zone_model->getALL(array("id"=>$tarifdomicile->zone_id))[0]->zone;
                    $poids = $this->Weight_model->getALL(array("id"=>$tarifdomicile->weight_id))[0]->weight;
                    $domicile[] =  array("label"=>'['.$zone.']['.$poids.']',
                                        "amount"=>$tarifdomicile->amount,
                                    );
                 }
                 $data['bureau'] = $bureau ; $data['domicile'] = $domicile ;
                 $ville_id = $this->Zone_model->getALL(array("customer_id"=>$value, "deleted"=>0));
                 $villes=array(); 
                 foreach ($ville_id as $ville) {
                     $villes[] = array("id"=>$ville->town_id,
                                        "ville"=>$this->Town_model->getALL(array("id"=>$ville->town_id))[0]->name,
                                    ) ;
                 }
                 $data['villes']=$villes ;
                $this->load->view('general/header.php');
                $this->load->view('configuration/tarif/edit_tarif.php',$data);
                $this->load->view('general/footer.php');

            }
        }
     
        else{
            $data['customers'] = $this->Operation_model->getCroisedRows('select * from customer where deleted=0 and id in (select distinct customer_id from deposit_collected)  ');
            $this->load->view('general/header.php');
            $this->load->view('configuration/tarif/list_tarifs.php', $data);
            $this->load->view('general/footer.php');
        }

    }

    public function labelZonePoids(){
        $customer = $this->input->post('select_id');
        $customer_id = $this->customer_model->getALL(array("name"=>$customer))[0]->id ;
        $zones = $this->Operation_model->getCroisedRows('select distinct zone from zone where customer_id='.$customer_id);
        $poids = $this->Weight_model->getALL(array("deleted"=>0));
         
        $label = array() ;
        foreach ($zones as $zone) {
            foreach ($poids as $poid ) {
                $label[] = "[".$zone->zone."]"."[".$poid->weight."]"  ;
            }
        }
        $villes = $this->Operation_model->getCroisedRows('select name from town where deposit_local=1 and id in (select town_id from zone where customer_id='.$customer_id.' )');
        //var_dump($villes) ; die;
        $lenght_label = count($label) ;
        $vill = array() ;
        foreach ($villes as $ville ) {
            $vill[]=$ville->name ;
        }

        $lenght_ville = count($vill) ;
        $data['tarification']=array("client"=>$customer_id, "label"=>$lenght_label, "ville"=>$lenght_ville) ;
         $this->session->data = $data['tarification'];
        $result=array();
        $result['label'] = $label ;
        $result['ville'] = $vill ;
        echo json_encode($result);

    }
}
