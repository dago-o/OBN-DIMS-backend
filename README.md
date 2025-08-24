# 📦 ODIMS Backend (PHP + MySQL)

This repository contains the backend system of OBN-DIMS (OBN Digital Infrustructure Management System) developed using PHP and MySQL. 
It supports all core backend functionality such as device management, user authentication, engineer and admin roles, request handling, and database interaction.

## 📚 Requirements

- PHP 7.4 or above

- MySQL 5.7 or above

- Server(Appache on XAMPP)

- Postman (for API testing - optional)

## ⬇️ Installation & Setup Guide
###  📁 1. Clone the Backend Repository
Backend Repository: https://github.com/dago-o/OBN-DIMS-backend.git

⚠️ Important:
Make sure you have folder path like below in the htdocs folder:
"C:\xampp\htdocs\projects_and_practices\projects\OBN_project"

cd C:\xampp\htdocs\projects_and_practices\projects\OBN_project
git clone https://github.com/dago-o/OBN-DIMS-backend.git
cd OBN-DIMS-backend

###  📁 2. Import the Database

- Open phpMyAdmin or use the MySQL CLI.

- Create a database (e.g., obn_dims).

- Import the database.sql file:

### Via phpMyAdmin:

- Go to your database

- Click "Import"

- Select the database.sql file from the repository

- Click "Go"
✅ The database.sql file contains all required tables and sample data.

###  📁 3. Configure the Database Connection

Open /connection.php and update with your credentials if any change needed:

$host = "localhost";
$user = "root";
$password = "";
$database = "obn_dims";

###  📁 4. Run your one Backend file for testing








