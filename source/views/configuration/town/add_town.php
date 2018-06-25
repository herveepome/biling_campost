
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">

                    <h4 class="page-title">Nouvelle ville</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Editer une ville</b></h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                <?php if ($this->uri->segment(2) == "new"): ?>
                                    <form action="<?php echo site_url('ville/create'); ?>"   method="POST">
                                    <?php else: ?>
                                        <?php if (isset($ville)): ?>
                                            <form action="<?php echo site_url('ville/' . $ville->id . '/update'); ?>"   method="POST">
                                            <?php endif; ?>
                                        <?php endif; ?>

        <!-- end page title end breadcrumb -->
                                   
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">ville</label>
                                        <div class="col-4">
                                            <input type="text" value="<?php if (isset($ville)) echo $ville->name; ?>"  id="example-email" name="ville" class="form-control" placeholder="ville" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Région</label>
                                        <div class="col-4">
                                                <select class="form-control" name="region" value="<?php if (isset($region)) echo $region[0]->name; ?>" required>
                                                    <?php if(isset($region)) {?>  
                                                        <option><?php echo $region[0]->name ; ?></option>
                                                    <?php } else {?>
                                                                <option selected disabled>Sélectionnez une région</option>
                                                   <?php } 
                                                       
                                                    if (isset($regions)) {
                                                        foreach ($regions as $region) {
                                                            ?>
                                                            <option><?php echo $region->name ?></option>
                                                            <?php }
                                                        }
                                                        ?>

                                                </select>
                                        </div>
                                        </div>
                                     <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Point de livraison</label>
                                        <div class="col-4">
                                                <select class="form-control" name="deposit" value="<?php if (isset($deposit)) echo $deposit[0]->name; ?>" required>
                                                   <?php if(isset($deposit)) {?>  
                                                        <option><?php echo $deposit[0]->name ; ?></option>
                                                    <?php } else {?>
                                                                <option selected disabled>Sélectionnez un point de livraison</option>
                                                   <?php } 
                                                    if (isset($deposits)) {
                                                        foreach ($deposits as $deposit) {
                                                            ?>
                                                            <option><?php echo $deposit->name ?></option>
                                                            <?php }
                                                        }
                                                        ?>

                                                </select>
                                        </div>
                                        </div>
                                    
                                      <center>
                                              <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Valider</button>

                                                    <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('config/villes'); ?>">Annuler</a>
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
