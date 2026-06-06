# Student Accommodation Management Website

A complete web-based platform for managing student housing with features for students, landlords, and administrators.

## Features

### For Students
- ✅ User registration and login
- ✅ Browse accommodation listings
- ✅ Search and filter properties
- ✅ View property details
- ✅ Apply for accommodations online
- ✅ Track application status
- ✅ Personal dashboard

### For Landlords
- ✅ User registration and login
- ✅ Add and manage property listings
- ✅ Edit property details and status
- ✅ View student applications
- ✅ Approve or reject applications
- ✅ Landlord dashboard

### For Administrators
- ✅ Secure admin login
- ✅ Manage all users
- ✅ Manage all properties
- ✅ View and manage applications
- ✅ Manage contact messages
- ✅ System overview and statistics

## Requirements

- XAMPP (Apache, MySQL, PHP)
- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5
- Modern web browser

## Installation Steps

### 1. Setup XAMPP
- Download and install XAMPP from https://www.apachefriends.org/
- Start Apache and MySQL services

### 2. Extract Project Files
- Extract the project folder to: `C:\xampp\htdocs\` (Windows) or `/Applications/XAMPP/htdocs/` (Mac)
- Folder should be: `C:\xampp\htdocs\student-accommodation\`

### 3. Create Database
- Open phpMyAdmin: http://localhost/phpmyadmin
- Create a new database named `student_accommodation`
- Import the `database.sql` file:
  - Go to Import tab
  - Select `database.sql` file
  - Click Import

### 4. Configure Database Connection
- Edit `config/db.php` if your database credentials are different
- Default credentials:
  - Host: localhost
  - Username: root
  - Password: (empty)
  - Database: student_accommodation

### 5. Access the Website
- Open browser and visit: http://localhost/student-accommodation
- You're done! 🎉

## Default Demo Accounts

### Student Account
- Email: `student@example.com`
- Password: `password`

### Landlord Account
- Email: `landlord@example.com`
- Password: `password`

### Admin Account
- Email: `admin@accommodation.com`
- Password: `password`

## Folder Structure

```
student-accommodation/
├── assets/
│   ├── css/style.css          # Main stylesheet
│   ├── js/script.js           # Client-side validation
│   └── images/                # Image storage
├── config/
│   └── db.php                 # Database configuration
├── includes/
│   ├── header.php             # Header with navbar
│   ├── footer.php             # Footer
│   └── auth_check.php         # Authentication functions
├── admin/                      # Admin pages
│   ├── dashboard.php
│   ├── users.php
│   ├── properties.php
│   ├── applications.php
│   └── messages.php
├── landlord/                   # Landlord pages
│   ├── dashboard.php
│   ├── add_property.php
│   ├── edit_property.php
│   └── manage_properties.php
├── student/                    # Student pages
│   └── dashboard.php
├── uploads/                    # Property images storage
├── index.php                   # Home page
├── register.php                # Registration page
├── login.php                   # Login page
├── logout.php                  # Logout handler
├── listings.php                # Browse listings
├── property_details.php        # Property details
├── apply.php                   # Apply for property
├── contact.php                 # Contact form
├── database.sql                # Database schema
└── README.md                   # This file
```

## Key Features

### Authentication & Security
- Password hashing using PHP password_hash()
- Session-based authentication
- Role-based access control
- Input validation and sanitization

### User Roles
1. **Student**: Can browse, search, and apply for accommodations
2. **Landlord**: Can list properties and manage applications
3. **Admin**: Can manage the entire system

### Database Tables
- `users`: User accounts
- `properties`: Property listings
- `applications`: Student applications
- `messages`: Contact form messages

## Usage Tips

1. **For Students**: Browse listings, apply for rooms, track application status
2. **For Landlords**: Add properties, manage listings, review applications
3. **For Admins**: Monitor system, manage users and content

## Security Features Implemented

- ✅ Password hashing (PHP password_hash)
- ✅ Prepared statements for SQL injection prevention
- ✅ Input validation and sanitization
- ✅ Session-based authentication
- ✅ Role-based access restrictions
- ✅ CSRF protection through form validation

## Browser Compatibility

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers

## Responsive Design

- ✅ Desktop (1200px+)
- ✅ Tablet (768px - 1199px)
- ✅ Mobile (< 768px)

## Future Enhancements

- Payment integration
- Email notifications
- Advanced search filters
- Property ratings and reviews
- Chat system between users
- Document upload functionality

## Support

For issues or questions:
1. Check the database configuration in `config/db.php`
2. Verify all files are in the correct folders
3. Ensure XAMPP services are running
4. Clear browser cache if experiencing issues

## License

This is a educational project for learning purposes.

## Credits

Built with:
- HTML5, CSS3, JavaScript
- PHP 7.4+
- MySQL
- Bootstrap 5
- XAMPP

---

**Last Updated:** 2024
**Version:** 1.0
