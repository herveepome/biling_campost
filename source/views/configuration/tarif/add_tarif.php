<script>
    function change() {
        val = document.getElementById("select_id").value;
       // alert(val);
       jQuery.ajax({
            url: " <?php echo base_url(); ?>" + "index.php/config/ConfigurationManager/labelZonePoids " ,
            type: "POST",
            dataType: "JSON",
            data: {select_id : val},
            success:function(data){
                var result = jQuery.parseJSON(JSON.stringify(data));
                //alert(JSON.stringify(data)) ;
               if (result){
                    for (var i = 0; i < result.label.length; i++) {
                        jQuery('#'+'ajaxd' + i).html(JSON.stringify(result.label[i]).split('"').join(''));
                        jQuery('#'+'ajaxp' + i).html(JSON.stringify(result.label[i]).split('"').join(''));
                   }
                   for(var i = 0; i < result.ville.length; i++){
                        jQuery('#'+'ajaxv' + i).html(JSON.stringify(result.ville[i]).split('"').join(''));
                   }
               } 

        }
       })

    }
</script>


<?php


if (isset($_SESSION['user'])) {
 //var_dump($_SESSION) ; die;
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
                           
                            <h4 class="page-title">Tarification client</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->


                <!-- Basic Form Wizard -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <h4 class="m-t-0 header-title"><b>Tarification client</b></h4>

                            <?php if ($this->uri->segment(2) == "new"): ?>
                                    <form id="basic-form" action="<?php echo site_url('tarifs/create'); ?>"   method="POST">
                                    <?php else: ?>
                                        <?php if (isset($tarif)): ?>
                                            <form id="basic-form" action="<?php echo site_url('tarifs/' . $tarif->id . '/update'); ?>"   method="POST">
                                            <?php endif; ?>
                                        <?php endif; ?>

                                <div>
                                    <h3>Sélectionnez un client</h3>
                                    <section>
                                        <div class="form-group clearfix">
                                           <label class="col-2 col-form-label" for="example-email">Client</label>
                                            <div class="col-4">
                                                    <select onchange="change()" id="select_id" class="form-control" name="customer" value="<?php if (isset($customer)) echo $customer[0]->name; ?>" required>
                                                       <?php if(isset($customer)){  ?>
                                                                 <option><?php echo $customer[0]->name ?></option>
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
                                  
                                            <?php if(isset($_SESSION['data'])){
                                                $length = $_SESSION['data']['label'] ;
                                                for($i = 0; $i < $length ; $i++) {?> 
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label class="col-4 col-form-label" id="<?php echo("ajaxd".$i)?>" for="example-email">
                                                             
                                                             </label>

                                                            <input class="col-6" type="text" value="<?php if (isset($domicile_collected)){echo($domicile_collected[$i]->amount); $i++;}   ?>" id="example-email"  name="tarifdomicile[]" class="form-control"
                                                                   placeholder="tarif à domicile"
                                                                   required>

                                                    </div>

                                                </div>
                                                <?php } }?>
                                          
                                        </div>
                                    </section>
                                    <h3>Tarification au bureau de poste</h3>
                                    <section>
                                        <div class="form-group row">
                                  
                                            <?php if(isset($_SESSION['data'])){
                                                $length = $_SESSION['data']['label'] ;
                                                for($i = 0; $i < $length ; $i++) {?> 
                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label class="col-4 col-form-label" id="<?php echo("ajaxp".$i)?>" for="example-email">
                                                             
                                                             </label>

                                                            <input class="col-6" type="text" value="<?php if (isset($bureau_collected)){echo($bureau_collected[$i]->amount); $i++;}   ?>" id="example-email"  name="tarifbureau[]" class="form-control"
                                                                   placeholder="tarif au bureau de poste"
                                                                   required>

                                                    </div>

                                                </div>
                                                <?php } } else {?>


                                              <?php  }?>
                                          
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
                                                        <?php if(isset($_SESSION['data'])){
                                                        $length = $_SESSION['data']['ville'] ;
                                                        for($i = 0; $i < $length ; $i++) {?> >
                                                                <option id="<?php echo("ajaxv".$i)?>" > </option>
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
<?php }
}?>
