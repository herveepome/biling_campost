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

                    <h4 class="page-title">Nouvel interval de cash</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Editer un interval de cash</b></h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                <?php if ($this->uri->segment(2) == "new"): ?>
                                    <form action="<?php echo site_url('cash/create'); ?>"   method="POST">
                                    <?php else: ?>
                                        <?php if (isset($cash)): ?>
                                            <form action="<?php echo site_url('cash/' . $cash->id . '/update'); ?>"   method="POST">
                                            <?php endif; ?>
                                        <?php endif; ?>

        <!-- end page title end breadcrumb -->
                                   
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label" for="example-email">cash</label>
                                        <div class="col-4">
                                            <input type="text" value="<?php if (isset($cash)) echo $cash->interval; ?>"  id="example-email" name="cash" class="form-control" placeholder="cash" required>
                                        </div>
                                    </div>
                                    
                                      <center>
                                              <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Valider</button>

                                                    <a class="btn btn-danger waves-effect waves-light" href="<?php echo site_url('config/cash_intervals'); ?>">Annuler</a>
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
</div>
</div>
</div>
</div>
</div>
<!-- end wrapper -->
<!-- end wrapper -->
<?php }
}?>