<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
 
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <!--<h3 class="box-title"></h3>-->
               </div>
    
           
           
            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
<?php  foreach($doclist  as $key=>$value ){  
   $image = getimageview( $list , $value['documenttype'],false );?>
   <?php echo form_open_multipart( $posturl ); ?> 
   <?php echo form_hidden('tableid', $bkid);?>
   <?php echo form_hidden('documenttype', $value['documenttype']);?>
   <?php echo form_hidden('oldimage', getimageview( $list , $value['documenttype'],true ) );?>
  <div class="col-md-3" style="margin-top:10px; margin-bottom: 50px;"> 
    <div style="width: 100%;height: 230px;">
    <img src="<?php echo $image;?>" width="100%" >
    </div>
  <div class="form-group">
  <?php echo form_label($value['documentname'], 'userfile');?>
  <?php echo form_input(array('type'=>'file','name'=>'userfile'.$value['documenttype'],'required'=>'required', 'class'=>'form-control','placeholder'=>'Select Image') );?> 
  </div>
        <div class="row" style="margin-top:10px">
        <div class="col-md-3" >  
        <?php echo form_submit('mysubmit'.$value['documenttype'], 'Upload', array('class'=>'btn btn-primary') );  ?>             
        </div>
        </div> 
  </div>
  <?php echo form_close(); ?>
<?php }?>
</div>
 

</div>                        
            


<div class="spacer-10"></div>
 <!-- /.box-body -->
</div>

</div></div></div>
    
    
<!----------------- Main content end ------------------------->

</div></div>
<!--------- /.content-wrapper --------->
</div>
</section>

<?php function getimageview($arra,$keyname,$raw){
   $return = $raw ? '' : base_url('assets/images/150x100.png');
   foreach ($arra as $key => $value) {
      if($value['documenttype'] == $keyname){
        $return = $raw ? $value['documentorimage'] : base_url('uploads/').$value['documentorimage'];
      }
   }
   return $return;
}?>