<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'question' => 'Làm thế nào để đặt vé xe?',
            'answer' => 'Bạn có thể đặt vé xe qua website, gọi điện hotline 0123 456 789, hoặc trực tiếp tại các điểm bán vé. Đặt vé online sẽ được ưu đãi giảm giá.',
            'sort_order' => 1,
            'status' => true,
        ]);

        Faq::create([
            'question' => 'Tôi có thể hủy vé đã đặt không?',
            'answer' => 'Có, bạn có thể hủy vé trước giờ khởi hành 24 giờ để được hoàn lại 80% giá vé. Hủy trong vòng 12-24 giờ sẽ được hoàn 50%. Không hoàn tiền nếu hủy trong vòng 12 giờ trước giờ khởi hành.',
            'sort_order' => 2,
            'status' => true,
        ]);

        Faq::create([
            'question' => 'Xe có wifi không?',
            'answer' => 'Tất cả các xe của chúng tôi đều được trang bị wifi miễn phí với tốc độ cao, giúp bạn có thể làm việc hoặc giải trí suốt chuyến đi.',
            'sort_order' => 3,
            'status' => true,
        ]);

        Faq::create([
            'question' => 'Tôi được mang bao nhiêu hành lý?',
            'answer' => 'Mỗi hành khách được mang tối đa 20kg hành lý miễn phí. Hành lý quá khổ hoặc quá trọng sẽ được tính phí thêm theo quy định.',
            'sort_order' => 4,
            'status' => true,
        ]);

        Faq::create([
            'question' => 'Có điểm trung chuyển không?',
            'answer' => 'Tùy theo tuyến đường, xe sẽ có các điểm dừng chân để hành khách nghỉ ngơi, ăn uống. Thời gian dừng khoảng 15-20 phút.',
            'sort_order' => 5,
            'status' => true,
        ]);

        Faq::create([
            'question' => 'Xe có đón tận nhà không?',
            'answer' => 'Hiện tại chúng tôi chưa có dịch vụ đón tận nhà. Quý khách vui lòng đến các điểm đón đã công bố để lên xe.',
            'sort_order' => 6,
            'status' => true,
        ]);
    }
}
