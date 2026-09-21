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
