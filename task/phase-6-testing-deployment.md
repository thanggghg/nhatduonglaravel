# Phase 6: Kiểm thử và Deploy

**Mục tiêu:** Đảm bảo website hoạt động ổn định và deploy lên production

**Timeline:** 2-3 ngày

## Tasks

### 6.1 Testing Checklist

#### Functional Testing

**Homepage**
- [ ] Banner slider hiển thị đúng
- [ ] Nút đặt vé hoạt động
- [ ] Tuyến xe nổi bật hiển thị
- [ ] Tin tức mới nhất hiển thị
- [ ] Footer links hoạt động

**Navigation**
- [ ] Menu desktop hoạt động
- [ ] Menu mobile hoạt động
- [ ] Breadcrumb hiển thị đúng trên mọi trang
- [ ] Active state cho menu items

**Posts**
- [ ] Danh sách bài viết phân trang đúng
- [ ] Chi tiết bài viết hiển thị đầy đủ
- [ ] Bài viết liên quan hiển thị
- [ ] Danh mục filter hoạt động
- [ ] SEO meta tags hiển thị đúng

**Routes**
- [ ] Danh sách tuyến xe hiển thị
- [ ] Chi tiết tuyến xe hiển thị đầy đủ
- [ ] Lịch trình hiển thị
- [ ] Điểm đón/trả hiển thị
- [ ] FAQs hiển thị
- [ ] Nút đặt vé hoạt động
- [ ] SEO meta tags hiển thị đúng

**Schedules**
- [ ] Bảng lịch trình hiển thị đúng
- [ ] Filter theo tuyến hoạt động
- [ ] Responsive trên mobile

**Contact**
- [ ] Form validation hoạt động
- [ ] Submit form thành công
- [ ] Success message hiển thị
- [ ] Data lưu vào database
- [ ] Email notification gửi (nếu có)
- [ ] Google Map embed hiển thị

**Booking**
- [ ] Click nút đặt vé redirect đúng
- [ ] Log được ghi nhận
- [ ] Route_id truyền đúng
- [ ] Source_page truyền đúng
- [ ] Floating buttons trên mobile hoạt động

**Admin Panel**
- [ ] Login/logout hoạt động
- [ ] Dashboard hiển thị stats
- [ ] CRUD banners hoạt động
- [ ] CRUD posts hoạt động
- [ ] CRUD routes hoạt động
- [ ] CRUD schedules hoạt động
- [ ] CRUD pages hoạt động
- [ ] Upload images hoạt động
- [ ] Slug auto-generate hoạt động
- [ ] Filters và search hoạt động

#### Responsive Testing

**Desktop (1920x1080)**
- [ ] Layout hiển thị đúng
- [ ] Images không bị vỡ
- [ ] Menu hoạt động

**Tablet (768x1024)**
- [ ] Layout adapt đúng
- [ ] Menu mobile hoạt động
- [ ] Tables responsive

**Mobile (375x667)**
- [ ] Layout mobile-friendly
- [ ] Text readable
- [ ] Buttons tap-able
- [ ] Floating buttons hoạt động
- [ ] Forms dễ sử dụng

#### Browser Testing

- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Safari (iOS)
- [ ] Chrome Mobile (Android)

#### SEO Testing

- [ ] All pages có meta title
- [ ] All pages có meta description
- [ ] Open Graph tags hoạt động (test bằng Facebook Debugger)
- [ ] Twitter Card tags hoạt động
- [ ] Sitemap XML accessible
- [ ] Robots.txt accessible
- [ ] Structured data valid (Google Rich Results Test)
- [ ] No broken links
- [ ] No 404 errors

#### Performance Testing

- [ ] PageSpeed Insights score > 80
- [ ] Images optimized
- [ ] CSS/JS minified
- [ ] Caching hoạt động
- [ ] No slow queries
- [ ] Load time < 3s

#### Security Testing

- [ ] Admin panel chỉ accessible với auth
- [ ] CSRF protection hoạt động
- [ ] SQL injection prevention
- [ ] XSS prevention
- [ ] Form validation đầy đủ
- [ ] No sensitive data exposed

### 6.2 Bug Fixing

- [ ] Tạo danh sách bugs tìm được
- [ ] Ưu tiên bugs theo mức độ nghiêm trọng
- [ ] Fix critical bugs trước
- [ ] Test lại sau khi fix
- [ ] Document bugs và solutions

### 6.3 Pre-Deployment Preparation

#### Environment Configuration

- [ ] Setup `.env` cho production
  - APP_ENV=production
  - APP_DEBUG=false
  - APP_URL (production domain)
  - DB credentials
  - MAIL credentials
  - BOOKING_TOOL_URL
  - GA_MEASUREMENT_ID
  - FB_PIXEL_ID

