# PHP-User-Management-System-CRUD-model-one

A complete PHP/MySQL CRUD application for managing user records with server-side validation and Bootstrap 5 UI.

## Features
- ➕ Add new users with validation
- 👁️ View user details
- ✏️ Update existing users
- 🗑️ Delete users
- ✅ Server-side validation with error messages
- 🔍 Duplicate phone/email checking
- 💾 Input persistence after validation errors
- 🎨 Bootstrap 5 responsive design
- 📱 Font Awesome icons
- ⚡ Session-based flash messages

## Requirements
- PHP 7.0 or higher
- MySQL/MariaDB
- Web server (Apache/Nginx)

## Installation
1. Import `crud_two.sql` to your database
2. Configure database connection in `conn.php`
3. Run the project on your local server

## Database Structure
- **Database:** crud_two
- **Table:** users
- **Fields:** id, first_name, last_name, phone, email, gender, created_at

## Technologies Used
- PHP (MySQLi)
- MySQL
- Bootstrap 5
- Font Awesome 6
- HTML5/CSS3
