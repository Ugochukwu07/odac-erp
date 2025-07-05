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
            <?php echo form_open_multipart( adminurl('addcmspage/')); ?>  
            <?php echo form_hidden('id', $id);?>    
            <?php echo form_hidden('domainid', $domainid);?>  

<div class="row"> 
<div class="col-md-6">  

<div class="form-group"> 
<?php echo form_label('Page Type', 'pageurl');?> 
<?php echo form_dropdown(array('name'=>'pageurl','required'=>'required','class'=>'form-control select22'),array(''=>'Select Page--','index'=>'Home Page','about-us'=>'About Us','terms-and-conditions'=>'Terms And Conditions','privacy-policy'=>'Privacy Policy','cancellation-refund-policy'=>'Cancellation & Refund Policy','disclaimer-policy'=>'Disclaimer Policy','why-choose-us'=>'Why Choose Us','our-company'=>'Our Company','discuss'=>'Discuss Scipt'),set_value('pageurl',$pageurl));?> 

</div> 
</div>




<div class="col-md-12"> 
<div class="form-group"> 
<?php echo form_label('Title/Heading', 'titleorheading');?> 
<?php echo form_input(array('name'=>'titleorheading','required'=>'required','class'=>'form-control','placeholder'=>'Title/Heading....','autocomplete'=>'off'), set_value('titleorheading',$titleorheading));?>  
</div>



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
<?php echo form_input(array('name'=>'summary','required'=>'required','class'=>'form-control','placeholder'=>'Meta Summary....','autocomplete'=>'off'), set_value('summary',$summary));?>  
</div> 


<div class="form-group"> 
<?php echo form_label('Content', 'content');?> 
<?php echo form_textarea( array('name'=>'content','class'=>'form-control textarea','rows'=> '15','cols'=> '10','placeholder'=>'Content...') , $content  ); ?> 
</div>
</div>




<div class="row" style="margin-top:10px"> 
<div class="col-md-12"> 
<div class="col-md-3">  
<div class="form-group"> 
<?php echo form_label('Status', 'status');?> 
<?php echo form_dropdown(array('name'=>'status','required'=>'required','class'=>'form-control select22'),array(''=>'Select Status','yes'=>'Active','no'=>'InActive'),set_value('status',$status));?>  
</div></div>


<div class="col-md-3" style="margin-top:23px">  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>     
</div>

<div class="col-md-3 pull-right"  style="margin-top:23px">   
<?php if( VIEW ==='yes'){  
		echo  anchor( adminurl('Viewcmspage'),'View',array('class'=>'btn btn-sm btn-success fa fa-sign-out') );  
		}  
?> 
</div>   
</div>         

<?php echo form_close(); ?> 

<div class="spacer-10"></div> 
 <!-- /.box-body --> 
</div>


</div> </div></div></div> 

    

    

<!----------------- Main content end ------------------------->



</div></div>

<!--------- /.content-wrapper --------->

</div>

</section>