# 🏠 Student Accommodation Management System

<p align="center">

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

</p>

> A complete **Student Accommodation Management System** developed using **PHP, MySQL, Bootstrap, HTML, CSS, and JavaScript** that simplifies the process of searching, listing, and managing student rental accommodations. The system provides dedicated portals for **Students, Landlords, and Administrators**, enabling seamless property management and accommodation booking.

---

# 📖 Table of Contents

- Overview
- Features
- Technology Stack
- System Modules
- Project Structure
- Installation
- Database Setup
- User Roles
- Screenshots
- Security Features
- Future Enhancements
- License

---

# 📌 Overview

The **Student Accommodation Management System** is a web-based platform designed to simplify the accommodation search process for students while providing landlords with an efficient way to manage their rental properties.

The application enables:

- Students to browse available accommodations
- Landlords to publish and manage rental listings
- Administrators to monitor and manage the complete platform

The system provides an intuitive and responsive interface suitable for desktop, tablet, and mobile devices.

---

# ✨ Features

## 👨‍🎓 Student Module

- Student Registration
- Secure Login
- Browse Available Properties
- Search Accommodation Listings
- Property Details Page
- Online Accommodation Application
- Track Application Status
- Personal Dashboard

---

## 🏡 Landlord Module

- Landlord Registration
- Secure Login
- Add New Property
- Upload Property Images
- Edit Property Details
- Manage Property Listings
- View Student Applications
- Accept / Reject Applications
- Landlord Dashboard

---

## 👨‍💼 Admin Module

- Secure Admin Authentication
- Dashboard Analytics
- User Management
- Property Management
- Application Management
- Contact Message Management
- Complete System Monitoring

---

# 🚀 Technology Stack

## Frontend

- HTML5
- CSS3
- Bootstrap 5
- JavaScript

## Backend

- PHP

## Database

- MySQL

## Development Environment

- XAMPP / WAMP / LAMP

---

# 📂 Project Structure

```text
student-accommodation/
│
├── admin/
│   ├── dashboard.php
│   ├── users.php
│   ├── properties.php
│   ├── applications.php
│   └── messages.php
│
├── landlord/
│   ├── dashboard.php
│   ├── add_property.php
│   ├── edit_property.php
│   └── manage_properties.php
│
├── student/
│   └── dashboard.php
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── config/
│   └── db.php
│
├── includes/
│
├── uploads/
│
├── database.sql
├── index.php
├── login.php
├── register.php
├── listings.php
├── property_details.php
├── apply.php
├── contact.php
└── README.md
```

---

# ⚙️ Installation Guide

## 1. Clone Repository

```bash
git clone https://github.com/yourusername/student-accommodation.git
```

or download the ZIP.

---

## 2. Move Project

Copy the project folder into

```
xampp/htdocs/
```

Example

```
C:\xampp\htdocs\student-accommodation
```

---

## 3. Start XAMPP

Start

- Apache
- MySQL

---

## 4. Create Database

Open

```
http://localhost/phpmyadmin
```

Create a database named

```
student_accommodation
```

Import

```
database.sql
```

---

## 5. Configure Database

Edit

```
config/db.php
```

Example

```php
Host     : localhost
Username : root
Password : 
Database : student_accommodation
```

---

## 6. Run Project

Open your browser

```
http://localhost/student-accommodation
```

---

# 👥 User Roles

## 🎓 Student

- Register/Login
- Search Properties
- View Details
- Apply for Accommodation
- Track Applications

---

## 🏠 Landlord

- Login
- Add Properties
- Edit Listings
- Remove Listings
- Review Applications

---

## 👨‍💼 Administrator

- Manage Users
- Manage Properties
- Manage Applications
- View Messages
- Monitor Entire Platform

---

# 🗄 Database Tables

The project includes the following tables:

- users
- properties
- applications
- messages

---

# 🔒 Security Features

✔ Password Hashing

✔ Session Authentication

✔ Role-Based Access

✔ Input Validation

✔ SQL Injection Prevention using Prepared Statements

✔ Secure Login System

✔ Form Validation

---

# 📱 Responsive Design

Supports

- Desktop
- Laptop
- Tablet
- Mobile Devices

---

# 📸 Screenshots

# 📸 Screenshots

## 🏠 1. Home Page
<img width="1355" alt="Landlord Home" src="https://github.com/user-attachments/assets/2e45c7b8-c09e-4670-b6ae-f146f27e04a5" />

---

## 📝 2. User Registration
<img width="1348" alt="Registration Page" src="https://github.com/user-attachments/assets/078b88b1-3a9d-45a3-8fe8-844670fc0ad9" />

---

## 🔐 3. Login Page
<img width="1354" alt="Login Page" src="https://github.com/user-attachments/assets/a284fe13-76a4-46bf-9630-1471c1d479c7" />

---

## 🏡 4. Property Listings
<img width="1356" alt="Property Listings" src="https://github.com/user-attachments/assets/8ad72478-2805-4795-afeb-fe44ffb0845b" />

---

## 📋 5. Booking / Order Page
<img width="1354" alt="Order Page" src="https://github.com/user-attachments/assets/c1402e1e-fcbd-429d-9729-c5f293758cea" />

---

## 📞 6. Contact Page
<img width="1345" alt="Contact Page" src="https://github.com/user-attachments/assets/c7e6a2a8-9128-4e66-8aad-7b7ce5a9e5ff" />

---

## 👤 7. User Dashboard
<img width="1355" alt="User Dashboard" src="https://github.com/user-attachments/assets/cc39bb74-42de-4fcc-9a23-d8c06d1f9d72" />

---

## 🛠️ 8. Admin Dashboard
<img width="1350" alt="Admin Dashboard" src="https://github.com/user-attachments/assets/d20d64dc-7d48-40b6-a8fc-d7a84c99ce92" />

---

## 👥 9. Admin User Management
<img width="1366" alt="Admin User Management" src="https://github.com/user-attachments/assets/daee672b-2f31-436f-8dd3-d80af037ffbb" />
---

# 💡 Future Improvements

- Payment Gateway Integration
- Online Rent Payment
- Email Notifications
- SMS Notifications
- Property Reviews
- Google Maps Integration
- Chat System
- Document Upload
- AI-based Property Recommendation
- Advanced Search Filters

---

# 🎯 Learning Outcomes

This project demonstrates knowledge of

- PHP Development
- CRUD Operations
- Authentication Systems
- MySQL Database Design
- Session Management
- Bootstrap Responsive Design
- File Upload Handling
- Role-Based Access Control

---

# 🛠 Requirements

- PHP 7.4+
- MySQL 5.7+
- Apache Server
- XAMPP/WAMP/LAMP
- Modern Web Browser

---

# 🤝 Contributing

Contributions are welcome.

1. Fork the repository

2. Create a feature branch

```bash
git checkout -b feature-name
```

3. Commit changes

```bash
git commit -m "Added new feature"
```

4. Push branch

```bash
git push origin feature-name
```

5. Open a Pull Request

---

# ⭐ Show Your Support

If you found this project helpful, please consider giving it a ⭐ on GitHub.

---

# 📄 License

This project is developed for **educational and learning purposes**.

Feel free to modify and enhance it for academic or personal use.

---

# 👨‍💻 Author

**Prajwal T.S.**

GitHub: https://github.com/yourusername
LinkedIn: https://www.linkedin.com/in/prajwal-t-s-354a57359

---

<p align="center">
Made with ❤️ using PHP, MySQL, Bootstrap and JavaScript
</p>
