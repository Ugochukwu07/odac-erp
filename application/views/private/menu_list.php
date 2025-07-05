<?php defined('BASEPATH') OR exit('No direct script access allowed');  $timecurrent = date('Y-m-d H:i:s'); ?>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
    <?php if(!empty($prebtn)){
    echo "<a href='".$prebtn."' class='btn-sm btn-primary'>PREVIOUS</a>";
    }

    if(!empty($nxtbtn)){
    echo "<a href='".$nxtbtn."' class='btn-sm btn-primary' style='margin-left:10px;'>NEXT</a>";
    }?>
   
   <?php 
    function getParentMenu( $list, $parent_id ){
      foreach ($list as $key => $value) {
         if( $value['id'] === $parent_id ){
            return $value['menu_name'];
            exit;
         }
      }

    }
   ?>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Menu Name</th>
                    <th>Parent Menu</th>  
                    <th>Menu Level</th> 
                    <th>Menu Url</th>  
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = 1; $goto = array();
        if( !empty($list)){
         foreach($list as $key=>$value):  

        ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?=$value['menu_name']?> </td> 
                        <td><?=getParentMenu( $list, $value['parent_id']);?></td> 
                        <td><?=$value['menu_level']?> </td> 
                        <td><?=$value['menu_url']?> </td>  
                        <td><?php echo ($value['status']=='yes') ? 'Active' : 'InActive';?></td>  
                        <td>
          <?php if( EDIT ==='yes'){ ?> 
          <?php echo  anchor( adminurl('menu_item/?id='.md5($value['id'])),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit') ); }?>    
            
          <?php if( REMOVE ==='yes'){?> 
                
          <?php } ?>
                  </td>
                  </tr>
                  
                <?php $i++; endforeach ; }?>
                
                </tbody>
                
                
                <tfoot>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Full Name</th>
                    <th>Mobile</th> 
                    <th>Password</th>
                    <th>Register Date</th>  
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<!----------------- Main content end ------------------------->
    
    
    
 </div>
<!--------- /.content-wrapper --------->



<!-- manual filter Modal -->
<div id="openCityFilter" class="modal fade" role="dialog">
  <div class="modal-dialog" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" > 
        <form action="<?=adminurl('roll_team_list');?>" method="get">  
          <input type="hidden" name="pageno" value="0">
        <div class="row"> 
           <div class="col-md-7">
             <label>Mobile Number</label> 
            <?php echo form_input(['name'=>'mobile','class'=>'form-control','id'=>'mobile','placeholder'=>'Please Enter Mobile Number'] );?> 
           </div> 

           <div class="col-md-3"> 
             <input type="submit" class="btn btn-primary" value="Apply" style="margin-top: 29px;">
           </div> 
        </div>
      </form>
         <div style="height:50px">&nbsp;</div>
      </div>
      
    </div>

  </div>
</div>


<script type="text/javascript">

function openModel(){
    $('#openCityFilter').modal('show');
}


function selectCity(id,name) {
  $("#search-box").val(name);
  $("#stateid").val(id);
  $("#suggesstion-box").hide();
}

</script>

