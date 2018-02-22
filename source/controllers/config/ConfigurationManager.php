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
        $this->load->model('Configuration_model');
    }

    // lister les adresses

    public function getAdresses(){
         $data['adresses']=$this->Configuration_model->getAllAdresses();
        
        $this->load->view('general/header.php');
        $this->load->view('configuration/adresse/list_adresses.php', $data);
        $this->load->view('general/footer.php');

    }

     // lister les zones

    public function getZones(){
         $data['zones']=$this->Configuration_model->getAllZones();
        
        $this->load->view('general/header.php');
        $this->load->view('configuration/zone/list_zones.php', $data);
        $this->load->view('general/footer.php');

    }

     // lister les regions

    public function getRegions(){
         $data['regions']=$this->Configuration_model->getAllRegions();
        
        $this->load->view('general/header.php');
        $this->load->view('configuration/region/list_regions.php', $data);
        $this->load->view('general/footer.php');

    }

     // lister les intervauxlles de poids

    public function getWeight(){
         $data['weights']=$this->Configuration_model->getAllWeight();
        
        $this->load->view('general/header.php');
        $this->load->view('configuration/weight/list_weight.php', $data);
        $this->load->view('general/footer.php');

    }

     // lister les intervaux de cash

    public function getCash(){
         $data['cashs']=$this->Configuration_model->getAllCashIntervalls();
        
        $this->load->view('general/header.php');
        $this->load->view('configuration/cash/list_cash.php', $data);
        $this->load->view('general/footer.php');

    }

    // ajouter une nouvelle adresse

    public function createAdress(){
        $this->edit();
    }

    // mettre à jour une adresse
    public function editAdress(){

    }

    // supprimer une adresse

    public function dropAdress(){

    }

    // ajouter une nouvelle zone

    public function createZone(){
        $this->edit();
    }

    // mettre à jour une zone
    public function editZone(){

    }

    // supprimer une adresse

    public function dropZone(){

    }

    // ajouter un nouvel interval de cash

    public function createCashIntervall(){
        $this->edit();
    }

    // mettre à jour une adresse
    public function editCashIntervall(){

    }

    // supprimer une adresse

    public function dropCashIntervall(){

    }

     // ajouter un nouvel interval de poids

    public function createWeightIntervall(){
        $this->edit();
    }

    // mettre à jour un interval de poids
    public function editWeightIntervall(){

    }

    // supprimer un interval de poids

    public function dropWeightIntervall(){

    }

    // ajouter une nouvelle région

    public function createRegion(){
        $this->edit();
    }

    // mettre à jour une région
    public function editRegion(){
        
    }

    // supprimer une région

    public function dropRegion(){

    }

}
