
<html>
    <head>

        <meta charset="utf-8" />
        <title>Facturation CAMPOST</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />


        <!--Form Wizard-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/jquery.steps/css/jquery.steps.css');?>" >

        <link rel="shortcut icon" href="<?php echo base_url('assets/images/campost.png'); ?>">
        <!-- DataTables -->
        <link href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url('assets/plugins/datatables/buttons.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="<?php echo base_url('assets/plugins/datatables/responsive.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- Plugins css-->
        <link href="<?php echo base_url('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/multiselect/css/multi-select.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/select2/select2.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" type="text/css" />


        <!-- App css -->
        <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/icons.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/plugins/custombox/dist/custombox.min.css'); ?>" rel="stylesheet" />


        <script src="<?php echo base_url('assets/js/modernizr.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>

    </head>
    
<div id="doublons" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Suppression des doublons</h4>
    <div class="custom-modal-text">
        <?php echo "Nous allons supprimer les éventu" . $doublons . "que nous avons trouvés" ?>
        <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url(''); ?>">OK.</a>

    </div>
</div>
    

<!-- jQuery  -->

        <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/popper.min.js');?>"></script><!-- Popper for Bootstrap --><!-- Tether for Bootstrap -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/waves.js');?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.slimscroll.js');?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.scrollTo.min.js');?>"></script>

        <!-- Required datatable js -->
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap4.min.js');?>"></script>
        <!-- Buttons examples -->
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.buttons.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/buttons.bootstrap4.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/jszip.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/pdfmake.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/vfs_fonts.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/buttons.html5.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/buttons.print.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/buttons.colVis.min.js');?>"></script>


        <!--Form Wizard-->
        <script src="<?php echo base_url('assets/plugins/jquery.steps/js/jquery.steps.min.js');?>" type="text/javascript" > </script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-validation/js/jquery.validate.min.js');?>"></script>

        <!--wizard initialization-->
        <script src="<?php echo base_url('assets/pages/jquery.wizard-init.js');?>" type="text/javascript"></script>

        <!-- Responsive examples -->
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.responsive.min.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/responsive.bootstrap4.min.js');?>"></script>

        <!-- App js -->
        <script src="<?php echo base_url('assets/js/jquery.core.js');?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.app.js');?>"></script>

        <!-- Modal-Effect -->
        <script src="<?php echo base_url('assets/plugins/custombox/dist/custombox.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/custombox/dist/legacy.min.js'); ?>"></script>

        <!-- jQuery form advanced and datepick -->
        <script src="<?php echo base_url('assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/multiselect/js/jquery.multi-select.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-quicksearch/jquery.quicksearch.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/select2/select2.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/moment/moment.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/switchery/switchery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/pages/jquery.form-advanced.init.js'); ?>"></script>

