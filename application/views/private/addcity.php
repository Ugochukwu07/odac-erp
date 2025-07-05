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
            <?php echo form_open_multipart( $posturl ); ?> 
            <?php echo form_hidden('id', $id);?>  
            
            
            
<div class="row">
<div class="col-md-6"> 

<?php if(!$id){?>
<div class="form-group">
<?php echo form_label('Type Address', 'cityid');?>
<input type="text" class="form-control" id="location"  onFocus="geolocate();"  onblur="checkinput();" placeholder="Enter address" autocomplete="off" > 
</div>
<?php } ?>

  
<?php if($id){?>
<div class="form-group">
<?php echo form_label('State name', 'stateid');?>
<?php echo form_dropdown(array('name'=>'stateid','required'=>'required','class'=>'form-control select22'),get_dropdownsmulti('state' ,null, 'id', 'statename', 'State name'),set_value('stateid',$stateid) );?> 
</div>
<?php } else if(!$id){?>
<div class="row">
<div class="col-lg-6">
<div class="form-group">
<?php echo form_label('State Name', 'statename');?>
<?php echo form_input(array('name'=>'statename','required'=>'required','class'=>'form-control','placeholder'=>'Enter State Name','id'=>'administrative_area_level_1') );?> 
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<?php echo form_label('State Code', 'statecode');?>
<?php echo form_input(array('name'=>'statecode', 'required'=>'required','class'=>'form-control','placeholder'=>'Enter State Code','id'=>'statecode') );?> 
</div>
</div>
</div>
<?php } ?>

<div class="row">
<div class="col-lg-6">
<div class="form-group">
<?php echo form_label('City Name', 'cityname');?>
<?php echo form_input(array('name'=>'cityname', 'value'=>set_value('cityname',$cityname),'required'=>'required','class'=>'form-control','placeholder'=>'Enter City Name','id'=>'locality') );?> 
</div>
</div>

<div class="col-lg-6">
<?php echo form_label('City Pin code', 'citycode');?>
<?php echo form_input(array('name'=>'citycode', 'value'=>set_value('citycode',$citycode),'class'=>'form-control numbersOnly','placeholder'=>'Enter City Pin','id'=>'postal_code','maxlength'=>'6') );?>
</div>
</div>
 
 
 <div class="form-group">
<?php echo form_label('Pickup/Drop Address', 'pickupdropaddress');?>
<input type="text" name="pickupdropaddress" class="form-control" id="pickupdropaddress" value="<?=$pickupdropaddress;?>" placeholder="Enter pickup/drop address" autocomplete="off" > 
</div>


<div class="row">
<div class="col-lg-6">
<div class="form-group">
<?php echo form_label('Status', 'status');?>
<?php echo form_dropdown(array('name'=>'status','required'=>'required','class'=>'form-control'),array(''=>'Select Status','yes'=>'Active','no'=>'InActive'),set_value('status',$status));?> 
</div>
</div></div>

 

<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>             
</div>
<div class="col-md-3 pull-right">                 
<?php if( VIEW ==='yes'){ 
  if( $stateid ){
    echo  anchor( adminurl('Viewcity/?stateid='.$stateid ),'View',array('class'=>'btn btn-success fa fa-sign-out') );
  }else{
    echo  anchor( adminurl('Viewcity'),'View',array('class'=>'btn btn-success fa fa-sign-out') );
  }
} 
?>
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
var componentForm = {
  locality: 'long_name',
  administrative_area_level_1: 'long_name',
  postal_code: 'short_name',
  street_number: 'short_name',
}; 

var componentForm2 = { 
  administrative_area_level_1: 'short_name' 
}; 


function fillInAddress() { 
  var place = autocomplete.getPlace();

  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
    if (componentForm2[addressType]) {
      var val = place.address_components[i][componentForm2[addressType]]; 
      document.getElementById('statecode').value = val;
    }
  } 

}


</script>
