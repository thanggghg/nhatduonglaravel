# Thiết kế Database

**Database Engine:** PostgreSQL

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
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(500),
    image VARCHAR(255),
    button_text VARCHAR(100),
    button_url VARCHAR(500),
    position VARCHAR(100),
    sort_order INTEGER DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 3. Bảng post_categories

```sql
CREATE TABLE post_categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 4. Bảng posts

```sql
CREATE TABLE posts (
    id BIGSERIAL PRIMARY KEY,
    post_category_id BIGINT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    thumbnail VARCHAR(255),
    summary TEXT,
    content TEXT,
    meta_title VARCHAR(255),
    meta_description VARCHAR(500),
    status VARCHAR(50) DEFAULT 'draft',
    published_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (post_category_id) REFERENCES post_categories(id) ON DELETE SET NULL
);
```

## 5. Bảng routes

```sql
CREATE TABLE routes (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    from_location VARCHAR(255) NOT NULL,
    to_location VARCHAR(255) NOT NULL,
    distance VARCHAR(100),
    estimated_time VARCHAR(100),
    price_from DECIMAL(12,2),
    image VARCHAR(255),
    description TEXT,
    booking_url VARCHAR(500),
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 6. Bảng schedules

```sql
CREATE TABLE schedules (
    id BIGSERIAL PRIMARY KEY,
    route_id BIGINT NOT NULL,
    departure_time TIME NOT NULL,
    arrival_time TIME,
    bus_type VARCHAR(255),
    price DECIMAL(12,2),
    note VARCHAR(500),
    sort_order INTEGER DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);
```

## 7. Bảng pickup_points

```sql
CREATE TABLE pickup_points (
    id BIGSERIAL PRIMARY KEY,
    route_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(500),
    map_url VARCHAR(500),
    phone VARCHAR(50),
    note VARCHAR(500),
    sort_order INTEGER DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);
```

## 8. Bảng dropoff_points

```sql
CREATE TABLE dropoff_points (
    id BIGSERIAL PRIMARY KEY,
    route_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(500),
    map_url VARCHAR(500),
    phone VARCHAR(50),
    note VARCHAR(500),
    sort_order INTEGER DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);
```

## 9. Bảng pages

```sql
CREATE TABLE pages (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT,
    meta_title VARCHAR(255),
    meta_description VARCHAR(500),
    status VARCHAR(50) DEFAULT 'published',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 10. Bảng faqs

```sql
CREATE TABLE faqs (
    id BIGSERIAL PRIMARY KEY,
    question VARCHAR(500) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INTEGER DEFAULT 0,
    status VARCHAR(50) DEFAULT 'active',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 11. Bảng contacts

```sql
CREATE TABLE contacts (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    email VARCHAR(255),
    message TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'new',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 12. Bảng booking_click_logs

```sql
CREATE TABLE booking_click_logs (
    id BIGSERIAL PRIMARY KEY,
    route_id BIGINT,
    source_page VARCHAR(255),
    booking_url VARCHAR(500),
    ip_address VARCHAR(100),
    user_agent TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE SET NULL
);
```
