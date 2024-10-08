@props([
    'selected' => false,
])

<button
    wire:click="select"
    class="w-5 h-5 flex items-center justify-center rounded-full
        {{ $selected
            ? 'bg-blue-500 hover:bg-blue-600 text-white'
            : 'opacity-0 group-hover:opacity-100 bg-white hover:bg-gray-100'
        }}
    "
>
    @if($selected)
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
        </svg>
    @else
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
        </svg>
    @endif
</button>
