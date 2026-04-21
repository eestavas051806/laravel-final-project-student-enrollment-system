# EduEnroll – Student Enrollment System

A web-based Student Enrollment System built with **Laravel 12** and **Bootstrap 5**,
following the coding conventions of the `laravel-app-fresh` example project.

**IT Professional Track 3 IT9a/L Subject**
Project Leader: Elisha Mae M. Estavas
University of Mindanao – Davao Campus

---

## Features

| Screen | Route | Description |
|---|---|---|
| Login | `/login` | Student authentication |
| Register | `/register` | New student registration with ID photo |
| Dashboard | `/dashboard` | Enrolled subjects, units, fee summary |
| Subject Enrollment | `/enroll` | Add / remove subjects, confirm enrollment |
| Subjects Browse | `/subjects` | View all available subjects with filters |

---

## Tech Stack

- **Backend** – Laravel 12 (PHP 8.2+)
- **Database** – MySQL (configurable via `.env`)
- **Frontend** – Bootstrap 5.3 via CDN + DM Sans / DM Serif Display fonts
- **Architecture** – MVC with Resource Controllers, Blade templates, session-based auth
- **Design** – Red & white two-tone theme matching the Figma prototype

---

## Local Setup

### Requirements
- PHP 8.2+
- Composer
- MySQL 8+
- Node.js 18+ (for Vite)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/student-enrollment-system.git
cd student-enrollment-system

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Copy environment file and configure
cp .env.example .env
php artisan key:generate

# 5. Set up your database in .env
#    DB_DATABASE=student_enrollment_system
#    DB_USERNAME=root
#    DB_PASSWORD=your_password

# 6. Run migrations and seed sample data
php artisan migrate --seed

# 7. Link storage for ID photo uploads
php artisan storage:link

# 8. Start the development server
php artisan serve
```

Visit: **http://localhost:8000**

---

## Demo Login

After seeding, use these credentials to log in immediately:

| Field | Value |
|---|---|
| Email | `demo@student.edu.ph` |
| Password | `password` |

---

## Project Structure

```
student-enrollment-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php        ← login, register, logout
│   │   ├── DashboardController.php   ← student dashboard
│   │   ├── SubjectController.php     ← browse subjects
│   │   └── EnrollmentController.php  ← add/remove/confirm enrollment
│   └── Models/
│       ├── Student.php
│       ├── Subject.php
│       └── Enrollment.php
├── database/
│   ├── migrations/                   ← students, subjects, enrollments tables
│   └── seeders/DatabaseSeeder.php    ← 15 sample subjects + 1 demo student
├── resources/views/
│   ├── layout/app.blade.php          ← main Bootstrap 5 layout with red navbar
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── dashboard.blade.php
│   ├── enrollments/index.blade.php
│   └── subjects/index.blade.php
└── routes/web.php                    ← all named routes
```

---

## Database Schema

```
students       → id, first_name, last_name, middle_name, date_of_birth,
                  gender, contact_number, complete_address, email, password,
                  course, year_level, student_id, id_photo, is_enrolled

subjects       → id, code, name, units, schedule, department, year_level,
                  max_slots, fee_per_unit, description, is_active

enrollments    → id, student_id (FK), subject_id (FK),
                  academic_year, semester, status
```

---

## Coding Conventions

This project follows the same patterns established in `laravel-app-fresh`:

- **Models** – `$fillable` array, minimal Eloquent relationships
- **Controllers** – validation inside controller methods, named route redirects
- **Routes** – `routes/web.php` only; closures for simple routes, full controllers for feature routes
- **Views** – `@extends('layout.app')` + `@section('content')`, inline `<style>` per view, Bootstrap grid
- **Design** – Red (`#96281b` / `#c0392b`) + White two-tone, DM Serif Display headings
