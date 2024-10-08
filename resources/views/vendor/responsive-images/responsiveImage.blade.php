<picture>
    @foreach(($breakpoints ?? []) as $breakpoint)
        @foreach($breakpoint->sources() ?? [] as $source)
            @php
                $srcSet = $source->getSrcset();
            @endphp

            @if($srcSet !== null)
                <source
                    @if($type = $source->getMimeType()) type="{{ $type }}" @endif
                    @if($media = $source->getMediaString()) media="{{ $media }}" @endif
                    srcset="{{ $srcSet }}"
                    @if($includePlaceholder ?? false) sizes="1px" @endif
               >
            @endif
        @endforeach
    @endforeach

    <img
        {!! $attributeString ?? '' !!}
        src="{{ $src }}"
        @unless(\Illuminate\Support\Str::contains($attributeString, 'alt'))
        alt="{{ (string) $asset['alt'] ?: (string) $asset['title'] }}"
        @endunless
        @isset($width) width="{{ $width }}" @endisset
        @isset($height) height="{{ $height }}" @endisset
        @if($hasSources)
            x-data
            x-statamic-responsive-images
        @endif
   >
</picture>
