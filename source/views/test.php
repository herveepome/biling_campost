
<html>         
            <div  class="col-2">
                                   <a  href="#doublons"> <button  value="fav_HTML" id="calcul_doublons" >test </button></a>
                               
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
</html> 
 <script>
                var el=document.getElementById('calcul_doublons').value;
                alert(el);
                document.getElementById('calcul_doublons').click();
                            
                 $('#test').click(function() {
                  alert('cliqué !');
                  });

 </script>