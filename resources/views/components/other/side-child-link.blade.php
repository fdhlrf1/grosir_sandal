@props(['active' => false])
{{-- fungsi dari blade yaitu props untuk ngasih tau kita punya properti dari komponen ini --}}

<a {{ $attributes }} class="{{ $active ? 'bg-gray-200'
 : 'hover:bg-blue-500 hover:text-white'}}
    text-gray-600 block w-full px-10 py-2 text-sm" aria-current="{{ $active  ? 'page' : false }}">{{ $slot }}
</a>
