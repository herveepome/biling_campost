<?php

if (isset($_SESSION['user'])) {
 //var_dump('tata') ; die;
  $var ='http://'.$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  $var = substr($var, strlen(site_url())+1);
  
    $now = time(); // Checking the time now when home page starts.
    if ($now > $_SESSION['expire']) {
        session_destroy();

        $var = str_replace('/', '-', $var) ;
        redirect ("login_form/".$var );
    } else {
        ?>
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title">Liste des intervaux de poids </h4>
                </div>
            </div>
        </div>

        <!-- end page title end breadcrumb -->
        <div class="row">

            <div class="col-sm-12">

                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="m-b-30">
                                <a href="<?php echo site_url('weight/new'); ?>"><button id="addToTable" class="btn btn-success waves-effect waves-light">Ajouter un interval de poids<i class="mdi mdi-plus-circle-outline"></i></button></a>
                            </div>
                        </div>
                    </div>
                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Adresse</th>
                                  <th>Actions</th>
                              </tr>
                              </thead>


                              <tbody>
                                  <?php if (isset($weight_intervals) && $weight_intervals!=null && !empty($weight_intervals)){ ?>
                                  
                                  <?php foreach ($weight_intervals as $weight) {?>
                             <tr>
                                  <td><?php echo $weight->weight ?></td>
                                  <td class="actions">
                                        <a href="<?php echo site_url('weight/'.$weight->id.'/edit'); ?>" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="#custom-modal<?php echo $weight->id ?>" class="hidden on-editing cancel-row" data-animation="fadein" data-plugin="custommodal" data-original-title="Delete" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-times"></i></a>
                                  </td>
                              </tr>
                             <?php 
                                  }} ?>
                              
                              </tbody>
                          </table>
                    <?php if (isset($weight_intervals) && $weight_intervals!=null && !empty($weight_intervals)){ ?>
                                  
                    <?php foreach ($weight_intervals as $weight) {?>
                    
                    <!-- Custom Modal -->
        <div id="custom-modal<?php echo $weight->id ?>" class="modal-demo">
            <button type="button" class="close" onclick="Custombox.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">Attention</h4>
            <div class="custom-modal-text">
             <?php echo "Voulez vous vraiment supprimer L'intervalle de poids".$weight->weight." ?" ?>
                 <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url('weight/'.$weight->id .'/delete'); ?>">oui</a>
                  <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('config/weight_intervals'); ?>">Non</a>
                    
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