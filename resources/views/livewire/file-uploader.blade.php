<div>
    <x-input-label for="files" :value="__('Files')" class="hidden" />

    <div x-data="{
        isDragging: false,
        handleDrop(e) {
            e.preventDefault()
            this.isDragging = false
            this.$refs.input.files = e.dataTransfer.files
            this.$refs.input.dispatchEvent(new Event('change'))
        }
    }" x-on:dragenter.prevent="isDragging = true" x-on:dragleave.prevent="isDragging = false"
        x-on:dragover.prevent x-on:drop="handleDrop($event)" class="relative">
        {{-- <label for="files"
            class="flex flex-col items-center justify-center w-full h-48 transition-colors border border-dashed rounded-lg cursor-pointer bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-500 dark:hover:border-indigo-600 hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-950/50"
            :class="isDragging ? '!border-indigo-500 !bg-indigo-50 dark:!bg-indigo-950/50' :
                'border-slate-300 dark:border-slate-700'">
            <flux:icon.arrow-up-to-line wire:target='files' wire:loading.remove
                class="!h-6 !w-6 !mb-3 !text-slate-400" />

            <div class="flex items-center justify-center mb-3.5 space-x-1.5 text-sm italic font-medium text-slate-500"
                wire:target='files' wire:loading.flex>
                <span>Uploading files</span>

                <flux:icon.loader-circle wire:target='files' wire:loading
                    class="!w-5 !h-5 !mb-0.5 animate-spin !text-slate-500" />
            </div>

            <p class="mb-2 text-sm text-slate-500 dark:text-slate-400">
                <span class="font-semibold text-indigo-500">
                    Click to upload
                </span>

                or drag and drop
            </p>

            <p class="text-xs text-slate-500 dark:text-slate-400">
                JPG, JPEG, PNG, HEIC, SVG, AVIF, or WEBP
            </p>

            <input id="files" name="files" type="file" x-ref="input" wire:model="files"
                accept=".jpg, .jpeg, .png, .heic, .svg, .avif, .webp" class="hidden cursor-pointer" multiple />
        </label> --}}

        <x-filepond::upload wire:model="files" multiple
            placeholder="
        <p class='text-sm text-slate-500 dark:text-slate-400'>
            <span class='font-medium text-indigo-500 duration-200 ease-in-out cursor-pointer hover:text-indigo-600 dark:text-indigo-600 dark:hover:text-indigo-500'>
                Click to upload
            </span>

            or drag and drop
            </p>" />

        @if ($uploaded_files)
            <div class="space-y-2.5">
                @foreach ($uploaded_files->reverse() as $file)
                    <div wire:key="{{ $file['name'] }}-{{ $file['size'] }}" wire:transition.duration.300ms
                        class="flex items-center mt-2.5 justify-between p-[7px] border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900">
                        <div class="flex items-center space-x-2">
                            <div>
                                <x-pure-finance.file-preview :$file />
                            </div>

                            <div class="flex flex-col -space-y-1">
                                <p class="text-[13px] text-slate-600 dark:text-slate-300">
                                    {{ $file['name'] }}
                                </p>

                                <span class="text-xs text-slate-400">
                                    Size: {{ $file['size'] }}
                                </span>
                            </div>
                        </div>

                        <button type="button" wire:click="removeFile('{{ $file['name'] }}')">
                            <x-heroicon-s-x-mark
                                class="p-0.5 text-red-500 duration-100 ease-in-out rounded-md w-6 h-6 hover:bg-slate-200 dark:hover:bg-slate-700" />
                        </button>
                    </div>
                @endforeach
            </div>
        @endif

        @error('files.*')
            <div class="pb-4 text-sm text-rose-600 dark:text-rose-400">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
