<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

$id = isset($id) ? $id : ''; ?>

 

<section class="content"> 
      <div class="row"> 
        <!-- left column --> 
        <div class="col-md-12"> 
          <!-- general form elements --> 
          <div class="box box-primary"> 
            <div class="box-header with-border"> 
              <h3 class="box-title"> </h3>  
               </div> 

           

            <!-- /.box-header -->

            <div class="box-body">

            <?php echo form_open_multipart( adminurl( $pagename )); ?>  
            <?php echo form_hidden('id', $id);?> 
            <?php echo form_hidden('pagetype', 'seo');?> 
            <?php echo form_hidden('domainid', $domainid);?>  
            

            

            

<div class="row"> 

<div class="col-md-12"> 
<div class="form-group">

<?php echo form_label('Title/Heading', 'titleorheading');?> 
<?php echo form_input(array('name'=>'titleorheading','required'=>'required','class'=>'form-control','placeholder'=>'Title/Heading....','id'=>'titleorheading','onkeyup'=>"createseourl('titleorheading'),this.value = this.value.replace(/[^0-9a-zA-Z\. ]/g,'');",'autocomplete'=>'off'), set_value('titleorheading',$titleorheading));?> 

</div>

</div>



<div class="col-md-8">

<div class="form-group">

<?php echo form_label('Page Url', 'pageurl'); 

$inputfl = array('name'=>'pageurl','required'=>'required','class'=>'form-control','placeholder'=>'pageurl....','id'=>'pageurl','onblur'=>"createseourl('pageurl');",'onkeyup'=>"this.value = this.value.replace(/[^0-9a-zA-Z\. ]/g,'');",'autocomplete'=>'off');

if($id){ $inputfl = $inputfl + array('readonly'=>'readonly'); }?>

<?php echo form_input( $inputfl , set_value('pageurl',$pageurl));?> 

</div>

</div>



<div class="col-md-4" style="margin-top: 30px">

<span id="vurl">

<?php if(!$id){ ?><a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="checkUrl();"> Validate Url </a><?php }else{?>

<img src="<?php echo base_url('assets/images/ok.png');?>" style="width: 70px"><?php }?></span>

<span id="loader"></span>

<span id="msg" style="color:red;font-size:13px;"></span>

</div>  





<div class="col-md-12">

<div class="form-group">

<?php echo form_label('Meta Title', 'metatitle');?>

<?php echo form_input(array('name'=>'metatitle','required'=>'required','class'=>'form-control','placeholder'=>'Meta Title....','autocomplete'=>'off'), set_value('metatitle',$metatitle));?> 

</div>



<div class="form-group">

<?php echo form_label('Meta Description', 'metadescription');?>

<?php echo form_input(array('name'=>'metadescription','required'=>'required','class'=>'form-control','placeholder'=>'Meta Description....','autocomplete'=>'off'), set_value('metadescription',$metadescription));?> 

</div>



<div class="form-group"> 
<?php echo form_label('Meta Keyword', 'metakeyword');?> 
<?php echo form_input(array('name'=>'metakeyword','required'=>'required','class'=>'form-control','placeholder'=>'Meta Keyword....','autocomplete'=>'off'), set_value('metakeyword',$metakeyword));?> 
</div>

 
<div class="form-group"> 
<?php echo form_label('Meta Summary', 'summary');?> 
<?php echo form_input(array('name'=>'summary','required'=>'required','class'=>'form-control','placeholder'=>'Meta summary....','autocomplete'=>'off'), set_value('summary',$summary));?> 
</div> 

  

<div class="form-group">

<?php echo form_label('Content', 'content');?> 
<?php echo form_textarea( array('name'=>'content','class'=>'form-control textarea','rows'=> '15','cols'=> '10','placeholder'=>'Content...') , $content  ); ?>

</div>
</div>


<div class="col-md-12">
<div class="row">
<div class="col-md-3">   
<?php echo form_label('Status', 'status');?> 
<?php echo form_dropdown(array('name'=>'status','required'=>'required','class'=>'form-control select22'),array(''=>'Select Status','yes'=>'Active','no'=>'InActive'),set_value('status',$status));?> 
</div> 

  
<div class="col-md-3" style="margin-top: 25px" >  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') ); ?> 
</div>

<div class="col-md-3 pull-right" style="margin-top: 25px" >    
<?php if( VIEW ==='yes'){  
		echo  anchor( adminurl('Viewseopage'),'View',array('class'=>'btn btn-sm btn-success fa fa-sign-out') );  
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

  function createseourl(selector){  
    var checkid = '<?=$id;?>';  
    var str = $('#'+selector).val(); 
    str = str.replace(/^\s+|\s+$|\s+(?=\s)/g, ""); 
    str = str.trim();  
    str = str.replace(/ /g,"-"); 
    str = str.toLowerCase(); 
   if( ( checkid.length == 0 ) && ( selector == 'titleorheading') ){ 
     $('#pageurl').val(str); 
   }else if( selector == 'pageurl'){ $('#pageurl').val(str); }
  }



  function checkUrl(){ 
  var successs = '<img src="<?php echo base_url('assets/images/ok.png');?>" style="width: 70px">'; 

   var loader = '<img src="<?php echo base_url('assets/images/loader.gif');?>" style="width: 70px">';

  $('#msg').html(''); 
  var geturl = $('#pageurl').val();   
  if( geturl.length > 0 ){ 
    $.ajax({ 
    type:'GET', 
    url:'<?php echo adminurl($pagename.'/checkposturl?pageurl=');?>'+geturl, 
    beforeSend: function(){  
      $('#vurl').hide();  
      $('#loader').html(loader); 
    },
    success:function(res){ 
           if(res == 0 ){ 
           $('#vurl').hide(); 
           $('#loader').html(successs); 
           }else if(res != 0 ){  
            $('#pageurl').val(''); 
            $('#vurl').show(); 
            $('#loader').html(''); 
            $('#msg').html('Page url Already Exists.'); } 
      }

    });

  }else{ $('#msg').html('Please create page url');}

  }

</script>