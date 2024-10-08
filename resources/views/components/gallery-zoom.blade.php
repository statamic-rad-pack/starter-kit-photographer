<div class="items-center hidden sm:flex gap-x-2">

    <button
        x-on:click="zoomOut"
        :class="{ 'text-gray-400 ': isMinZoomed }"
        :disabled="isMinZoomed"
        aria-label="{{ __('Zoom out') }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4" aria-hidden="true" focusable="false">
            <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
        </svg>
    </button>

    <input
        x-model="currentZoom"
        type="range"
        :min="minZoom"
        :max="maxZoom"
        step="1"
        aria-label="{{ __('Zoom slider') }}"
        class="
            w-full bg-transparent cursor-pointer appearance-none disabled:opacity-50 disabled:pointer-events-none focus:outline-none
            [&::-webkit-slider-thumb]:w-3.5
            [&::-webkit-slider-thumb]:h-3.5
            [&::-webkit-slider-thumb]:-mt-[5px]
            [&::-webkit-slider-thumb]:appearance-none
            [&::-webkit-slider-thumb]:bg-black
            [&::-webkit-slider-thumb]:rounded-full
            [&::-webkit-slider-thumb]:transition-all
            [&::-webkit-slider-thumb]:duration-150
            [&::-webkit-slider-thumb]:ease-in-out
            [&::-webkit-slider-thumb]:

            [&::-moz-range-thumb]:w-3.5
            [&::-moz-range-thumb]:h-3.5
            [&::-moz-range-thumb]:appearance-none
            [&::-moz-range-thumb]:bg-black
            [&::-moz-range-thumb]:border-none
            [&::-moz-range-thumb]:rounded-full
            [&::-moz-range-thumb]:transition-all
            [&::-moz-range-thumb]:duration-150
            [&::-moz-range-thumb]:ease-in-out

            [&::-webkit-slider-runnable-track]:w-full
            [&::-webkit-slider-runnable-track]:h-1
            [&::-webkit-slider-runnable-track]:bg-gray-200
            [&::-webkit-slider-runnable-track]:rounded-full
            [&::-webkit-slider-runnable-track]:

            [&::-moz-range-track]:w-full
            [&::-moz-range-track]:h-1
            [&::-moz-range-track]:bg-gray-200
            [&::-moz-range-track]:rounded-full
        "
    >

    <button
        x-on:click="zoomIn"
        :class="{ 'text-gray-400': isMaxZoomed }"
        :disabled="isMaxZoomed"
        aria-label="{{ __('Zoom in') }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4" aria-hidden="true" focusable="false">
            <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
        </svg>
    </button>

</div>
