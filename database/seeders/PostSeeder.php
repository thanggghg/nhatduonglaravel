<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tinTuc = PostCategory::where('slug', 'tin-tuc')->first();
        $khuyenMai = PostCategory::where('slug', 'khuyen-mai')->first();
        $huongDan = PostCategory::where('slug', 'huong-dan')->first();
        $kinhNghiem = PostCategory::where('slug', 'kinh-nghiem-du-lich')->first();

        // Tin tức
        Post::create([
            'post_category_id' => $tinTuc->id,
            'title' => 'Nhà Xe Nhật Dương Chính Thức Khai Trương Tuyến Sài Gòn - Đà Lạt',
            'slug' => 'nha-xe-nhat-duong-chinh-thuc-khai-truong-tuyen-sai-gon-da-lat',
            'summary' => 'Nhà Xe Nhật Dương trân trọng thông báo chính thức khai trương tuyến xe cao cấp Sài Gòn - Đà Lạt với chất lượng dịch vụ hàng đầu.',
            'content' => '<p>Sau thời gian chuẩn bị kỹ lưỡng, Nhà Xe Nhật Dương chính thức khai trương tuyến xe cao cấp Sài Gòn - Đà Lạt với cam kết mang đến trải nghiệm di chuyển tốt nhất cho khách hàng.</p><p>Xe giường nằm VIP với đầy đủ tiện nghi: điều hòa mát lạnh, wifi miễn phí, nước uống, chăn gối sạch sẽ. Tài xế giàu kinh nghiệm, đảm bảo an toàn tuyệt đối.</p>',
            'published_at' => now()->subDays(2),
            'status' => true,
        ]);

        Post::create([
            'post_category_id' => $tinTuc->id,
            'title' => 'Nâng Cấp Chất Lượng Dịch Vụ - Xe Mới, Tiện Nghi Cao Cấp',
            'slug' => 'nang-cap-chat-luong-dich-vu-xe-moi-tien-nghi-cao-cap',
            'summary' => 'Nhà Xe Nhật Dương đầu tư hàng tỷ đồng mua sắm xe mới, nâng cấp toàn bộ đội xe để phục vụ khách hàng tốt hơn.',
            'content' => '<p>Trong năm 2026, Nhà Xe Nhật Dương đã đầu tư mạnh mẽ vào việc nâng cấp chất lượng dịch vụ. Toàn bộ đội xe được thay mới với những chiếc xe cao cấp nhất hiện nay.</p><p>Mỗi chiếc xe đều được trang bị hệ thống giải trí hiện đại, ghế massage thư giãn, và không gian rộng rãi thoải mái.</p>',
            'published_at' => now()->subDays(5),
            'status' => true,
        ]);

        // Khuyến mãi
        Post::create([
            'post_category_id' => $khuyenMai->id,
            'title' => 'Ưu Đãi Đặc Biệt Tháng 5 - Giảm Giá 20% Toàn Bộ Tuyến Xe',
            'slug' => 'uu-dai-dac-biet-thang-5-giam-gia-20-toan-bo-tuyen-xe',
            'summary' => 'Chương trình khuyến mãi lớn nhất trong năm! Giảm giá 20% cho tất cả các tuyến xe khi đặt vé online.',
            'content' => '<p>Nhân dịp khai trương tuyến mới, Nhà Xe Nhật Dương triển khai chương trình ưu đãi đặc biệt trong tháng 5/2026:</p><ul><li>Giảm 20% giá vé cho tất cả tuyến xe</li><li>Tặng thêm voucher 50.000đ cho lần đặt vé tiếp theo</li><li>Miễn phí nước uống và bánh snack trên xe</li></ul><p>Áp dụng cho vé đặt online từ ngày 27/05 đến 31/05/2026.</p>',
            'published_at' => now()->subDay(),
            'status' => true,
        ]);

        Post::create([
            'post_category_id' => $khuyenMai->id,
            'title' => 'Chương Trình Khách Hàng Thân Thiết - Tích Điểm Đổi Quà',
            'slug' => 'chuong-trinh-khach-hang-than-thiet-tich-diem-doi-qua',
            'summary' => 'Ra mắt chương trình khách hàng thân thiết với nhiều ưu đãi hấp dẫn. Đặt vé càng nhiều, nhận quà càng lớn!',
            'content' => '<p>Nhà Xe Nhật Dương trân trọng giới thiệu chương trình Khách Hàng Thân Thiết với nhiều ưu đãi đặc biệt:</p><ul><li>Tích 1 điểm cho mỗi 100.000đ chi tiêu</li><li>Đổi điểm lấy vé miễn phí hoặc giảm giá</li><li>Ưu tiên đặt chỗ trong dịp cao điểm</li><li>Quà tặng sinh nhật đặc biệt</li></ul>',
            'published_at' => now()->subDays(3),
            'status' => true,
        ]);

        // Hướng dẫn
        Post::create([
            'post_category_id' => $huongDan->id,
            'title' => 'Hướng Dẫn Đặt Vé Xe Online Nhanh Chóng Và Đơn Giản',
            'slug' => 'huong-dan-dat-ve-xe-online-nhanh-chong-va-don-gian',
            'summary' => 'Chỉ với 4 bước đơn giản, bạn đã có thể đặt vé xe online một cách dễ dàng và nhanh chóng.',
            'content' => '<p>Đặt vé xe online tại Nhà Xe Nhật Dương vô cùng đơn giản:</p><h3>Bước 1: Chọn tuyến xe</h3><p>Truy cập website, chọn tuyến xe bạn muốn di chuyển</p><h3>Bước 2: Chọn giờ khởi hành</h3><p>Lựa chọn giờ xuất bến phù hợp với lịch trình của bạn</p><h3>Bước 3: Điền thông tin</h3><p>Cung cấp thông tin cá nhân: họ tên, số điện thoại, email</p><h3>Bước 4: Thanh toán</h3><p>Thanh toán online hoặc trả tiền khi lên xe</p>',
            'published_at' => now()->subDays(7),
            'status' => true,
        ]);

        // Kinh nghiệm du lịch
        Post::create([
            'post_category_id' => $kinhNghiem->id,
            'title' => '10 Địa Điểm Check-in Đẹp Nhất Đà Lạt Năm 2026',
            'slug' => '10-dia-diem-check-in-dep-nhat-da-lat-nam-2026',
            'summary' => 'Khám phá 10 địa điểm check-in siêu đẹp tại Đà Lạt, từ cổ điển đến hiện đại, đảm bảo ảnh sống ảo triệu like!',
            'content' => '<p>Đà Lạt không chỉ nổi tiếng với khí hậu mát mẻ mà còn có vô số địa điểm check-in tuyệt đẹp:</p><ol><li>Đồi chè Cầu Đất - Tầm nhìn bao quát toàn thành phố</li><li>Ga Đà Lạt - Kiến trúc cổ điển Pháp</li><li>Vườn hoa thành phố - Hoa nở quanh năm</li><li>Hồ Xuân Hương - Lãng mạn buổi hoàng hôn</li><li>Quán Gió Đà Lạt - View đẹp uống cafe</li></ol><p>Đừng quên đặt vé xe Nhật Dương để có chuyến đi trọn vẹn nhé!</p>',
            'published_at' => now()->subDays(4),
            'status' => true,
        ]);

        Post::create([
            'post_category_id' => $kinhNghiem->id,
            'title' => 'Kinh Nghiệm Du Lịch Nha Trang Tiết Kiệm Cho Sinh Viên',
            'slug' => 'kinh-nghiem-du-lich-nha-trang-tiet-kiem-cho-sinh-vien',
            'summary' => 'Hướng dẫn chi tiết cách du lịch Nha Trang với ngân sách tiết kiệm dành cho sinh viên và học sinh.',
            'content' => '<p>Du lịch Nha Trang không cần tốn kém! Dưới đây là kinh nghiệm tiết kiệm chi phí:</p><h3>Đi lại:</h3><p>Đặt vé xe khách trước để được giá tốt hơn. Nhà Xe Nhật Dương thường có chương trình ưu đãi sinh viên.</p><h3>Ăn uống:</h3><p>Ăn ở các quán bình dân, quán lề đường. Giá cả phải chăng, món ăn ngon.</p><h3>Tham quan:</h3><p>Nhiều bãi biển công cộng miễn phí vé. Vinpearland có thể mua combo tiết kiệm.</p>',
            'published_at' => now()->subDays(6),
            'status' => true,
        ]);
    }
}
