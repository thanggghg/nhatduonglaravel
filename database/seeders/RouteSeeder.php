<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Schedule;
use App\Models\PickupPoint;
use App\Models\DropoffPoint;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Route 1: Sài Gòn - Đà Lạt
        $route1 = Route::create([
            'name' => 'Sài Gòn - Đà Lạt',
            'slug' => 'sai-gon-da-lat',
            'from_location' => 'TP. Hồ Chí Minh',
            'to_location' => 'Đà Lạt',
            'distance' => 308,
            'estimated_time' => '7-8 giờ',
            'price_from' => 200000,
            'description' => 'Tuyến xe cao cấp từ Sài Gòn đi Đà Lạt với xe giường nằm chất lượng cao, điều hòa mát lạnh, wifi miễn phí. Khởi hành đúng giờ, đảm bảo an toàn tuyệt đối.',
            'booking_url' => 'https://example.com/book',
            'status' => true,
        ]);

        // Schedules for Route 1
        Schedule::create([
            'route_id' => $route1->id,
            'departure_time' => '06:00',
            'arrival_time' => '13:30',
            'bus_type' => 'Giường nằm VIP',
            'price' => 250000,
            'sort_order' => 1,
            'status' => true,
        ]);

        Schedule::create([
            'route_id' => $route1->id,
            'departure_time' => '22:00',
            'arrival_time' => '05:30',
            'bus_type' => 'Giường nằm VIP',
            'price' => 250000,
            'sort_order' => 2,
            'status' => true,
        ]);

        // Pickup Points for Route 1
        PickupPoint::create([
            'route_id' => $route1->id,
            'name' => 'Bến xe Miền Đông',
            'address' => '292 Đinh Bộ Lĩnh, P.26, Q.Bình Thạnh, TP.HCM',
            'phone' => '028 3899 3333',
            'sort_order' => 1,
            'status' => true,
        ]);

        PickupPoint::create([
            'route_id' => $route1->id,
            'name' => 'Bến xe An Sương',
            'address' => 'QL22, An Sương, Q.12, TP.HCM',
            'phone' => '028 3899 4444',
            'sort_order' => 2,
            'status' => true,
        ]);

        // Dropoff Points for Route 1
        DropoffPoint::create([
            'route_id' => $route1->id,
            'name' => 'Bến xe Đà Lạt',
            'address' => '1 Tô Hiến Thành, Phường 3, TP. Đà Lạt',
            'phone' => '0263 3822 895',
            'sort_order' => 1,
            'status' => true,
        ]);

        // Route 2: Sài Gòn - Nha Trang
        $route2 = Route::create([
            'name' => 'Sài Gòn - Nha Trang',
            'slug' => 'sai-gon-nha-trang',
            'from_location' => 'TP. Hồ Chí Minh',
            'to_location' => 'Nha Trang',
            'distance' => 450,
            'estimated_time' => '9-10 giờ',
            'price_from' => 220000,
            'description' => 'Tuyến xe đi Nha Trang chất lượng cao với giường nằm êm ái, phục vụ chu đáo. Dừng nghỉ tại các điểm dừng chân tiện nghi.',
            'booking_url' => 'https://example.com/book',
            'status' => true,
        ]);

        Schedule::create([
            'route_id' => $route2->id,
            'departure_time' => '07:00',
            'arrival_time' => '16:30',
            'bus_type' => 'Giường nằm cao cấp',
            'price' => 280000,
            'sort_order' => 1,
            'status' => true,
        ]);

        Schedule::create([
            'route_id' => $route2->id,
            'departure_time' => '21:00',
            'arrival_time' => '06:30',
            'bus_type' => 'Giường nằm VIP',
            'price' => 300000,
            'sort_order' => 2,
            'status' => true,
        ]);

        PickupPoint::create([
            'route_id' => $route2->id,
            'name' => 'Bến xe Miền Đông',
            'address' => '292 Đinh Bộ Lĩnh, P.26, Q.Bình Thạnh, TP.HCM',
            'phone' => '028 3899 3333',
            'sort_order' => 1,
            'status' => true,
        ]);

        DropoffPoint::create([
            'route_id' => $route2->id,
            'name' => 'Bến xe Nha Trang',
            'address' => '23 Tháng 10, Phường Phước Long, TP. Nha Trang',
            'phone' => '0258 3812 586',
            'sort_order' => 1,
            'status' => true,
        ]);

        // Route 3: Sài Gòn - Vũng Tàu
        $route3 = Route::create([
            'name' => 'Sài Gòn - Vũng Tàu',
            'slug' => 'sai-gon-vung-tau',
            'from_location' => 'TP. Hồ Chí Minh',
            'to_location' => 'Vũng Tàu',
            'distance' => 125,
            'estimated_time' => '2-2.5 giờ',
            'price_from' => 120000,
            'description' => 'Tuyến xe đi Vũng Tàu nhanh chóng, tiện lợi với nhiều chuyến trong ngày. Xe limousine cao cấp, ghế massage thư giãn.',
            'booking_url' => 'https://example.com/book',
            'status' => true,
        ]);

        Schedule::create([
            'route_id' => $route3->id,
            'departure_time' => '06:00',
            'arrival_time' => '08:30',
            'bus_type' => 'Limousine',
            'price' => 150000,
            'sort_order' => 1,
            'status' => true,
        ]);

        Schedule::create([
            'route_id' => $route3->id,
            'departure_time' => '08:00',
            'arrival_time' => '10:30',
            'bus_type' => 'Limousine',
            'price' => 150000,
            'sort_order' => 2,
            'status' => true,
        ]);

        Schedule::create([
            'route_id' => $route3->id,
            'departure_time' => '14:00',
            'arrival_time' => '16:30',
            'bus_type' => 'Limousine',
            'price' => 150000,
            'sort_order' => 3,
            'status' => true,
        ]);

        PickupPoint::create([
            'route_id' => $route3->id,
            'name' => 'Bến xe Miền Đông',
            'address' => '292 Đinh Bộ Lĩnh, P.26, Q.Bình Thạnh, TP.HCM',
            'phone' => '028 3899 3333',
            'sort_order' => 1,
            'status' => true,
        ]);

        DropoffPoint::create([
            'route_id' => $route3->id,
            'name' => 'Bến xe Vũng Tàu',
            'address' => '52 Nam Kỳ Khởi Nghĩa, P.Thắng Tam, TP. Vũng Tàu',
            'phone' => '0254 3859 627',
            'sort_order' => 1,
            'status' => true,
        ]);

        // Route 4: Sài Gòn - Phan Thiết
        $route4 = Route::create([
            'name' => 'Sài Gòn - Phan Thiết',
            'slug' => 'sai-gon-phan-thiet',
            'from_location' => 'TP. Hồ Chí Minh',
            'to_location' => 'Phan Thiết',
            'distance' => 200,
            'estimated_time' => '4-5 giờ',
            'price_from' => 150000,
            'description' => 'Tuyến xe đi Phan Thiết - Mũi Né với dịch vụ chuyên nghiệp, xe mới, sạch sẽ, tài xế giàu kinh nghiệm.',
            'booking_url' => 'https://example.com/book',
            'status' => true,
        ]);

        Schedule::create([
            'route_id' => $route4->id,
            'departure_time' => '07:00',
            'arrival_time' => '11:30',
            'bus_type' => 'Giường nằm',
            'price' => 180000,
            'sort_order' => 1,
            'status' => true,
        ]);

        Schedule::create([
            'route_id' => $route4->id,
            'departure_time' => '15:00',
            'arrival_time' => '19:30',
            'bus_type' => 'Giường nằm',
            'price' => 180000,
            'sort_order' => 2,
            'status' => true,
        ]);

        PickupPoint::create([
            'route_id' => $route4->id,
            'name' => 'Bến xe Miền Đông',
            'address' => '292 Đinh Bộ Lĩnh, P.26, Q.Bình Thạnh, TP.HCM',
            'phone' => '028 3899 3333',
            'sort_order' => 1,
            'status' => true,
        ]);

        DropoffPoint::create([
            'route_id' => $route4->id,
            'name' => 'Bến xe Phan Thiết',
            'address' => 'Đường Tú Mỡ, Phường Phú Thủy, TP. Phan Thiết',
            'phone' => '0252 3821 234',
            'sort_order' => 1,
            'status' => true,
        ]);
    }
}
