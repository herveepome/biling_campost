
        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                           
                            <h4 class="page-title">Tarification client</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


                <!-- Basic Form Wizard -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">

                                        <?php if (isset($customer)): ?>
                                            <form id="basic-form" action="<?php echo site_url('tarifs/' . $customer->id . '/update'); ?>"   method="POST">
                                            <?php endif; ?>

                                <div>
                                    <h3>Sélectionnez un client</h3>
                                    <section>
                                        <div class="form-group clearfix">
                                           <label class="col-2 col-form-label" for="example-email">Client</label>
                                            <div class="col-4">
                                                    <select id="select_id" class="form-control" name="customer" value="<?php if (isset($customer)) echo $customer->name; ?>" required>
                                                       <?php if(isset($customer)){  ?>
                                                                 <option><?php echo $customer->name ?></option>
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
                                    </section>
                                    <h3>Commissions sur les cashs</h3>
                                    <section>
                                        <div class="form-group row">
                                    <?php if (isset($intervals) && $intervals != null && !empty($intervals)) { $i=0;?>
                                         <?php foreach ($intervals as $interval) { ?>

                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label class="col-4 col-form-label" for="example-email"> [ <?php echo $interval->interval ; ?> ] </label>

                                                        <input class="col-6" type="text" value="<?php if (isset($cash_collected)){   echo($cash_collected[$i]->amount); $i++;}   ?>" id="example-email"  name="amount[]" class="form-control" placeholder="commission" required>

                                                   

                                                </div>

                                            </div>
                                        <?php
                                         }
                                    }
                                    ?>
                                </div>

                                    </section>
                                    <h3>Tarification à domicile</h3>
                                    <section>
                                        <div class="form-group row">
                                    <?php if (isset($domicile) && $domicile != null && !empty($domicile)) { ?>
                                         <?php foreach ($domicile as $domicil) { ?>

                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label class="col-4 col-form-label" for="example-email"> [ <?php echo $domicil['label'] ; ?> ] </label>

                                                        <input class="col-6" type="text" value="<?php echo $domicil['amount'] ;  ?>" id="example-email"  name="amount[]" class="form-control" placeholder="tarif domicile" required>

                                                   

                                                </div>

                                            </div>
                                        <?php
                                         }
                                    }
                                    ?>
                                </div>

                                    </section>

                                    <h3>Tarification au bureau de poste</h3>
                                     <section>
                                        <div class="form-group row">
                                    <?php if (isset($bureau) && $bureau != null && !empty($bureau)) { ?>
                                         <?php foreach ($bureau as $buro) { ?>

                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label class="col-4 col-form-label" for="example-email"> [ <?php echo $buro['label'] ; ?> ] </label>

                                                        <input class="col-6" type="text" value="<?php echo $buro['amount'] ;  ?>" id="example-email"  name="amount[]" class="form-control" placeholder="tarif bureau" required>

                                                   

                                                </div>

                                            </div>
                                        <?php
                                         }
                                    }
                                    ?>
                                </div>

                                    </section>
                                     <h3>Choisir le point de livraison du client</h3>
                                    <section>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" for="example-email">Point de livraison</label>
                                            <div class="col-4">
                                                    <select  class="form-control" name="deposit" value="<?php if (isset($deposit)) echo $deposit[0]->name; ?>" required>
                                                       <?php if(isset($deposit)) {?>  
                                                            <option><?php echo $deposit[0]->name ; ?></option>
                                                        <?php } else {?>
                                                                    <option selected disabled>Sélectionnez un point de livraison</option>
                                                       <?php } 
                                                        if (isset($deposits)) {
                                                            foreach ($deposits as $deposit) {
                                                                ?>
                                                                <option ><?php echo $deposit->name ?></option>
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
                                                        <?php if(isset($villes)){
                                                        foreach ($villes as $ville) {?> >
                                                                <option ><?php echo $ville['ville'] ; ?> </option>
                                                                <?php }
                                                            }
                                                            ?>

                                                    </select>
                                            </div>
                                          
                                        </div>
                                    </section>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>


            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->

        <!-- End Navigation Bar-->
