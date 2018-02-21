<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">GENERATION DE FACTURES</a></li>
                            <li class="breadcrumb-item"><a href="#">Générer une facture</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">GENERATION DE FACTURES</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Generation de facture</b></h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                <form class="form-horizontal" onsubmit="return (verifFileExtension('fichier',extensionsValides));" role="form">

	                                    <div class="form-group row">
	                                        <label class="col-2 col-form-label" for="example-email">Fichier final de facturation</label>
	                                        <div class="col-6">
	                                            <input type="file" id="fichier" name="operation_file" class="form-control" placeholder="Fichier final de facturation" required>
	                                        </div>
	                                    </div>
	                                    <div class="actions">
	                                        <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Générer</button>
	                                        <button type="reset" class="btn btn-danger waves-effect waves-light">Annuler</button>
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
