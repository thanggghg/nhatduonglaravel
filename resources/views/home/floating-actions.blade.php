{{-- Mobile floating action buttons --}}
<div class="fixed bottom-6 right-6 flex flex-col gap-3 z-40 lg:hidden">
  <a href="tel:1900 2879" class="w-12 h-12 bg-brand-green rounded-full flex items-center justify-center shadow-xl hover:bg-green-hover transition-colors">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
  </a>
  <a href="{{ route('booking.index') }}" class="w-12 h-12 bg-brand-gold rounded-full flex items-center justify-center shadow-xl hover:bg-gold-hover transition-colors">
    <svg class="w-5 h-5 text-gold-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
  </a>
</div>
