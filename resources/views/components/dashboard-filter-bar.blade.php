@props([
    'title' => 'Filter Inventaris',
])

{{-- ===== START: Dashboard Filter Bar ===== --}}
<div class="card">
    <div class="card-header">
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">{{ $slot }}</div>
</div>
{{-- ===== END: Dashboard Filter Bar ===== --}}