- [ ] Generate new APP_KEY: `php artisan key:generate`
- [ ] Review all config files

#### Optimization

- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `php artisan optimize`
- [ ] Set up queue worker (nếu dùng queue)

#### Database

- [ ] Backup local database
- [ ] Test migrations trên fresh database
- [ ] Prepare seeders cho production data
- [ ] Document database schema

### 6.4 Deployment

#### Server Setup

**Requirements:**
- [ ] PHP 8.2+
- [ ] Composer
- [ ] PostgreSQL 14+
- [ ] Nginx/Apache
- [ ] SSL certificate
- [ ] Node.js & npm (để build assets)

**Server Configuration:**
- [ ] Setup web server (Nginx/Apache)
- [ ] Configure document root to `/public`
- [ ] Enable rewrite rules
- [ ] Configure PHP-FPM
- [ ] Set proper file permissions (755 for folders, 644 for files)
- [ ] Set storage và cache writable

**Example Nginx Config:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/nhatduonglaravel/public;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    
    index index.php;
    
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Deployment Steps

1. **Upload Code**
   - [ ] Clone repository hoặc upload via FTP
   - [ ] `git clone https://github.com/thanggghg/nhatduonglaravel.git`
   - [ ] `cd nhatduonglaravel`

2. **Install Dependencies**
   - [ ] `composer install --optimize-autoloader --no-dev`
   - [ ] `npm install && npm run build` (nếu có)

3. **Setup Environment**
   - [ ] Copy `.env.example` to `.env`
   - [ ] Update `.env` với production credentials (PostgreSQL)
   - [ ] `php artisan key:generate`

**Example Production .env:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nhatduonglaravel_prod
DB_USERNAME=postgres
DB_PASSWORD=secure_password
```

4. **Database Setup**
   - [ ] Create production PostgreSQL database: `CREATE DATABASE nhatduonglaravel_prod;`
   - [ ] `php artisan migrate --force`
   - [ ] `php artisan db:seed --force` (nếu có)

5. **Storage Setup**
   - [ ] `php artisan storage:link`
   - [ ] Set permissions: `chmod -R 775 storage bootstrap/cache`

6. **Optimization**
   - [ ] `php artisan config:cache`
   - [ ] `php artisan route:cache`
   - [ ] `php artisan view:cache`

7. **Queue Worker (Optional)**
   - [ ] Setup supervisor để chạy queue worker
   - [ ] `php artisan queue:work --daemon`

8. **SSL Setup**
   - [ ] Install SSL certificate (Let's Encrypt)
   - [ ] Configure HTTPS redirect
   - [ ] Update APP_URL to https

9. **Test Deployment**
   - [ ] Visit homepage
   - [ ] Test all major functionalities
   - [ ] Test admin login
   - [ ] Test booking redirect
   - [ ] Check for errors in logs

### 6.5 Post-Deployment

#### Monitoring

- [ ] Setup error monitoring (Sentry, Bugsnag)
- [ ] Setup uptime monitoring (UptimeRobot, Pingdom)
- [ ] Monitor server resources (CPU, RAM, Disk)
- [ ] Monitor database performance

#### Backup

- [ ] Setup automated database backups (daily)
- [ ] Setup automated file backups (weekly)
- [ ] Test restore procedure
- [ ] Store backups off-site

#### Documentation

- [ ] Document deployment process
- [ ] Document server credentials
- [ ] Document admin credentials
- [ ] Create user manual for admin panel
- [ ] Create maintenance guide

#### Go Live

- [ ] Update DNS records to point to new server
- [ ] Wait for DNS propagation (24-48h)
- [ ] Monitor traffic and errors
- [ ] Announce launch to stakeholders

### 6.6 Maintenance

- [ ] Setup maintenance mode: `php artisan down`
- [ ] Create backup before updates
- [ ] Test updates on staging first
- [ ] Run migrations: `php artisan migrate`
- [ ] Clear caches after updates
- [ ] Exit maintenance mode: `php artisan up`

## Acceptance Criteria

- [ ] Website accessible via production domain
- [ ] HTTPS enabled and working
- [ ] All functionalities tested and working
- [ ] No critical bugs
- [ ] Admin panel accessible
- [ ] Booking redirect working
- [ ] SEO properly configured
- [ ] Analytics tracking active
- [ ] Mobile responsive
- [ ] PageSpeed score > 80
- [ ] Backups configured
- [ ] Monitoring setup

## Notes

- Always test on staging before deploying to production
- Keep deployment checklist handy
- Document any issues and solutions
- Prepare rollback plan in case of critical failures
