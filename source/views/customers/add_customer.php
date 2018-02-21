
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">

                    <h4 class="page-title">Nouveau Client</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Création d'un nouveau client</b></h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                <?php if ($this->uri->segment(2) == "create"): ?>
                                    <form action="<?php echo site_url('customer/store/'); ?>"   method="POST">
                                    <?php else: ?>
                                        <?php if (isset($customer)): ?>
                                            <form action="<?php echo site_url('customer/' . $customer[0]->id . '/update'); ?>"   method="POST">
                                            <?php endif; ?>
                                        <?php endif; ?>

        <!-- end page title end breadcrumb -->

      
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Nom de l'entreprise</label>
                                        <div class="col-6">
                                          <input type="text" value="<?php if (isset($customer)) echo $customer[0]->name; ?>" id="example-email" name="name" class="form-control" placeholder="Nom de l'entreprise" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Registre de commerce</label>
                                        <div class="col-6">
                                            <input type="text" value="<?php if (isset($customer)) echo $customer[0]->business_register; ?>"id="example-email" name="business_register" class="form-control" placeholder="Numéro registre de commerce"  required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Numéro de contribuable</label>
                                        <div class="col-6">
                                            <input type="text" value="<?php if (isset($customer)) echo $customer[0]->uin; ?>" id="example-email" name="uin" class="form-control" placeholder="Numéro de contribuable" minlength="14" maxlength="14" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Numéro de compte</label>
                                        <div class="col-6">
                                            <input type="text"  value="<?php if (isset($customer)) echo $customer[0]->account_number; ?>" id="example-email" name="account_number" class="form-control" placeholder="Numéro de compte" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Banque</label>
                                        <div class="col-6">
                                            <input type="text" value="<?php if (isset($customer)) echo $customer[0]->bank; ?>" id="example-email" name="bank" class="form-control" placeholder="Banque" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Ville</label>
                                        <div class="col-4">
                                            <input type="text" value="<?php if (isset($customer)) echo $customer[0]->town; ?>" id="example-email" name="town" class="form-control" placeholder="Ville" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Adresse</label>
                                        <div class="col-4">
                                            <input type="text" value="<?php if (isset($customer)) echo $customer[0]->adress; ?>"  id="example-email" name="adress" class="form-control" placeholder="Adresse" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">BP</label>
                                        <div class="col-4">
                                            <input type="text" value="<?php if (isset($customer)) echo $customer[0]->postal_box; ?>" id="example-email"  name="postal_box" class="form-control" placeholder="Boite Postale" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Numéro de téléphone</label>
                                        <div class="col-4">
                                            <input type="text" value="<?php if (isset($customer)) echo $customer[0]->phone_number; ?>"id="example-email"  name="phone_number" class="form-control" placeholder="Numéro de téléphone" required>
                                        </div>

                                    </div>

                                      <center>
                                              <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Valider</button>

                                                    <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('customers'); ?>">Annuler</a>
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
