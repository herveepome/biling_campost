<div class="wrapper">
            <div class="container-fluid">
			<div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">

                    </div>
                    <?php if (isset($message)) {?>
                    <div class="alert alert-success">
                    <?php  echo $message; ?>
                    </div>
                    <?php } ?>
                    <h4 class="page-title">BILPOST</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
                <div class="card-box">
                                <form action="<?php echo site_url('get_file'); ?>" method="post">
                                        <div class="form-group row">
	                                        <label class="col-1 col-form-label" for="example-email">Client</label>
	                                        <div class="col-2">
												<div class="col-16">
		                                            <select class="form-control" name="customer" required>
                                                        <?php if (isset($customers)){
                                                            foreach ($customers as $customer){?>
                                                                <option><?php echo $customer->name?></option>
                                                            <?php }
                                                        }  ?>

		                                            </select>
		                                        </div>
											</div>
											<div class="col-1">
	                                        </div>
											<label class="col-1 col-form-label" for="example-email">Période</label>
                                            <div class="col-2">
                                                <div class="input-group">
                                                    <input type="text" name="period" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" required>
                                                    <span class="input-group-addon bg-primary b-0 text-white"><i class="ion-calendar"></i></span>
                                                </div><!-- input-group -->
                                            </div>
                                            <label class="col-1 col-form-label" for="example-email">Fichier</label>
                                            <div class="col-2">
                                                <div class="col-16">
                                                    <select class="form-control" name="file" required>
                                                        <option>Facture</option>
                                                        <option>Listing de facturation</option>
                                                    </select>
                                                </div>
                                            </div>
											<div class="col-1">
											<div class="col-2">
												<button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Rechercher</button>
	                                        </div>
										</div>
								</form><br><br>
                            <div class="col-20">
		                            <img src="<?php echo base_url('assets/images/facturation.jpg'); ?>" />
		                    </div>
                </div>
            </div> <!-- end container -->
        </div>
