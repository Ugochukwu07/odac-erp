<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $this->load->view(adminfold('includes/all-css'));?>
  
  <title>Admin Activity Tracking</title>
  
  <style>
    .hierarchy-badge {
      font-size: 11px;
      padding: 3px 6px;
    }
    .activity-card {
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-bottom: 15px;
      padding: 15px;
    }
    .activity-stats {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .stat-item {
      text-align: center;
      padding: 10px;
      background: #f9f9f9;
      border-radius: 5px;
      flex: 1;
      margin: 0 5px;
    }
    .stat-number {
      font-size: 24px;
      font-weight: bold;
      color: #337ab7;
    }
    .stat-label {
      font-size: 12px;
      color: #666;
    }
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view(adminfold('includes/header'));?>
<?php $this->load->view(adminfold('includes/menu'));?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admin Activity Tracking
      <small>Monitor admin activities based on hierarchy</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo adminurl('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Admin Activity</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <i class="fa fa-users"></i> Admin Users You Can Track
              <span class="label <?php echo get_admin_hierarchy_badge_class(); ?> hierarchy-badge">
                <?php echo get_admin_hierarchy_display(); ?>
              </span>
            </h3>
            
            <div class="box-tools pull-right">
              <div class="input-group">
                <input type="date" id="dateFrom" class="form-control" value="<?php echo date('Y-m-01'); ?>">
                <span class="input-group-addon">to</span>
                <input type="date" id="dateTo" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary" onclick="loadActivitySummary()">
                    <i class="fa fa-search"></i> Load Summary
                  </button>
                </span>
              </div>
            </div>
          </div>
          
          <div class="box-body">
            <!-- Activity Summary -->
            <div id="activitySummary" class="activity-stats">
              <!-- Summary will be loaded here -->
            </div>
            
            <!-- Admin Users List -->
            <div class="row">
              <?php if(!empty($admin_users)): ?>
                <?php foreach($admin_users as $user): ?>
                  <div class="col-md-4">
                    <div class="activity-card">
                      <div class="row">
                        <div class="col-md-8">
                          <h4><?php echo htmlspecialchars($user['name']); ?></h4>
                          <p class="text-muted"><?php echo htmlspecialchars($user['mobile']); ?></p>
                          <span class="label <?php echo $user['hierarchy_badge']; ?> hierarchy-badge">
                            <?php echo $user['hierarchy_display']; ?>
                          </span>
                          
                          <?php if(!empty($user['roles'])): ?>
                            <br><br>
                            <strong>Roles:</strong>
                            <?php foreach($user['roles'] as $role): ?>
                              <span class="label label-info"><?php echo htmlspecialchars($role); ?></span>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </div>
                        
                        <div class="col-md-4 text-right">
                          <button type="button" class="btn btn-sm btn-primary" 
                                  onclick="viewUserBookings('<?php echo $user['mobile']; ?>', '<?php echo htmlspecialchars($user['name']); ?>')">
                            <i class="fa fa-eye"></i> View Bookings
                          </button>
                          <br><br>
                          <button type="button" class="btn btn-sm btn-info" 
                                  onclick="viewUserActivity('<?php echo $user['mobile']; ?>', '<?php echo htmlspecialchars($user['name']); ?>')">
                            <i class="fa fa-history"></i> View Activity
                          </button>
                          <br><br>
                          <button type="button" class="btn btn-sm btn-warning" 
                                  onclick="viewGeneralActivity('<?php echo $user['mobile']; ?>', '<?php echo htmlspecialchars($user['name']); ?>')">
                            <i class="fa fa-list"></i> General Activity
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="col-md-12">
                  <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> No admin users found that you can track.
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal for User Bookings -->
<div class="modal fade" id="userBookingsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn btn-danger" onclick="closeModal('userBookingsModal')">&times;</button>
        <h4 class="modal-title">User Bookings - <span id="userBookingsName"></span></h4>
      </div>
      <div class="modal-body">
        <div id="userBookingsContent">
          <div class="text-center">
            <i class="fa fa-spinner fa-spin fa-2x"></i> Loading...
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal for User Activity -->
<div class="modal fade" id="userActivityModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn btn-danger" onclick="closeModal('userActivityModal')">&times;</button>
        <h4 class="modal-title">User Activity - <span id="userActivityName"></span></h4>
      </div>
      <div class="modal-body">
        <div id="userActivityContent">
          <div class="text-center">
            <i class="fa fa-spinner fa-spin fa-2x"></i> Loading...
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal for General Activity -->
<div class="modal fade" id="generalActivityModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn btn-danger" onclick="closeModal('generalActivityModal')">&times;</button>
        <h4 class="modal-title">General Activity - <span id="generalActivityName"></span></h4>
      </div>
      <div class="modal-body">
        <div id="generalActivityContent">
          <div class="text-center">
            <i class="fa fa-spinner fa-spin fa-2x"></i> Loading...
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view(adminfold('includes/all-js'));?>

<script>
$(document).ready(function() {
    // Load initial activity summary
    loadActivitySummary();
});

function loadActivitySummary() {
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    
    $.ajax({
        url: '<?php echo adminurl("AdminActivity/getActivitySummary"); ?>',
        type: 'GET',
        data: {
            from: dateFrom,
            to: dateTo
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                displayActivitySummary(response.summary);
            } else {
                alert('Error loading activity summary: ' + response.error);
            }
        },
        error: function() {
            alert('Error loading activity summary');
        }
    });
}

function displayActivitySummary(summary) {
    var html = '';
    
    if (summary.length === 0) {
        html = '<div class="col-md-12"><div class="alert alert-info">No activity data found for the selected period.</div></div>';
    } else {
        summary.forEach(function(user) {
            html += '<div class="stat-item">';
            html += '<div class="stat-number">' + user.total_bookings + '</div>';
            html += '<div class="stat-label">Total Bookings</div>';
            html += '<small>' + user.user_name + '</small>';
            html += '</div>';
        });
    }
    
    $('#activitySummary').html(html);
}

function viewUserBookings(mobile, name) {
    $('#userBookingsName').text(name);
    $('#userBookingsModal').modal('show');
    
    $.ajax({
        url: '<?php echo adminurl("AdminActivity/getUserBookings"); ?>',
        type: 'GET',
        data: { mobile: mobile },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                displayUserBookings(response.bookings);
            } else {
                $('#userBookingsContent').html('<div class="alert alert-danger">' + response.error + '</div>');
            }
        },
        error: function() {
            $('#userBookingsContent').html('<div class="alert alert-danger">Error loading user bookings</div>');
        }
    });
}

