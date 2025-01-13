@props(['active' => false])
{{-- fungsi dari blade yaitu props untuk ngasih tau kita punya properti dari komponen ini --}}

<a {{ $attributes }}
    class="{{ $active ? 'bg-gray-200 text-gray-700' : 'text-gray-700 hover:bg-gray-200 hover:text-gray-700 transition-colors' }} flex items-center justify-between w-full px-6 py-3"
    aria-current="{{ $active ? 'page' : false }}">{{ $slot }}
</a>
