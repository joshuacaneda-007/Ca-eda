# AnimeTracker — Profile Picture (Base64) & Deployment Guide

## How Base64 Image Storage Works

Instead of saving uploaded images as files on disk (which disappear on Railway/Heroku
container restarts), the image is converted to a Base64 string and stored directly in
the `users.profile_picture_base64` database column.

### Flow

```
User uploads image → PHP reads binary → base64_encode() → prepend data URI scheme
→ store full string in DB → render with <img src="data:image/jpeg;base64,...">
```

### Data URI format stored
```
data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAA...
```

This string is used directly as the `src` attribute of `<img>` tags — no file system needed.

---

## Files Changed

| File | Change |
|------|--------|
| `database/migrations/2024_01_02_000001_add_profile_picture_base64_to_users.php` | Adds `profile_picture_base64 longtext nullable` column |
| `app/Models/User.php` | Added `profile_picture_base64` to `$fillable` |
| `app/Http/Controllers/ProfileController.php` | Converts upload to base64, stores in DB |
| `resources/views/layouts/app.blade.php` | Topbar avatar uses base64 |
| `resources/views/users/index.blade.php` | User table avatars use base64 |
| `resources/views/profile/show.blade.php` | Profile avatar uses base64 + live preview |

---

## Validation Rules (ProfileController)

```php
'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
```

- Only JPEG/JPG/PNG accepted
- Maximum 2 MB per upload
- Optional — existing picture kept if no new file uploaded

---

## Local Development Setup

```bash
# 1. Clone / open project
cd your-project

# 2. Install dependencies
composer install

# 3. Copy env and set DB credentials
cp .env.example .env
# Edit DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 4. Generate app key
php artisan key:generate

# 5. Run migrations + seed
php artisan migrate --seed

# 6. Create storage symlink (for any legacy file paths)
php artisan storage:link

# 7. Serve
php artisan serve
```

Login: `admin@animetracker.com` / `password`

---

## Railway Deployment Steps

1. Push your code to GitHub
2. Create a new Railway project → "Deploy from GitHub repo"
3. Add a **MySQL** plugin in Railway dashboard
4. Set these environment variables in Railway:

```
APP_KEY=base64:your-key-here        # php artisan key:generate --show
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=<railway-mysql-host>
DB_PORT=3306
DB_DATABASE=<railway-db-name>
DB_USERNAME=<railway-db-user>
DB_PASSWORD=<railway-db-password>

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

5. Add a start command in `railway.json` or Procfile:

```
# Procfile
web: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

6. Deploy — profile pictures now survive restarts because they live in MySQL, not on disk.

---

## Why NOT file storage on Railway

| File Storage | Base64 in DB |
|---|---|
| Files deleted on container restart | Persists in MySQL forever |
| Requires S3/R2 setup | Zero external services |
| Needs `storage:link` | Works out of the box |
| Fast for large files | Fine for avatars (< 2MB) |

For production at scale, consider migrating to **AWS S3** or **Cloudflare R2**,
but for a student project or small app, base64-in-DB is perfectly reliable.
