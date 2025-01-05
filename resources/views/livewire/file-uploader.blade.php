<div>
    <x-input-label for="files" :value="__('Files')" />

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
        <label for="files"
            class="flex flex-col items-center justify-center w-full h-48 mt-2 transition-colors border border-dashed rounded-lg cursor-pointer bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-500"
            :class="isDragging ? '!border-indigo-500 !bg-indigo-50 dark:!bg-indigo-950/50' :
                'border-slate-300 dark:border-slate-700'">
            <flux:icon.arrow-up-to-line class="!h-6 !w-6 !mb-3 !text-slate-400" />

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
        </label>

        <div wire:loading wire:target='files' class="w-full mt-4 space-y-2">
            <div
                class="flex items-center justify-between p-2.5 border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900">
                <div class="flex items-center space-x-1.5">
                    <div class="p-2 bg-indigo-100 rounded-lg dark:bg-indigo-900/50">
                        <flux:icon.photo class="!text-indigo-400 dark:!text-indigo-600" />
                    </div>

                    <span class="text-sm italic font-medium truncate text-slate-500 dark:text-slate-300">
                        Uploading...
                    </span>
                </div>

                <flux:icon.loader-circle class="!w-5 !h-5 animate-spin !text-slate-500" />
            </div>
        </div>

        @if ($uploaded_files)
            <div class="my-4 space-y-2">
                @foreach ($uploaded_files->reverse() as $file)
                    <div wire:transition.duration.500ms
                        class="flex items-center justify-between p-2.5 border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900">
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10">
                                <img src="{{ $this->getS3Path($file['name']) }}" alt="{{ $file['name'] }}"
                                    class="w-10 h-10 rounded-md" />
                            </div>

                            <div class="flex flex-col">
                                <span class="max-w-xs text-sm truncate text-slate-600 dark:text-slate-300">
                                    {{ $file['name'] }}
                                </span>

                                <span class="text-xs text-slate-400">
                                    Size: {{ $file['size'] }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-1.5">
                            {{-- <button type="button" wire:click="viewFile('{{ $file }}')"
                                class="duration-200 ease-in-out text-slate-500 hover:text-slate-700 dark:hover:text-slate-400">
                                <x-heroicon-o-eye class="w-4 h-4" />
                            </button> --}}

                            <button type="button" wire:click="removeFile('{{ $file['name'] }}')"
                                class="duration-200 ease-in-out text-rose-500 hover:text-rose-700">
                                <x-heroicon-o-x-mark class="w-5 h-5 text-rose-500 hover:text-rose-700" />
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- @if ($selected_attachment)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="max-w-md p-4 bg-white rounded-lg">
                    <h3 class="text-lg font-semibold truncate">
                        {{ $selected_attachment }}
                    </h3>

                    <img src="{{ asset('storage/uploads/' . $selected_attachment) }}"
                        alt="{{ $selected_attachment }}" class="mt-4 max-h-80" />

                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 mt-4 text-white bg-red-500 rounded hover:bg-red-600">
                        Close
                    </button>
                </div>
            </div>
        @endif --}}

        <!-- Error Messages -->
        <x-input-error :messages="$errors->get('files.*')" class="mt-2" />
    </div>
</div>
