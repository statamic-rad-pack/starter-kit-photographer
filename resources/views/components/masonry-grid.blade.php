<div
    {{ $attributes
        ->merge(['x-data' => '{}'])
        ->twMerge('grid items-start grid-cols-1')
    }}
    x-masonry.wait.600
    x-init="$nextTick(() => { $dispatch('reload:masonry') })" {{-- Ensure we reload and fix the masonry after x-cloak has finished. --}}
>
    {{ $slot }}
</div>
