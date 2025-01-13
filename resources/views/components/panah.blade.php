@props(['active' => false])
{{-- fungsi dari blade yaitu props untuk ngasih tau kita punya properti dari komponen ini --}}

<svg id="icon-data" class="{{ $active ? 'w-4 h-4 transition-transform transform rotate-90'
 : 'w-4 h-4 transition-transform transform rotate-0" aria-current="{{ $active  ? 'page' : false }}">{{ $slot }}
</svg>
