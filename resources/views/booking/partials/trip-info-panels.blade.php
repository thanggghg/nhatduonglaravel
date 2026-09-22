@php
    $text = [
        'vi' => [
            'discount' => 'Giảm giá', 'original' => 'Giá gốc', 'sale' => 'Giá khuyến mãi', 'saved' => 'Bạn tiết kiệm', 'no_discount' => 'Chuyến này hiện chưa áp dụng khuyến mãi.',
            'pickup' => 'Điểm đón', 'dropoff' => 'Điểm trả', 'time' => 'Giờ', 'no_points' => 'Nhà xe chưa công bố điểm cụ thể cho chuyến này.',
            'reviews' => 'đánh giá', 'no_reviews' => 'Chưa có nhận xét chi tiết từ VeXeRe cho chuyến này.',
            'cancellation' => 'Hoàn / hủy vé', 'payment' => 'Thanh toán', 'e_ticket' => 'Vé điện tử', 'deposit' => 'Đặt cọc', 'no_policy' => 'Nhà xe chưa công bố chính sách này trên VeXeRe.',
            'no_images' => 'Nhà xe chưa cập nhật thêm hình ảnh cho chuyến này.', 'free' => 'Miễn phí', 'no_amenities' => 'Chưa có danh sách tiện ích cho chuyến này.',
        ],
        'en' => [
            'discount' => 'Discount', 'original' => 'Original fare', 'sale' => 'Promotional fare', 'saved' => 'You save', 'no_discount' => 'No promotion currently applies to this departure.',
            'pickup' => 'Pickup points', 'dropoff' => 'Drop-off points', 'time' => 'Time', 'no_points' => 'The operator has not published specific points for this departure.',
            'reviews' => 'reviews', 'no_reviews' => 'VeXeRe has no detailed comments for this departure.',
            'cancellation' => 'Refund / cancellation', 'payment' => 'Payment', 'e_ticket' => 'E-ticket', 'deposit' => 'Deposit', 'no_policy' => 'The operator has not published this policy on VeXeRe.',
            'no_images' => 'The operator has not added more images for this departure.', 'free' => 'Free', 'no_amenities' => 'No amenities are listed for this departure.',
        ],
        'ru' => [
            'discount' => 'Скидка', 'original' => 'Обычная цена', 'sale' => 'Цена со скидкой', 'saved' => 'Экономия', 'no_discount' => 'На этот рейс сейчас нет акции.',
            'pickup' => 'Места посадки', 'dropoff' => 'Места высадки', 'time' => 'Время', 'no_points' => 'Перевозчик не указал точки для этого рейса.',
            'reviews' => 'отзывов', 'no_reviews' => 'На VeXeRe нет подробных отзывов об этом рейсе.',
            'cancellation' => 'Возврат / отмена', 'payment' => 'Оплата', 'e_ticket' => 'Электронный билет', 'deposit' => 'Депозит', 'no_policy' => 'Перевозчик не опубликовал эту политику на VeXeRe.',
            'no_images' => 'Перевозчик не добавил фотографии этого рейса.', 'free' => 'Бесплатно', 'no_amenities' => 'Для этого рейса удобства не указаны.',
        ],
    ][$locale];
    $discount = $originalFare > $fare ? (int) round((1 - ($fare / $originalFare)) * 100) : 0;
    $operatorPolicy = [
        'vi' => [
            'title' => 'Chính sách nhà xe',
            'sections' => [
                ['title' => 'Chính sách trẻ em', 'paragraphs' => ['Bé từ 6 tuổi (sinh năm 2020) được tính là 1 khách. Một người lớn đi kèm bé 6 tuổi phải mua vé phòng đôi hoặc tách thành 2 phòng riêng.'], 'bullets' => ['Từ 5 tuổi trở xuống (tính theo năm sinh): miễn phí.', 'Từ 6 tuổi trở lên: phải mua vé như người lớn.']],
                ['title' => 'Thời gian trung chuyển và thời gian đến', 'paragraphs' => ['Khách đặt vé từ Quận 1 cho chuyến khởi hành từ 05:30 đến 22:00 phải có mặt trước giờ hiển thị 1 tiếng để đi xe trung chuyển ghế ngồi ra bãi xe Quận 2 hoặc Bến xe Miền Đông mới, sau đó lên xe khách giường nằm.', 'Chuyến khởi hành ban ngày có thể đến muộn từ 1–2 giờ so với lịch trình dự kiến.']],
                ['title' => 'Hành lý', 'paragraphs' => ['Phòng đơn: dưới 30 kg. Phòng đôi: dưới 40 kg.']],
                ['title' => 'Khách nước ngoài', 'paragraphs' => ['Vui lòng cung cấp số WhatsApp và kiểm tra email thường xuyên để công ty có thể liên hệ.']],
                ['title' => 'Kích thước và tải trọng giường', 'paragraphs' => ['Giường đôi: dài 178 cm, rộng 85 cm, tải trọng tối đa 130 kg/giường.', 'Phòng đơn nhỏ tầng dưới cuối xe 6D dài 167 cm.']],
                ['title' => 'Động vật cảnh', 'paragraphs' => ['Nhà xe không nhận vận chuyển động vật cảnh hoặc thú cưng.']],
                ['title' => 'Hành khách vị thành niên', 'paragraphs' => ['Trẻ vị thành niên dưới 16 tuổi phải có cha mẹ hoặc người giám hộ đi kèm.']],
                ['title' => 'Hủy hoặc dời vé ngày thường', 'paragraphs' => ['Không áp dụng trước, trong và sau các kỳ nghỉ lễ.'], 'periods' => [
                    ['title' => 'Trước giờ khởi hành trên 24 giờ', 'bullets' => ['Hủy vé miễn phí.', 'Dời vé miễn phí 1 lần.']],
                    ['title' => 'Từ 6 đến 24 giờ trước giờ khởi hành', 'bullets' => ['Phí hủy: 30% giá trị vé.', 'Vé giá gốc được dời 1 lần.', 'Vé sử dụng coupon được dời với điều kiện thanh toán phần chênh lệch về vé giá gốc.']],
                    ['title' => 'Dưới 6 giờ trước giờ khởi hành', 'bullets' => ['Phí hủy: 100% giá trị vé, không được hủy.', 'Không được dời vé.']],
                ], 'note' => 'Vé sử dụng mã giảm giá, coupon hoặc thuộc chương trình khuyến mãi không áp dụng chính sách hủy vé.'],
            ],
            'thanks' => 'Xin cảm ơn quý khách.',
        ],
        'en' => [
            'title' => 'Operator policy',
            'sections' => [
                ['title' => 'Child policy', 'paragraphs' => ['Children aged 6 (born in 2020) count as one passenger. One adult travelling with a 6-year-old child must book a double cabin or two separate cabins.'], 'bullets' => ['Children aged 5 and under (calculated by birth year): free of charge.', 'Children aged 6 and over: an adult ticket is required.']],
                ['title' => 'Shuttle and arrival times', 'paragraphs' => ['Passengers booking from District 1 on departures between 05:30 and 22:00 must arrive one hour before the displayed time to take the seated shuttle to the District 2 parking area or the new Mien Dong Bus Station, where they will board the sleeper bus.', 'Daytime departures may arrive 1–2 hours later than the estimated schedule.']],
                ['title' => 'Luggage', 'paragraphs' => ['Single cabin: under 30 kg. Double cabin: under 40 kg.']],
                ['title' => 'International passengers', 'paragraphs' => ['Please provide a WhatsApp number and check your email regularly so the operator can contact you.']],
                ['title' => 'Bed dimensions and weight limit', 'paragraphs' => ['Double bed: 178 cm long and 85 cm wide, with a maximum load of 130 kg per bed.', 'The small lower single berth 6D at the rear of the bus is 167 cm long.']],
                ['title' => 'Pets', 'paragraphs' => ['The operator does not transport pets or companion animals.']],
                ['title' => 'Minor passengers', 'paragraphs' => ['Passengers under 16 must be accompanied by a parent or legal guardian.']],
                ['title' => 'Weekday cancellation and rescheduling', 'paragraphs' => ['This policy does not apply before, during, or after public holidays.'], 'periods' => [
                    ['title' => 'More than 24 hours before departure', 'bullets' => ['Free cancellation.', 'One free reschedule.']],
                    ['title' => 'From 6 to 24 hours before departure', 'bullets' => ['Cancellation fee: 30% of the ticket value.', 'Full-price tickets may be rescheduled once.', 'Coupon tickets may be rescheduled after paying the difference up to the full fare.']],
                    ['title' => 'Less than 6 hours before departure', 'bullets' => ['Cancellation fee: 100% of the ticket value; cancellation is not permitted.', 'Rescheduling is not permitted.']],
                ], 'note' => 'Tickets purchased with a discount code, coupon, or promotional programme are not eligible for cancellation.'],
            ],
            'thanks' => 'Thank you.',
        ],
        'ru' => [
            'title' => 'Правила перевозчика',
            'sections' => [
                ['title' => 'Правила для детей', 'paragraphs' => ['Ребёнок с 6 лет (2020 года рождения) считается отдельным пассажиром. Один взрослый с 6-летним ребёнком должен забронировать двухместное купе или два отдельных купе.'], 'bullets' => ['Дети до 5 лет включительно (по году рождения): бесплатно.', 'Дети с 6 лет: требуется билет по взрослому тарифу.']],
                ['title' => 'Трансфер и время прибытия', 'paragraphs' => ['Пассажиры с посадкой в Районе 1 на рейсы с 05:30 до 22:00 должны прибыть за один час до указанного времени, чтобы воспользоваться сидячим трансфером до стоянки в Районе 2 или нового автовокзала Миен Донг, где производится посадка в спальный автобус.', 'Дневные рейсы могут прибыть на 1–2 часа позже расчётного времени.']],
                ['title' => 'Багаж', 'paragraphs' => ['Одноместное купе: до 30 кг. Двухместное купе: до 40 кг.']],
                ['title' => 'Иностранные пассажиры', 'paragraphs' => ['Укажите номер WhatsApp и регулярно проверяйте электронную почту, чтобы перевозчик мог связаться с вами.']],
                ['title' => 'Размеры и допустимая нагрузка', 'paragraphs' => ['Двуспальная кровать: длина 178 см, ширина 85 см, максимальная нагрузка 130 кг на кровать.', 'Малое нижнее одноместное место 6D в задней части автобуса имеет длину 167 см.']],
                ['title' => 'Домашние животные', 'paragraphs' => ['Перевозчик не принимает к перевозке домашних животных.']],
                ['title' => 'Несовершеннолетние пассажиры', 'paragraphs' => ['Пассажиры младше 16 лет должны путешествовать с родителем или законным опекуном.']],
                ['title' => 'Отмена и перенос в обычные дни', 'paragraphs' => ['Правила не действуют до, во время и после праздничных дней.'], 'periods' => [
                    ['title' => 'Более чем за 24 часа до отправления', 'bullets' => ['Бесплатная отмена.', 'Один бесплатный перенос.']],
                    ['title' => 'За 6–24 часа до отправления', 'bullets' => ['Комиссия за отмену: 30% стоимости билета.', 'Билет по полной цене можно перенести один раз.', 'Билет с купоном можно перенести после доплаты разницы до полной стоимости.']],
                    ['title' => 'Менее чем за 6 часов до отправления', 'bullets' => ['Комиссия за отмену: 100% стоимости билета; отмена невозможна.', 'Перенос невозможен.']],
                ], 'note' => 'Билеты со скидочным кодом, купоном или по акции не подлежат отмене.'],
            ],
            'thanks' => 'Благодарим вас.',
        ],
    ][$locale];
    $amenityIcons = [
        10 => '<svg viewBox="0 0 24 24"><path d="M5 5h14v10H9l-4 4V5Z"/><path d="m9 9 2 2 4-4"/></svg>',
        11 => '<svg viewBox="0 0 24 24"><path d="M4 15h16M6 15a6 6 0 0 1 12 0M12 7V5M4 19h16"/></svg>',
        14 => '<b>WC</b>',
        17 => '<svg viewBox="0 0 24 24"><path d="M9 18h6M10 22h4M8 14a6 6 0 1 1 8 0c-1 1-1 2-1 2H9s0-1-1-2Z"/></svg>',
        21 => '<svg viewBox="0 0 24 24"><path d="M7 3v7l5 4 5-4V3M5 21l7-7 7 7"/></svg>',
        23 => '<svg viewBox="0 0 24 24"><path d="M12 3s6 6.4 6 11a6 6 0 0 1-12 0c0-4.6 6-11 6-11Z"/></svg>',
        24 => '<svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="11" rx="3"/><path d="M7 11h10"/></svg>',
        25 => '<svg viewBox="0 0 24 24"><path d="m14 3 7 7-3 3-2-2-8 8H4v-4l8-8-2-2 4-2Z"/></svg>',
        27 => '<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M8 22h8M12 18v4"/></svg>',
        29 => '<svg viewBox="0 0 24 24"><path d="m13 2-7 12h6l-1 8 7-12h-6z"/></svg>',
        31 => '<svg viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 3v18M16 3v18M8 8h8"/></svg>',
        36 => '<svg viewBox="0 0 24 24"><path d="m14 3 7 7-3 3-2-2-8 8H4v-4l8-8-2-2 4-2Z"/></svg>',
        52 => '<svg viewBox="0 0 24 24"><path d="M4 9h4l5-4v14l-5-4H4V9Z"/><path d="M17 9a4 4 0 0 1 0 6M19 6a8 8 0 0 1 0 12"/></svg>',
        54 => '<svg viewBox="0 0 24 24"><path d="M4 9a13 13 0 0 1 16 0M7 13a8 8 0 0 1 10 0M10 17a3 3 0 0 1 4 0"/><circle cx="12" cy="20" r="1" fill="currentColor" stroke="none"/></svg>',
        55 => '<svg viewBox="0 0 24 24"><path d="M12 2v20M4.9 6l14.2 12M19.1 6 4.9 18M3 12h18"/></svg>',
        57 => '<svg viewBox="0 0 24 24"><path d="M6 5h12v14H6zM9 5V3h6v2M9 10h6M9 14h4"/></svg>',
    ];
