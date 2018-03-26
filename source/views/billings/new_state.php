<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
         <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">

                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Création du <?php if (isset($file_to_upload) && $file_to_upload!=null) echo $file_to_upload; ?></b></h4>
                    <div class="row">
                        
                       
                        
                        <div class="col-12">
                            <div class="p-20">
                                
                                    <form action="<?php echo site_url($link); ?>"   method="POST" class="form-horizontal" >
       
                                   <?php if (isset($_SESSION["message"]) && $_SESSION["message"] != null): ?>
                                          <div class="form-group row">
                                        
                                        <div class="col-10">
                                             <div class="alert alert-danger" >
                                
                                <font style="color:black;"><?php echo $_SESSION["message"]; ?><br></p></font>
                           
                                </div>
                                              </div>
                                    </div>
                                   <?php unset($_SESSION["message"]);endif; ?>
                                     <br>
                                    <div class="form-group row">
                                        
                                        <label class="col-2 col-form-label">Nom du client</label>
                                        <div class="col-2">

                                            <select class="form-control" name="customer" required>
                                                <?php if (isset($customers) && $customers != null && !empty($customers)) { ?>

                                                    <?php foreach ($customers as $customer) { ?>
                                                        <option><?php echo $customer->name ?></option>
                                                     <?php }
                                                }
                                                ?> 
                                            </select>
                                           
                                                
                                        </div>
                                    </div>
                                     <br>   
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label"  for="example-email">Période de facturation</label>
                                        <div class="col-2">
                                            <div class="input-group">
                                                <input type="text" name="period" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" required>
                                                <span class="input-group-addon bg-primary b-0 text-white"><i class="ion-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </div>
                                    <div class="actions_perso">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Créer</button>
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
