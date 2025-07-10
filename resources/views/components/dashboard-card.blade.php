@props(['icon', 'title', 'value', 'color'])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'purple' => 'bg-purple-100 text-purple-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
];
@endphp

<div class="bg-white rounded-lg p-6 shadow hover:shadow-lg transition transform hover:-translate-y-1">
    <div class="p-4 {{ $colors[$color] ?? 'bg-gray-100 text-gray-600' }} rounded-full w-fit mb-4">
        <i class="{{ $icon }} fa-2x"></i>
    </div>
    <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
    <p class="text-3xl font-bold text-{{ $color }}-600 mt-2">{{ $value }}</p>
</div>
