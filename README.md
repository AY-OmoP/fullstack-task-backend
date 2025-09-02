# 🚀 Fullstack Task — Backend (CodeIgniter 4 + JWT)

This is the backend for the Fullstack Developer task.  
Built with **CodeIgniter 4**, featuring **JWT authentication**, migrations, seeders, and a single-POST insert into `auth_user` + `teachers`.

---

## ✨ Features

- 🔑 JWT-based authentication (`firebase/php-jwt`)
- 👤 Register/Login
- 🔒 Protected routes for Users & Teachers
- 🏫 Teachers table with 1–1 relation to Users
- 🗄️ Migrations & seeders included
- 📦 Database export file: [`sql/export.sql`](./sql/export.sql)

---

## ⚙️ Tech Stack

- PHP 8.x
- CodeIgniter 4
- MySQL (default) or PostgreSQL
- Composer

---

## 🛠️ Setup & Run

### 1. Clone repo & install dependencies

```bash
git clone https://github.com/AY-OmoP/fullstack-task-backend.git
cd fullstack-task-backend
composer install
```
