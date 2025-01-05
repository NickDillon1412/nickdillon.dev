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
            class="flex flex-col items-center justify-center w-full h-48 mt-1.5 transition-colors border border-dashed rounded-lg cursor-pointer bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-500"
            :class="isDragging ? '!border-indigo-500 !bg-indigo-50 dark:!bg-indigo-950/50' :
                'border-slate-300 dark:border-slate-700'">
            <flux:button icon="arrow-up-to-line" variant="ghost"
                class="!h-4 !w-4 !mb-3 !border-none !text-slate-400 hover:!bg-slate-50 dark:hover:!bg-slate-900 !shadow-none" />
            </svg>

            <p class="mb-2 text-sm text-slate-500 dark:text-slate-400">
                <span class="font-semibold">
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

        <div wire:loading wire:target="files" class="mt-2">
            <span class="text-sm text-slate-500 dark:text-slate-400">
                Uploading...
            </span>
        </div>

        @if ($uploaded_files)
            <div class="mt-4 space-y-2">
                @foreach ($uploaded_files->reverse() as $file)
                    <div class="flex items-center justify-between p-2 rounded bg-slate-50 dark:bg-slate-700">
                        <span class="text-sm truncate text-slate-600 dark:text-slate-300">
                            {{ $file }}
                        </span>

                        <div class="flex items-center space-x-1">
                            <button type="button" wire:click="viewFile('{{ $file }}')"
                                class="duration-200 ease-in-out text-slate-500 hover:text-slate-700 dark:hover:text-slate-400">
                                <x-heroicon-o-eye class="w-4 h-4" />
                            </button>

                            <button type="button" wire:click="removeFile('{{ $file }}')"
                                class="duration-200 ease-in-out text-rose-500 hover:text-rose-700">
                                <x-heroicon-o-x-mark class="w-4 h-4 text-rose-500 hover:text-rose-700" />
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
