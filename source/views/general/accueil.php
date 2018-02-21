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
                    <h4 class="page-title">BILLING CAMPOST</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
                <div class="card-box">
                                <form action="#">
                                        <div class="form-group row">
	                                        <label class="col-1 col-form-label" for="example-email">Client</label>
	                                        <div class="col-2">
												<div class="col-16">
		                                            <select class="form-control" required>
																                            <option>		</option>
		                                                        <option>client 1</option>
		                                                        <option>client 2</option>
		                                            </select>
		                                        </div>
											</div>
											<div class="col-1">
	                                        </div>
											<label class="col-1 col-form-label" for="example-email">Période</label>
	                                        <div class="col-2">
	                                            <input type="text" id="example-email" name="Numero_registre_commerce" width="30px" class="form-control" placeholder="Ex:01/2017" maxlength="14" required>
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
