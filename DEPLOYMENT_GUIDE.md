# Local Deployment Guide - Laravel Vite Project

## Status Summary

**What's Working:**
- ✅ Vite frontend dev server (running on port 5173)
- ✅ npm install completed
- ✅ Project code is correct and ready

**What Needs Fixing:**
- ❌ PHP/Composer SSL certificate issues on this Windows system
- ❌ Laravel backend server not starting (vendor dependencies missing)

---

## Solution 1: XAMPP (Recommended - Easiest)

### Steps:
1. Download XAMPP from: https://www.apachefriends.org/download.html
2. Install with default settings
3. Copy your project folder to: `C:\xampp\htdocs\laravel-project\`
4. Open XAMPP Control Panel and start:
   - Apache
   - MySQL
5. Open terminal in your project folder and run:
   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   ```
6. Configure `.env` with your database:
   ```
   DB_DATABASE=student_enrollment
   DB_USERNAME=root
   DB_PASSWORD=
   ```
7. Run migrations:
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```
8. Start development servers in separate terminals:
   - **Terminal 1:** `npm run dev`
   - **Terminal 2:** `php artisan serve`
9. Visit: http://127.0.0.1:8000

---

## Solution 2: WSL 2 (Linux Subsystem)

### Prerequisites:
- Windows 10/11 with admin access
- ~10GB free disk space

### Steps:
1. Open PowerShell as Administrator
2. Run: `wsl --install`
3. Restart computer
4. After restart, open PowerShell again and run:
   ```powershell
   wsl
   ```
5. Inside WSL terminal:
   ```bash
   cd /mnt/c/Users/Elisha\ Mae\ Managat/Documents/IT9a\ Final\ Project/laravel-final-project-student-enrollment-system
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```
6. Start servers:
   ```bash
   # Terminal 1
   npm run dev
   
   # Terminal 2
   php artisan serve --host=0.0.0.0
   ```
7. Visit: http://127.0.0.1:8000

---

## Solution 3: Docker

If you have Docker Desktop installed:

```bash
docker-compose up -d
composer install
npm install
php artisan migrate --seed
npm run dev
php artisan serve
```

---

## Troubleshooting

### "php: command not found"
- Add PHP to PATH or use full path: `C:\php\php.exe artisan serve`
- Or use XAMPP which handles this automatically

### "Composer SSL certificate error"
- This is the current issue
- Solutions: Use XAMPP, WSL 2, or run on a Linux server
- Do NOT try to disable SSL verification permanently

### "npm command not found"
- Set PowerShell execution policy: `Set-ExecutionPolicy -Scope CurrentUser RemoteSigned`
- Use `npm.cmd run dev` instead

### Database connection error
- Ensure MySQL is running (XAMPP Control Panel if using XAMPP)
- Verify `.env` DB_* settings match your database credentials
- Default XAMPP: username=root, password=empty

---

## Quick Reference: Key Commands

```bash
# Install dependencies
composer install
npm install

# Setup
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

# Development
npm run dev              # Terminal 1: Vite frontend
php artisan serve       # Terminal 2: Laravel backend

# Production build
npm run build
php artisan config:cache
php artisan route:cache
```

---

## Project Structure
```
laravel-final-project-student-enrollment-system/
├── app/                    (PHP code - models, controllers)
├── resources/views/        (Blade templates)
├── resources/css/          (Tailwind/app.css)
├── resources/js/           (JavaScript)
├── database/migrations/    (Database schema)
├── routes/web.php          (URL routes)
├── vite.config.js          (Vite configuration)
├── package.json            (npm dependencies)
├── composer.json           (PHP dependencies)
└── .env                    (Configuration - create from .env.example)
```

---

## Notes

- The Vite server on port 5173 is currently running and ready
- Frontend assets are hot-reloading in development mode
- You still need to complete the Composer install step (solutions above)
- The project is 100% ready once dependencies are installed

For questions, refer to Laravel docs: https://laravel.com/docs
