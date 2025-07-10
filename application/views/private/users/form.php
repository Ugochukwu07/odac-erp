<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $this->load->view( adminfold('includes/all-css'));?>
  
  <title><?php echo isset($user) ? 'Edit User' : 'Add New User'; ?></title>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view( adminfold('includes/header'));?>
<?php $this->load->view( adminfold('includes/menu'));?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo isset($user) ? 'Edit User' : 'Add New User'; ?>
      <small><?php echo isset($user) ? 'Update user information and roles' : 'Create a new user account'; ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo adminurl('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo adminurl('Users');?>">Users</a></li>
      <li class="active"><?php echo isset($user) ? 'Edit' : 'Add'; ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10 mr-auto ml-auto">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">User Information</h3>
          </div>
          
          <form role="form" method="post" action="<?php echo adminurl('Users/save');?>">
            <div class="box-body">
              <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?php echo $this->session->flashdata('error'); ?>
                </div>
              <?php endif; ?>
              
              <?php if(isset($user)): ?>
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
              <?php endif; ?>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?php echo isset($user) ? htmlspecialchars($user['name']) : set_value('name'); ?>" 
                           required>
                    <?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="mobile">Mobile/Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="mobile" name="mobile" 
                           value="<?php echo isset($user) ? htmlspecialchars($user['mobile']) : set_value('mobile'); ?>" 
                           required <?php echo isset($user) ? 'readonly' : ''; ?>>
                    <?php echo form_error('mobile', '<span class="text-danger">', '</span>'); ?>
                    <?php if(isset($user)): ?>
                      <small class="text-muted">Mobile/Email cannot be changed after creation</small>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password"><?php echo isset($user) ? 'New Password' : 'Password'; ?> 
                      <?php if(!isset($user)): ?><span class="text-danger">*</span><?php endif; ?>
                    </label>
                    <input type="password" class="form-control" id="password" name="password" 
                           <?php echo isset($user) ? '' : 'required'; ?>>
                    <?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
                    <?php if(isset($user)): ?>
                      <small class="text-muted">Leave blank to keep current password</small>
                    <?php endif; ?>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="confirm_password">Confirm Password 
                      <?php if(!isset($user)): ?><span class="text-danger">*</span><?php endif; ?>
                    </label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                           <?php echo isset($user) ? '' : 'required'; ?>>
                    <?php echo form_error('confirm_password', '<span class="text-danger">', '</span>'); ?>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value="active" <?php echo (isset($user) && $user['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                  <option value="inactive" <?php echo (isset($user) && $user['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
              </div>
              
              <hr>
              
              <h4><i class="fa fa-users"></i> Role Assignment</h4>
              <p class="text-muted">Select the roles that this user should have:</p>
              
              <?php if(!empty($roles)): ?>
                <div class="row">
                  <?php foreach($roles as $role): ?>
                    <div class="col-md-4">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="roles[]" 
                                 value="<?php echo $role['id']; ?>" 
                                 <?php echo (isset($user_roles) && in_array($role['id'], $user_roles)) ? 'checked' : ''; ?>>
                          <strong><?php echo htmlspecialchars($role['name']); ?></strong>
                          <?php if($role['name'] == 'Super Admin'): ?>
                            <span class="label label-danger">System Role</span>
                          <?php endif; ?>
                          <br>
                          <small class="text-muted"><?php echo htmlspecialchars($role['description']); ?></small>
                        </label>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                
                <div class="alert alert-info">
                  <i class="fa fa-info-circle"></i> 
                  <strong>Note:</strong> Users can have multiple roles. The permissions from all assigned roles will be combined.
                </div>
                
              <?php else: ?>
                <div class="alert alert-warning">
                  <i class="fa fa-warning"></i> No roles found. Please create roles first.
                </div>
              <?php endif; ?>
              
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> <?php echo isset($user) ? 'Update User' : 'Create User'; ?>
              </button>
              <a href="<?php echo adminurl('Users');?>" class="btn btn-default">
                <i class="fa fa-times"></i> Cancel
              </a>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $this->load->view( adminfold('includes/footer'));?>
</div>
<!-- ./wrapper -->

<?php $this->load->view( adminfold('includes/all-js'));?>

<script>
$(document).ready(function() {
    // Password confirmation validation
    $('#confirm_password').on('input', function() {
        var password = $('#password').val();
        var confirmPassword = $(this).val();
        
        if(password !== confirmPassword) {
            $(this).get(0).setCustomValidity('Passwords do not match');
        } else {
            $(this).get(0).setCustomValidity('');
        }
    });
    
    $('#password').on('input', function() {
        $('#confirm_password').trigger('input');
    });
});
</script>

</body>
</html> 