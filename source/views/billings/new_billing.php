<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">FACTURES</a></li>
                            <li class="breadcrumb-item"><a href="#">Générer une nouvelle facture</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">FACTURES</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Création d'une nouvelle facture</b></h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                <form action="<?php echo site_url('billings/generate'); ?>"   method="POST"class="form-horizontal" onsubmit="return (verifFileExtension('fichier', extensionsValides));" role="form" accept-charset="utf-8" enctype="multipart/form-data">

                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">Nom du client</label>
                                        <div class="col-6">

                                            <select class="form-control" name="customer" required>
                                                <?php if (isset($customers) && $customers != null && !empty($customers)) { ?>

                                                    <?php foreach ($customers as $customer) { ?>
                                                        <option><?php echo $customer->name ?></option>
                                                        <?php }
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="customerID" value="<?php echo $customer->id ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Période</label>
                                        <div class="col-4">
                                            <input type="text" id="example-email" name="period" class="form-control" placeholder="Ex: 01/2018"  required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Fichier des opérations</label>
                                        <div class="col-6">
                                            <input type="file"  name="operation_file" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">Fichier de versements</label>
                                        <div class="col-6">
                                            <input type="file"  name="versed_file" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label"  for="example-email">Date de facturation</label>
                                        <div class="col-2">
                                            <div class="input-group">
                                                <input type="text" name="facturation_date" class="form-control" placeholder="mm/dd/yyyy" id="datepicker" required>
                                                <span class="input-group-addon bg-primary b-0 text-white"><i class="ion-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </div>

                                    <div class="actions_perso">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Générer</button>
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
