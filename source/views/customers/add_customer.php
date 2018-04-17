<?php

if (isset($_SESSION['user'])) {
 //var_dump('tata') ; die;
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
                    <h4 class="page-title">Nouveau client</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <!-- Basic Form Wizard -->
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Création d'un nouveau client</b></h4>

                    <?php if ($this->uri->segment(2) == "create"): ?>
                    <form id="basic-form" action="<?php echo site_url('customer/store/'); ?>"   method="POST">
                        <?php else: ?>
                        <?php if (isset($customer)): ?>
                        <form id="basic-form" action="<?php echo site_url('customer/' . $customer[0]->id . '/update'); ?>"   method="POST">
                            <?php endif; ?>
                            <?php endif; ?>
                        <div>
                            <h3>Informations relative au client</h3>
                            <section>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Nom de l'entreprise</label>
                                    <div class="col-6">
                                        <input type="text" value="<?php if (isset($customer)) echo $customer[0]->name; ?>" id="example-email" name="name" class="form-control" placeholder="Nom de l'entreprise" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label" for="example-email">Registre de commerce</label>
                                    <div class="col-6">
                                        <input type="text" value="<?php if (isset($customer)) echo $customer[0]->business_register; ?>"id="example-email" name="business_register" class="form-control" placeholder="Numéro registre de commerce"  required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label" for="example-email">Numéro de contribuable</label>
                                    <div class="col-6">
                                        <input type="text" value="<?php if (isset($customer)) echo $customer[0]->uin; ?>" id="example-email" name="uin" class="form-control" placeholder="Numéro de contribuable" minlength="12" maxlength="20" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label" for="example-email">Numéro de compte</label>
                                    <div class="col-6">
                                        <input type="text"  value="<?php if (isset($customer)) echo $customer[0]->account_number; ?>" id="example-email" name="account_number" class="form-control" placeholder="Numéro de compte" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label" for="example-email">Banque</label>
                                    <div class="col-6">
                                        <input type="text" value="<?php if (isset($customer)) echo $customer[0]->bank; ?>" id="example-email" name="bank" class="form-control" placeholder="Banque" >
                                    </div>
                                </div>
                                <?php ?>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label" for="example-email">Adresse</label>
                                    <div class="col-4">
                                        <input type="text" value="<?php if (isset($customer)) echo $customer[0]->adress; ?>"  id="example-email" name="adress" class="form-control" placeholder="Adresse" >
                                        <?php var_dump($adresses);die;if (isset($adresses) && $adresses != null && !empty($adresses)) { ?>
                                        <select class="form-control" name="adress" >
                                                <option disabled selected> choisir une adresse  </option>
                                        <?php  foreach ($adresses as $adresse) {  ?>
                                                    <option> 
                                                        <?php echo $adresse->$adresse ?>
                                                    </option>
                                               <?php }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label" for="example-email">Numéro de téléphone</label>
                                    <div class="col-4">
                                        <input type="text" value="<?php if (isset($customer)) echo $customer[0]->phone_number; ?>"id="example-email"  name="phone_number" class="form-control" placeholder="Numéro de téléphone" >
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label" for="example-email">Format du numéro de tracking</label>
                                    <div class="col-4">
                                        <input type="text" value="<?php if (isset($customer)) echo $customer[0]->tracking_number; ?>"id="example-email"  name="tracking_number" class="form-control" placeholder="Format du numéro de tracking " >
                                    </div>

                                </div>


                            </section>
                            <h3>Commissions sur les cashs </h3>
                            <section>

                                <div class="form-group row">
                                    <?php if (isset($cashs) && $cashs != null && !empty($cashs)) { $i=0;?>
                                         <?php foreach ($cashs as $cash) { ?>

                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label class="col-4 col-form-label" for="example-email"> [ <?php echo $cash->interval ; ?> ] </label>

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
                                    <?php if (isset($zones) && $zones != null && !empty($zones)) {
                                        if (isset($poids) && $poids != null && !empty($poids)) {
                                            $i=0;?>
                                        <?php foreach ($zones as $zone) {
                                                foreach ($poids as $poid) {?>

                                                <div class="col-6">
                                                    <div class="form-group row">
                                                        <label class="col-4 col-form-label" for="example-email">
                                                            [ <?php echo $zone->zone; ?> ][<?php echo $poid->weight; ?>] </label>

                                                            <input class="col-6" type="text" value="<?php if (isset($domicile_collected)){echo($domicile_collected[$i]->amount); $i++;}   ?>" id="example-email"  name="tarifdomicile[]" class="form-control"
                                                                   placeholder="tarif à domicile"
                                                                   required>

                                                    </div>

                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    }
                                    ?>
                                </div>
                            </section>
                            <h3>Tarification au bureau de poste</h3>
                            <section>
                                <div class="form-group row">
                                    <?php if (isset($zones) && $zones != null && !empty($zones)) {
                                        if (isset($poids) && $poids != null && !empty($poids)) {
                                            $i=0;?>
                                            <?php foreach ($zones as $zone) {
                                                foreach ($poids as $poid) {?>

                                                    <div class="col-6">
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label" for="example-email">
                                                                [ <?php echo $zone->zone; ?> ][<?php echo $poid->weight; ?>] </label>

                                                                <input class="col-6" type="text" value="<?php if (isset($bureau_collected)){echo($bureau_collected[$i]->amount); $i++;}   ?>" id="example-email"  name="tarifbureau[]" class="form-control"
                                                                       placeholder="tarif au bureau de poste"
                                                                       required>

                                                        </div>

                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </section>

                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- End row -->




    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<?php }
}?>
