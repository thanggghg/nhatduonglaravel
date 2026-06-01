@extends('layouts.app')

@push('styles')
<style>
  @keyframes subtle-zoom { from{transform:scale(1.05)} to{transform:scale(1.12)} }

  .route-card { transition: transform 0.35s cubic-bezier(.22,.68,0,1.2), box-shadow 0.35s ease; }
  .route-card:hover { transform: translateY(-6px) scale(1.01); }

  @keyframes ticker { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
  .ticker-inner { animation: ticker 25s linear infinite; width: max-content; }
  .ticker-inner:hover { animation-play-state: paused; }

  @keyframes floatCard { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
  .testimonial-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .testimonial-card:hover { transform: translateY(-4px); }
</style>
@endpush

@section('content')

@include('home.hero')
@include('home.ticker')
@include('home.routes')
@include('home.schedules')
@include('home.why-us')
@include('home.news')
@include('home.testimonials')
@include('home.faq')
@include('home.cta')
@include('home.floating-actions')

@endsection
