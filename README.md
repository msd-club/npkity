# NPK Sensor Web UI - Documentation

## 📋 Project Overview

A comprehensive web-based NPK (Nitrogen, Phosphorus, Potassium) sensor monitoring system with user authentication, dashboard analytics, and plot management capabilities. Built with vanilla PHP, Bootstrap 5, jQuery, and MySQL.

## 🚀 Features

### ✅ User Authentication
- Login with username/email and password
- User registration with email, username, and password confirmation
- Session-based authentication
- Secure password hashing

### 📊 Dashboard
- Real-time statistics display (Total Plots, Total Samples, Average Nutrients)
- Recent activity tracking
- System health monitoring
- Top performing plots visualization

### 🗺️ Plots Management
- Complete CRUD operations for agricultural plots
- DataTables integration with server-side processing
- Search and filter functionality
- Responsive table with pagination
- Modal-based forms for add/edit operations

### 🎨 User Interface
- Clean, modern Bootstrap 5 design
- Boxicons for beautiful icons
- Responsive sidebar navigation
- Toast notifications for user feedback
- Professional DataTables implementation

## 🏗️ Project Structure

```
npk_sensor_web_ui/
├── index.php                 # Login/Registration page
├── dashboard.php             # Main dashboard
├── plots.php                 # Plots management
├── logout.php                # Logout handler
├── api/
│   ├── connection.php        # Database connection
│   ├── user_login.php        # User login API
│   ├── user_register.php     # User registration API
│   ├── plot_create.php       # Create new plot
│   ├── plot_update.php       # Update plot
│   ├── plot_delete.php       # Delete plot (soft delete)
│   ├── plot_list.php         # List plots for DataTables
│   └── plot_get.php          # Get single plot details
├── layouts/
│   ├── base.php              # Main template layout
│   └── sidebar.php           # Sidebar navigation
└── assets/
    ├── css/
    │   └── custom.css        # Custom styles
    └── js/
        └── plots.js          # Plots page JavaScript
```

## 🗄️ Database Schema

### SQL Queries

#### 1. Create Database
```sql
CREATE DATABASE IF NOT EXISTS npk_database;
USE npk_database;
```

#### 2. Users Table
```sql
CREATE TABLE IF NOT EXISTS users (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### 3. Plots Table
```sql
CREATE TABLE IF NOT EXISTS plots (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    location VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    is_deleted BOOLEAN DEFAULT FALSE
);
```

## 🔧 Installation Guide

### Prerequisites
- XAMPP/WAMP/MAMP or any PHP development environment
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache recommended)

### Step-by-Step Installation

1. **Clone or download the project**
   ```bash
   git clone https://github.com/msd-club/npkity.git
   cd npkity
   ```

2. **Setup Database**
   - Open phpMyAdmin or MySQL CLI
   - Create a new database named `npk_database`
   - Run all SQL queries from the "Database Schema" section above

3. **Configure Database Connection**
   Edit `/api/connection.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', ''); // Your MySQL password
   define('DB_NAME', 'npk_database');
   ```

4. **Set Up Web Server**
   - Place the project folder in your web server's root directory
     - XAMPP: `C:/xampp/htdocs/npkity/`
     - WAMP: `C:/wamp64/www/npkity/`
     - MAMP: `/Applications/MAMP/htdocs/npkity/`

5. **Access the Application**
   - Open your browser and navigate to:
     ```
     http://localhost/npkity/
     ```

6. **Login Credentials**
   - Register a new account using the registration form

## 🖥️ Usage Guide

### Authentication
1. **Registration**: Click "Create New Account" on the login page
   - Provide email, username, and password (min 6 characters)
   - Registration will redirect you to login page
   
2. **Login**: Use your registered credentials
   - Successful login redirects to dashboard
   - Invalid credentials show error message

### Dashboard
- View key metrics in stat cards
- Monitor recent activities in the table
- Check system health indicators
- See top performing plots

### Plots Management
1. **View All Plots**: Navigate to "Plots" in sidebar
2. **Add New Plot**: Click "Add New Plot" button
   - Fill location (required) and description (optional)
   - Submit to save
3. **Edit Plot**: Click edit (pencil) icon
   - Update location/description
   - Save changes
4. **Delete Plot**: Click delete (trash) icon
   - Confirm deletion in modal
   - Uses soft delete (can be restored from database)

### Search & Filter
- Use search box to find plots by location or description
- Click "All Plots" or "Active Only" to filter
- DataTables provides pagination and sorting

## 🔐 Security Features

- **Password Security**: Uses PHP's `password_hash()` and `password_verify()`
- **SQL Injection Prevention**: Prepared statements for all database queries
- **XSS Protection**: `htmlspecialchars()` for output escaping
- **Session Management**: Secure session handling
- **CSRF Protection**: (Recommended to add tokens for production)
- **Input Validation**: Server-side validation for all user inputs

## 📝 API Documentation

### Authentication Endpoints
```
POST /api/user_login.php
POST /api/user_register.php
```

### Plot Management Endpoints
```
GET  /api/plot_list.php     # List all plots (DataTables format)
GET  /api/plot_get.php      # Get single plot by ID
POST /api/plot_create.php   # Create new plot
POST /api/plot_update.php   # Update existing plot
POST /api/plot_delete.php   # Soft delete plot
```

### Request/Response Format
All API endpoints return JSON:
```json
{
    "success": true|false,
    "message": "Status message",
    "data": {}|[] // Optional data
}
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 🙏 Acknowledgments

- [Bootstrap 5](https://getbootstrap.com/) for UI components
- [Boxicons](https://boxicons.com/) for beautiful icons
- [DataTables](https://datatables.net/) for table functionality
- [jQuery](https://jquery.com/) for JavaScript utilities

## 📞 Support

For support, please:
1. Check the troubleshooting section
2. Review browser console for errors
3. Verify database configuration
4. Create an issue in the repository

---