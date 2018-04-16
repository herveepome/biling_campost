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
                    <h4 class="page-title"> <?php  if ( isset($period) ){ ?> Fichier de facturation de la période du <?php echo $period ?> <?php } else { ?> Fichier de facturation     <?php  } ?> </h4>
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
                                 <a href="<?php echo site_url('billing/newLine'); ?>"><button id="addToTable" class="btn btn-success waves-effect waves-light">Ajouter une ligne<i class="mdi mdi-plus-circle-outline"></i></button></a>

                                 <?php if  (isset($malformedLines) && $malformedLines!=null && !empty($malformedLines)){ 
                                    if(count($malformedLines) <= 10 ){?>
                                            <a href="#custom-modal-region" class="hidden on-editing cancel-row" data-animation="fadein" data-plugin="custommodal" data-original-title="Valider" data-overlaySpeed="200" data-overlayColor="#36404a">
                                             <button type="submit" id="addToTable" class="btn btn-primary waves-effect waves-light">Valider</button>
                                         </a>

                                  <?php  }else{
                                            if(isset($customer)&& $customer!=null && !empty($customer) && isset($period) && $period!=null && !empty($period)){ ?>
                                                <a href="<?php echo site_url('billing/get_malformed_lines/'.$customer.'/'.$period ); ?>"><button id="addToTable" class="btn btn-success waves-effect waves-light">Valider<i class="mdi mdi-plus-circle-outline"></i> </button> </a>

                                        <?php }
                                   }                                          
                                  }else { ?>
                                     <a href="<?php echo site_url('billing/read'); ?>"><button id="addToTable" class="btn btn-success waves-effect waves-light">Ajouter une ligne<i class="mdi mdi-plus-circle-outline"></i></button></a>
                                 <?php } ?>
                             </div>

                         </div>

                        </div>
                    </div>

                    <table id="datatable" class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Num</th>
                            <th>Date de collecte</th>
                            <th>Num commande</th>
                            <th>Num colis</th>
                            <th>Destination</th>
                            <th>Poids</th>
                            <th>Région</th>
                            <th>Lieux de dépôt</th>
                            <th>Statut final</th>
                            <th>Date statut final</th>
                            <th>Actions</th>
                        </tr>
                        </thead>


                        <tbody>
                        <?php if (isset($billings) && $billings!=null && !empty($billings)){ ?>

                            <?php foreach ($billings as $billing) {?>
                                <tr>
                                    <td><?php echo $billing->id ?></td>
                                    <td><?php echo $billing->date_collected ?></td>
                                    <td><?php echo $billing->order_number?></td>
                                    <td><?php echo $billing->tracking_number ?></td>
                                    <td><?php echo $billing->destination ?></td>
                                    <td><?php echo $billing->weight?></td>
                                    <td><?php echo $billing->region?></td>
                                    <td><?php echo $billing->deposit_local?></td>
                                    <td><?php echo $billing->final_status?></td>
                                    <td><?php echo $billing->final_status_date ?></td>
                                    <td class="actions">

                                        <a href="<?php echo site_url('billing/'.$billing->id.'/edit'); ?> " class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>

                                        <a href="#custom-modal<?php echo $billing->id ?>" class="hidden on-editing cancel-row" data-animation="fadein" data-plugin="custommodal" data-original-title="Delete" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }}  ?>

                        </tbody>
                    </table>
                    <?php if (isset($billings) && $billings!=null && !empty($billings)){ ?>

                        <?php foreach ($billings as $billing) {?>

                            <!-- Custom Modal -->
                            <div id="custom-modal<?php echo $billing->id ?>" class="modal-demo">
                                <button type="button" class="close" onclick="Custombox.close();">
                                    <span>&times;</span><span class="sr-only">Close</span>
                                </button>
                                <h4 class="custom-modal-title">Attention</h4>
                                <div class="custom-modal-text">
                                    <?php echo "Voulez vous vraiment supprimer  cette ligne?" ?>
                                    <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url('billing/'.$billing->id .'/delete'); ?>">oui</a>
                                    <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('billings'); ?>">Non</a>

                                </div>
                            </div>

                            <?php
                        }} ?>

                        <!-- Custom Modal -->
                        <div id="custom-modal-region" class="modal-demo">
                            <button type="button" class="close" onclick="Custombox.close();">
                                <span>&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h4 class="custom-modal-title">Attention</h4>
                            <div class="custom-modal-text" style="text-align: left; line-height: 3">
                                <?php if (isset($malformedLines) && $malformedLines!=null && !empty($malformedLines)){
                                    if(count($malformedLines)>10 ){
                                        $line='';
                                        foreach ($malformedLines as $lines)
                                            $line=$line.$lines->id. ",";
                                        echo "Les lignes numéro ".$line."ont les régions, les poids, les statuts, et/ou les lieux de dépôt nuls ou mal écrites 
                                        ou nulles; ces lignes ne seront pas facturées. Valider quand même?";
                                    }

                                   
                                }?>
                            </div>
                            <div class="custom-modal-text" style="text-align: right">
                                <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url('billing/read'); ?>">oui</a>
                                <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('billings'); ?>">Non</a>
                            </div>

                        </div>

                        <?php
                   ?>
                </div>

            </div>
            <!-- end: col -->

            <!-- end row -->
        </div> <!-- end container -->
    </div>
 
<?php }
}?>