<div class="fixed inset-x-0 bottom-0 bg-white border-t select-none border-slate-900/10">
    <div class="py-4 mx-auto fluid-container">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
            <x-gallery-zoom />

            @if($this->downloadEnabled)
                @if(count($this->selection))
                    <div class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600">
                        <span>
                            {{ trans_choice(':count item selected|:count items selected', $this->assetsCount(), ['count' => $this->assetsCount()]) }}
                        </span>

                        <button wire:click="resetSelection">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                            </svg>
                        </button>
                    </div>
                @endif

                <x-download-button
                    url="{{ $this->zipUrl }}"
                    label="{{ trans_choice('Download :count file|Download :count files', $this->assetsCount(), ['count' => $this->assetsCount()]) }}"
                    class="w-full sm:w-auto text-white px-4 gap-1.5 py-1.5 text-sm {{ count($this->selection) ? 'bg-blue-600 hover:bg-blue-700' : 'bg-black hover:bg-gray-700' }}"
                />
            @endif
        </div>
    </div>
</div>
