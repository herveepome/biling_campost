<?php

if (isset($_SESSION['user'])) {

$now = time(); // Checking the time now when home page starts.
// var_dump($_SESSION['start']) ; var_dump($_SESSION['expire']) ; var_dump($now);  die;
if ($now > $_SESSION['expire']) {
    session_destroy();
    redirect ("login_form");
} else {
?>
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title"><?php echo "Liste ".$name ?></h4>
                </div>
            </div>
        </div>

        <!-- end page title end breadcrumb -->
        <div class="row">
<?php if (isset($message)) {?>
                    <div class="alert alert-success">
                    <?php  echo $message; ?>
                    </div>
                    <?php } ?>
            <div class="col-sm-12">

                <div class="card-box">
                  
                    <table id="datatable" class="table table-bordered" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Fichier</th>
                     
                                  <th>Période</th>
                                  <th>Actions</th>
                                  
                              </tr>
                              </thead>


                              <tbody>
                                   <?php if (isset($states) && $states!=null && !empty($states)){ ?>
                                  
                                  <?php foreach ($states as $state) {?>
                             <tr>
                               <td><?php echo $state->name ?></td>
                                  
                                  <td><?php echo $state->period ?></td>
                                  
                                  
                                  <td class="actions">
                                        <a href="<?php if($state->type=='F' || $state->type=='LF' ){
                                            echo base_url($state->file_path);
                                            }elseif($state->type=='FF'){
                                            echo site_url("billing/".$state->id."/read");
                                            }else{
                                                echo site_url("state/".$state->id."/preview");}  ?>" 
                                            class="hidden on-editing save-row" data-toggle="tooltip" 
                                            data-placement="top" title="" data-original-title="Visualiser"><i class="ti-eye"></i></a>
                                        
                                        <?php if($state->type!='FF' && $state->type!='F' && $state->type!='LF' ){ ?>
                                      <a href="#custom-modal<?php echo $state->id ?>" class="hidden on-editing cancel-row" data-animation="fadein" data-plugin="custommodal" data-original-title="Delete" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-times"></i></a>
                                        <?php } ?>
                                  </td>
                              </tr>
                             <?php 
                                  }} ?>
                              
                              </tbody>
                          </table>
                    
                            
                        <?php if (isset($states) && $states!=null && !empty($states)){ ?>
                                            
                     <?php foreach ($states as $state) {?>
                    
                    <!-- Custom Modal -->
        <div id="custom-modal<?php echo $state->id ?>" class="modal-demo">
            <button type="button" class="close" onclick="Custombox.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">Attention</h4>
            <div class="custom-modal-text">
             <?php echo "Voulez vous vraiment supprimer  le fichier ".$state->name." ?" ?>
                 <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url('state/'.$state->id.'/delete'); ?>">oui</a>
                  <a class="btn btn-danger waves-effect waves-light" href="
                      <?php 
                  if ($state->type == "FR") {
            echo site_url('state/list_returned_file');
        }
        if ($state->type == "FF") {
            echo site_url('state/list_billing');
        }
        if ($state->type == "LF") {
             echo site_url('state/listing');
        }
          if ($state->type == "FPO") {
              echo site_url('state/list_paidonline_file');
          }
          if ($state->type == "FCD") {
              echo site_url('state/list_delivery_file');
          }
        if ($state->type == "FC") {
            echo site_url('state/list_croised_file');
        }
        if ($state->type == "FRT") {
            echo site_url('state/list_rejected_file');
        }
        if ($state->type == "FUV") {
            echo site_url('state/list_unvoiced_file');
        } ?>">Non</a>
                    
            </div>
        </div>
                    
                    <?php 
                        }} ?>

             
                </div>
            </div>
            <!-- end: col -->

        <!-- end row -->
    </div> <!-- end container -->
</div>
<!-- end wrapper -->
</div>

<?php }
}?>