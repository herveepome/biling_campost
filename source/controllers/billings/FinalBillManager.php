<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FinalBillManager
 *
 * @author raoul
 */

include_once (APPPATH.'controllers/MainController.php');
//include_once (APPPATH.'libraries/PHPExcel/IOFactory.php');

Class FinalBillManager extends MainController{

  public function __construct()
	{
		parent::__construct();
                $this->load->helper(array('form', 'url'));
                $this->load->model('state_model');
                $this->load->library('datetimefrench');


	}

  public function index(){
        
    //echo numfmt_create('fr_FR', NumberFormatter::SPELLOUT)->format(19.475);
        //echo round(12.4587, 2);
        //echo base_url("/upload/bill/test.php");
      //date_default_timezone_set('Europe/Paris');
      //setlocale (LC_TIME, 'fr_FR.utf8','fra');
          
      



        /*$this->load->view('general/header.php');
    $this->load->view('files/list_cross_file.php');
    $this->load->view('general/footer.php');*/
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
        


  public function uploader() {
          $today=date('m/Y');
          $rejected_file='rejected_file'.$today;
          $returned_file='returned_file'.$today;
          $file_paid_delivery='file_paid_delivery'.$today;

          $this->upload_file('xlsx|xls','./upload/reject/','2048','rejected_file');
          $this->state_model->insert(array("file_path" => './upload/reject/' . $rejected_file, "period" => 1, "type" => "RF", "date" => '2000-09-09', "period" => 1, "customerID" => 1));
          //recuperation du fichier des rejets
          $path_file_reject='./upload/reject/'.$_FILES['rejected_file']['name'];
          $pfr=$this->file_to_array($path_file_reject);

          //upload des fichiers retournés
          $this->upload_file('xlsx|xls','./upload/returned/','2048','returned_file');
          $this->state_model->insert(array("file_path" => './upload/returned/' . $returned_file, "period" => 1, "type" => "FR", "date" => '2000-09-09', "period" => 1, "customerID" => 1));
          //recuperation des retournés
          $path_file_return='./upload/returned/'.$_FILES['returned_file']['name'];
          $pfreturn=$this->file_to_array($path_file_return);

          //upload et stockage dans la base de données
          $this->upload_file('xlsx|xls','./upload/paid_delivred/','2048','file_paid_delivery');
          $this->state_model->insert(array("file_path" => './upload/paid_delivred/' . $file_paid_delivery, "period" => 1, "type" => "FPD", "date" => '2000-09-09', "period" => 1, "customerID" => 1));
          //recuperation du fichier edes paie livrés
          $path_file_paid_delivery='./upload/paid_delivred/'.$_FILES['file_paid_delivery']['name'];
          $pfpd=$this->file_to_array($path_file_paid_delivery);

          $tab_principal=array($pfr,$pfreturn,$pfpd);
          var_dump($tab_principal);

          //return $tab_principal;
          //redirect('Finalbillings');
  }


 public function getfile(){
  // var_dump($this->input->post());die;
   //extract($this->input->post());
   echo $_FILES['rejected_file']['name'];
   echo $_FILES['returned_file']['name'];
   echo $_FILES['file_paid_delivery']['name'];

 }




  public function file_to_array($file) {

      //load the excel library
      $this->load->library('excel');

      //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($file);

      //get only the Cell Collection
      $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

      //extract to a PHP readable array format
      foreach ($cell_collection as $cell) {
          $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
          $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
          $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

          //The header will/should be in row 1 only. of course, this can be modified to suit your need.
          if ($row == 1) {
              $header[$row][$column] = $data_value;
          } else {
              $arr_data[$row][$column] = $data_value;
          }
      }

      //send the data in an array format
      $data['header'] = $header;
      $data['values'] = $arr_data;

      return $data;
    }

    public function excel_array(){
        //$file =$this->file_to_array();
        $dataArray = array(
            array(
                'PHP7',
                'Java Script',
                'Java',
                'Node JS',
            )
        );

        // create php excel object
        $this->load->library('excel');
        // set active sheet
        $this->excel->setActiveSheetIndex(0);
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($dataArray);
        $this->excel->getActiveSheet()->setTitle('test worksheet');

        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Fichier Principale de Facturation');

        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);

        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:D1');

        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //nom du fichier
        $filename = 'Fichier de facturation.xlsx';

        //mime type
        //envoyer le nom du  ficchier au navigateur
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header( 'content-type: text/html; charset=utf-8' );
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        flush();

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('c:/');
      }


}
