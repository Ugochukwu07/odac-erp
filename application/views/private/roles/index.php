<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $this->load->view( adminfold('includes/all-css'));?>
  
  <title>Role Management</title>
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
      Role Management
      <small>Manage system roles and permissions</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo adminurl('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Roles</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">System Roles</h3>
            <div class="box-tools">
              <a href="<?php echo adminurl('Roles/add');?>" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add New Role
              </a>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <?php if($this->session->flashdata('success')): ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('success'); ?>
              </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('error')): ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php endif; ?>

            <table id="rolesTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Role Name</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Users</th>
                  <th>Permissions</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($roles)): ?>
                  <?php foreach($roles as $role): ?>
                    <tr>
                      <td><?php echo $role['id']; ?></td>
                      <td>
                        <strong><?php echo htmlspecialchars($role['name']); ?></strong>
                        <?php if($role['name'] == 'Super Admin'): ?>
                          <span class="label label-danger">System Role</span>
                        <?php endif; ?>
                      </td>
                      <td><?php echo htmlspecialchars($role['description']); ?></td>
                      <td>
                        <?php if($role['status'] == 'active'): ?>
                          <span class="label label-success">Active</span>
                        <?php else: ?>
                          <span class="label label-warning">Inactive</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <span class="badge bg-blue"><?php echo $role['user_count']; ?></span>
                      </td>
                      <td>
                        <span class="badge bg-green"><?php echo $role['permission_count']; ?></span>
                      </td>
                      <td><?php echo date('M d, Y', strtotime($role['created_at'])); ?></td>
                      <td>
                        <div class="btn-group">
                          <a href="<?php echo adminurl('Roles/edit/'.$role['id']);?>" 
                             class="btn btn-sm btn-info" title="Edit Role">
                            <i class="fa fa-edit"></i>
                          </a>
                          <?php if($role['name'] != 'Super Admin'): ?>
                            <a href="javascript:void(0);" 
                               onclick="deleteRole(<?php echo $role['id']; ?>, '<?php echo htmlspecialchars($role['name']); ?>')"
                               class="btn btn-sm btn-danger" title="Delete Role">
                              <i class="fa fa-trash"></i>
                            </a>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center">No roles found</td>
                  </tr>
                <?php endif; ?>
              </tbody>
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
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $this->load->view( adminfold('includes/footer'));?>
</div>
<!-- ./wrapper -->

<?php $this->load->view( adminfold('includes/all-js'));?>

<script>
$(document).ready(function() {
    $('#rolesTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[0, "asc"]]
    });
});

function deleteRole(roleId, roleName) {
    if(confirm('Are you sure you want to delete the role "' + roleName + '"?\n\nThis action cannot be undone and will remove all role assignments.')) {
        window.location.href = '<?php echo adminurl("Roles/delete/");?>' + roleId;
    }
}
</script>

</body>
</html> 