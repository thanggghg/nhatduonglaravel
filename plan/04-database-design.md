# Thiết kế Database

## 1. Danh sách bảng chính

```text
users
roles
permissions
banners
post_categories
posts
routes
schedules
pickup_points
dropoff_points
pages
faqs
settings
contacts
booking_click_logs
```

## 2. Bảng banners

```sql
CREATE TABLE banners (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(500) NULL,
    image VARCHAR(255) NULL,
    button_text VARCHAR(100) NULL,
    button_url VARCHAR(500) NULL,
    position VARCHAR(100) NULL,
    sort_order INT DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 3. Bảng post_categories

```sql
CREATE TABLE post_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 4. Bảng posts

```sql
CREATE TABLE posts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_category_id BIGINT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    thumbnail VARCHAR(255) NULL,
    summary TEXT NULL,
    content LONGTEXT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description VARCHAR(500) NULL,
    status VARCHAR(50) DEFAULT 'draft',
    published_at DATETIME NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (post_category_id) REFERENCES post_categories(id) ON DELETE SET NULL
);
```

## 5. Bảng routes

```sql
CREATE TABLE routes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    from_location VARCHAR(255) NOT NULL,
    to_location VARCHAR(255) NOT NULL,
    distance VARCHAR(100) NULL,
    estimated_time VARCHAR(100) NULL,
    price_from DECIMAL(12,2) NULL,
    image VARCHAR(255) NULL,
    description LONGTEXT NULL,
    booking_url VARCHAR(500) NULL,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 6. Bảng schedules

```sql
CREATE TABLE schedules (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    route_id BIGINT UNSIGNED NOT NULL,
    departure_time TIME NOT NULL,
    arrival_time TIME NULL,
    bus_type VARCHAR(255) NULL,
    price DECIMAL(12,2) NULL,
    note VARCHAR(500) NULL,
    sort_order INT DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);
```

## 7. Bảng pickup_points

```sql
CREATE TABLE pickup_points (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    route_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(500) NULL,
    map_url VARCHAR(500) NULL,
    phone VARCHAR(50) NULL,
    note VARCHAR(500) NULL,
    sort_order INT DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);
```

## 8. Bảng dropoff_points

```sql
CREATE TABLE dropoff_points (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    route_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(500) NULL,
    map_url VARCHAR(500) NULL,
    phone VARCHAR(50) NULL,
    note VARCHAR(500) NULL,
    sort_order INT DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);
```

## 9. Bảng pages

```sql
CREATE TABLE pages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description VARCHAR(500) NULL,
    status VARCHAR(50) DEFAULT 'published',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 10. Bảng faqs

```sql
CREATE TABLE faqs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(500) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 11. Bảng contacts

```sql
CREATE TABLE contacts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NULL,
    email VARCHAR(255) NULL,
    message TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'new',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 12. Bảng booking_click_logs

```sql
CREATE TABLE booking_click_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    route_id BIGINT UNSIGNED NULL,
    source_page VARCHAR(255) NULL,
    booking_url VARCHAR(500) NULL,
    ip_address VARCHAR(100) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE SET NULL
);
```
