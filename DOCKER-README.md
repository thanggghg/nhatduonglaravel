# Nhat Duong Laravel - Docker Setup

Docker configuration cho dự án Website bán vé xe Nhật Dương.

## Stack

- **PHP:** 8.3-fpm
- **Web Server:** Nginx
- **Database:** PostgreSQL 16
- **Node:** 20 (cho Tailwind CSS)

## Yêu cầu

- Docker Desktop đã cài đặt
- Docker Compose

## Cài đặt và Chạy

### 1. Build và Start Docker Containers

```bash
docker-compose up -d --build
```

### 2. Tạo Laravel Project

```bash
docker-compose exec app composer create-project laravel/laravel .
```

### 3. Cấu hình .env

```bash
docker-compose exec app cp .env.example .env
```

Sửa database config trong `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=nhatduonglaravel
DB_USERNAME=postgres
DB_PASSWORD=postgres123
```

### 4. Generate App Key

```bash
docker-compose exec app php artisan key:generate
```

### 5. Chạy Migration

```bash
docker-compose exec app php artisan migrate
```

### 6. Install Node Dependencies

```bash
docker-compose exec node npm install
docker-compose exec node npm run build
```

## Truy cập

- **Website:** http://localhost:8000
- **Admin:** http://localhost:8000/admin (sau khi setup Filament)
- **PostgreSQL:** localhost:5432

## Lệnh Docker Thường Dùng

### Start containers
```bash
docker-compose up -d
```

### Stop containers
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f app
```

### Access app container
```bash
docker-compose exec app bash
```

### Run artisan commands
```bash
docker-compose exec app php artisan [command]
```

### Run composer
```bash
docker-compose exec app composer [command]
```

### Run npm
```bash
docker-compose exec node npm [command]
```

## Cấu trúc thư mục

```
nhatduonglaravel/
├── docker/
│   ├── nginx/
│   │   └── conf.d/
│   │       └── default.conf
│   └── php/
│       └── local.ini
├── src/                    # Laravel source code
├── docker-compose.yml
├── Dockerfile
└── DOCKER-README.md
```

## Troubleshooting

### Permission issues
```bash
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
```

### Clear cache
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Rebuild containers
```bash
docker-compose down
docker-compose up -d --build --force-recreate
```
