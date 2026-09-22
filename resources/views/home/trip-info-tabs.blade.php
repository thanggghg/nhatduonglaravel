@php
  $originalFare = max($trip['fare'], (int) ($trip['original_fare'] ?? $trip['fare']));
  $discountPercent = $originalFare > $trip['fare'] ? (int) round((1 - ($trip['fare'] / $originalFare)) * 100) : 0;
@endphp
<div class="hn-trip-info" data-trip-info data-loaded="false" data-loading-label="{{ $homeTripCopy['loading'] }}" data-error-label="{{ $homeTripCopy['error'] }}" data-url="{{ route('booking.trip.info', ['from_id' => $fleetFromId, 'to_id' => $fleetToId, 'trip_code' => $trip['code'], 'fare' => $trip['fare'], 'original_fare' => $originalFare, 'utilities' => implode(',', $trip['utility_ids'] ?? []), 'display_usd' => 1, 'lang' => $locale]) }}">
  <div class="trip-tabs" id="{{ $tabsId }}" role="tablist" aria-label="{{ $trip['vehicle_type'] }}">
    @foreach($homeTripTabs as $tab => $label)
      <button type="button" role="tab" id="{{ $tabsId.'-'.$tab }}" aria-selected="{{ $tab === 'discount' ? 'true' : 'false' }}" aria-controls="{{ $tabsId.'-panel' }}" tabindex="{{ $tab === 'discount' ? '0' : '-1' }}" data-trip-tab="{{ $tab }}" class="{{ $tab === 'discount' ? 'is-active' : '' }}">{{ $label }}</button>
    @endforeach
  </div>
  <div class="trip-panels" id="{{ $tabsId.'-panel' }}" aria-live="polite">
    <section class="trip-panel" data-trip-panel="discount" role="tabpanel" aria-labelledby="{{ $tabsId.'-discount' }}">
      @if($discountPercent > 0)
        <div class="trip-price-grid"><div><span>{{ $homeTripCopy['original'] }}</span><del>{{ number_format($originalFare) }} VND</del><small class="price-usd">≈ ${{ $toUsd($originalFare) }}</small></div><div><span>{{ $homeTripCopy['sale'] }}</span><strong>{{ number_format($trip['fare']) }} VND</strong><small class="price-usd">≈ ${{ $toUsd($trip['fare']) }}</small></div><div class="trip-price-save"><b>-{{ $discountPercent }}%</b><span>{{ $homeTripCopy['save'] }} {{ number_format($originalFare - $trip['fare']) }} VND <small class="price-usd">≈ ${{ $toUsd($originalFare - $trip['fare']) }}</small></span></div></div>
      @else
        <p class="trip-empty">{{ $homeTripCopy['no_discount'] }}</p>
      @endif
    </section>
  </div>
</div>
