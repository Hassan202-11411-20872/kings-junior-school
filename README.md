# Kings Junior School Management System

A comprehensive PHP-based school management system for Kings Junior School. This system handles student management, teacher administration, grading, and report generation.

## Features

- **Student Management**: Add, edit, delete, and manage student records
- **Teacher Management**: Manage teacher accounts and assignments
- **Class Management**: Organize classes and streams
- **Subject Management**: Configure subjects for different classes
- **Grading System**: Record and manage student marks
- **Report Generation**: Generate comprehensive student reports
- **User Authentication**: Secure login system with role-based access
- **File Upload**: Support for student photos and documents

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB 10.2 or higher
- Web server (Apache/Nginx)
- PHP extensions: PDO, PDO_MySQL, GD (for image processing)

## Installation

### Local Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/kings-junior-school.git
   cd kings-junior-school
   ```

2. **Set up the database**
   - Create a MySQL database named `kings_junior_school`
   - Import the database schema:
   ```bash
   mysql -u root -p kings_junior_school < database/kings_junior_school.sql
   ```

3. **Configure the application**
   - Copy `config.php` and modify database credentials if needed
   - Ensure upload directories are writable:
   ```bash
   chmod 755 uploads/
   chmod 755 uploads/students/
   ```

4. **Access the application**
   - Open your web browser and navigate to the project URL
   - Default admin credentials:
     - Username: `irene`
     - Password: `admin123` (change this immediately!)

### Production Deployment

1. **Environment Variables**
   Set the following environment variables for production:
   ```bash
   DB_HOST=your_database_host
   DB_NAME=your_database_name
   DB_USER=your_database_user
   DB_PASS=your_database_password
   APP_URL=https://your-domain.com
   APP_ENV=production
   ```

2. **Security Considerations**
   - Change default admin password
   - Use HTTPS in production
   - Set proper file permissions
   - Configure backup strategy

## Project Structure

```
kjs/
├── admin/           # Admin panel files
├── teacher/         # Teacher panel files
├── assets/          # CSS, images, and static files
├── database/        # Database schema and migrations
├── includes/        # Shared PHP files
├── uploads/         # File uploads (auto-created)
├── config.php       # Application configuration
├── index.php        # Main entry point
├── login.php        # Authentication
└── README.md        # This file
```

## User Roles

### Admin
- Full system access
- Manage all users, students, teachers
- Configure classes, subjects, grading
- Generate reports

### Teacher
- View assigned classes and students
- Record and manage marks
- Generate class reports

## Database Schema

The system uses the following main tables:
- `users` - User accounts and authentication
- `students` - Student information
- `teachers` - Teacher profiles and assignments
- `classes` - Class and stream management
- `subjects` - Subject configuration
- `marks` - Student grades and assessments
- `grading_scale` - Grading system configuration

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions, please contact the development team or create an issue on GitHub.

## Changelog

### Version 1.0.0
- Initial release
- Basic school management functionality
- User authentication system
- Report generation capabilities 