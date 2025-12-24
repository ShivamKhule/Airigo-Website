# Airigojobs - Aviation & Hospitality Job Portal

A modern, production-ready job portal built with PHP, Firebase, and Tailwind CSS, specifically designed for the aviation and hospitality industry.

## 🚀 Features

- **User Management**: Separate registration for job seekers and employers
- **Job Posting & Search**: Advanced job search with filters and categories
- **Application System**: Quick apply and application tracking
- **Firebase Integration**: Real-time database and authentication
- **Responsive Design**: Mobile-first design with Tailwind CSS
- **Security**: CSRF protection, rate limiting, input sanitization
- **Email Notifications**: Automated email system for applications
- **File Uploads**: Secure resume and document uploads
- **Activity Logging**: Comprehensive user activity tracking
- **Caching System**: Performance optimization with file-based caching

## 📋 Requirements

- PHP 7.4 or higher
- Composer
- Firebase project with Realtime Database
- Web server (Apache/Nginx)
- SSL certificate (recommended for production)

## 🛠️ Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd Airigo-Website-1
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Configure Environment
Copy the `.env` file and update with your settings:
```bash
cp .env.example .env
```

Edit `.env` with your Firebase and application settings:
```env
# Firebase Configuration
FIREBASE_PROJECT_ID=your-project-id
FIREBASE_PRIVATE_KEY_ID=your-private-key-id
FIREBASE_PRIVATE_KEY="-----BEGIN PRIVATE KEY-----\nYour private key here\n-----END PRIVATE KEY-----\n"
FIREBASE_CLIENT_EMAIL=your-service-account@your-project.iam.gserviceaccount.com
FIREBASE_CLIENT_ID=your-client-id
FIREBASE_DATABASE_URL=https://your-project-default-rtdb.firebaseio.com/

# Application Settings
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Email Configuration
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@airigojobs.com
MAIL_FROM_NAME="Airigojobs"
```

### 4. Firebase Setup

#### Option A: Service Account File (Recommended for Production)
1. Download your Firebase service account JSON file
2. Rename it to `firebase-credentials.json`
3. Place it in the `config/` directory
4. Ensure proper file permissions (600)

#### Option B: Environment Variables
Use the environment variables in `.env` as shown above.

### 5. Set Directory Permissions
```bash
chmod 755 assets/uploads/
chmod 755 logs/
chmod 755 cache/
chmod 600 config/firebase-credentials.json  # if using service account file
chmod 600 .env
```

### 6. Configure Web Server

#### Apache (.htaccess included)
The `.htaccess` file is already configured with:
- URL rewriting
- Security headers
- Compression
- Caching rules
- Rate limiting (if mod_evasive is available)

#### Nginx Configuration Example
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    root /path/to/Airigo-Website-1;
    index index.php;

    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # PHP handling
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Remove .php extension
    location / {
        try_files $uri $uri/ @extensionless-php;
    }

    location @extensionless-php {
        rewrite ^(.*)$ $1.php last;
    }

    # Deny access to sensitive files
    location ~ /\.(env|git|htaccess) {
        deny all;
    }

    location ~ /(vendor|config|logs|cache)/ {
        deny all;
    }
}
```

## 🔧 Configuration

### Environment Variables
All configuration is managed through environment variables in the `.env` file:

- **APP_ENV**: Set to `production` for live sites
- **APP_DEBUG**: Set to `false` in production
- **APP_URL**: Your domain URL
- **Firebase settings**: Your Firebase project credentials
- **Mail settings**: SMTP configuration for email notifications
- **Security settings**: Session and CSRF token lifetimes
- **Upload settings**: File upload limits and allowed types
- **Cache settings**: Enable/disable caching and set lifetimes

### Firebase Database Structure
The application expects the following Firebase Realtime Database structure:
```
{
  "users": {
    "user_id": {
      "email": "user@example.com",
      "full_name": "User Name",
      "role": "jobseeker|recruiter",
      "phone": "+1234567890",
      "created_at": "2024-01-01 00:00:00"
    }
  },
  "jobs": {
    "job_id": {
      "title": "Job Title",
      "company": "Company Name",
      "location": "City, Country",
      "type": "full-time|part-time|contract",
      "salary_min": 50000,
      "salary_max": 80000,
      "description": "Job description",
      "requirements": "Job requirements",
      "posted_by": "user_id",
      "created_at": "2024-01-01 00:00:00",
      "status": "active|closed"
    }
  },
  "applications": {
    "user_id_job_id": {
      "job_id": "job_id",
      "user_id": "user_id",
      "status": "applied|shortlisted|rejected|hired",
      "applied_at": "2024-01-01 00:00:00"
    }
  },
  "favorites": {
    "user_id_job_id": {
      "job_id": "job_id",
      "user_id": "user_id",
      "favorited_at": "2024-01-01 00:00:00"
    }
  }
}
```

## 🔒 Security Features

- **CSRF Protection**: All forms include CSRF tokens
- **Input Sanitization**: All user inputs are sanitized
- **Rate Limiting**: API endpoints have rate limiting
- **Secure File Uploads**: File type and size validation
- **Session Security**: Secure session configuration
- **SQL Injection Prevention**: Using Firebase (NoSQL)
- **XSS Protection**: Output escaping and CSP headers

## 📧 Email Templates

Email templates are located in the `emails/` directory:
- `welcome-jobseeker.php`: Welcome email for job seekers
- `welcome-recruiter.php`: Welcome email for recruiters
- `application-received.php`: Notification for employers

## 🚀 Production Deployment

### 1. Server Requirements
- PHP 7.4+ with required extensions
- Composer installed
- SSL certificate configured
- Proper file permissions set

### 2. Environment Setup
```bash
# Set production environment
echo "APP_ENV=production" >> .env
echo "APP_DEBUG=false" >> .env

# Set proper permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 600 .env config/firebase-credentials.json
chmod 755 assets/uploads/ logs/ cache/
```

### 3. Performance Optimization
- Enable OPcache in PHP
- Configure proper caching headers
- Use a CDN for static assets
- Enable gzip compression
- Optimize images and assets

### 4. Monitoring
- Set up error logging
- Monitor application logs in `logs/` directory
- Set up uptime monitoring
- Configure backup systems

## 🐛 Troubleshooting

### Common Issues

1. **Firebase Connection Issues**
   - Verify Firebase credentials in `.env`
   - Check Firebase project permissions
   - Ensure database URL is correct

2. **File Upload Issues**
   - Check directory permissions (755 for directories, 644 for files)
   - Verify PHP upload limits in `php.ini`
   - Check available disk space

3. **Email Not Sending**
   - Verify SMTP settings in `.env`
   - Check firewall settings for SMTP ports
   - Test with a simple mail script

4. **Session Issues**
   - Check session directory permissions
   - Verify session configuration in `php.ini`
   - Clear browser cookies

### Debug Mode
Enable debug mode for development:
```env
APP_ENV=development
APP_DEBUG=true
```

This will:
- Show detailed error messages
- Log errors to files
- Display debug information

## 📝 API Endpoints

- `POST /api/apply-job.php`: Submit job application
- `POST /api/toggle-favorite.php`: Add/remove job from favorites
- `GET /api/jobs.php`: Get job listings (with filters)

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🆘 Support

For support and questions:
- Check the troubleshooting section
- Review the logs in `logs/` directory
- Contact the development team

## 🔄 Updates

To update the application:
1. Backup your database and files
2. Pull the latest changes
3. Run `composer update`
4. Clear cache: `rm -rf cache/*`
5. Test thoroughly before going live

---

**Note**: Always test changes in a staging environment before deploying to production.