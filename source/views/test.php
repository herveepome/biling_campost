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
    } else {?>
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

                                         <?php if (isset($malformedLines) && $malformedLines!=null && !empty($malformedLines)) {
                                                if (count($malformedLines)<=10){?>
                                                    <a href="#custom-modal-region" class="hidden on-editing cancel-row" data-animation="fadein" data-plugin="custommodal" data-original-title="Valider" data-overlaySpeed="200" data-overlayColor="#36404a">
                                                         <button type="submit" id="addToTable" class="btn btn-primary waves-effect waves-light">Valider</button>
                                                     </a>
                                                 <?php}else{
                                                        if ( isset($customer)&& $customer!=null && !empty($customer) && isset($period) && $period!=null && !empty($period) ){?>
                                                        
                                                        <a href="<?php echo site_url('billing/get_malformed_lines/'.$customer.'/'.$period); ?>"><button id="addToTable" class="btn btn-success waves-effect waves-light">Valider<i class="mdi mdi-plus-circle-outline"></i> </button> </a>
                                         <?php}}}  else { ?>
                                             <a href="<?php echo site_url('billing/read'); ?>"><button id="addToTable" class="btn btn-success waves-effect waves-light">Valider<i class="mdi mdi-plus-circle-outline"></i></button></a>
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
                                        <?php 
                                            if(count($malformedLines)<=10){
                                                $line='';
                                                foreach ($malformedLines as $lines)
                                                    $line=$line.$lines->id. ",";
                                                echo "Les lignes numéro ".$line."ont les régions, les lieux de dépôt, les statuts et/ou les poids mal écrits ou nuls; ces lignes ne seront pas facturées. Valider quand même?";
                                              
                                            }?>
                                    </div>
                                    <div class="custom-modal-text" style="text-align: right">

                                        <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url('billing/read'); ?>">oui</a>
                                        <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('billings'); ?>">Non</a>
                                    </div>

                                </div>

                        </div>

                    </div>
                    <!-- end: col -->

                    <!-- end row -->
                </div> <!-- end container -->
            </div>
            <!-- end wrapper -->
      
<?php }}}?>






// charger les fichiers opérations et versements


<style type="text/css">
        #myProgress {
        width: 100%;
        background-color: grey;
    }
    #myBar {
        width: 1%;
        height: 30px;
        background-color: green;
    }
</style>
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
        
        
        ?>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12" >
                <div class="col-sm-5 m-t-20" >
                    
                </div>
            </div>
        </div>
        <div id="myProgress">
          <div id="myBar"></div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Chargement du <?php if (isset($file_to_upload) && $file_to_upload != null) echo $file_to_upload; ?></b></h4>
                    <div class="row">

                        <div class="col-12">
                            <div class="p-20">
                                <?php //if (isset($file_to_upload) && $file_to_upload!=null): ?>
                                <?php //if ($file_to_upload=="Fichier des versements"): ?>
                                <form action="<?php echo site_url($link); ?>"   method="POST" class="form-horizontal" onsubmit="return (verifFileExtension('fichier', extensionsValides));" role="form" accept-charset="utf-8" enctype="multipart/form-data" >
                                    <?php //else: ?>

                                    <?php //endif; ?>
                                    <?php  ?>
                                    <?php if (isset($_SESSION["message"]) && $_SESSION["message"] != null): ?>
                                        <div class="form-group row">

                                            <div class="col-10">
                                                <div class="alert alert-danger" >

                                                    <font style="color:black;"><?php echo $_SESSION["message"]; ?><br></p></font>

                                                </div>
                                            </div>
                                        </div>
                                    <?php unset($_SESSION["message"]); endif; ?>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Nom du client</label>
                                        <div class="col-2">

                                            <select class="form-control" name="customer" required>
                                                <?php if (isset($customers) && $customers != null && !empty($customers)) { ?>
                                                     
                                                    <?php foreach ($customers as $customer) { ?>
                                                        <option><?php echo $customer->name ?></option>
                                                       <?php
                                                    }
                                                }
                                                ?> 
                                            </select>
                                            
                                                
                                                 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email"><?php if (isset($file_to_upload) && $file_to_upload != null) echo $file_to_upload; ?></label>
                                        <div class="col-2">
                                            <input type="file"  name="file" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label"  for="example-email">Période de facturation</label>
                                        <div class="col-2">
                                            <div class="input-group">
                                                <input type="text" name="period" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" required>
                                                <span class="input-group-addon bg-primary b-0 text-white"><i class="ion-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label"  for="example-email">Date de facturation</label>
                                        <div class="col-2">
                                            <div class="input-group">
                                                <input type="text" name="facturation_date" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" required>
                                                <span class="input-group-addon bg-primary b-0 text-white"><i class="ion-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </div>

                                    <div class="actions_perso">
                                        <button type="submit" onclick="move()" class="btn btn-primary waves-effect waves-light btn-md">Charger</button>
                                        <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('billings'); ?>">Annuler</a>
                                    </div>

                            </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- end row -->

            </div> <!-- end card-box -->
        </div><!-- end col -->
    </div>
    <!-- end row -->
</div> <!-- end container -->
</div>
<!-- end wrapper -->
<?php }
}?>