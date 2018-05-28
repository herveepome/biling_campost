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
                    <h4 class="page-title">DETAILS SUR LE CLIENT</h4>
                </div>
            </div>
        </div>

        <!-- end page title end breadcrumb -->

        <div class="row">

            <div class="col-sm-12">

                <div class="card-box">
                  <div class="row">
                      <div class="col-12">
                          <div class="p-20">
                              
                             <?php if (isset($customer)){ ?>
                                  <div class="form-group row">
                                      <div class="col-6">

                                          <div class="form-group row">
                                              <label class="col-4 col-form-label">Nom de l'entreprise</label>
                                              <label class="col-6 col-form-label"><b><?php echo $customer[0]->name; ?></b></label>
                                          </div>
                                          <div class="form-group row">
                                              <label class="col-4 col-form-label" for="example-email">Registre de commerce</label>
                                              <label class="col-6 col-form-label" for="example-email"><b><?php echo $customer[0]->business_register; ?></b></label>
                                          </div>
                                          <div class="form-group row">
                                              <label class="col-4 col-form-label" for="example-email">Numéro de contribuable</label>
                                              <label class="col-6 col-form-label" for="example-email"><b><?php echo $customer[0]->uin; ?></b></label>
                                          </div>
                                          <div class="form-group row">
                                              <label class="col-4 col-form-label" for="example-email">Numéro de compte</label>
                                              <label class="col-6 col-form-label" for="example-email"><b><?php echo $customer[0]->account_number; ?></b></label>
                                          </div>
                                      </div>
                                      <div class="col-6">
                                          <div class="form-group row">
                                              <label class="col-4 col-form-label" for="example-email">Banque</label>
                                              <label class="col-6 col-form-label" for="example-email"><b><?php echo $customer[0]->bank; ?></b></label>
                                          </div>

                                          <div class="form-group row">
                                              <label class="col-4 col-form-label" for="example-email">Adresse</label>
                                              <label class="col-6 col-form-label" for="example-email"><b><?php echo $customer[0]->adress; ?></b></label>
                                          </div>


                                          <div class="form-group row">
                                              <label class="col-4 col-form-label" for="example-email">Numéro de téléphone</label>
                                              <label class="col-6 col-form-label" for="example-email"><b><?php echo $customer[0]->phone_number; ?></b></label>
                                          </div>
                                          <div class="form-group row">
                                              <label class="col-4 col-form-label" for="example-email">Format de tracking number</label>
                                              <label class="col-6 col-form-label" for="example-email"><b><?php echo $customer[0]->tracking_number; ?></b></label>
                                          </div>
                                      </div>
                                  </div>
                                  
                                     <div class="form-group row">
                                            <div class="actions">

                                                <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url('customers'); ?>">Retour</a>

                                            </div>
                                     </div>
                          </div>
                       <?php }?>
                      </div>
                </div>
            </div>
            <!-- end: col -->
        <!-- end row -->
    </div> <!-- end container -->
</div>
</div>
</div>
<!-- end wrapper -->
<?php }
}?>