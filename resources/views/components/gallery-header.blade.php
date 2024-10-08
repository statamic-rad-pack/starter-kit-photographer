@cascade([
    'homepage',
    'settings',
])

<div>
    <h1 class="flex flex-wrap items-baseline justify-between gap-2 pt-5 pb-4 sm:py-12">
        <span class="font-serif text-2xl font-medium sm:text-4xl">{{ $this->entry->title }}</span>
        <a href="{{ $homepage }}" class="font-serif text-xs font-medium sm:text-sm">by {{ $settings->business_name }}</a>
    </h1>
</div>
