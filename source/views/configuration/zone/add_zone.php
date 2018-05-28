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

                    <h4 class="page-title">Nouvelle zone</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Editer une zone</b></h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                <?php if ($this->uri->segment(2) == "new"): ?>
                                    <form action="<?php echo site_url('zone/create'); ?>"   method="POST">
                                    <?php else: ?>
                                        <?php if (isset($zone)): ?>
                                            <form action="<?php echo site_url('zone/' . $zone->id . '/update'); ?>"   method="POST">
                                            <?php endif; ?>
                                        <?php endif; ?>

        <!-- end page title end breadcrumb -->
                                   
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">zone</label>
                                        <div class="col-4">
                                            <input type="text" value="<?php if (isset($zone)) echo $zone->zone; ?>"  id="example-email" name="zone" class="form-control" placeholder="zone" required>
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Client</label>
                                        <div class="col-4">
                                                <select class="form-control" name="customer" value="<?php if (isset($customer)) echo $customer[0]->name; ?>" required>
                                                   <?php if(isset($customer)){  ?>
                                                             <option><?php echo $customer[0]->name ?></option>
                                                   <?php  } else{ ?>
                                                                <option disabled selected>Sélectionnez un Client</option>
                                                 <?php  } 
                                                    if (isset($customers)) {
                                                        foreach ($customers as $customer) {
                                                            ?>
                                                            <option><?php echo $customer->name ?></option>
                                                            <?php }
                                                        }
                                                        ?>

                                                </select>
                                        </div>
                                        </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Ville</label>
                                        <div class="col-4">

                                                <select multiple class="form-control" name="ville[]" value="<?php if (isset($ville)) echo $ville[0]->name; ?>" required>
                                                    <?php if(isset($ville)){ ?>
                                                             <option><?php echo $ville[0]->name ?></option>
                                                   <?php  } else{ ?>
                                                                <option disabled selected>Sélectionnez une ville</option>
                                                 <?php  } 
                                                   
                                                    if (isset($regions)) {
                                                         if (isset($villes)) {
                                                            $i = 0 ;
                                                            
                                                                foreach ($regions as $region) { ?>
                                                                    <option style="font-weight: bold;"> <?php echo $region->name ?> </option> 
                                                                 <?php    foreach($villes[$i] as $ville){?>
                                                                            <option style="padding-left: 15px;"><?php echo $ville->name ?></option>
                                                                    <?php } $i++; 
                                                                } ?>
                                                            
                                                            <?php }
                                                        }
                                                        ?>

                                                </select>
                                        </div>
                                        </div>
                                    
                                      <center>
                                              <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Valider</button>

                                                    <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('config/zones'); ?>">Annuler</a>
                                         </center>
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
</div>
</div>
</div>
</div>
</div>
<!-- end wrapper -->
<!-- end wrapper -->
<?php }
}?>