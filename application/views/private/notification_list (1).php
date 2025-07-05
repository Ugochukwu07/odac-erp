<div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title"><?=$title;?> <?=$subtitle;?>  
                  <a href="<?=base_url( ADMINPATH.'notification' );?>" style="color: #111; float: right;" rel="tooltip" data-original-title="Add More"><i class="material-icons">add_circle_outline</i></a>
                  </h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>S.N.</th> 
                          <th>User Type</th>
                          <th>Title</th>  
                          <th>Image</th> 
                          <th>Add Date / Modify Date</th>  
                          <th>Status</th> 
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>S.N.</th> 
                          <th>User Type</th>
                          <th>Title</th>  
                          <th>Image</th> 
                          <th>Add Date / Modify Date</th> 
                          <th>Status</th> 
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>

                      <?php if(!empty($list)){ $i=1;
                        foreach ($list as $key => $value) { ?>

                        <tr id="tr<?=$value['id'];?>" >
                          <td><?=$i;?></td> 
                          <td><?=$value['usertype']=='astro'?'Astrologer':'Customer/User';?></td>
                          <td><?=$value['title'];?></td> 
                          <td><?=($value['imagename']?'<img src="'.UPLOADS.$value['imagename'].'" width="50">':'');?></td>  
                          <td><?=date('d-m-Y',strtotime($value['add_date']));?> <br/> <?=date('d-m-Y',strtotime($value['modify_date']));?> </td>
                          <td><?=$value['status']=='yes'?'Active':'InActive';?></td>
                          <td class="text-right"> 
                            
                            <a href="<?=base_url( ADMINPATH.'notification?id='.md5($value['id']) );?>" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit</i></a>
                            <a href="javascript:void(0);" onclick="delrecord('<?=$value['id']?>','<?=$value['imagename']?>')" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                         
                          </td>
                        </tr>

                        <?php $i++; } }?>
                      
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
          </div>
          <!-- end row -->
        </div>
      </div>

<script>

function delrecord( id, img ){ 
  var catid =  id ;
  var oldimage =  img ; 
    if(catid.length == 0 ){ notifyme('error','Something is wrong!'); return false; }  

  $.ajax({
    type:'POST',
    data:{'id':catid,'oldimage':oldimage },
    url:'<?=base_url(ADMINPATH).$pagename.'/deleterecord';?>', 
        cache: false,
    success:function(res){
      var resobj = JSON.parse(res);
      notifyme(resobj.type,resobj.message); 
      setTimeout(function(){ window.location.href="<?=base_url(ADMINPATH).$pagename ; ?>"},500);
    }
  }); 
}


</script> 

  