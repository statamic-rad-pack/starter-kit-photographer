<div class="fixed inset-x-0 bottom-0 bg-white border-t border-gray-200 select-none">
    <div class="flex flex-col items-center justify-between h-16 gap-4 mx-auto fluid-container sm:flex-row">
        <x-gallery-zoom />

        @if($this->assetsProcessing)
            <div class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-green-800 rounded gap-x-2 bg-green-100 ring-1 ring-green-400">
                <span class="relative flex w-2.5 h-2.5">
                    <span class="absolute inline-flex w-full h-full bg-green-400 rounded-full opacity-75 animate-ping"></span>
                    <span class="relative inline-flex w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                </span>
                {{ __('Assets processing') }}
            </div>
        @endif

        @if($this->allowDownload)
            @if(count($this->selection))
                <div class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600">
                    <span>
                        {{ trans_choice(':count item selected|:count items selected', $this->assetsCount, ['count' => $this->assetsCount]) }}
                    </span>

                    <button wire:click="resetSelection">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                        </svg>
                    </button>
                </div>
            @endif

            <x-download-button
                as="button"
                wire:click="downloadZip"
                label="{{ trans_choice('Download :count file|Download :count files', $this->assetsCount, ['count' => $this->assetsCount]) }}"
                class="w-full sm:w-auto text-white px-4 gap-1.5 py-1.5 text-sm {{ count($this->selection) ? 'bg-blue-600 hover:bg-blue-700' : 'bg-black hover:bg-gray-700' }}"
            />
        @endif

    </div>
</div>
