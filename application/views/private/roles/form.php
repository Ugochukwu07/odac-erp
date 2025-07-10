<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $this->load->view( adminfold('includes/all-css'));?>
  
  <title><?php echo isset($role) ? 'Edit Role' : 'Add New Role'; ?></title>
  
  <style>
    .permission-group {
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-bottom: 15px;
      padding: 10px;
    }
    .permission-group h4 {
      margin-top: 0;
      color: #333;
      border-bottom: 1px solid #eee;
      padding-bottom: 5px;
    }
    .permission-item {
      margin: 5px 0;
    }
    .select-all-group {
      background: #f9f9f9;
      padding: 8px;
      border-radius: 3px;
      margin-bottom: 10px;
    }
  </style>
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
      <?php echo isset($role) ? 'Edit Role' : 'Add New Role'; ?>
      <small><?php echo isset($role) ? 'Update role information and permissions' : 'Create a new role with permissions'; ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo adminurl('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo adminurl('Roles');?>">Roles</a></li>
      <li class="active"><?php echo isset($role) ? 'Edit' : 'Add'; ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Role Information</h3>
          </div>
          
          <form role="form" method="post" action="<?php echo adminurl('Roles/save');?>">
            <div class="box-body">
              <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?php echo $this->session->flashdata('error'); ?>
                </div>
              <?php endif; ?>
              
              <?php if(isset($role)): ?>
                <input type="hidden" name="role_id" value="<?php echo $role['id']; ?>">
              <?php endif; ?>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Role Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?php echo isset($role) ? htmlspecialchars($role['name']) : set_value('name'); ?>" 
                           required <?php echo (isset($role) && $role['name'] == 'Super Admin') ? 'readonly' : ''; ?>>
                    <?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" 
                            <?php echo (isset($role) && $role['name'] == 'Super Admin') ? 'disabled' : ''; ?>>
                      <option value="active" <?php echo (isset($role) && $role['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                      <option value="inactive" <?php echo (isset($role) && $role['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" 
                          placeholder="Enter role description..."><?php echo isset($role) ? htmlspecialchars($role['description']) : set_value('description'); ?></textarea>
                <?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
              </div>
              
              <hr>
              
              <h4><i class="fa fa-shield"></i> Permissions</h4>
              <p class="text-muted">Select the permissions that this role should have:</p>
              
              <?php if(!empty($permissions)): ?>
                <?php 
                // Group permissions by module
                $grouped_permissions = [];
                foreach($permissions as $permission) {
                    $module = $permission['module'] ?: 'General';
                    $grouped_permissions[$module][] = $permission;
                }
                ?>
                
                <?php foreach($grouped_permissions as $module => $module_permissions): ?>
                  <div class="permission-group form-group ml-3">
                    <h4><?php echo htmlspecialchars($module); ?></h4>
                    
                    <div class="select-all-group">
                      <label>
                        <input type="checkbox" class="select-all-module" data-module="<?php echo $module; ?>">
                        <strong>Select All <?php echo htmlspecialchars($module); ?> Permissions</strong>
                      </label>
                    </div>
                    
                    <div class="row">
                      <?php foreach($module_permissions as $permission): ?>
                        <div class="col-md-4 permission-item">
                          <label>
                            <input type="checkbox" name="permissions[]" 
                                   value="<?php echo $permission['id']; ?>" 
                                   class="permission-checkbox module-<?php echo $module; ?>"
                                   <?php echo (isset($role_permissions) && in_array($permission['id'], $role_permissions)) ? 'checked' : ''; ?>>
                            <?php echo htmlspecialchars($permission['name']); ?>
                          </label>
                          <?php if($permission['description']): ?>
                            <br><small class="text-muted"><?php echo htmlspecialchars($permission['description']); ?></small>
                          <?php endif; ?>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
                
              <?php else: ?>
                <div class="alert alert-warning">
                  <i class="fa fa-warning"></i> No permissions found. Please create permissions first.
                </div>
              <?php endif; ?>
              
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> <?php echo isset($role) ? 'Update Role' : 'Create Role'; ?>
              </button>
              <a href="<?php echo adminurl('Roles');?>" class="btn btn-default">
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
    // Handle "Select All" checkboxes for each module
    $('.select-all-module').change(function() {
        var module = $(this).data('module');
        var isChecked = $(this).is(':checked');
        
        $('.module-' + module).prop('checked', isChecked);
    });
    
    // Update "Select All" checkbox when individual permissions change
    $('.permission-checkbox').change(function() {
        var module = $(this).hasClass('module-') ? $(this).attr('class').match(/module-(\w+)/)[1] : '';
        if(module) {
            var totalCheckboxes = $('.module-' + module).length;
            var checkedCheckboxes = $('.module-' + module + ':checked').length;
            
            if(checkedCheckboxes === 0) {
                $('.select-all-module[data-module="' + module + '"]').prop('indeterminate', false).prop('checked', false);
            } else if(checkedCheckboxes === totalCheckboxes) {
                $('.select-all-module[data-module="' + module + '"]').prop('indeterminate', false).prop('checked', true);
            } else {
                $('.select-all-module[data-module="' + module + '"]').prop('indeterminate', true);
            }
        }
    });
    
    // Initialize "Select All" checkboxes
    $('.select-all-module').each(function() {
        var module = $(this).data('module');
        var totalCheckboxes = $('.module-' + module).length;
        var checkedCheckboxes = $('.module-' + module + ':checked').length;
        
        if(checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0) {
            $(this).prop('checked', true);
        } else if(checkedCheckboxes > 0) {
            $(this).prop('indeterminate', true);
        }
    });
});
</script>

</body>
</html> 