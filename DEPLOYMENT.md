# Deployment Guide

This guide will help you deploy the Kings Junior School Management System to a web hosting service.

## Prerequisites

- A web hosting account with PHP and MySQL support
- Domain name (optional but recommended)
- FTP/SFTP access or Git deployment capability

## Deployment Options

### Option 1: Shared Hosting (cPanel, etc.)

1. **Upload Files**
   - Use FTP/SFTP to upload all project files to your web hosting
   - Upload to the `public_html` or `www` directory

2. **Database Setup**
   - Create a MySQL database through your hosting control panel
   - Import the database schema:
     ```sql
     -- Run the contents of database/kings_junior_school.sql
     ```

3. **Configuration**
   - Copy `config.example.php` to `config.php`
   - Update database credentials in `config.php`
   - Update `APP_URL` to your domain

4. **File Permissions**
   - Set upload directories to writable (755 or 775)
   - Ensure `config.php` is readable by the web server

### Option 2: VPS/Dedicated Server

1. **Server Setup**
   ```bash
   # Update system
   sudo apt update && sudo apt upgrade -y
   
   # Install LAMP stack
   sudo apt install apache2 mysql-server php php-mysql php-gd php-mbstring
   
   # Enable Apache modules
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

2. **Database Setup**
   ```bash
   # Secure MySQL installation
   sudo mysql_secure_installation
   
   # Create database and user
   sudo mysql -u root -p
   CREATE DATABASE kings_junior_school;
   CREATE USER 'kjs_user'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON kings_junior_school.* TO 'kjs_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   
   # Import database
   mysql -u kjs_user -p kings_junior_school < database/kings_junior_school.sql
   ```

3. **Application Deployment**
   ```bash
   # Clone repository
   cd /var/www/html
   sudo git clone https://github.com/yourusername/kings-junior-school.git
   sudo chown -R www-data:www-data kings-junior-school
   
   # Configure application
   cd kings-junior-school
   sudo cp config.example.php config.php
   sudo nano config.php  # Edit database credentials
   ```

4. **Apache Configuration**
   ```apache
   # Create /etc/apache2/sites-available/kjs.conf
   <VirtualHost *:80>
       ServerName your-domain.com
       DocumentRoot /var/www/html/kings-junior-school
       
       <Directory /var/www/html/kings-junior-school>
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/kjs_error.log
       CustomLog ${APACHE_LOG_DIR}/kjs_access.log combined
   </VirtualHost>
   ```

5. **Enable Site**
   ```bash
   sudo a2ensite kjs.conf
   sudo systemctl reload apache2
   ```

### Option 3: Cloud Platforms

#### Heroku
1. Create a `Procfile`:
   ```
   web: vendor/bin/heroku-php-apache2
   ```

2. Set environment variables:
   ```bash
   heroku config:set DB_HOST=your_db_host
   heroku config:set DB_NAME=your_db_name
   heroku config:set DB_USER=your_db_user
   heroku config:set DB_PASS=your_db_password
   heroku config:set APP_URL=https://your-app.herokuapp.com
   ```

#### DigitalOcean App Platform
1. Connect your GitHub repository
2. Set environment variables in the dashboard
3. Configure build settings for PHP

## Security Checklist

- [ ] Change default admin password
- [ ] Use HTTPS (SSL certificate)
- [ ] Set proper file permissions
- [ ] Configure firewall rules
- [ ] Enable automatic backups
- [ ] Keep PHP and MySQL updated
- [ ] Use strong database passwords
- [ ] Configure error logging

## Post-Deployment

1. **Test the Application**
   - Verify all features work correctly
   - Test file uploads
   - Check database connections
   - Verify user authentication

2. **Performance Optimization**
   - Enable PHP OPcache
   - Configure MySQL query cache
   - Enable Apache compression
   - Set up CDN for static assets

3. **Monitoring**
   - Set up error monitoring
   - Configure uptime monitoring
   - Set up database backup automation
   - Monitor server resources

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Verify database credentials
   - Check if MySQL service is running
   - Ensure database exists

2. **File Upload Issues**
   - Check directory permissions
   - Verify PHP upload settings
   - Check file size limits

3. **404 Errors**
   - Verify .htaccess file exists
   - Check Apache rewrite module
   - Confirm file paths

4. **Permission Denied**
   - Set proper file ownership
   - Configure correct permissions
   - Check SELinux settings (if applicable)

## Support

For deployment issues, check:
- Hosting provider documentation
- PHP and MySQL error logs
- Apache/Nginx error logs
- Application error logs

## Backup Strategy

1. **Database Backups**
   ```bash
   # Daily backup script
   mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
   ```

2. **File Backups**
   - Backup uploads directory
   - Backup configuration files
   - Use version control for code

3. **Automated Backups**
   - Set up cron jobs for database backups
   - Use cloud storage for backup files
   - Test backup restoration regularly 