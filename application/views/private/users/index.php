<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $this->load->view( adminfold('includes/all-css'));?>
  
  <title>User Management</title>
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
      User Management
      <small>Manage system users and their roles</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo adminurl('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Users</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">System Users</h3>
            <div class="box-tools">
              <a href="<?php echo adminurl('Users/add');?>" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add New User
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

            <table id="usersTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Mobile/Email</th>
                  <th>Roles</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($users)): ?>
                  <?php foreach($users as $user): ?>
                    <tr>
                      <td><?php echo $user['id']; ?></td>
                      <td>
                        <strong><?php echo htmlspecialchars($user['name']); ?></strong>
                        <?php if($user['id'] == $this->session->userdata('adminloginstatus')['user_id']): ?>
                          <span class="label label-info">Current User</span>
                        <?php endif; ?>
                      </td>
                      <td><?php echo htmlspecialchars($user['mobile']); ?></td>
                      <td>
                        <?php if(!empty($user['roles'])): ?>
                          <?php foreach($user['roles'] as $role): ?>
                            <span class="label label-primary"><?php echo htmlspecialchars($role); ?></span>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <span class="text-muted">No roles assigned</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if($user['status'] == 'active'): ?>
                          <span class="label label-success">Active</span>
                        <?php else: ?>
                          <span class="label label-warning">Inactive</span>
                        <?php endif; ?>
                      </td>
                      <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                      <td>
                        <div class="btn-group">
                          <a href="<?php echo adminurl('Users/edit/'.$user['id']);?>" 
                             class="btn btn-sm btn-info" title="Edit User">
                            <i class="fa fa-edit"></i>
                          </a>
                          <?php if($user['id'] != $this->session->userdata('adminloginstatus')['user_id']): ?>
                            <a href="javascript:void(0);" 
                               onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name']); ?>')"
                               class="btn btn-sm btn-danger" title="Delete User">
                              <i class="fa fa-trash"></i>
                            </a>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center">No users found</td>
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
    $('#usersTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[0, "asc"]]
    });
});

function deleteUser(userId, userName) {
    if(confirm('Are you sure you want to delete the user "' + userName + '"?\n\nThis action cannot be undone.')) {
        window.location.href = '<?php echo adminurl("Users/delete/");?>' + userId;
    }
}
</script>

</body>
</html> 