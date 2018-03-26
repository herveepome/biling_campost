<!DOCTYPE html>
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

<body>
<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <a href="<?php echo site_url('billings'); ?>" class="logo">
                    <img src="<?php echo base_url('assets/images/billpost3.jpg') ?>" alt="" height="80px" class="logo-lg">
                </a>
            </div>
            <!-- End Logo container-->
            <div class="clearfix"></div>
        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->


</header><br>

<div class="wrapper-page">

    <div class="text-center">
        <a href="index.html" class="logo-lg"><i class="mdi mdi-radar"></i> <span>Billpost/création de compte</span> </a>
    </div>

    <form class="form-horizontal m-t-20" action="<?php echo site_url('register'); ?>" method="post">

        <div class="form-group row">
            <div class="col-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-email"></i></span>
                    <input class="form-control" type="email" required="" placeholder="Email">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-account"></i></span>
                    <input class="form-control" type="text" required="" placeholder="Username">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-key"></i></span>
                    <input class="form-control" type="password" required="" placeholder="Password">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-12">
                <div class="checkbox checkbox-primary">
                    <input id="checkbox-signup" type="checkbox" checked="checked">
                    <label for="checkbox-signup">
                        I accept <a href="#">Terms and Conditions</a>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group text-right m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-primary btn-custom waves-effect waves-light w-md" type="submit">Register</button>
            </div>
        </div>

        <div class="form-group row m-t-30">
            <div class="col-12 text-center">
                <a href="<?php if(isset($login))  echo $login ; ?>" class="text-muted">Already have account?</a>
            </div>
        </div>

    </form>
</div>