@endphp

<section class="trip-panel" data-trip-panel="discount" role="tabpanel">
    @if($discount > 0)
        <div class="trip-price-grid"><div><span>{{ $text['original'] }}</span><del>{{ number_format($originalFare) }} VND</del></div><div><span>{{ $text['sale'] }}</span><strong>{{ number_format($fare) }} VND</strong></div><div class="trip-price-save"><b>-{{ $discount }}%</b><span>{{ $text['saved'] }} {{ number_format($originalFare - $fare) }} VND</span></div></div>
    @else
        <p class="trip-empty">{{ $text['no_discount'] }}</p>
    @endif
</section>

<section class="trip-panel" data-trip-panel="points" role="tabpanel" hidden>
    <div class="trip-point-columns">
        @foreach(['pickup_points' => 'pickup', 'dropoff_points' => 'dropoff'] as $pointsKey => $labelKey)
            <div><h4>{{ $text[$labelKey] }}</h4>
                @forelse($details[$pointsKey] as $point)
                    <div class="trip-point"><i aria-hidden="true"></i><div><strong>{{ $point['name'] }}</strong>@if($point['address'])<span>{{ $point['address'] }}</span>@endif</div>@if($point['time'])<time>{{ $point['time'] }}</time>@endif</div>
                @empty <p class="trip-empty">{{ $text['no_points'] }}</p> @endforelse
            </div>
        @endforeach
    </div>
