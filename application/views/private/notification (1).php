  <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_paste</i>
                  </div> 
                   <h4 class="card-title"><?=$title;?> <?=$subtitle;?>  
                  <a href="<?=base_url( ADMINPATH.'notification_list' );?>" style="color: #111; float: right;" rel="tooltip" data-original-title="View List"><i class="material-icons">view_list</i></a>
                  </h4>
                </div>
                <div class="card-body ">
 
             

      <?=form_open_multipart( $posturl,['method'=>'post'] );?>
			<?=form_hidden('id', $id );?> 
			<?=form_hidden('oldimage', $imagename );?> 


			<div class="row">
			 <?=form_label('User Type :-', 'usertype',['class'=>'col-sm-2 col-form-label']);?>  
			  <div class="col-sm-10">
			      <div class="form-group select-wizard">
			      <?=form_dropdown(['name'=>'usertype','class'=>'selectpicker','id'=>'usertype','required'=>'required','data-size'=>'7','data-style'=>'select-with-transition','style'=>'width:100%'],['astro'=>'Astrologer','user'=>'Customer'],set_value('usertype',$usertype));?> 
			    </div>
			  </div>
			</div> 



        <div class="row">
				 <?=form_label('Title :-', 'notititle',['class'=>'col-sm-2 col-form-label']);?>  
				  <div class="col-sm-10">
				      <div class="form-group select-wizard">
				      <?=form_input(['name'=>'notititle','class'=>'form-control','id'=>'notititle','placeholder'=>'Enter title','required'=>'required'],set_value('notititle',$notititle));?> 
				    </div>
				  </div>
				</div> 


				<div class="row">
				 <?=form_label('Description :-', 'description',['class'=>'col-sm-2 col-form-label']);?>  
				  <div class="col-sm-10">
				      <div class="form-group select-wizard">
				      <?=form_input(['name'=>'description','class'=>'form-control','id'=>'description','placeholder'=>'Enter description','required'=>'required'],set_value('description',$description));?> 
				    </div>
				  </div>
				</div>  
				
 
 

				<div class="row">
				 <?=form_label('Image :-', 'profit',['class'=>'col-sm-2 col-form-label']);?>  
				  <div class="col-sm-5">
				      <div class="form-group select-wizard">
				      <?=form_input(['name'=>'file','type'=>'file','class'=>'btn','id'=>'file','style'=>'opacity:1;z-index:1;margin-top:20px']);?> 
				    </div>
				  </div>

				  <div class="col-sm-5">
				      <div class="form-group select-wizard">
				      <?php if(!empty($imagename)){ echo '<img src="'.UPLOADS.$imagename.'"  width="100px" >';}?> 
				    </div>
				  </div> 

				</div> 

  
		<div class="row" style="margin-top: 30px;"> 
			<div class="col-sm-1">&nbsp;</div>
			<div class="col-sm-6">
				<div class="row">
				 <?=form_label('Status :-', 'status',['class'=>'col-sm-2 col-form-label']);?>  
				  <div class="col-sm-10">
				      <div class="form-group select-wizard">
				      <?=form_dropdown(['name'=>'status','class'=>'form-control','data-size'=>'7','data-style'=>'select-with-transition','class'=>'selectpicker','style'=>'width:100%','id'=>'status'],['yes'=>'Active','no'=>'In Active'],set_value('status',$status));?>  
				    </div>
				  </div>
				</div>  
				</div>  

				<div class="col-sm-5"> 
					<button type="submit" class="btn btn-primary my-1">Submit</button>
				</div>
				</div>
			<?=form_close();?>

<br/><br/><br/>
                </div>
               
              </div>
            </div>
             
            
          </div>
        </div>
      </div>


<!-- Modal -->
<div class="modal fade" id="openLoader" tabindex="-1" role="dialog" aria-labelledby="openLoaderLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="openLoaderLabel">Notification is Broadcasting...</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div> 
			<div class="modal-body">
			<div class="form-group">
						<center><img src="<?=base_url('public/wavesbroadcat.gif');?>" width="100px" height="100px"></img></center>
					</div>
		    </div>

	</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
	<?php if( $push == 'yes' ){?>
	window.load = setTimeout( function(){ 
	sendnotifications('<?=$id;?>', 0, 100 );
	$('#openLoader').modal({ backdrop: 'static', keyboard: true, show: true });
	 
  }, 100 );
  <?php }?>

function sendnotifications(id,start,limit){ 
       $.ajax({
        type:'POST',
        url:'<?=base_url( ADMINPATH ).'notification/pushnotification';?>',
        data:{'id':id,'start':start,'limit':limit},
        async:true,
        crossDomain:true,
        success: function(res){ 
          var obj = JSON.parse(res);
            if(obj.status){
              var nid = obj.id; var nstart = obj.start; var nlimit = obj.limit;
              setTimeout( function(){ sendnotifications(nid,nstart,nlimit); },300 );
            }else if(!obj.status){ 
              window.location.href='<?=base_url( ADMINPATH ).'notification/index';?>';
            }
        }
       });  
  } 
</script>
