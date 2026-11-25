@props([
    'title' => 'Filter Inventaris',
])

@php
    $heading = is_string($title) && trim($title) !== '' ? trim($title) : 'Filter Inventaris';
@endphp

<div class="card">
    <div class="card-header">
        <h4>{{ $heading }}</h4>
    </div>

    <div class="card-body">{{ $slot }}</div>
</div>
