<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Modelable;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;

class FileUploader extends Component
{
    use WithFileUploads;

    #[Modelable, Validate([
        'files' => ['required', 'array'],
        'files.*' => ['image', 'mimes:jpg,jpeg,png,heic,svg,avif,webp']
    ])]
    public array $files = [];

    public Collection $uploaded_files;

    public string $selected_file = '';

    public string $s3_path = 'pure-finance/files';

    public function mount(): void
    {
        $this->uploaded_files = collect();
    }

    public function formatFileSize(int $bytes): string
    {
        return match (true) {
            $bytes >= 1073741824 => round($bytes / 1073741824, 2) . ' GB',
            $bytes >= 1048576 => round($bytes / 1048576, 2) . ' MB',
            $bytes >= 1024 => round($bytes / 1024, 2) . ' KB',
            default => $bytes . ' Bytes',
        };
    }

    public function updatedFiles(): void
    {
        $this->validateOnly('files');

        foreach ($this->files as $file) {
            $this->uploaded_files->push([
                'name' => $file->getClientOriginalName(),
                'size' => $this->formatFileSize($file->getSize()),
            ]);

            $file->storePubliclyAs(
                'pure-finance/files',
                $file->getClientOriginalName(),
                's3'
            );
        }

        $this->files = [];
    }

    #[Computed]
    public function getS3Path(string $file_name): string
    {
        return Storage::disk('s3')->url("{$this->s3_path}/{$file_name}");
    }

    public function removeFile(string $file_name): void
    {
        if (Storage::disk('s3')->exists("{$this->s3_path}/{$file_name}")) {
            Storage::disk('s3')->delete("{$this->s3_path}/{$file_name}");
        }

        $this->uploaded_files = $this->uploaded_files
            ->reject(fn(array $file): bool => $file['name'] === $file_name)
            ->values();

        $this->dispatch('file-deleted');
    }

    public function viewFile(int $index): void
    {
        $this->selected_file = $this->uploaded_files[$index]->getClientOriginalName() ?? null;
    }

    #[On('file-deleted')]
    public function render(): View
    {
        return view('livewire.file-uploader');
    }
}