</section>

<section class="trip-panel" data-trip-panel="reviews" role="tabpanel" hidden>
    @if($details['rating']['score'] || $details['rating']['count'])
        <div class="trip-rating"><strong>{{ $details['rating']['score'] ? number_format($details['rating']['score'], 1) : '—' }}</strong><span aria-hidden="true">★</span><p>{{ number_format($details['rating']['count']) }} {{ $text['reviews'] }}</p></div>
    @endif
    @forelse($details['rating']['comments'] as $review)
        <blockquote><p>“{{ $review['content'] }}”</p><footer>{{ $review['author'] ?: 'VeXeRe' }}@if($review['rating']) · {{ number_format($review['rating'], 1) }} ★@endif</footer></blockquote>
    @empty <p class="trip-empty">{{ $text['no_reviews'] }}</p> @endforelse
</section>

<section class="trip-panel" data-trip-panel="policies" role="tabpanel" hidden>
    <div class="trip-policy-grid">
        @foreach(['cancellation', 'payment', 'e_ticket', 'deposit'] as $policy)
            <article><span aria-hidden="true">{{ $loop->iteration < 3 ? '✓' : 'i' }}</span><div><h4>{{ $text[$policy] }}</h4><p>{{ $details['policies'][$policy] ?: $text['no_policy'] }}</p></div></article>
        @endforeach
    </div>
