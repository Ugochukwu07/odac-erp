 <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.1
    </div>
    <strong>Copyright &copy; 2014-<?=date('Y');?>  </strong> All rights reserved.
  </footer>

  
<div class="control-sidebar-bg"></div>
<div id="snackbar"></div>
</div>
<!-- ./wrapper -->
<script>function removemsg(){
	  setTimeout( function(){ $('#emmsg').hide('slow');},2000);
	}

  
function viewmsg(){ 
            <?php $snackmsg = notifications(); if(isset($snackmsg)){?>  
            var msg = '<?php echo $snackmsg;?>'; 
            if(msg){
            var msg = msg ? msg+'!!' : ''; 
            $('#snackbar').html( msg );
            $('#snackbar').show();
            $('#snackbar').addClass('show');
            setTimeout(function(){  $('#snackbar').hide(); $('#snackbar').removeClass('show'); }, 3000);
            }
            <?php } ?>  
         }    
   

function viewmsgmn(msg){   
            var msg = msg ? msg+'!!' : ''; 
            $('#snackbar').html( msg );
            $('#snackbar').show();
            $('#snackbar').addClass('show');
            setTimeout(function(){  $('#snackbar').hide(); $('#snackbar').removeClass('show'); }, 3000); 
         }   
                 
</script>