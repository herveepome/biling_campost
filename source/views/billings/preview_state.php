<!DOCTYPE html>
<html>


    <body>

        


        <div class="wrapper">
            <div class="container-fluid">

                <!-- Page-Title -->
               

                <div class="row">
                    <div class="col-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title"><b> <?php echo $file_text_name ?></b></h4>
                        <br>
                        <input type="hidden" id="file_id" value="<?php if (isset($file_text_name) && $file_text_name != null && !empty($file_text_name)) echo $file_text_name ?>" >
                            <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr class="font-13">
                                   <?php if (isset($headers)) { ?> 
                                    <?php foreach ($headers as $header) { ?>
                                    <th><?php echo $header; ?></th>
                                     <?php }} ?>
                                </tr>
                                </thead>


                                <tbody>
                                <tr class="font-14" >
                                     <?php if (isset($rows)) { ?> 
                                     <?php foreach ($rows as $row) { ?>
                                <td ><?php echo $row->shipment_provider; ?></td>
                                <td ><?php echo $row->status; ?></td>
                                <td ><?php echo $row->size; ?></td>
                                <td ><?php echo $row->order; ?></td>
                                <td ><?php echo $row->region; ?></td>
                                <td ><?php echo $row->payment_method; ?></td>
                                <td ><?php echo $row->amount_to_collect; ?></td>
                                <?php if (isset($row->amount_collected)): ?><td ><?php echo $row->amount_collected; ?></td><?php endif;?>
                                <td ><?php echo $row->bureau; ?></td>
                                <td ><?php echo $row->date_operation; ?></td>
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