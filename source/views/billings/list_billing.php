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

                <div class="row">

                    <div class="col-sm-12">

                        <div class="card-box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="m-b-30">
                                        <button id="addToTable" class="btn btn-success waves-effect waves-light">Add <i class="mdi mdi-plus-circle-outline"></i></button>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-striped add-edit-table" id="datatable-editable">
                                <thead>
                                <tr>
                                    <th>Num</th>
                                    <th>Date de collecte</th>
                                    <th>Num commande</th>
                                    <th>Num colis</th>
                                    <th>Destination</th>
                                    <th>Poids</th>
                                    <th>Statut final</th>
                                    <th>Date statut final</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody> 
                                    <?php if (isset($values) && $values!=null && !empty($values)){ ?>
                                  
                                  <?php foreach ($values as $value) {?>
                                <tr class="gradeX">
                                    <td><?php echo $value->bill_number ?></td>
                                    <td><?php echo $value->date_collected ?></td>
                                    <td><?php echo $value->order_number?></td>
                                    <td><?php echo $value->tracking_number ?></td>
                                    <td><?php echo $value->destination ?></td>
                                    <td><?php echo $value->weight?></td>
                                    <td><?php echo $value->final_status?></td>
                                    <td><?php echo $value->final_status_date ?></td>
                                    <td class="actions">
                                        <a href="#" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="on-default remove-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                        <a href="#" class="hidden on-editing save-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save"><i class="fa fa-save"></i></a>
                                    </td>
                                </tr>
                                    
                             <?php 
                                  }} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end: col -->

                </div> <!-- end row -->

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


        
     


















        <div class="wrapper">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-sm-12">

                        <div class="card-box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="m-b-30">
                                        <button id="addToTable" class="btn btn-success waves-effect waves-light">Add <i class="mdi mdi-plus-circle-outline"> </i></button>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-striped add-edit-table" id="datatable-editable">
                                <thead>
                                <tr>
                                    <th>Num</th>
                                    <th>Date de collecte</th>
                                    <th>Num commande</th>
                                    <th>Num colis</th>
                                    <th>Destination</th>
                                    <th>Poids</th>
                                    <th>Statut final</th>
                                    <th>Date statut final</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody> 
                                    <?php if (isset($values) && $values!=null && !empty($values)): ?>
                                    
                                    
                                    <?php foreach ($values as $value) {?>

                                <tr class="gradeX">
                                    <td><?php echo $value->bill_number ;?></td>
                                    <td><?php echo $value->date_collected ;?></td>
                                    <td><?php echo $value->order_number ;?></td>
                                    <td><?php echo $value->tracking_number; ?></td>
                                    <td><?php echo $value->destination; ?></td>
                                    <td><?php echo $value->weight; ?></td>
                                    <td><?php echo $value->final_status; ?></td>
                                    <td><?php echo $value->final_status_date; ?></td>
                                    <td class="actions">
                                        <a href="#" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="on-default remove-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                        <a href="#" class="hidden on-editing save-row" data-toggle="tooltip" data-placement="top" title="" data-original-title="Save"><i class="fa fa-save"></i></a>
                                    </td>
                                </tr>
                                    
                             <?php 
                                  }endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end: col -->

                </div> <!-- end row -->

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->
        <?php }
        }?>

        
     
