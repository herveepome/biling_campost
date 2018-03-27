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



include_once (APPPATH . 'controllers/MainController.php');

class UserManager extends MainController{


    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('customer_model');
        $this->load->library('session');
    }

    public function index() {


    }

    public function login(){
        $data['customers'] = $this->customer_model->getALL(array("deleted"=>0)) ;
        $data['register'] = $this->load->view('general/register.php', null, true);
        if ($this->input->post()){
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $user  = $this->user_model->getALL(array("login"=>$login,"password"=>$password));
            if (isset($user) && !empty($user)&& $user!=null){
                $_SESSION['user'] = $login;
                $_SESSION['start'] = time(); // récupérer le temps auquel l'utilisateur se connecte
                $_SESSION['expire'] = $_SESSION['start'] + (2 * 60); // la session s'expire après 30mn
                $this->load->view('general/header.php');
                $this->load->view('general/accueil.php',$data);
                $this->load->view('general/footer.php');
            }
            else{
                $data['error'] = "votre login et/ou mot de passe est incorrect; essayez de nouveau!"  ;
                $this->load->view('general/login.php',$data);
                $this->load->view('general/footer.php');
            }


        }
    }

    public function registerForm(){
        $this->load->view('general/register.php');
        $this->load->view('general/footer.php');
    }

    public function loginForm(){
        $this->load->view('general/login.php');
        $this->load->view('general/footer.php');
    }

    public function register(){
        $data['customers'] = $this->customer_model->getALL(array("deleted"=>0)) ;
        $data['login'] = $this->load->view('general/login.php', null, true);
        if ($this->input->post()){
            $error = null;
            extract($this->input->post(NULL, TRUE));
            $user = array("email"=>$email,"login"=>$login,"password"=>sha1($password));
            $this->user_model->insert($user);
            $this->load->view('general/header.php');
            $this->load->view('general/accueil.php',$data);
            $this->load->view('general/footer.php');

        }
    }
}