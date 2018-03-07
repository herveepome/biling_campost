<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <h4 class="page-title"><?php echo "Liste des fichiers ".$name ?></h4>
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
                                  <th>Type</th>
                                  <th>Période</th>
                                  <th>Actions</th>
                                  
                              </tr>
                              </thead>


                              <tbody>
                                   <?php if (isset($states) && $states!=null && !empty($states)){ ?>
                                  
                                  <?php foreach ($states as $state) {?>
                             <tr>
                               <td><?php echo $state->name ?></td>
                                  <td><?php echo $state->type ?></td>
                                  <td><?php echo $state->period ?></td>
                                  
                                  
                                  <td class="actions">
                                        <a href="<?php if($state->type='FF'){echo site_url("billing/".$state->id."/read");}else{echo site_url("state/".$state->id."/preview");}  ?>" class="hidden on-editing save-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Visualiser"><i class="ti-eye"></i></a>
                                        
                                        <a href="" class="hidden on-editing cancel-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer"><i class="fa fa-times"></i></a>
                                    </td>
                              </tr>
                             <?php 
                                  }} ?>
                              
                              </tbody>
                          </table>
             
                </div>
            </div>
            <!-- end: col -->

        <!-- end row -->
    </div> <!-- end container -->
</div>
<!-- end wrapper -->
</div>

