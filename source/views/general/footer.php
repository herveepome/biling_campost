<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                2018 © CAMPOST - Designed by SAO
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

<!-- Custom Modal -->
        <div id="custom-modal" class="modal-demo">
            <button type="button" class="close" onclick="Custombox.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">Warning</h4>
            <div class="custom-modal-text">
                Voulez vous supprimer cet element?
                    <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Oui</button>
                    <button type="reset" class="btn btn-danger waves-effect waves-light">Non</button>
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


        
        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').DataTable();

                //Buttons examples
                var file = document.getElementById('file_id').value;
                
                var table = $('#datatable-buttons').DataTable({
                    lengthChange: false,
                    buttons: [{extend: 'excelHtml5',title:file}, {extend: 'pdfHtml5',title:file}]
                });

                table.buttons().container()
                        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            } );

        </script>
        <script>
            function move() {
                var elem = document.getElementById("myBar");
                var finalMessage = document.getElementById('finalMessage');
                var timer = document.getElementById('time').value;
                var width = 1;
                var id = setInterval(frame, 5000);
                function frame() {
                    if (width >= timer) {
                        clearInterval(id);
                        return true;
                    } else {
                        width++;
                        finalMessage.innerHTML = "Veuillez patienter, Chargement du fichier en cours";
                        elem.style.width = width  + '%';
                        elem.innerHTML = width * 2  + '%';
                    }
                }
            }

        </script>

