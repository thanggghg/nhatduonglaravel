# Phase 5: SEO và Tracking

**Mục tiêu:** Tối ưu hiển thị Google và đo lường hiệu quả

**Timeline:** 2-3 ngày

## Tasks

### 5.1 SEO Optimization

#### Meta Tags Setup
- [ ] Cài đặt artesaos/seotools (nếu chưa có)
- [ ] Setup SEOManager trong AppServiceProvider
- [ ] Tạo helper function cho SEO trong BaseController

#### Homepage SEO
- [ ] Meta title: "Xe khách Nhật Dương - Đặt vé xe chất lượng cao"
- [ ] Meta description: mô tả ngắn gọn về dịch vụ
- [ ] Open Graph tags (og:title, og:description, og:image)
- [ ] Twitter Card tags
- [ ] Canonical URL

#### Posts SEO
- [ ] Dynamic meta title từ post.meta_title hoặc post.title
- [ ] Dynamic meta description từ post.meta_description hoặc post.summary
- [ ] Open Graph image từ post.thumbnail
- [ ] Article structured data (Schema.org)
- [ ] Author meta tag
- [ ] Published date meta tag
- [ ] Canonical URL

#### Routes SEO
- [ ] Dynamic meta title: "{route.name} - Xe khách Nhật Dương"
- [ ] Dynamic meta description từ route.description
- [ ] Open Graph image từ route.image
- [ ] LocalBusiness structured data (Schema.org)
- [ ] BusTrip structured data
- [ ] Breadcrumb structured data
- [ ] Canonical URL

#### Pages SEO
- [ ] Dynamic meta title và description cho mỗi page
- [ ] Open Graph tags
- [ ] Canonical URL

### 5.2 Sitemap & Robots

#### Sitemap XML
- [ ] Cài spatie/laravel-sitemap hoặc tạo manual
- [ ] Tạo route `/sitemap.xml`
- [ ] Include homepage
- [ ] Include all published posts
- [ ] Include all active routes
- [ ] Include all pages
- [ ] Set priority và changefreq
- [ ] Cache sitemap

#### Robots.txt
- [ ] Tạo file `public/robots.txt`
- [ ] Allow all pages
- [ ] Disallow admin: `/admin`
- [ ] Disallow private: `/booking-redirect`
- [ ] Add sitemap URL

**Example:**
```text
User-agent: *
Disallow: /admin
Disallow: /booking-redirect
Allow: /

Sitemap: https://yourdomain.com/sitemap.xml
```

### 5.3 Google Analytics

#### Setup GA4
- [ ] Tạo Google Analytics property
- [ ] Lấy Measurement ID (G-XXXXXXXXXX)
- [ ] Thêm GA_MEASUREMENT_ID vào `.env`
- [ ] Thêm script GA trong SettingResource admin
- [ ] Inject GA script vào layout

**Code:**
```html
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

#### Event Tracking
- [ ] Track button "Đặt vé" clicks
- [ ] Track route view events
- [ ] Track post view events
- [ ] Track form submissions

**Example Event:**
```javascript
gtag('event', 'booking_click', {
  'event_category': 'Booking',
  'event_label': 'Route: HCM - Dalat',
  'value': route_id
});
```

### 5.4 Facebook Pixel

#### Setup FB Pixel
- [ ] Tạo Facebook Pixel trong Business Manager
- [ ] Lấy Pixel ID
- [ ] Thêm FB_PIXEL_ID vào `.env`
- [ ] Thêm script FB Pixel trong SettingResource admin
- [ ] Inject FB Pixel script vào layout

**Code:**
```html
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', 'YOUR_PIXEL_ID');
fbq('track', 'PageView');
</script>
```

#### Event Tracking
- [ ] Track ViewContent (route detail)
- [ ] Track InitiateCheckout (booking button click)
- [ ] Track Lead (contact form submission)

### 5.5 Google Search Console

#### Setup GSC
- [ ] Verify domain ownership
- [ ] Submit sitemap
- [ ] Monitor indexing status
- [ ] Check for crawl errors
- [ ] Request indexing for key pages

### 5.6 Performance Optimization

#### Image Optimization
- [ ] Compress images before upload
- [ ] Implement lazy loading for images
- [ ] Use WebP format
- [ ] Set proper width/height attributes
- [ ] Use CDN (optional)

#### Page Speed
- [ ] Minify CSS and JS
- [ ] Enable browser caching
- [ ] Compress responses (Gzip)
- [ ] Optimize database queries
- [ ] Use Laravel caching for routes and config

**Commands:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Mobile Optimization
- [ ] Test on Google Mobile-Friendly Test
- [ ] Optimize viewport settings
- [ ] Ensure text is readable without zoom
- [ ] Ensure tap targets are sized appropriately

### 5.7 Schema Markup (Structured Data)

#### Organization Schema
- [ ] Add to footer or homepage
- [ ] Include: name, logo, url, contactPoint, sameAs (social)

#### LocalBusiness Schema
- [ ] Add to homepage
- [ ] Include: name, address, telephone, openingHours

#### BusTrip Schema
- [ ] Add to route detail pages
- [ ] Include: departureStation, arrivalStation, provider

#### BreadcrumbList Schema
- [ ] Add to all pages with breadcrumbs
- [ ] Dynamic based on page hierarchy

### 5.8 Admin SEO Tools

#### SEO Dashboard Widget
- [ ] Show posts without meta description
- [ ] Show routes without meta description
- [ ] Show broken images
- [ ] Show duplicate meta titles

#### SEO Checklist in Admin
- [ ] Reminder to fill meta tags
- [ ] Character count for title (50-60)
- [ ] Character count for description (150-160)
- [ ] Image alt text checker

## Acceptance Criteria

- [ ] Tất cả trang có meta title và description
- [ ] Open Graph tags hiển thị đúng khi share lên social media
- [ ] Sitemap XML accessible tại `/sitemap.xml`
- [ ] Robots.txt configured properly
- [ ] Google Analytics tracking hoạt động
- [ ] Facebook Pixel tracking hoạt động
- [ ] Structured data validation pass (Google Rich Results Test)
- [ ] Page speed score > 80 (PageSpeed Insights)
- [ ] Mobile-friendly test pass
- [ ] No crawl errors in Google Search Console

## Notes

- Test SEO bằng các tools: Google Rich Results Test, Facebook Debugger, Twitter Card Validator
- Monitor Google Search Console thường xuyên
- Regularly check Analytics for insights
- A/B test meta descriptions for better CTR
