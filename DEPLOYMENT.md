# Render Deployment Guide

## Step-by-Step Deployment to Render

### Step 1: Prepare Your Code

1. **Ensure all files are committed to GitHub**
2. **Create the necessary configuration files** (already done):
   - `render.yaml` - Render configuration
   - `composer.json` - PHP dependencies
   - `public/.htaccess` - Apache configuration
   - `public/index.php` - Entry point

### Step 2: Set Up Database on Render

1. **Create MySQL Database:**
   - Go to [Render Dashboard](https://dashboard.render.com)
   - Click "New" → "MySQL"
   - Choose "Free" plan
   - Set database name: `kings_junior_school`
   - Note down the connection details

2. **Import Database:**
   - Use the provided `database/kings_junior_school.sql` file
   - Import via phpMyAdmin or MySQL command line

### Step 3: Deploy Web Application

1. **Create Web Service:**
   - In Render Dashboard, click "New" → "Web Service"
   - Connect your GitHub repository
   - Configure as follows:

2. **Configuration Settings:**
   ```
   Name: kings-junior-school
   Environment: PHP
   Build Command: composer install
   Start Command: vendor/bin/heroku-php-apache2 public/
   ```

3. **Environment Variables:**
   ```
   DB_HOST=your-mysql-host.render.com
   DB_NAME=kings_junior_school
   DB_USER=your-database-user
   DB_PASS=your-database-password
   PHP_VERSION=8.1
   APP_ENV=production
   APP_DEBUG=false
   ```

### Step 4: Update Database Configuration

**Important:** Update `includes/db.php` to use environment variables:

```php
<?php
$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'kings_junior_school';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
```

### Step 5: Test Deployment

1. **Wait for deployment to complete**
2. **Visit your Render URL** (e.g., `https://kings-junior-school.onrender.com`)
3. **Test login with default credentials:**
   - Admin: `irene` / `admin123`
   - Teacher: `silvia` / `teacher123`

### Step 6: Configure Custom Domain (Optional)

1. **Add custom domain in Render dashboard**
2. **Update DNS settings** with your domain provider
3. **Enable SSL certificate** (automatic with Render)

## Free Tier Limitations

- **Web Service**: 750 hours/month (enough for full-time use)
- **MySQL Database**: 1GB storage
- **Bandwidth**: 100GB/month
- **Build Time**: 500 minutes/month

## Monitoring and Maintenance

1. **Check Render dashboard** for deployment status
2. **Monitor logs** for any errors
3. **Set up alerts** for downtime
4. **Regular backups** of database

## Troubleshooting

### Common Issues:

1. **Database Connection Failed:**
   - Check environment variables
   - Verify database credentials
   - Ensure database is running

2. **Build Failed:**
   - Check `composer.json` syntax
   - Verify PHP version compatibility
   - Review build logs

3. **Application Not Loading:**
   - Check start command
   - Verify file permissions
   - Review application logs

## Security Considerations

1. **Change default passwords** after first login
2. **Enable HTTPS** (automatic with Render)
3. **Regular security updates**
4. **Monitor audit logs**

## Support

For deployment issues:
1. Check Render documentation
2. Review application logs
3. Contact Render support if needed

Your school management system will be accessible to your staff worldwide once deployed! 🎉 