</section>

<section class="trip-panel" data-trip-panel="images" role="tabpanel" hidden>
    @if($details['images'])<div class="trip-gallery">@foreach($details['images'] as $image)<a href="{{ $image }}" target="_blank" rel="noopener"><img src="{{ $image }}" alt="{{ $details['trip']['vehicle_type'] }}" loading="lazy"></a>@endforeach</div>
    @else <p class="trip-empty">{{ $text['no_images'] }}</p> @endif
</section>

<section class="trip-panel" data-trip-panel="amenities" role="tabpanel" hidden>
    @if($details['amenities'])<ul class="trip-amenities">@foreach($details['amenities'] as $amenity)<li><span class="trip-amenity-icon" aria-hidden="true">{!! $amenityIcons[$amenity['id']] ?? '<svg viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"/></svg>' !!}</span><span class="trip-amenity-copy"><strong>{{ $amenity['name'] }}</strong>@if($amenity['is_free'])<small>{{ $text['free'] }}</small>@endif</span></li>@endforeach</ul>
    @else <p class="trip-empty">{{ $text['no_amenities'] }}</p> @endif
</section>

<section class="trip-panel trip-operator-policy" data-trip-panel="operator_policy" role="tabpanel" hidden>
    <h3>{{ $operatorPolicy['title'] }}</h3>
    <ol>
        @foreach($operatorPolicy['sections'] as $section)
            <li>
                <h4>{{ $section['title'] }}</h4>
                @foreach($section['paragraphs'] ?? [] as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                @if(!empty($section['bullets']))<ul>@foreach($section['bullets'] as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>@endif
                @foreach($section['periods'] ?? [] as $period)
                    <div class="trip-policy-period"><strong>{{ $period['title'] }}</strong><ul>@foreach($period['bullets'] as $bullet)<li>{{ $bullet }}</li>@endforeach</ul></div>
                @endforeach
                @if(!empty($section['note']))<p class="trip-policy-note">{{ $section['note'] }}</p>@endif
            </li>
        @endforeach
    </ol>
    <p><strong>{{ $operatorPolicy['thanks'] }}</strong></p>
</section>
