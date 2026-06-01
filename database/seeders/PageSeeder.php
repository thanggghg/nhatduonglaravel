<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::create([
            'title' => 'Về Chúng Tôi',
            'slug' => 've-chung-toi',
            'content' => '<h2>Giới Thiệu Về Nhà Xe Nhật Dương</h2>
<p>Nhà Xe Nhật Dương được thành lập từ năm 2010 với mục tiêu mang đến dịch vụ vận chuyển hành khách chất lượng cao, an toàn và tin cậy.</p>

<h3>Sứ Mệnh</h3>
<p>Chúng tôi cam kết mang đến trải nghiệm di chuyển tốt nhất cho khách hàng với dịch vụ chuyên nghiệp, xe hiện đại và đội ngũ nhân viên tận tâm.</p>

<h3>Tầm Nhìn</h3>
<p>Trở thành đơn vị vận tải hành khách hàng đầu Việt Nam, được khách hàng tin tưởng và lựa chọn.</p>

<h3>Giá Trị Cốt Lõi</h3>
<ul>
<li><strong>An Toàn:</strong> Đặt an toàn của khách hàng lên hàng đầu</li>
<li><strong>Chất Lượng:</strong> Không ngừng nâng cao chất lượng dịch vụ</li>
<li><strong>Tận Tâm:</strong> Phục vụ khách hàng với trái tim</li>
<li><strong>Tin Cậy:</strong> Xây dựng lòng tin qua từng chuyến đi</li>
</ul>

<h3>Đội Xe Hiện Đại</h3>
<p>Toàn bộ đội xe của Nhà Xe Nhật Dương đều là xe mới, được trang bị đầy đủ tiện nghi: điều hòa, wifi, ghế massage, giường nằm cao cấp.</p>

<h3>Liên Hệ</h3>
<p>Hotline: 1900 2879<br>Email: info@nhatduong.com<br>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>',
            'status' => true,
        ]);

        Page::create([
            'title' => 'Chính Sách Bảo Mật',
            'slug' => 'chinh-sach-bao-mat',
            'content' => '<h2>Chính Sách Bảo Mật Thông Tin</h2>

<h3>1. Thu Thập Thông Tin</h3>
<p>Chúng tôi thu thập thông tin cá nhân khi bạn đặt vé, bao gồm: họ tên, số điện thoại, email, địa chỉ.</p>

<h3>2. Sử Dụng Thông Tin</h3>
<p>Thông tin của bạn được sử dụng để:</p>
<ul>
<li>Xử lý đơn đặt vé</li>
<li>Liên hệ xác nhận và thông báo</li>
<li>Cải thiện dịch vụ</li>
<li>Gửi thông tin khuyến mãi (nếu bạn đồng ý)</li>
</ul>

<h3>3. Bảo Mật Thông Tin</h3>
<p>Chúng tôi cam kết bảo mật thông tin cá nhân của bạn. Thông tin sẽ được mã hóa và lưu trữ an toàn.</p>

<h3>4. Chia Sẻ Thông Tin</h3>
<p>Chúng tôi không chia sẻ thông tin cá nhân của bạn cho bên thứ ba, trừ khi có yêu cầu pháp lý.</p>

<h3>5. Quyền Của Bạn</h3>
<p>Bạn có quyền yêu cầu xem, sửa đổi hoặc xóa thông tin cá nhân của mình bất cứ lúc nào.</p>',
            'status' => true,
        ]);

        Page::create([
            'title' => 'Điều Khoản Sử Dụng',
            'slug' => 'dieu-khoan-su-dung',
            'content' => '<h2>Điều Khoản Sử Dụng Dịch Vụ</h2>

<h3>1. Đặt Vé</h3>
<p>Khi đặt vé, quý khách cần cung cấp thông tin chính xác và đầy đủ.</p>

<h3>2. Thanh Toán</h3>
<p>Quý khách có thể thanh toán online hoặc trả tiền khi lên xe. Vé đã thanh toán sẽ được xác nhận qua email/SMS.</p>

<h3>3. Hủy Vé</h3>
<ul>
<li>Hủy trước 24 giờ: Hoàn 80% giá vé</li>
<li>Hủy trong 12-24 giờ: Hoàn 50% giá vé</li>
<li>Hủy trong vòng 12 giờ: Không hoàn tiền</li>
</ul>

<h3>4. Hành Lý</h3>
<p>Mỗi khách được mang 20kg hành lý miễn phí. Hành lý quá cước sẽ tính phí thêm.</p>

<h3>5. Trách Nhiệm</h3>
<p>Quý khách có mặt tại điểm đón đúng giờ. Nhà xe không chịu trách nhiệm nếu khách đến muộn.</p>

<h3>6. An Toàn</h3>
<p>Vui lòng tuân thủ quy định an toàn và hướng dẫn của nhân viên trong suốt chuyến đi.</p>',
            'status' => true,
        ]);
    }
}