function displayUserBookings(bookings) {
    var html = '';
    
    if (bookings.length === 0) {
        html = '<div class="alert alert-info">No bookings found for this user.</div>';
    } else {
        html = '<table class="table table-bordered table-striped">';
        html += '<thead><tr><th>Booking ID</th><th>Customer</th><th>Vehicle</th><th>Status</th><th>Amount</th><th>Date</th></tr></thead>';
        html += '<tbody>';
        
        bookings.forEach(function(booking) {
            html += '<tr>';
            html += '<td>' + booking.bookingid + '</td>';
            html += '<td>' + booking.name + '<br><small>' + booking.mobileno + '</small></td>';
            html += '<td>' + booking.model + '</td>';
            html += '<td><span class="label label-' + getStatusClass(booking.attemptstatus) + '">' + booking.attemptstatus + '</span></td>';
            html += '<td>₹' + booking.totalamount + '</td>';
            html += '<td>' + booking.bookingdates + '</td>';
            html += '</tr>';
        });
        
        html += '</tbody></table>';
    }
    
    $('#userBookingsContent').html(html);
}

function viewUserActivity(mobile, name) {
    $('#userActivityName').text(name);
    $('#userActivityModal').modal('show');
    
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    
    $.ajax({
        url: '<?php echo adminurl("AdminActivity/getUserActivity"); ?>',
        type: 'GET',
        data: { 
            mobile: mobile,
            from: dateFrom,
            to: dateTo
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                displayUserActivity(response.activities, response.edit_logs);
            } else {
                $('#userActivityContent').html('<div class="alert alert-danger">' + response.error + '</div>');
            }
        },
        error: function() {
            $('#userActivityContent').html('<div class="alert alert-danger">Error loading user activity</div>');
        }
    });
}

