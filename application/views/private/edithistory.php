<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $details = $data[0];
 $redirect = $this->input->get('redirect');
?>

<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}


// RBAC-aware user type handling
$user_roles = isset($session_data['user_roles']) ? $session_data['user_roles'] : [];
$user_type = 'admin'; // Default

if (!empty($user_roles)) {
    if (in_array('Super Admin', $user_roles)) {
        $user_type = 'admin';
    } elseif (in_array('Manager', $user_roles)) {
        $user_type = 'manager';
    } elseif (in_array('User', $user_roles)) {
        $user_type = 'user';
    }
}
?>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-lg-6">
                    <?php echo goToDashboard(); ?>
                    </div>
              
                    <div class="col-lg-6">   
                    <a class="btn btn-warning pull-right" href="<?php echo adminurl('bookingview/?type='.$redirect );?>" >GO Back</a>
                    </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
            <div class="col-lg-12">
            
            
            <div class="row">
            <div class="col-lg-12 col-xs-12"><strong>Booking ID : <?php echo $bookingid;?></strong></div> 
            </div> 

            
            <hr/>
            
             
            <?php
            
            $html = '';
            if(!empty($list)){
                $html .= '<div class="row">';
                $html .= '<div class="col-lg-2 spanr12"> <strong>Edit Field</strong></div>';
                $html .= '<div class="col-lg-2 spanr12"><strong>New Value</strong></div>';
                $html .= '<div class="col-lg-2 spanr12"><strong>Old Value</strong></div>';
                $html .= '<div class="col-lg-2 spanr12"><strong>Edit By Name</strong></div>';
                $html .= '<div class="col-lg-2 spanr12"><strong>Edit By Mobile</strong></div>';
                $html .= '<div class="col-lg-2 spanr12"><strong>Edit Date</strong></div>';
                $html .= '</div>';
                foreach( $list as $key=>$value ){
                    $html .= '<div class="row">';
                    $html .= '<div class="col-lg-2">'.$value['edited_field'].'</div>';
                    $html .= '<div class="col-lg-2">'.$value['new_value'].'</div>';
                    $html .= '<div class="col-lg-2">'.$value['previous_value'].'</div>';
                    $html .= '<div class="col-lg-2">'.$value['edit_by_name'].'</div>';
                    $html .= '<div class="col-lg-2">'.$value['edit_by_mobile'].'</div>';
                    $html .= '<div class="col-lg-2">'.date('d M Y h:i A', strtotime($value['edited_on'])).'</div>';
                    $html .= '</div>';
                } 
            }
            
            echo $html;
            ?>
            

            
       

 
 
            

             <hr/>    
             <hr/>        
           </div>
           
            
               </div> 
              
              </div>
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    
         
</div>


<!----------------- Main content end ------------------------->
    
    
    
 </div>
<!--------- /.content-wrapper --------->

 