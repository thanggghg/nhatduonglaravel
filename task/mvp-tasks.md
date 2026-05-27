# MVP Tasks - Quick Reference

**Mục tiêu:** Phiên bản đầu tiên có thể chạy và sử dụng được

## Must Have (Bắt buộc)

### Admin CMS
- [ ] Banner management
- [ ] Post categories management
- [ ] Posts management (với rich editor)
- [ ] Routes management
- [ ] Schedules management
- [ ] Pages management (giới thiệu, hướng dẫn)
- [ ] FAQ management
- [ ] Settings management (site info, booking URL)
- [ ] Contact form submissions view

### Frontend Pages
- [ ] Trang chủ (home)
  - [ ] Hero banner
  - [ ] Featured routes
  - [ ] Latest posts
  - [ ] Booking button
  
- [ ] Trang tuyến xe
  - [ ] Danh sách tuyến (routes index)
  - [ ] Chi tiết tuyến (routes show)
  - [ ] Lịch trình
  - [ ] Điểm đón/trả
  - [ ] Booking button
  
- [ ] Trang tin tức
  - [ ] Danh sách bài viết (posts index)
  - [ ] Chi tiết bài viết (posts show)
  - [ ] Related posts
  
- [ ] Trang lịch trình (schedules index)
  - [ ] Bảng lịch trình tham khảo
  
- [ ] Trang giới thiệu (page show)
- [ ] Trang hướng dẫn đặt vé (page show)
- [ ] Trang liên hệ (contact)
  - [ ] Form liên hệ
  - [ ] Thông tin công ty

### Core Features
- [ ] Navigation menu (desktop + mobile)
- [ ] Footer với links và info
- [ ] Breadcrumb navigation
- [ ] Booking redirect functionality
- [ ] Booking click logging
- [ ] SEO meta tags (basic)
- [ ] Responsive design
- [ ] Brand colors applied (#0b7f42, #fbb116)

## Nice to Have (Nên có)

- [ ] Booking click tracking dashboard
- [ ] Advanced SEO (structured data)
- [ ] Sitemap XML
- [ ] Google Analytics integration
- [ ] Facebook Pixel integration
- [ ] Image lazy loading
- [ ] Page caching
- [ ] Search functionality
- [ ] Floating buttons on mobile
- [ ] Social share buttons

## Won't Have (Không làm trong MVP)

- [ ] Seat selection
- [ ] Payment processing
- [ ] Ticket generation
- [ ] Real-time booking management
- [ ] Ticket cancellation/refund
- [ ] Multi-language
- [ ] User registration/login
- [ ] User dashboard
- [ ] Driver management
- [ ] Vehicle fleet management
- [ ] Advanced reporting
- [ ] Email notifications (có thể có basic contact form email)

## MVP Timeline Estimate

**Total: 2-3 weeks**

- Week 1: Setup + Admin CMS (Phase 1 + 2)
- Week 2: Frontend UI (Phase 3)
- Week 3: Booking Integration + Testing (Phase 4 + 6)

*Phase 5 (SEO) có thể làm sau MVP hoặc song song*

## MVP Success Criteria

- [ ] Khách hàng có thể:
  - Xem thông tin tuyến xe
  - Xem lịch trình tham khảo
  - Đọc tin tức
  - Bấm đặt vé và được chuyển sang tool bên thứ ba
  - Gửi form liên hệ

- [ ] Admin có thể:
  - Đăng nhập admin panel
  - Quản lý tất cả nội dung (banners, posts, routes, schedules, pages)
  - Cấu hình thông tin website
  - Xem danh sách liên hệ

- [ ] Technical:
  - Website responsive trên mobile
  - Không có critical bugs
  - Basic SEO meta tags
  - Booking redirect hoạt động
  - Page load < 3s

## Post-MVP Enhancements (v2)

Priority for next version:

1. Advanced tracking dashboard
2. Google Analytics + Facebook Pixel
3. Advanced SEO (structured data, sitemap)
4. Performance optimization
5. Email notifications for contacts
6. Search functionality
7. Newsletter subscription
8. Promotional popups
9. Multi-language (if needed)
10. Mobile app (future)

## Quick Start Guide

1. Làm theo thứ tự: Phase 1 → Phase 2 → Phase 3 → Phase 4 → Phase 6
2. Phase 5 có thể làm song song hoặc sau
3. Focus vào Must Have trước
4. Test thường xuyên
5. Commit code thường xuyên
6. Deploy sớm trên staging để test

## Notes

- Ưu tiên mobile-first vì đa số khách đặt vé qua mobile
- Giữ design đơn giản và rõ ràng
- Nút "Đặt vé" phải nổi bật nhất
- Test kỹ booking redirect vì đây là chức năng core nhất
- Đảm bảo admin panel dễ sử dụng cho non-tech users