function displayUserActivity(activities, editLogs) {
    var html = '';
    
    if (activities.length === 0) {
        html = '<div class="alert alert-info">No activity found for this user in the selected period.</div>';
    } else {
        html = '<div class="nav-tabs-custom">';
        html += '<ul class="nav nav-tabs">';
        html += '<li class="active"><a href="#bookings-tab" data-toggle="tab">Bookings</a></li>';
        html += '<li><a href="#edits-tab" data-toggle="tab">Edit History</a></li>';
        html += '</ul>';
        
        html += '<div class="tab-content">';
        
        // Bookings tab
        html += '<div class="tab-pane active" id="bookings-tab">';
        html += '<table class="table table-bordered table-striped">';
        html += '<thead><tr><th>Booking ID</th><th>Customer</th><th>Status</th><th>Created</th><th>Last Edited</th></tr></thead>';
        html += '<tbody>';
        
        activities.forEach(function(activity) {
            html += '<tr>';
            html += '<td>' + activity.bookingid + '</td>';
            html += '<td>' + activity.name + '<br><small>' + activity.mobileno + '</small></td>';
            html += '<td><span class="label label-' + getStatusClass(activity.attemptstatus) + '">' + activity.attemptstatus + '</span></td>';
            html += '<td>' + activity.bookingdates + '</td>';
            html += '<td>' + (activity.editdates || 'Never') + '</td>';
            html += '</tr>';
        });
        
        html += '</tbody></table>';
        html += '</div>';
        
        // Edit history tab
        html += '<div class="tab-pane" id="edits-tab">';
        if (editLogs.length === 0) {
            html += '<div class="alert alert-info">No edit history found.</div>';
        } else {
            html += '<table class="table table-bordered table-striped">';
            html += '<thead><tr><th>Booking ID</th><th>Field</th><th>Old Value</th><th>New Value</th><th>Edited By</th><th>Date</th></tr></thead>';
            html += '<tbody>';
            
            editLogs.forEach(function(log) {
                html += '<tr>';
                html += '<td>' + log.booking_id + '</td>';
                html += '<td>' + log.edited_field + '</td>';
                html += '<td>' + log.previous_value + '</td>';
                html += '<td>' + log.new_value + '</td>';
                html += '<td>' + log.edit_by_name + '<br><small>' + log.edit_by_mobile + '</small></td>';
                html += '<td>' + log.edited_on + '</td>';
                html += '</tr>';
            });
            
            html += '</tbody></table>';
        }
        html += '</div>';
        
        html += '</div></div>';
    }
    
    $('#userActivityContent').html(html);
}

function viewGeneralActivity(mobile, name) {
    $('#generalActivityName').text(name);
    $('#generalActivityModal').modal('show');

    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();

    $.ajax({
        url: '<?php echo adminurl("AdminActivity/getGeneralActivity"); ?>',
        type: 'GET',
        data: {
            mobile: mobile,
            from: dateFrom,
            to: dateTo
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                displayGeneralActivity(response.activities);
            } else {
                $('#generalActivityContent').html('<div class="alert alert-danger">' + response.error + '</div>');
            }
        },
        error: function() {
            $('#generalActivityContent').html('<div class="alert alert-danger">Error loading general activity</div>');
        }
    });
}

function displayGeneralActivity(activities) {
    var html = '';

    if (activities.length === 0) {
        html = '<div class="alert alert-info">No general activity found for this user in the selected period.</div>';
    } else {
        html = '<table class="table table-bordered table-striped">';
        html += '<thead><tr><th>ID</th><th>Activity Type</th><th>Description</th><th>IP Address</th><th>Date</th></tr></thead>';
        html += '<tbody>';

        activities.forEach(function(activity) {
            html += '<tr>';
            html += '<td>' + activity.id + '</td>';
            html += '<td>' + activity.activity_type + '</td>';
            html += '<td>' + activity.activity_description + '</td>';
            html += '<td>' + activity.ip_address + '</td>';
            html += '<td>' + activity.created_at + '</td>';
            html += '</tr>';
        });

        html += '</tbody></table>';
    }

    $('#generalActivityContent').html(html);
}

function getStatusClass(status) {
    switch(status) {
        case 'new': return 'default';
        case 'approved': return 'success';
        case 'complete': return 'info';
        case 'cancel': return 'danger';
        case 'reject': return 'warning';
        default: return 'default';
    }
}

function closeModal(modalId) {
    $('#' + modalId).modal('hide');
    // Alternative method if Bootstrap modal doesn't work
    $('#' + modalId).removeClass('in');
    $('#' + modalId).css('display', 'none');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}
</script>

</body>
</html> 