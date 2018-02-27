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
        $this->load->model('Configuration_model');
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
            $this->Configuration_model->create($adresse,'adresse');

            redirect('config/adresses');
        }
        // éditer une adresse
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['adresse'] = $this->Configuration_model->edit($value,'id','adresse');
                $this->load->view('general/header.php');
                $this->load->view('configuration/adresse/add_adress.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour une adresse
        else if(($action=='update')&&($value!='')){
                    $adresse=array('adresse'=>addslashes($this->input->post('adresse'))
                                            );
                    $this->Configuration_model->update($value,$adresse,'id','adresse');
                    redirect('config/adresses');
             
        } 
        // supprimer une adresse
        else if(($action=='delete')&&($value!=''))
        {   
            $adresse = array('adresse'=>$this->Configuration_model->find('adresse','id',$value,'adresse')[0]->adresse,
                             'deleted'=>1);
            $this->Configuration_model->update($value,$adresse,'id','adresse');
                    redirect('config/adresses');
             
        }
        // lister les adresses
        else{
            $data['adresses']=$this->Configuration_model->all('adresse');
            $this->load->view('general/header.php');
            $this->load->view('configuration/adresse/list_adresses.php', $data);
            $this->load->view('general/footer.php');
        }
    }

  /* configurer les zones */

    public function zone($action='', $value=''){
        if (($action=='new')&&($value==''))
        {   
            $data['zone']=null;
            $this->load->view('general/header.php');
            $this->load->view('configuration/zone/add_zone.php',$data);
            $this->load->view('general/footer.php');
        }

        // éditer une zone
        else if ($action=='create'){
            
            $zone=array(
                        'zone'=>addslashes($this->input->post('zone'))
                    );
            $this->Configuration_model->create($zone,'zone');

            redirect('config/zones');
        }
        // éditer une zone
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['zone'] = $this->Configuration_model->edit($value,'id','zone');
                $this->load->view('general/header.php');
                $this->load->view('configuration/zone/add_zone.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour une zone
        else if(($action=='update')&&($value!='')){
                    $zone=array('zone'=>addslashes($this->input->post('zone'))
                                            );
                    $this->Configuration_model->update($value,$zone,'id','zone');
                    redirect('config/zones');
             
        } 
        // supprimer une zone
        else if(($action=='delete')&&($value!=''))
        {   
            $zone = array('zone'=>$this->Configuration_model->find('zone','id',$value,'zone')[0]->zone,
                             'deleted'=>1);
            $this->Configuration_model->update($value,$zone,'id','zone');
                    redirect('config/zones');
             
        }
        // lister les zones
        else{
            $data['zones']=$this->Configuration_model->all('zone');
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
            $data['zones']=$this->Configuration_model->all('zone');
            $this->load->view('general/header.php');
            $this->load->view('configuration/region/add_region.php',$data);
            $this->load->view('general/footer.php');
        }

        // éditer une région
        else if ($action=='create'){
            $zone=array('zone' =>$this->Configuration_model->find('id','zone',addslashes($this->input->post('zone')),'zone')) ;
            $id_zone=$zone["zone"][0]->id; 
            $region=array(
                        'name'=>addslashes($this->input->post('region')),
                        'zone_id'=>$id_zone  
                    );
            $this->Configuration_model->create($region,'regions');

            redirect('config/regions');
        }
        // éditer une région
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['region'] = $this->Configuration_model->edit($value,'id','regions');
                $data['zones']=$this->Configuration_model->all('zone');
                $this->load->view('general/header.php');
                $this->load->view('configuration/region/add_region.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour une région
        else if(($action=='update')&&($value!='')){
            $zone=array('zone' =>$this->Configuration_model->find('id','zone',addslashes($this->input->post('zone')),'zone')) ;
            $id_zone=$zone["zone"][0]->id; 
            $region=array(
                'name'=>addslashes($this->input->post('region')),
                'zone_id'=>$id_zone  
            );
            $this->Configuration_model->update($value,$region,'id','regions');
            redirect('config/regions');
             
        } 
        // supprimer une région
        else if(($action=='delete')&&($value!=''))
        {   
            $region = array('name'=>$this->Configuration_model->find('name','id',$value,'regions')[0]->name,
                            'zone_id'=>$this->Configuration_model->find('zone_id','id',$value,'regions')[0]->zone_id,
                             'deleted'=>1);
            $this->Configuration_model->update($value,$region,'id','regions');
                    redirect('config/regions');
             
        }
        // lister les régions
        else{
            $data['regions']=$this->Configuration_model->all('regions');
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
            $this->Configuration_model->create($weight,'weight');

            redirect('config/weight_intervals');
        }
        // éditer un interval de poids
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['weight'] = $this->Configuration_model->edit($value,'id','weight');
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
                    $this->Configuration_model->update($value,$weight,'id','weight');
                    redirect('config/weight_intervals');
             
        } 
        // supprimer un interval de poids
        else if(($action=='delete')&&($value!=''))
        {   
            $weight = array('weight'=>$this->Configuration_model->find('weight','id',$value,'weight')[0]->weight,
                             'deleted'=>1);
            $this->Configuration_model->update($value,$weight,'id','weight');
                    redirect('config/weight_intervals');
             
        }
        // lister les intervaux de poids
        else{
            $data['weight_intervals']=$this->Configuration_model->all('weight');
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
            $this->Configuration_model->create($cash,'cash_interval');

            redirect('config/cash_intervals');
        }
        // éditer un interval de cash
       else if(($action=='edit')&&($value!=''))
        {
           if($value > 0){
                $data['cash'] = $this->Configuration_model->edit($value,'id','cash_interval');
                $this->load->view('general/header.php');
                $this->load->view('configuration/cash/add_cash.php',$data);
                $this->load->view('general/footer.php');

            }
        }
        // mettre à jour un interval de cash
        else if(($action=='update')&&($value!='')){
                    $cash=array('interval'=>addslashes($this->input->post('cash'))
                                            );
                    $this->Configuration_model->update($value,$cash,'id','cash_interval');
                    redirect('config/cash_intervals');
             
        } 
        // supprimer un interval de cash
        else if(($action=='delete')&&($value!=''))
        {   
            $cash = array('interval'=>$this->Configuration_model->find('interval','id',$value,'cash_interval')[0]->interval,
                             'deleted'=>1);
            $this->Configuration_model->update($value,$cash,'id','cash_interval');
                    redirect('config/cash_intervals');
             
        }
        // lister les intervaux de cash
        else{
            $data['cash_intervals']=$this->Configuration_model->all('cash_interval');
            $this->load->view('general/header.php');
            $this->load->view('configuration/cash/list_cash.php', $data);
            $this->load->view('general/footer.php');
        }
    }

}
