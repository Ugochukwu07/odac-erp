<style type="text/css">table tr td { font-size: 12px }</style>
   

    <div class="spacer20"></div>
    <section>
    <div class="container">
    <div class="row">
    <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12" >
     <table id="example" class="table table-bordered table-striped table-responsive">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Bookingid/Triptype</th> 
                    <th>Pickup/Drop City</th> 
                    <th>Pickup/Drop Date</th>   
                    <th>Vehicle Details</th>
                    <th>Booking Status</th>  
                    <th><div style="width: 100px">Action</div></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = 1;
                 if( !empty($list))

                 foreach($list as $key=>$value):   
                 ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td> 
                        <td><?php echo $value['bookingid'];?> <br/>
                          <span class="spanr12" ><em><strong><?=ucfirst($value['triptype']);?></strong></em></span></td>
                          
                        <td><span class="spang12" ><em><strong><?php echo $value['pickupcity'];?></strong></em></span>  <br/>
                          <span class="spanr12" ><em><strong><?php echo $value['dropcity']?$value['dropcity']:$value['dropaddress'];?></strong></em></span> 
                        </td>
                         
                        <td>
                        <span class="spang12">
                        <em><strong><?= date('d M Y h:i: A',strtotime($value['pickupdatetime'])); ?></strong></em></span> <br/>
                        <span class="spanr12">
            <em><strong><?= date('d M Y h:i: A',strtotime($value['dropdatetime'])); ?></strong></em></span>  </td> 
                        <td> 
                          <span class="spang12"><em><strong><?= $value['vehicleno'];?></strong></em></span><br/><?=$value['modelname']?>
                          </td> 
                          <td><br/> 
                          <span class="spanr12" ><em><strong><?=ucfirst($value['attemptstatus']);?></strong></em></span></td>
                        <td>
                            
<a  href="<?=PEADEX;?>slip/index?utm=<?=md5($value['id'])?>&for=print" target="_blank">Print <?php echo $value['attemptstatus']=='complete'?'Invoice':'Slip';?></a> 
                  </td>
                  </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                <tfoot>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Bookingid/Triptype</th> 
                    <th>Pickup/Drop City</th> 
                    <th>Pickup/Drop Date</th>   
                    <th>Vehicle Details</th>
                    <th>Booking Status</th>    
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
    </div>
    </div>
    </div>
    </section>


 <section>
    <div class="container">
    
    </div>
 </section>
 <div class="spacer30"></div>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>