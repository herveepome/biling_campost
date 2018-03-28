<!DOCTYPE html>
<html>


<body>


<?php

if (isset($_SESSION['user'])) {

$now = time(); // Checking the time now when home page starts.
// var_dump($_SESSION['start']) ; var_dump($_SESSION['expire']) ; var_dump($now);  die;
if ($now > $_SESSION['expire']) {
    session_destroy();
    redirect ("login_form");
} else {
?>

<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->


        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title"><b><?php if (isset($file_text_name)) echo $file_text_name ;  ?></b></h4>
                    <br>
                    <input type="hidden" id="file_id" value="<?php if (isset($file_text_name) && $file_text_name != null && !empty($file_text_name)) echo $file_text_name ?>" >
                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr class="font-13">
                            <th>Num</th>
                            <th>Date de collecte</th>
                            <th>Num commande</th>
                            <th>Num colis</th>
                            <th>Destination</th>
                            <th>Poids</th>
                            <th>Statut final</th>
                            <th>Date statut final</th>
                        </tr>
                        </thead>


                        <tbody>
                        <tr class="font-14" >
                            <?php if (isset($billing)) { ?>
                            <?php foreach ($billing as $bill) { ?>
                            <td><?php echo $bill->id ?></td>
                            <td><?php echo $bill->date_collected ?></td>
                            <td><?php echo $bill->order_number?></td>
                            <td><?php echo $bill->tracking_number ?></td>
                            <td><?php echo $bill->destination ?></td>
                            <td><?php echo $bill->weight?></td>
                            <td><?php echo $bill->final_status?></td>
                            <td><?php echo $bill->final_status_date ?></td>
                        </tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<?php }
}?>
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                2016 - 2017 © Minton - Coderthemes.com
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->


<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script><!-- Popper for Bootstrap --><!-- Tether for Bootstrap -->
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>

<!-- Required datatable js -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="../plugins/datatables/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="../plugins/datatables/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake.min.js"></script>
<script src="../plugins/datatables/vfs_fonts.js"></script>
<script src="../plugins/datatables/buttons.html5.min.js"></script>
<script src="../plugins/datatables/buttons.print.min.js"></script>
<script src="../plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="../plugins/datatables/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable();

        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            lengthChange: false,
            buttons: [{extend: 'excelHtml5',title:'test'}, {extend: 'pdfHtml5',title:'test'}],

        });

        table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    } );

</script>

</body>
</html>