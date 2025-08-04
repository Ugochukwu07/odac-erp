# Logo Environment Variables Setup

This document explains how to configure logo URLs using environment variables in the Odeac project.

## Overview

The project has been updated to use environment variables for logo configuration, making it easier to manage different logos across different environments (development, staging, production).

## Environment Variables

The following environment variables are now available for logo configuration:

### Logo Configuration Variables

- `LOGO_URL`: Full URL to the main logo image (e.g., `https://example.com/logo.png`)
- `DEFAULT_LOGO_URL`: Full URL to the default logo image (fallback logo)
- `UPLOADED_LOGO`: Filename of the uploaded logo in the uploads directory (e.g., `logo.png`)

## Setup Instructions

### 1. Create .env File

Create a `.env` file in the project root directory with the following content:

```env
# Logo Configuration
LOGO_URL=https://www.odac24.in/assets/cli/image/odac-cabs24.png
DEFAULT_LOGO_URL=https://www.odac24.in/assets/cli/image/odac-cabs24.png
UPLOADED_LOGO=logo.png

# Other environment variables can be added here
# Database configuration
# DB_HOST=localhost
# DB_USERNAME=root
# DB_PASSWORD=
# DB_DATABASE=odeac

# API Keys
# RAZOR_PAY_KEY_ID=
# RAZOR_PAY_SECRET_KEY=
# GGOGLEPLACEKEY=AIzaSyA33Nc-vkogu2ccN7evkSxFfsmS6PaGZ3Q
# GGOGLEMATRIX=AIzaSyA33Nc-vkogu2ccN7evkSxFfsmS6PaGZ3Q
```

### 2. Environment-Specific Configuration

For different environments, you can create environment-specific .env files:

- `.env.development` - Development environment
- `.env.staging` - Staging environment  
- `.env.production` - Production environment

### 3. Server Environment Variables

Alternatively, you can set these variables directly on your server:

```bash
export LOGO_URL="https://your-domain.com/logo.png"
export DEFAULT_LOGO_URL="https://your-domain.com/default-logo.png"
export UPLOADED_LOGO="logo.png"
```

## How It Works

The configuration in `application/config/config.php` now reads logo values from environment variables:

```php
// Logo configuration from environment variables
if (!defined('LOGO')) define('LOGO', getenv('LOGO_URL') ?: UPLOADS . (getenv('UPLOADED_LOGO') ?: 'logo.png'));
if (!defined('DEFAULT_LOGO')) define('DEFAULT_LOGO', getenv('DEFAULT_LOGO_URL') ?: 'https://www.odac24.in/assets/cli/image/odac-cabs24.png');
```

### Fallback Behavior

- If `LOGO_URL` is set, it will be used as the full logo URL
- If `LOGO_URL` is not set, it will use `UPLOADS` + `UPLOADED_LOGO` (or default to `logo.png`)
- If `DEFAULT_LOGO_URL` is not set, it will use the hardcoded default URL

## Files Updated

The following files have been updated to use environment variables:

1. `application/config/config.php` - Logo constant definitions
2. All view files that reference `LOGO` and `DEFAULT_LOGO` constants

## Usage in Views

The logo constants can still be used in views exactly as before:

```php
<img src="<?php echo DEFAULT_LOGO;?>" alt="Logo" />
<img src="<?php echo LOGO;?>" alt="Logo" />
```

## Benefits

1. **Environment Flexibility**: Different logos for different environments
2. **Easy Management**: Change logos without modifying code
3. **Security**: Sensitive configuration separated from code
4. **Deployment**: Easy to manage in CI/CD pipelines

## Troubleshooting

If logos are not displaying correctly:

1. Check that the `.env` file exists in the project root
2. Verify environment variable names are correct
3. Ensure the logo URLs are accessible
4. Check file permissions on the `.env` file
5. Restart your web server after making changes

## Migration Notes

- Existing code using `LOGO` and `DEFAULT_LOGO` constants will continue to work
- No changes required in view files
- The system will fall back to default values if environment variables are not set 