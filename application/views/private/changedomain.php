<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
 
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <?php if($domain){?> <h3 class="box-title">Current Domain: <?= $domain;?></h3><?php } ?>
               </div>
    
           
           
            <!-- /.box-header -->
            <div class="box-body">
            <?php echo form_open_multipart( $posturl ); ?> 
            <input type="hidden" name="domain" id="domainname"> 
            <?=form_hidden('return',$return);?>

<div class="row">
<div class="col-md-6"> 

 
<div class="form-group">
<?php echo form_label('Select Domain', 'domainid');?>
<?php echo form_dropdown(array('name'=>'domainid', 'class'=>'form-control select22','required'=>'required','onchange'=>'getDomainname();','id'=>'domainid'),get_dropdownsmulti('domain',array('status'=>'yes'),'id','domain',' Domain--' ),set_value('domainid',$domainid) );?> 
</div>
 
 
</div>   
</div>     


<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit',   'Submit' , array('class'=>'btn btn-primary') );  ?>             
</div> 
</div>                             
            
<?php echo form_close(); ?>

<div class="spacer-10"></div>
 <!-- /.box-body -->
</div>

</div></div></div>
    
    
<!----------------- Main content end ------------------------->

</div></div>
<!--------- /.content-wrapper --------->
</div>
</section>
<script type="text/javascript">
  function getDomainname(){ 
    var sel = document.getElementById('domainid');
    var opt = sel.options[sel.selectedIndex];
    var domain = opt.text;
    $('#domainname').val(domain);
  }
</script>