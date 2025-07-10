# Admin Hierarchy Booking Tracking System

## Overview

This system implements a hierarchical booking tracking mechanism for the admin panel, allowing different levels of administrators to track booking activities based on their hierarchy level. The system ensures that admins can only track activities of users at their same level or below, maintaining proper access control.

## Hierarchy Levels

The system defines three hierarchy levels:

1. **Super Admin (Level 1)** - Can track all admin activities
2. **Manager (Level 2)** - Can track Manager and User activities
3. **User (Level 3)** - Can track only User activities

## Features Implemented

### 1. RBAC Helper Functions

New helper functions added to `application/helpers/rbac_helper.php`:

- `get_admin_hierarchy_level($user_id)` - Get hierarchy level for a user
- `can_track_user_bookings($target_user_id)` - Check if current user can track another user
- `get_trackable_user_ids()` - Get list of user IDs current user can track
- `get_trackable_user_mobiles()` - Get list of mobile numbers current user can track
- `get_admin_hierarchy_filter()` - Get database filter for booking queries
- `can_view_booking($booking)` - Check if user can view specific booking
- `get_admin_hierarchy_display($user_id)` - Get display text for hierarchy level
- `get_admin_hierarchy_badge_class($user_id)` - Get Bootstrap badge class for hierarchy

### 2. Modified Booking Controller

Updated `application/controllers/private/Bookingview.php`:

- Added hierarchy filtering to `getRecordsFromDb()` method
- Automatically filters bookings based on user's hierarchy level
- Super Admins see all bookings
- Managers see bookings from Managers and Users
- Users see only their own bookings

### 3. New Admin Activity Controller

Created `application/controllers/private/AdminActivity.php`:

- `index()` - Main activity tracking dashboard
- `getUserBookings()` - Get bookings for a specific user
- `getUserActivity()` - Get detailed activity for a user
- `getActivitySummary()` - Get summary statistics for trackable users

### 4. Admin Activity View

Created `application/views/private/admin_activity.php`:

- Dashboard showing all trackable admin users
- Hierarchy level indicators with color-coded badges
- Activity summary with booking statistics
- Modal popups for detailed user activity
- Date range filtering for activity reports

### 5. Enhanced Booking View

Updated `application/views/private/bookingview.php`:

- Added hierarchy information display
- Shows current user's hierarchy level and tracking capabilities
- Link to Admin Activity Report for authorized users
- Visual indicators for hierarchy levels

### 6. Database Changes

SQL script `application/sql/add_admin_activity_permission.sql`:

- Adds new permission: `admin_activity_tracking`
- Assigns permission to Super Admin, Manager, and User roles
- Enables role-based access control for the new feature

### 7. Menu Integration

Updated `application/views/private/includes/menu.php`:

- Added "Admin Activity Tracking" menu item under User & Role Management
- Only visible to users with appropriate permissions

## How It Works

### 1. Hierarchy Determination

When a user logs in, the system determines their hierarchy level based on their assigned roles:

```php
$level = get_admin_hierarchy_level($user_id);
// Returns: 1 (Super Admin), 2 (Manager), or 3 (User)
```

### 2. Booking Filtering

All booking queries automatically apply hierarchy filters:

```php
$hierarchy_filter = get_admin_hierarchy_filter();
// Returns appropriate WHERE conditions based on user's level
```

### 3. Access Control

Before displaying any user's data, the system checks permissions:

```php
if (!can_track_user_bookings($target_user_id)) {
    // Show access denied message
}
```

### 4. Activity Tracking

The Admin Activity dashboard shows:

- List of all users the current admin can track
- Booking statistics for each user
- Detailed activity logs
- Edit history for bookings

## Usage Instructions

### For Super Admins

1. Access the Admin Activity Tracking from the menu
2. View all admin users and their activities
3. See comprehensive booking statistics
4. Track all booking modifications and edits

### For Managers

1. Access the Admin Activity Tracking from the menu
2. View only Manager and User activities
3. Cannot track Super Admin activities
4. See booking statistics for their level and below

### For Users

1. Cannot access Admin Activity Tracking
2. Can only see their own bookings
3. Cannot track other users' activities

## Security Features

1. **Hierarchy Enforcement**: Users cannot access data from higher hierarchy levels
2. **Permission-Based Access**: All features require appropriate permissions
3. **Session Validation**: All requests validate user session and permissions
4. **Database Filtering**: Queries automatically filter based on hierarchy
5. **Audit Trail**: All booking modifications are logged with user information

## Database Tables Used

- `pt_users` - User information
- `pt_roles` - Role definitions
- `pt_user_roles` - User-role assignments
- `pt_permissions` - Permission definitions
- `pt_role_permissions` - Role-permission assignments
- `pt_booking` - Booking data
- `pt_booking_editing_log` - Booking modification history

## Installation

1. Run the SQL script to add the new permission:
   ```sql
   source application/sql/add_admin_activity_permission.sql
   ```

2. Ensure the RBAC helper is loaded in your application

3. The new features will be automatically available based on user roles

## Configuration

### Adding New Hierarchy Levels

To add new hierarchy levels, modify the `get_admin_hierarchy_level()` function in `rbac_helper.php`:

```php
// Add new level
if (in_array('New Role', $role_names)) {
    return 4; // New hierarchy level
}
```

### Customizing Permissions

To customize permissions, edit the roles in the admin panel:

1. Go to User & Role Management > Manage Roles
2. Edit the desired role
3. Add/remove the `admin_activity_tracking` permission

## Troubleshooting

### Common Issues

1. **Permission Denied Errors**: Ensure the user has the `admin_activity_tracking` permission
2. **No Users Visible**: Check if the current user has appropriate hierarchy level
3. **Missing Menu Item**: Verify the user has the required permission

### Debug Mode

Enable debug mode to see hierarchy information:

```php
// Add to any view for debugging
echo "Current Level: " . get_admin_hierarchy_level();
echo "Trackable Users: " . implode(', ', get_trackable_user_mobiles());
```

## Future Enhancements

1. **Real-time Activity Monitoring**: WebSocket-based live activity updates
2. **Advanced Analytics**: Detailed performance metrics and reports
3. **Activity Export**: Export activity data to CSV/PDF
4. **Email Notifications**: Alerts for important activities
5. **Mobile App Integration**: Activity tracking on mobile devices

## Support

For technical support or questions about the hierarchical booking tracking system, please refer to the system documentation or contact the development team. 