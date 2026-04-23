# 🛡️ ComplaintHub — Complaint Management System

## 📌 Project Overview

ComplaintHub is a web-based complaint management system that allows users to submit complaints, track their status, and enables administrators to manage and resolve them efficiently.

---

## 🚀 Features

### 👤 User Features

* User Registration & Login
* Secure Authentication (Password Hashing)
* File Complaint with details
* Upload attachments (image/pdf)
* Track complaint status
* Session-based navigation
* Logout functionality

---

### 🛠️ Admin Features

* Admin Dashboard
* View all complaints
* Update complaint status (Pending / Resolved / Rejected)
* View total users & complaints
* Manage complaint lifecycle

---

## 🔄 Workflow

### User Flow

1. Register → Login
2. Submit Complaint
3. Upload Attachment (optional)
4. Complaint stored in database
5. Track complaint status

### Admin Flow

1. Login as Admin
2. View all complaints
3. Update complaint status
4. Changes reflected to users

---

## 🧠 Backend Flow

* Form submission → Input validation & sanitization
* Data stored using MySQLi prepared statements
* Passwords stored using hashing (`password_hash`)
* Sessions used for authentication
* File uploads handled via `move_uploaded_file()`

---

## 🗄️ Database Structure

### Users Table

* id (Primary Key)
* name
* email (Unique)
* phone
* password (hashed)
* created_at

### Complaints Table

* id (Primary Key)
* name
* email
* title
* category
* priority
* description
* attachment (file path)
* status (Pending / Resolved / Rejected)
* created_at

---

## 🖥️ Tech Stack

* Frontend: HTML, CSS
* Backend: PHP
* Database: MySQL
* Server: Apache (MAMP/XAMPP)

---

## 📁 Project Structure

```
complaint-system/
│
├── config.php
├── index.php
├── login.php
├── register.php
├── complaint.php
├── admin.php
├── update_status.php
├── logout.php
│
├── navbar.php
├── footer.php
│
├── uploads/
├── css/
│   └── style.css
```

---

## ⚙️ Setup Instructions

1. Install MAMP/XAMPP
2. Place project in `htdocs`
3. Start Apache & MySQL
4. Create database:

   ```
   CREATE DATABASE complaint_system;
   ```
5. Import tables
6. Update `config.php` with DB credentials
7. Run project:

   ```
   http://localhost/complaint-system/
   ```

---

## 🔐 Security Measures

* Input sanitization (`htmlspecialchars`)
* SQL Injection prevention (prepared statements)
* Password hashing (`password_hash`)
* Session-based authentication
* File type validation for uploads

---

## ⚠️ Limitations

* Basic admin authentication
* No email notifications
* No pagination/search
* Not deployed on cloud

---

## 🚀 Future Enhancements

* Role-based authentication (Admin/User)
* Email notifications
* Advanced dashboard with charts
* AJAX-based updates
* Cloud deployment

---

## 🎯 Conclusion

ComplaintHub simplifies complaint handling by providing a centralized platform for users and administrators, ensuring transparency, efficiency, and better resolution management.

---

## 👨‍💻 Author

Vinay

---
