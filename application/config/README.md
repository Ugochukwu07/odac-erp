# Environment Configuration Setup

This CodeIgniter 3.1.13 application uses environment-specific configuration files to manage different settings for development and production environments.

## Directory Structure

```
application/config/
├── config.php              # Base configuration (fallback defaults)
├── database.php            # Base database configuration (fallback defaults)
├── development/
│   ├── config.php          # Development-specific configuration overrides
│   └── database.php        # Development-specific database settings
└── production/
    ├── config.php          # Production-specific configuration overrides
    └── database.php        # Production-specific database settings
```

## Environment Switching

The application automatically switches environments based on the `CI_ENV` environment variable:

### Development Environment
```bash
export CI_ENV=development
# or
CI_ENV=development php index.php
```

### Production Environment
```bash
export CI_ENV=production
# or
CI_ENV=production php index.php
```

### Default Fallback
If `CI_ENV` is not set, the application defaults to `development` environment.

## Configuration Overrides

### Development Environment (`development/config.php`)
- **Base URL**: `http://localhost/`
- **Logging**: Verbose (level 4 - logs everything)
- **Database**: Localhost with root access
- **Security**: Relaxed for development convenience
- **Debugging**: Profiler enabled, CSRF disabled
- **Cache**: Disabled for easier debugging

### Production Environment (`production/config.php`)
- **Base URL**: `https://yourdomain.com/` (update to your actual domain)
- **Logging**: Minimal (level 1 - errors only)
- **Database**: Production database with secure credentials
- **Security**: Strict security settings enabled
- **Debugging**: Profiler disabled, CSRF enabled
- **Cache**: Enabled for performance

## Database Configuration

### Development Database (`development/database.php`)
```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'odeac_dev',
'db_debug' => TRUE,
```

### Production Database (`production/database.php`)
```php
'hostname' => 'live-db-host',
'username' => 'prod_user',
'password' => 'strong_production_password',
'database' => 'odeac_prod',
'db_debug' => FALSE,
```

## Important Notes

1. **Update Production Settings**: Before deploying to production, update the following in `production/config.php`:
   - `base_url` to your actual domain
   - `cookie_domain` to your actual domain
   - `encryption_key` to a strong, unique key

2. **Update Production Database**: Update the database credentials in `production/database.php`:
   - `hostname` to your production database host
   - `username` to your production database username
   - `password` to your production database password
   - `database` to your production database name

3. **Security**: The production configuration includes stricter security settings:
   - CSRF protection enabled
   - XSS filtering enabled
   - Secure cookies enabled
   - Session IP matching enabled

4. **Performance**: The production configuration is optimized for performance:
   - Query caching enabled
   - Output compression enabled
   - Profiler disabled
   - Query saving disabled

## Usage Examples

### Local Development
```bash
# Set environment variable
export CI_ENV=development

# Run the application
php -S localhost:8000
```

### Production Deployment
```bash
# Set environment variable
export CI_ENV=production

# Run the application
php index.php
```

### Apache/Nginx Configuration
Add to your web server configuration:
```apache
# Apache (.htaccess)
SetEnv CI_ENV production

# Nginx
fastcgi_param CI_ENV production;
```

## Fallback Configuration

The main `config.php` and `database.php` files serve as fallback defaults. CodeIgniter will:
1. Load the base configuration files
2. If an environment-specific folder exists, override with those settings
3. If no environment-specific folder exists, use only the base configuration

This ensures the application works even if environment-specific files are missing. 