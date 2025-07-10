-- Add new permission for admin activity tracking
INSERT INTO `pt_permissions` (`name`, `description`, `module`, `status`, `created_at`, `updated_at`) 
VALUES ('admin_activity_tracking', 'Track admin activities based on hierarchy', 'Admin Management', 'active', NOW(), NOW());

-- Get the permission ID
SET @permission_id = LAST_INSERT_ID();

-- Add this permission to Super Admin role
INSERT INTO `pt_role_permissions` (`role_id`, `permission_id`, `created_at`) 
SELECT r.id, @permission_id, NOW() 
FROM `pt_roles` r 
WHERE r.name = 'Super Admin';

-- Add this permission to Manager role (if exists)
INSERT INTO `pt_role_permissions` (`role_id`, `permission_id`, `created_at`) 
SELECT r.id, @permission_id, NOW() 
FROM `pt_roles` r 
WHERE r.name = 'Manager';

-- Add this permission to User role (if exists)
INSERT INTO `pt_role_permissions` (`role_id`, `permission_id`, `created_at`) 
SELECT r.id, @permission_id, NOW() 
FROM `pt_roles` r 
WHERE r.name = 'User'; 