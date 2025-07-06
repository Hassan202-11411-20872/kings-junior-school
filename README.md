# Kings Junior School Management System

A comprehensive school management system for Kings Junior School, built with PHP and MySQL.

## Features

- **Student Management**: Add, edit, delete, and track student information
- **Class Management**: Organize students by classes and streams
- **Marks Entry**: Record and manage student academic performance
- **Report Generation**: Generate detailed student reports
- **Teacher Portal**: Dedicated interface for teachers
- **Admin Dashboard**: Complete administrative control
- **Audit Logging**: Track all system activities
- **Student History**: Track student progression through classes
- **Session Management**: Day Scholar and Boarding Scholar support

## Deployment to Render

### Prerequisites
- Render account (free tier available)
- MySQL database (Render provides free MySQL)

### Step 1: Prepare Your Database

1. **Create a MySQL database on Render:**
   - Go to [Render Dashboard](https://dashboard.render.com)
   - Click "New" → "MySQL"
   - Choose "Free" plan
   - Note down the database credentials

2. **Import your database:**
   - Use the provided `database/kings_junior_school.sql` file
   - Import via phpMyAdmin or MySQL command line

### Step 2: Deploy to Render

1. **Connect your GitHub repository:**
   - Push your code to GitHub
   - In Render Dashboard, click "New" → "Web Service"
   - Connect your GitHub repository

2. **Configure the deployment:**
   - **Name**: `kings-junior-school`
   - **Environment**: `PHP`
   - **Build Command**: `composer install`
   - **Start Command**: `vendor/bin/heroku-php-apache2 public/`

3. **Set Environment Variables:**
   ```
   DB_HOST=your-mysql-host.render.com
   DB_NAME=your-database-name
   DB_USER=your-database-user
   DB_PASS=your-database-password
   APP_ENV=production
   ```

### Step 3: Update Database Configuration

Update `includes/db.php` to use environment variables:

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

## Local Development

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/kings-junior-school.git
   cd kings-junior-school
   ```

2. **Set up the database:**
   - Create a MySQL database
   - Import `database/kings_junior_school.sql`

3. **Configure database connection:**
   - Edit `includes/db.php` with your database credentials

4. **Set up web server:**
   - Point your web server to the project directory
   - Ensure PHP and MySQL are installed

## Default Login Credentials

### Admin Account
- **Username**: `irene`
- **Password**: `admin123`

### Teacher Account
- **Username**: `silvia`
- **Password**: `teacher123`

## File Structure

```
kings-junior-school/
├── admin/              # Admin panel files
├── teacher/            # Teacher portal files
├── includes/           # Shared PHP files
├── assets/            # CSS, JS, images
├── database/          # SQL files
├── uploads/           # Student photos
├── public/            # Public entry point
└── README.md          # This file
```

## Security Features

- Password hashing with bcrypt
- Session management
- SQL injection prevention
- XSS protection
- Audit logging
- Role-based access control

## Support

For technical support or questions, please contact the development team.

## License

This project is proprietary software for Kings Junior School. 