<div class="hn-amenity-tabs" data-amenity-tabs aria-label="{{ $amenityTabsLabel }}">
  @foreach($amenityTabs as $filter => $label)
    <button type="button" data-amenity-filter="{{ $filter }}" aria-pressed="{{ $filter === 'featured' ? 'true' : 'false' }}" class="{{ $filter === 'featured' ? 'is-active' : '' }}">{{ $label }}</button>
  @endforeach
</div>
<ul class="hn-amenity-list" data-amenity-list>
  @foreach($homeUi['amenities'] as $amenity)
    @php $featured = in_array($loop->index, $featuredAmenities, true); @endphp
    <li data-amenity-group="{{ $amenityGroups[$loop->index] }}" data-amenity-featured="{{ $featured ? 'true' : 'false' }}" @if(!$featured) hidden @endif>
      <span class="hn-amenity-icon" aria-hidden="true">{!! $amenityIcons[$loop->index] !!}</span>{{ $amenity }}
    </li>
  @endforeach
</ul>
