
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
                              
                             <?php if (isset($customer)): ?>
                              <form class="form-horizontal" role="form">
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
                                      <div class="col-6">
                                          <h3>Commissions sur cashs collectés</h3>  </br>
                                          <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                              <thead>
                                                  <tr>
                                                      <th>cashs collectés</th>
                                                      <th>commissions </th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              <?php if (isset($cashs) && $cashs!=null && !empty($cashs)){
                                                  if (isset($intervals) && $intervals!=null && !empty($intervals)){$i=0;
                                                       foreach ($cashs as $cash) {
                                                          // var_dump($intervals[1]);exit;
                                                          if ($cash->cash_interval_id=$intervals[$i][0]->id){?>
                                                              <tr>
                                                                <td><?php echo $intervals[$i][0]->interval ?></td>
                                                                <td><?php echo $cash->amount ?></td>

                                                              </tr>
                                                              <?php $i++;
                                                         }


                                                      }}
                                                  } ?>



                                              </tbody>
                                          </table>
                                      </div>
                                      <div class="col-6">
                                          <h3>Tarification Zone Poids</h3>  </br>
                                          <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                              <thead>
                                              <tr>
                                                  <th>A domicile</th>
                                                  <th>Au bureau de poste </th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php if (isset($cashs) && $cashs!=null && !empty($cashs)){
                                                  if (isset($intervals) && $intervals!=null && !empty($intervals)){$i=0;
                                                      foreach ($cashs as $cash) {
                                                          // var_dump($intervals[1]);exit;
                                                          if ($cash->cash_interval_id=$intervals[$i][0]->id){?>
                                                              <tr>
                                                                  <td><?php echo $intervals[$i][0]->interval ?></td>
                                                                  <td><?php echo $cash->amount ?></td>

                                                              </tr>
                                                              <?php $i++;
                                                          }


                                                      }}
                                              } ?>



                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  </div>

                                  
                                  <?php endif; ?>
                                  
                                     <div class="form-group row">
                                            <div class="actions">

                                                    

                                                    <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url('customers'); ?>">Retour</a>


                                            </div>
                                        </div>

                              </form>
                          </div>
                      </div>
                </div>
            </div>
            <!-- end: col -->

        <!-- end row -->
    </div> <!-- end container -->
</div>
<!-- end wrapper -->

