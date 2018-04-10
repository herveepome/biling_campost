<?php
if (isset($_SESSION['user'])) {

    $now = time(); // Checking the time now when home page starts.
    if ($now > $_SESSION['expire']) {
        session_destroy();
        redirect ('login_form');
    } else {
        //var_dump($dup_item_number);die;
        if (isset($dup_item_number) && $dup_item_number > 1) {
            ?>

                        <script>
                var el=document.getElementById('calcul_doublons').value;
                alert(el);
                document.getElementById('calcul_doublons').click();
                            
                function eventFire(el, etype){
            if (el.fireEvent) {
            el.fireEvent('on' + etype);
            } else {
            var evObj = document.createEvent('Events');
            evObj.initEvent(etype, true, false);
            el.dispatchEvent(evObj);
            }
            }
            function eventFire(document.getElementById('calcul_doublons'), 'click')

            </script> 
            <?php } ?>
            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">

                                <div  class="col-2">
                                   <a  href="#doublons"> <button  value="fav_HTML" id="calcul_doublons" style="display:none;">test </button></a>
                               
                                </div>

                                <div class="btn-group pull-right">
                                </div>

                                <?php if (isset($_SESSION["message"]) && $_SESSION["message"] != null): ?>
                                    <div class="form-group row">

                                        <div class="col-10">
                                            <div class="alert alert-danger" >

                                                <font style="color:black;"><?php echo $_SESSION["message"]; ?><br></p></font>

                                            </div>
                                        </div>
                                    </div>
                                    <?php unset($_SESSION["message"]);
                                endif; ?>

            <?php if (isset($doublons)): ?>

                                    <div class="col-1">
                                        <div class="col-2">
                                            <a href="<?php if (isset($state_file_id)) echo site_url('files/operation_file/duplicate_items_number/'.$state_file_id); ?>" > 
                                                <button type="button" class="btn btn-primary waves-effect waves-light">Supprimer les doublons</button>
                                            </a>
                                        </div>
                                    </div>
            <?php endif; ?>


                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group pull-right">

                                        </div>
                                            <?php if (isset($message)) { ?>
                                            <div class="alert alert-success">
                                            <?php echo $message; ?>
                                            </div>
            <?php } ?>

                                        <h4 class="page-title">BILPOST</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            <div class="card-box">
                                <form action="<?php echo site_url('get_file'); ?>" method="post">
                                    <div class="form-group row">
                                        <label class="col-1 col-form-label" for="example-email">Client</label>
                                        <div class="col-2">
                                            <div class="col-16">
                                                <select class="form-control" name="customer" required>
                                                    <?php
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
                                        <div class="col-1">
                                        </div>
                                        <label class="col-1 col-form-label" for="example-email">Période</label>
                                        <div class="col-2">
                                            <div class="input-group">
                                                <input type="text" name="period" class="form-control" placeholder="mm/dd/yyyy"
                                                       data-provide="datepicker" required>
                                                <span class="input-group-addon bg-primary b-0 text-white"><i
                                                        class="ion-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                        <label class="col-1 col-form-label" for="example-email">Fichier</label>
                                        <div class="col-2">
                                            <div class="col-16">
                                                <select class="form-control" name="file" required>
                                                    <option>Facture</option>
                                                    <option>Listing de facturation</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">
                                                    Rechercher
                                                </button>
                                            </div>
                                        </div>
                                </form>
                                <br><br>
                                <div class="col-20">
                                    <img src="<?php echo base_url('assets/images/facturation.jpg'); ?>"/>
                                </div>
                            </div>
                        </div> <!-- end container -->
                    </div>

                    <div id="doublons" class="modal-demo">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="custom-modal-title">Suppression des doublons</h4>
                        <div class="custom-modal-text">
            <?php echo "Nous allons procéder à la suppression de " . $dup_item_number . " doublon(s) que nous avons trouvés" ?>
                            <a class="btn btn-primary waves-effect waves-light btn-md" href="<?php echo site_url('deleting_duplicate_items'); ?>">OK.</a>

                        </div>
                    </div>
        <?php
        }
    }
?>