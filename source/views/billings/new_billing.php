
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">

                    <h4 class="page-title">Nouvelle ligne</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
         
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Insertion d'une ligne dans le fichier de facturation</b></h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                             <?php  if($this->uri->segment(2) == "newLine") : ?>
                                <form action="<?php echo site_url('billing/store/'); ?>"   method="POST">
                                    <?php else: ?>
                                    <?php if (isset($billing)): ?>
                                    <form action="<?php echo site_url('billing/' . $billing[0]->id .'/update'); ?>"   method="POST">

                                        <?php endif; ?>
                                        <?php endif; ?>

                                        <!-- end page title end breadcrumb -->

                                        <div class="form-group row">
                                            <label class="col-2 col-form-label">Date de collecte</label>
                                            <div class="col-6">
                                                <input type="text" value="<?php if (isset($billing)) echo $billing[0]->date_collected; ?>" id="example-email" name="date_collected" class="form-control" placeholder="Date de collecte" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" for="example-email">Numéro de commande</label>
                                            <div class="col-6">
                                                <input type="text" value="<?php if (isset($billing)) echo $billing[0]->order_number; ?>"id="example-email" name="order_number" class="form-control" placeholder="Numéro de commande"  required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" for="example-email">Numéro de colis Aige</label>
                                            <div class="col-6">
                                                <input type="text" value="<?php if (isset($billing)) echo $billing[0]->tracking_number; ?>" id="example-email" name="tracking_number" class="form-control" placeholder="Numéro de colis" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" for="example-email">Destination</label>
                                            <div class="col-6">
                                                <input type="text"  value="<?php if (isset($billing)) echo $billing[0]->destination; ?>" id="example-email" name="destination" class="form-control" placeholder="Destination" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" for="example-email">Région</label>
                                            <div class="col-6">
                                                <input type="text"  value="<?php if (isset($billing)) echo $billing[0]->region; ?>" id="example-email" name="region" class="form-control" placeholder="Région" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" for="example-email">Poids</label>
                                            <div class="col-6">
                                                <input type="text" value="<?php if (isset($billing)) echo $billing[0]->weight; ?>" id="example-email" name="weight" class="form-control" placeholder="Poids" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" for="example-email">Statut final</label>
                                            <div class="col-4">
                                                <input type="text" value="<?php if (isset($billing)) echo $billing[0]->final_status; ?>"  id="example-email" name="final_status" class="form-control" placeholder="Statut final" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-2 col-form-label" for="example-email">Date de statut final</label>
                                            <div class="col-4">
                                                <input type="text" value="<?php if (isset($billing)) echo $billing[0]->final_status_date; ?>"id="example-email"  name="final_status_date" class="form-control" placeholder="Date du statut final" required>
                                            </div>

                                        </div>

                                        <center>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Valider</button>

                                            <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('billings'); ?>">Annuler</a>
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

<!-- end wrapper -->
