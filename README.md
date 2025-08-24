# 📦 ODIMS Backend (PHP + MySQL)

This repository contains the backend system of **OBN-DIMS (OBN Digital Infrastructure Management System)** developed using **PHP and MySQL**.  
It supports all core backend functionality such as:

- Device management  
- User authentication  
- Engineer and admin roles  
- Request handling  
- Database interaction  

---

## 📚 Requirements

- PHP 7.4 or above  
- MySQL 5.7 or above  
- Server (Apache via XAMPP recommended)  
- Postman (for API testing - optional)

---

## ⬇️ Installation & Setup Guide

### 📁 1. Clone the Backend Repository

Repository URL:  https://github.com/dago-o/OBN-DIMS-backend.git

⚠️ **Important:**  
Ensure your folder path inside `htdocs` is like below:

C:\xampp\htdocs\projects_and_practices\projects\OBN_project


Then run the following commands:

```bash
cd C:\xampp\htdocs\projects_and_practices\projects\OBN_project
git clone https://github.com/dago-o/OBN-DIMS-backend.git
cd OBN-DIMS-backend

### 📁 2. Import the Database

You can use phpMyAdmin or MySQL CLI.

Steps:

Open phpMyAdmin

Create a new database (e.g., obn_dims)

Import the database.sql file from the cloned repository

💡 Via phpMyAdmin:

Go to your created database

Click Import

Choose the database.sql file

Click Go

✅ The database.sql file contains all required tables and sample data.

### 📁 3. Configure the Database Connection

Open the file:
/connection.php

Ensure the following credentials are set correctly:

$host = "localhost";
$user = "root";
$password = "";
$database = "obn_dims";


Change them based on your local server configuration if needed.

📁 4. Run Your Backend Files

Place your PHP files in the /OBN-DIMS-backend folder

Use your browser and go to:
http://localhost/projects_and_practices/projects/OBN_project/OBN-DIMS-backend/notification.php (for test only).

🤝 Contributors

Degefa Lemma (Full-stack Developer)
