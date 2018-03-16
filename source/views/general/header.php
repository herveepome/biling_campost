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
                            <img src="<?php echo base_url('assets/images/billpost.png') ?>" alt="" height="80px" class="logo-lg">
                        </a>
                    </div>
                    <!-- End Logo container-->
                    <div class="clearfix"></div>
                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                            <li class="has-submenu">
                                <a href="<?php echo site_url(''); ?>"><i class="ion-home"></i>ACCUEIL</a>
                                <ul class="submenu">
                                    <li class="has-submenu">
                                        <a href="#"><i class="ion-ios7-paper">&nbsp;&nbsp;</i> Charger le fichier des </a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo site_url('files/create_versement_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Versements</a></li>
                                            <li><a href="<?php echo site_url('files/create_operation_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Operation</a></li>
                                        </ul>
                                    </li>
                                     <li class="has-submenu"><a href="#"><i class="ion-ios7-paper">&nbsp;&nbsp;</i> Générer le fichier </a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo site_url('state/create_returned_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>des produits  retournés</a></li>
                                            <li><a href="<?php echo site_url('state/create_paidonline_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>des produits payés en ligne</a></li>
                                            <li><a href="<?php echo site_url('state/create_delivery_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>des produits  payés à la livraison</a></li>
                                            <li><a href="<?php echo site_url('state/create_croised_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i> croisé</a></li>
                                            <li><a href="<?php echo site_url('state/create_rejected_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>des produits rejettés</a></li>
                                            <li><a href="<?php echo site_url('state/create_unvoiced_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>des produits non facturés </a></li>
                                        </ul>
                                    </li>

                                    <li><a href="<?php echo site_url('billing/create'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Générer le fichier de facturation </a></li>

                                     <li><a href="<?php echo site_url('bill/create'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Générer une facture</a></li>

                                     <li class="has-submenu"><a href="#"><i class="ion-ios7-paper">&nbsp;&nbsp;</i> Configurer </a>
                                        <ul class="submenu">
                                            <li><a href="<?php echo site_url('config/adresses'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>les adresses</a></li>
                                            <li><a href="<?php echo site_url('config/zones'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>les zones</a></li>
                                            <li><a href="<?php echo site_url('config/regions'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>les régions</a></li>
                                            <li><a href="<?php echo site_url('config/weight_intervals'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i> les intervaux de poids</a></li>
                                            <li><a href="<?php echo site_url('config/cash_intervals'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>les intervaux de cash</a></li>
                                            
                                        </ul>
                                    </li>

                                </ul>

                            </li>

                            <li class="has-submenu">
                                <a href="<?php echo site_url('customers'); ?>"><i class="ion-person"></i>CLIENTS</a>
                                <ul class="submenu">
                                    <li><a href="<?php echo site_url('customer/create'); ?>"><i class="ion-plus-round">&nbsp;&nbsp;</i>Nouveau client</a></li>
                                </ul>
                            </li>

                            <li class="has-submenu">
                                <a href="#"><i class="ion-ios7-copy"></i>ETATS</a>
                                
                                        <ul class="submenu">
                                           
                                            <li><a href="<?php echo site_url('state/list_returned_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Fichiers des produits retournés</a></li>
                                            <li><a href="<?php echo site_url('state/list_paidonline_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Fichiers des produits payés en ligne</a></li>
                                            <li><a href="<?php echo site_url('state/list_delivery_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Fichiers des produits  payés à la livraison</a></li>
                                            <li><a href="<?php echo site_url('state/list_croised_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Fichiers croisés</a></li>
                                            <li><a href="<?php echo site_url('state/list_rejected_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Fichiers des produits rejettés</a></li>
                                            <li><a href="<?php echo site_url('state/list_unvoiced_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Fichier des produits non facturés </a></li>
                                            <li><a href="<?php echo site_url('state/list_billing_file'); ?>"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Fichier de facturation </a></li>
                                        </ul>


                            </li>

                            <li class="has-submenu">
                                <a href="#"><i class="ion-document-text"></i>FACTURES</a>
                                <ul class="submenu">
                                    
                                    <li><a href="components-carousel.html"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Listing mensuel</a></li>
                                    <li><a href="components-nestable-list.html"><i class="ion-ios7-paper">&nbsp;&nbsp;</i>Historique</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- End navigation menu -->

                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header><br>
        <!-- End Navigation Bar-->
